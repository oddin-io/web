<?php
namespace BombArea\SSO;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Client
{
    /**
     * @var string SSO Server URI
     */
    private $serverUri;

    /**
     * @var string Client ID provided by the SSO Server
     */
    private $id;

    /**
     * @var string Client Secret provided, accordance with ID, by the SSO Server
     */
    private $secret;

    /**
     * Client constructor.
     *
     * @param string $serverUri Server URI
     * @param string $id
     * @param string $secret
     */
    public function __construct($serverUri, $id, $secret)
    {
        if (!is_string($serverUri)) throw new \InvalidArgumentException("Server isn't string");
        if (!is_string($id)) throw new \InvalidArgumentException("Id isn't string");
        if (!is_string($secret)) throw new \InvalidArgumentException("Secret isn't string");

        $this->serverUri = $serverUri;
        $this->id = $id;
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getServerUri()
    {
        return $this->serverUri;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Start a session with the SSO Server
     *
     * @param string $username
     * @param string $password
     * @return LoggedClient
     * @throws \Exception in sso request error
     */
    public function login($username, $password)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $this->serverUri . "/login",
            [
                "query" => [
                    "client" => $this->id,
                    "secret" => $this->secret
                ],
                "json" => [
                    "username" => $username,
                    "password" => $password
                ]
            ]
        );


        $token = json_decode($response->getBody()->getContents(), true)["token"];
        return new LoggedClient($this, $token);
    }
}
