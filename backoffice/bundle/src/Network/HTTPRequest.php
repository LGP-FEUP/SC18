<?php

namespace AgileBundle\Network;

use AgileBundle\Utils\Dbg;
use Exception;
use GuzzleHttp\Client;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Classe utilitaire permettant de construire et d'exécuter des requêtes HTTP
 *
 * @author Lucas Garofalo | 10/11/2021 18:00
 */
class HTTPRequest {

    public const METHOD_POST = "POST";
    public const METHOD_PUT = "PUT";
    public const METHOD_DELETE = "DELETE";
    public const METHOD_GET = "GET";
    public const AVAILABLE_METHODS = [
      self::METHOD_POST,
      self::METHOD_PUT,
      self::METHOD_DELETE,
      self::METHOD_GET
    ];

    /**
     * Méthode d'appel HTTP
     *
     * @var string
     */
    private string $method = self::METHOD_GET;

    /**
     * URL d'appel
     *
     * @var string
     */
    private string $url = "";

    /**
     * Données envoyées dans le corps de la requête (ou dans l'URL si méthode GET)
     *
     * @var array
     */
    private array $body = [];

    /**
     * En-têtes HTTP de la requête
     *
     * @var array
     */
    #[ArrayShape([
        'string' => 'string'
    ])]
    private array $headers = [];

    /**
     * Timestamp d'exécution de la requête
     *
     * @var int
     */
    private int $execution_stamp = -1;

    /**
     * Données réponse de la requête HTTP
     *
     * @var array|string
     */
    private array|string $response_data = [];

    /**
     * Code de réponse de la requête HTTP
     *
     * @var int
     */
    private int $response_code = -1;

    /**
     * Durée d'exécution de la requête (ms)
     *
     * @var int
     */
    private int $execution_duration = 0;

    /**
     * Execute la requête et enregistre la réponse dans l'objet HTTPRequest
     *
     * @return $this
     * @throws Exception
     */
    public function execute(): HTTPRequest {
        if ($this->hasBeenExecuted()) {
            throw new Exception("Request already executed");
        } else {
            $this->execution_stamp = time();

            $data = ["headers" => $this->getHeaders()];

            if ($this->getMethod() == "GET") {
                $data["query"] = $this->getBody();
            } else {
                $data["json"] = $this->getBody();
            }

            $httpClient = new Client(['verify' => !is_dev()]);
            $res = $httpClient->request($this->getMethod(), $this->getURL(), $data);

            $this->response_code = $res->getStatusCode();
            $this->response_data = json_decode($res->getBody(), true) ?? $res->getBody();
            $this->execution_duration = time() - $this->execution_stamp;

            $strParams = json_encode($this->getBody());

            if ($this->getResponseCode() < 300) {
                Dbg::success("HTTP call $this->url ($this->method) called with params $strParams and returned $this->response_code");
            } else {
                Dbg::error("Error calling endpoint $this->url ($this->method) with params $strParams, server responded $this->response_code: ");
                Dbg::error($this->getResponseData());
            }

            return $this;
        }
    }

    /**
     * Met à jour la méthode HTTP de la requête
     *
     * @param string $method
     * @return $this
     */
    public function setMethod(
        #[ExpectedValues(self::AVAILABLE_METHODS)]
        string $method
    ): HTTPRequest {
        $this->method = $method;
        return $this;
    }

    /**
     * Met à jour l'URL De la requête
     *
     * @param string $url
     * @return $this
     */
    public function setURL(string $url): HTTPRequest {
        $this->url = $url;
        return $this;
    }

    /**
     * Met à jour les données de la requête
     *
     * @param array $data
     * @return $this
     */
    public function setBody(array $data): HTTPRequest {
        $this->body = $data;
        return $this;
    }

    /**
     * Met à jour les en-têtes HTTP de la requête
     *
     * @param array $headers
     * @return $this
     */
    #[ArrayShape([
        'string' => 'string'
    ])]
    public function setHeaders(array $headers): HTTPRequest {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Retourne le code réponse du serveur
     *
     * @return int
     */
    public function getResponseCode(): int {
        return $this->response_code;
    }

    /**
     * Retourne les données de réponse du serveur
     *
     * @return array|string
     */
    public function getResponseData(): array|string {
        return $this->response_data;
    }

    /**
     * Retourne le timestamp d'exécution de la requête
     *
     * @return int
     */
    public function getExecutionStamp(): int {
        return $this->execution_stamp;
    }

    /**
     * Retourne la durée d'exécution de la requête
     *
     * @return int
     */
    public function getExecutionDuration(): int {
        return $this->execution_duration;
    }

    /**
     * Retourne true si la requête a déjà été exécutée
     *
     * @return bool
     */
    public function hasBeenExecuted(): bool {
        return $this->execution_stamp > 0;
    }

    /**
     * Retourne l'URL de la requête
     *
     * @return string
     */
    public function getURL(): string {
        return $this->url;
    }

    /**
     * Retourne le corps de la requête
     *
     * @return array
     */
    public function getBody(): array {
        return $this->body;
    }

    /**
     * Retourne les en-têtes HTTP de la requête
     *
     * @return array
     */
    #[ArrayShape([
        'string' => "string"
    ])]
    public function getHeaders(): array {
        return $this->headers;
    }

    /**
     * Retourne la méthode HTTP de la requête
     *
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

}