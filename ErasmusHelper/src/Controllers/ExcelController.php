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

    public static int $LASTNAME = 7;
    public static int $FIRSTNAME = 8;
    public static int $DATE_OF_BIRTH = 10;
    public static int $EMAIL = 28;
    public static int $UNI_NAME = 35;
    public static int $UNI_CODE = 36;
    public static int $CITY_NAME = 37;
    public static int $COUNTRY_NAME = 38;

    public static string $default_message = "Dear Erasmus student, 
                                             \n\nHave you ever felt lost for your bureaucracy papers, missing deadlines or appointments ?
                                             \n\nHave you ever felt alone in this situation, and would've liked to have friends to help you ?
                                             \n\nIf so, don't hesitate to download our application. You will have all information you could need bureaucracy-wise
                                             and the possibility to meet new friends and share your Erasmus experience.
                                             \n\nEvents, Groups, Interests, Cultural informations, all you may want is just located here.
                                             \n\nDownload our Application \"ErasmusHelper\" from PlayStore or App Store and start your new Erasmus Experience now !";
    public static string $default_footer = "\n\nWe hope you enjoy your Erasmus experience with our app !\nFeel free to give any feedback to this address.\n\nThe SumsEra team.";

    /**
     * Parse the current sheet and returns data
     *
     * @param string $path
     * @param array|null $specificExcel
     * @return array|null
     */
    private static function parse(string $path, array $specificExcel = null): ?array {
        $toReturn = array();
        $testAgainstFormats = [
            IOFactory::READER_XLS,
            IOFactory::READER_XLSX
        ];

        $spreadsheet = IOFactory::load($path, 0, $testAgainstFormats);
        $content = $spreadsheet->getActiveSheet()->toArray();
        foreach ($content as $row) {
            if($row == $content[0]) {
                //Edits the constants if the Excel is not set as by default.
                if(empty($specificExcel)) {
                    foreach ($row as $key => $column) {
                        switch (strtolower($column)) {
                            case "email":
                            case "mail":
                            case "e-mail":
                                ExcelController::$EMAIL = $key;
                                break;
                            case "firstname":
                                ExcelController::$FIRSTNAME = $key;
                                break;
                            case "lastname":
                                ExcelController::$LASTNAME = $key;
                                break;
                            case "origin university":
                                ExcelController::$UNI_NAME = $key;
                                break;
                            case "origin university code":
                                ExcelController::$UNI_CODE = $key;
                                break;
                            case "date of birth":
                                ExcelController::$DATE_OF_BIRTH = $key;
                                break;
                            case "city of origin university":
                                ExcelController::$CITY_NAME = $key;
                                break;
                            case "country of origin university":
                                ExcelController::$COUNTRY_NAME = $key;
                                break;
                            default:
                                break;
                        }
                    }
                } else {
                    foreach ($row as $key => $column) {
                        switch (strtolower($column)) {
                            case $specificExcel["email"]:
                                ExcelController::$EMAIL = $key;
                                break;
                            case $specificExcel["firstname"]:
                                ExcelController::$FIRSTNAME = $key;
                                break;
                            case $specificExcel["lastname"]:
                                ExcelController::$LASTNAME = $key;
                                break;
                            case $specificExcel["origin_university"]:
                                ExcelController::$UNI_NAME = $key;
                                break;
                            case $specificExcel["origin_university_code"]:
                                ExcelController::$UNI_CODE = $key;
                                break;
                            case $specificExcel["date_of_birth"]:
                                ExcelController::$DATE_OF_BIRTH = $key;
                                break;
                            case $specificExcel["city_of_origin_university"]:
                                ExcelController::$CITY_NAME = $key;
                                break;
                            case $specificExcel["country_of_origin_university"]:
                                ExcelController::$COUNTRY_NAME = $key;
                                break;
                            default:
                                break;
                        }
                    }
                }
                continue;
            }
            $rowContent = array();
            $rowContent["email"] = filter_var($row[ExcelController::$EMAIL], FILTER_VALIDATE_EMAIL) ? $row[ExcelController::$EMAIL] : "";
            $rowContent["firstname"] = $row[ExcelController::$FIRSTNAME];
            $rowContent["lastname"] = $row[ExcelController::$LASTNAME];
            $rowContent["uni"] = Faculty::select(["code" => $row[ExcelController::$UNI_CODE]]);
            if($rowContent["uni"] == null && $rowContent["email"] != "") {
                $faculty = new Faculty();
                $faculty->code = $row[ExcelController::$UNI_CODE];
                $faculty->name = $row[ExcelController::$UNI_NAME];
                $city = City::select(["name" => $row[ExcelController::$CITY_NAME]]);
                if($city == null) {
                    $city = new City();
                    $city->name = $row[ExcelController::$CITY_NAME];
                    $country = Country::select(["name" => $row[ExcelController::$COUNTRY_NAME]]);
                    if($country == null) {
                        $country = new Country();
                        $country->name = $row[ExcelController::$COUNTRY_NAME];
                        $country->save();
                    }
                    $city->country_id = $country->id;
                    $city->save();
                }
                $faculty->city_id = $city->id;
                $faculty->save();
            }
            if(str_contains($row[ExcelController::$DATE_OF_BIRTH], '/')) {
                $dob = explode('/', $row[ExcelController::$DATE_OF_BIRTH]);
            } else {
                $dob = explode('-', $row[ExcelController::$DATE_OF_BIRTH]);
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
     * @param array|null $specificExcel
     * @return bool
     */
    public static function sendEmails(string $path, array $specificExcel = null): bool {
        try {
            $data = ExcelController::parse($path, $specificExcel);
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
                    } catch (AuthException|FirebaseException) {
                    }
                }
                if (!empty($toRemove)) {
                    foreach ($toRemove as $index) {
                        unset($data[$index]);
                    }
                }
                if (!empty($data)) {
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
                    if ($faculty != null) {
                        //If the authed admin/mod is a uni mod, it will pre-register the users, otherwise will just do a "generalized" mail.
                        foreach ($data as $row) {
                            //If multiple mails fails the redirect, check the readme, and edit the SMTP.php file in PhpMailer

                            $mail->AddAddress($row["email"]);

                            $mail->Subject = 'Erasmus Helper Application - Discover ' . $faculty->name . ' and Meet new Friends !';

                            if (isset($row["uni"]) && $row["uni"] != null
                                && isset($row["firstname"]) && $row["firstname"] != ""
                                && isset($row["lastname"]) && $row["lastname"] != ""
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

                                if ($tmpUser->save()) {
                                    $mail->Body = ExcelController::$default_message . "\n\nTemporary Login information (Please never share them with anyone):\n\nEmail login: " . $row["email"] . "\n\nTemporary password: " . $password . ExcelController::$default_footer;
                                } else {
                                    $mail->Body = ExcelController::$default_message . ExcelController::$default_footer;
                                }
                            } else {
                                $mail->Body = ExcelController::$default_message . ExcelController::$default_footer;
                            }
                            if (!$mail->send()) {
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

                        $mail->Body = ExcelController::$default_message . ExcelController::$default_footer;

                        if ($city != null) {
                            $mail->Subject = 'Erasmus Helper Application - Discover ' . $city->name . ' and Meet new Friends !';
                        } elseif ($country != null) {
                            $mail->Subject = 'Erasmus Helper Application - Discover ' . $country->name . ' and Meet new Friends !';
                        } else {
                            $mail->Subject = 'Erasmus Helper Application - Discover a new Erasmus experience and Meet new Friends !';
                        }
                        if (!$mail->send()) {
                            $toReturn = false;
                            Dbg::error("PHPMailer error: " . $mail->ErrorInfo);
                        }
                        $mail->clearAddresses();
                        $mail->clearAllRecipients();
                    }
                    return $toReturn;
                } else {
                    // Else, no email to send but still successful
                    return true;
                }
            }
        } catch (AuthException|FirebaseException|Exception $e) {
            Dbg::error($e->getMessage());
        }
        return false;
    }
}