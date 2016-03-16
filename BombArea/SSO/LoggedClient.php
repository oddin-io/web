<?php
namespace BombArea\SSO;

class LoggedClient
{
    /**
     * Session token
     *
     * @var string
     */
    private $token;

    /**
     * @var Client
     */
    private $client;

    public function __construct($client, $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getSessionToken()
    {
        return $this->token;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return Client
     */
    public function logout()
    {
        $client = new \GuzzleHttp\Client();
        $client->request("GET", $this->client->getServerUri() . "/logout",
            [
                "query" => [
                    "client" => $this->client->getId(),
                    "secret" => $this->client->getSecret(),
                    "token" => $this->token
                ]
            ]
        );

        return $this->client;
    }

    /**
     * Get session values from the sso server
     *
     * @return array Session data
     */
    public function getSessionData()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request("GET", $this->client->getServerUri() . "/session",
            [
                "query" => [
                    "client" => $this->client->getId(),
                    "secret" => $this->client->getSecret(),
                    "token" => $this->token
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Set session values in the sso server
     *
     * @param array $sessionData
     * @return array new session values
     */
    public function setSessionData($sessionData = [])
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $this->client->getServerUri() . "/session",
            [
                "query" => [
                    "client" => $this->client->getId(),
                    "secret" => $this->client->getSecret(),
                    "token" => $this->token
                ],
                "json" => $sessionData
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
