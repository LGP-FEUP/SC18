<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\User;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController {

    const LASTNAME = 7;
    const FIRSTNAME = 8;
    const DATE_OF_BIRTH = 10;
    const EMAIL = 28;
    const UNI_NAME = 35;
    const UNI_CODE = 36;
    const CITY_NAME = 37;
    const COUNTRY_NAME = 38;

    public static string $default_message = "Discover this app"; //TODO Edit this
    public static string $default_footer = "\n\nWe hope you enjoy your Erasmus experience with our app !\nFeel free to give any feedback to this address.\n\nThe SumsEra team.";

    /**
     * Parse the current sheet and returns data
     *
     * @param string $path
     * @return array|null
     */
    private static function parse(string $path): ?array {
        $toReturn = array();
        $testAgainstFormats = [
            IOFactory::READER_XLS,
            IOFactory::READER_XLSX
        ];

        $spreadsheet = IOFactory::load($path, 0, $testAgainstFormats);
        $content = $spreadsheet->getActiveSheet()->toArray();
        foreach ($content as $row) {
            if($row == $content[0]) continue;
            $rowContent = array();
            $rowContent["email"] = filter_var($row[self::EMAIL], FILTER_VALIDATE_EMAIL) ? $row[self::EMAIL] : "";
            $rowContent["firstname"] = $row[self::FIRSTNAME];
            $rowContent["lastname"] = $row[self::LASTNAME];
            $rowContent["uni"] = Faculty::select(["code" => $row[self::UNI_CODE]]);
            if($rowContent["uni"] == null && $rowContent["email"] != "") {
                $faculty = new Faculty();
                $faculty->code = $row[self::UNI_CODE];
                $faculty->name = $row[self::UNI_NAME];
                $city = City::select(["name" => $row[self::CITY_NAME]]);
                if($city == null) {
                    $city = new City();
                    $city->name = $row[self::CITY_NAME];
                    $country = Country::select(["name" => $row[self::COUNTRY_NAME]]);
                    if($country == null) {
                        $country = new Country();
                        $country->name = $row[self::COUNTRY_NAME];
                        $country->save();
                    }
                    $city->country_id = $country->id;
                    $city->save();
                }
                $faculty->city_id = $city->id;
                $faculty->save();
            }
            if(str_contains($row[self::DATE_OF_BIRTH], '/')) {
                $dob = explode('/', $row[self::DATE_OF_BIRTH]);
            } else {
                $dob = explode('-', $row[self::DATE_OF_BIRTH]);
            }
            if(sizeof($dob) >= 3) {
                $rowContent["date_of_birth"] = array(
                    "day" => intval($dob[0]),
                    "month" => intval($dob[1]),
                    "year" => intval($dob[2]) == 0 ? 2000 : intval($dob[2])
                );
            }
            if($rowContent["email"] != "") {
                $toReturn[] = $rowContent;
            }
        }
        if (!empty($toReturn)) {
            return $toReturn;
        }
        return null;
    }

    /**
     * Sends the mails tu corresponding addresses and pre-register the users if needed.
     *
     * @param string $path
     * @param string $body
     * @return bool
     */
    public static function sendEmails(string $path, string $body): bool {
        try {
            $data = ExcelController::parse($path);
            if ($data != null) {
                // To set the users already registered as validated, and not send them the mail
                $toRemove = array();
                for ($i = 0; $i < sizeof($data); $i++) {
                    try {
                        $userRec = App::getInstance()->firebase->auth->getUserByEmail($data[$i]["email"]);
                        $user = User::select(["id" => $userRec->uid]);
                        if ($user->validation_level < 2) {
                            $user->validation_level = 2;
                            $user->save();
                        }
                        $toRemove[] = $i;
                    } catch (AuthException|FirebaseException) {}
                }
                if(!empty($toRemove)) {
                    foreach ($toRemove as $index) {
                        unset($data[$index]);
                    }
                }
                Dbg::error($data);
                // To send the email
                $toReturn = true;
                $faculty = App::getInstance()->auth->getFaculty();
                $city = App::getInstance()->auth->getCity();
                $country = App::getInstance()->auth->getCountry();
                $mail = new PHPMailer();
                $mail->IsSMTP();

                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->Username = MAIL_SMTP;
                $mail->Password = MAIL_SMTP_PASS;

                $mail->SMTPDebug = 2;
                $mail->SetFrom(MAIL_SMTP, "SumsEra");
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAutoTLS = false;
                $mail->WordWrap = 150;
                $mail->IsHTML(false);
                if($faculty != null) {
                    //If the authed admin/mod is a uni mod, it will pre-register the users, otherwise will just do a "generalized" mail.
                    foreach ($data as $row) {
                        //If multiple mails fails the redirect, check the readme, and edit the SMTP.php file in PhpMailer

                        $mail->AddAddress($row["email"]);

                        $mail->Subject = 'Erasmus Helper Application - Discover ' . $faculty->name . ' and Meet new Friends !';

                        if(isset($row["uni"]) && $row["uni"] != null
                            && isset($row["firstname"]) && $row["firstname"] != ""
                            &&  isset($row["lastname"]) && $row["lastname"] != ""
                            && isset($row["date_of_birth"]) && !empty($row["date_of_birth"])) {

                            $password = App::UUIDGenerator();

                            $prop = array(
                                "email" => $row["email"],
                                "password" => $password
                            );
                            $user = App::getInstance()->firebase->auth->createUser($prop);

                            $tmpUser = new User();
                            $tmpUser->id = $user->uid;
                            $tmpUser->faculty_origin_id = $row["uni"]->id;
                            $tmpUser->faculty_arriving_id = $faculty->id;
                            $tmpUser->firstname = $row["firstname"];
                            $tmpUser->lastname = $row["lastname"];
                            $tmpUser->date_of_birth = $row["date_of_birth"];
                            $tmpUser->validation_level = 2;

                            if($tmpUser->save()) {
                                $mail->Body = $body . "\n\nTemporary Login information (Please never share them with anyone):\n\nEmail login: " . $row["email"] . "\n\nTemporary password: " . $password . ExcelController::$default_footer;
                            } else {
                                $mail->Body = $body . ExcelController::$default_footer;
                            }
                        } else {
                            $mail->Body = $body . ExcelController::$default_footer;
                        }
                        if(!$mail->send()) {
                            $toReturn = false;
                            Dbg::error("PHPMailer error: " . $mail->ErrorInfo);
                        }
                        $mail->clearAddresses();
                        $mail->clearAllRecipients();
                    }
                } else {
                    foreach ($data as $row) {
                        $mail->AddAddress($row["email"]);
                    }

                    $mail->Body = $body . ExcelController::$default_footer;

                    if ($city != null) {
                        $mail->Subject = 'Erasmus Helper Application - Discover ' . $city->name . ' and Meet new Friends !';
                    } elseif ($country != null) {
                        $mail->Subject = 'Erasmus Helper Application - Discover ' . $country->name . ' and Meet new Friends !';
                    } else {
                        $mail->Subject = 'Erasmus Helper Application - Discover a new Erasmus experience and Meet new Friends !';
                    }
                    if(!$mail->send()) {
                           $toReturn = false;
                           Dbg::error("PHPMailer error: " . $mail->ErrorInfo);
                    }
                    $mail->clearAddresses();
                    $mail->clearAllRecipients();
                }
                return $toReturn;
            }
        } catch (AuthException|FirebaseException|Exception $e) {
            Dbg::error($e->getMessage());
        }
        return false;
    }
}