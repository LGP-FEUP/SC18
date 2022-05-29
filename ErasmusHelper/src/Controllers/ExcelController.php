<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController
{

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

    public static function sendEmails(string $path, bool $authedSMTP = true): bool {
        try {
            $addresses = ExcelController::parseEmails($path);
            if ($addresses != null) {
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = 'smtp.sendgrid.net';
                $mail->Port = 587;
                $mail->SMTPAuth = $authedSMTP;
                $mail->WordWrap   = 50;
                $mail->IsHTML(false);
                if ($mail->SMTPAuth) {
                    $mail->Username = 'apikey';
                    $mail->Password = 'password'; //TODO api key
                }
                foreach ($addresses as $address) {
                    $mail->AddAddress($address);
                }
                $mail->Subject = 'Erasmus Helper Application - Discover FEUP and Meet new Friends !';
                $mail->Body = 'Discover this app'; //TODO message and subject
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