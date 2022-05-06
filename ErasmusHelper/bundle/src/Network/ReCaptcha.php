<?php

namespace AgileBundle\Network;

use AgileBundle\Utils\Dbg;
use Exception;

/**
 * Classe utilitaire permettant de vérifier des reCAPTCHA (v3)
 *
 * @author Lucas Garofalo | 10/11/2021 22:53
 */
class ReCaptcha {

    /**
     * URL de vérification de token reCAPTCHA
     */
    private const VERIFY_URL = "https://www.google.com/recaptcha/api/siteverify";

    /**
     * Vérifie qu'un token généré par un reCaptcha est valide
     *
     * @param string $secret
     * @param string $token
     * @return bool
     */
    public static function verifyToken(string $secret, string $token): bool {
        $request = (new HTTPRequest())
            ->setMethod(HTTPRequest::METHOD_GET)
            ->setURL(self::VERIFY_URL)
            ->setBody([
                "secret" => $secret,
                "response" => $token,
            ]);
        try {
            $request->execute();
            $response = $request->getResponseData();
            if ($response && ($response["success"] ?? false) == true && ($response["score"] ?? 0) > 0.6) {
                return true;
            } else {
                Dbg::warning("Bot probably found checking token $token:");
                Dbg::warning($response);
            }
        } catch (Exception $e) {
            Dbg::error("An error occurred sending captcha HTTPRequest: " . $e->getMessage());
        }
        return false;
    }

}