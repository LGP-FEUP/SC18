<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\App;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController {

    public static string $default_message = 'Discover this app'; //TODO Edit this

    /**
     * Parse the current sheet and returns all emails found
     *
     * @param string $path
     * @return array|null
     */
    private static function parseEmails(string $path): ?array {
        $toReturn = array();
        $testAgainstFormats = [
            IOFactory::READER_XLS,
            IOFactory::READER_XLSX
        ];

        $spreadsheet = IOFactory::load($path, 0, $testAgainstFormats);
        $content = $spreadsheet->getActiveSheet()->toArray();
        foreach ($content as $row) {
            foreach ($row as $key => $value) {
                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $toReturn[] = $value;
                }
            }
        }
        if (!empty($toReturn)) {
            return $toReturn;
        }
        return null;
    }

    public static function sendEmails(string $path, string $body): bool {
        try {
            $addresses = ExcelController::parseEmails($path);
            if ($addresses != null) {
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

                foreach ($addresses as $address) {
                    $mail->AddAddress($address);
                }

                $mail->WordWrap = 50;
                $mail->IsHTML(false);
                $faculty = App::getInstance()->auth->getFaculty();
                $city = App::getInstance()->auth->getCity();
                $country = App::getInstance()->auth->getCountry();
                if($faculty != null) {
                    $mail->Subject = 'Erasmus Helper Application - Discover ' . $faculty->name . ' and Meet new Friends !';
                } elseif ($city != null) {
                    $mail->Subject = 'Erasmus Helper Application - Discover ' . $city->name . ' and Meet new Friends !';
                } elseif ($country != null) {
                    $mail->Subject = 'Erasmus Helper Application - Discover ' . $country->name . ' and Meet new Friends !';
                } else {
                    $mail->Subject = 'Erasmus Helper Application - Discover a new Erasmus experience and Meet new Friends !';
                }
                $mail->Body = $body;
                if($mail->send()) {
                    return true;
                } else {
                    Dbg::error("PHPMailer error: " . $mail->ErrorInfo);
                }
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            Dbg::error($e->getMessage());
        }
        return false;
    }
}