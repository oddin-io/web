<?php
namespace BombArea\SSO;

use Desarrolla2\Cache\Cache;
use Desarrolla2\Cache\Adapter;
use Ramsey\Uuid\Uuid;

abstract class Server
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Client[]
     */
    private $clients;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * Directory to store cache files
     *
     * @var string
     */
    private $cacheDir;

    /**
     * Server constructor.
     *
     * @param string $name
     * @param string $cacheDir
     */
    public function __construct($name, $cacheDir = null)
    {
        $this->name = $name;
        $this->clients = [];

        $this->cacheDir = $cacheDir ?? "/tmp/sso/{$this->name}";
        $this->cache = $this->createCache();
    }

    /**
     * Register one Client
     *
     * @param Client $client
     */
    public function registerClient($client)
    {
        if (!($client instanceof Client)) throw new \InvalidArgumentException("Client isn't instance of Client");

        $this->clients[$client->getId()] = $client;
    }

    /**
     * @param string $id of Client
     */
    public function unregisterClient($id)
    {
        if (is_string($id)) throw new \InvalidArgumentException("Id isn't a string");

        unset($this->clients[$id]);
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @param string $id Client id
     * @param string $secret Client secret
     * @return Client
     */
    public function getClient($id, $secret)
    {
        if (!isset($this->clients[$id])) return null;

        if ($this->clients[$id]->getSecret() == $secret) return $this->clients[$id];
        else return null;
    }

    /**
     * @param Client $client
     * @param string $token
     * @return LoggedClient
     */
    public function getLoggedClient($client, $token)
    {
        if (!$this->isRegisteredClient($client)) throw new \InvalidArgumentException("Client isn't registered");
        if (!$this->isRegisteredSession($token)) throw new \InvalidArgumentException("Token isn't registered, not logged client");

        return new LoggedClient($client, $token);
    }

    /**
     * Create cache to store session tokens
     *
     * @return Cache
     */
    protected function createCache()
    {
        $adapter = new Adapter\File($this->cacheDir);
        $adapter->setOption("ttl", 3600);
        return new Cache($adapter);
    }

    /**
     * Return and register new token to represent the session
     *
     * @param Client $client
     * @param string $username
     * @param string $password
     * @throws \Exception if $client isn't registered
     * @throws \Exception if provided credentials is invalid, determined by authenticate return
     * @return LoggedClient
     */
    public function login($client, $username, $password)
    {
        if (!$this->isRegisteredClient($client)) {
            throw new \Exception("Client isn't registered");
        }

        if ($this->authenticate($username, $password)) {
            return $this->saveSession($this->clients[$client->getId()]);
        }

        throw new \Exception("Invalid credentials");
    }

    /**
     * Unregister and kill session of an LoggedClient
     *
     * @param LoggedClient $client
     * @return boolean TRUE on success and FALSE on failure
     */
    public function logout($client)
    {
        return $this->deleteSession($client);
    }

    /**
     * Generate an unique token string
     *
     * @return string
     */
    public function generateToken()
    {
        return Uuid::uuid1()->toString();
    }

    /**
     * @param Client $client
     * @param array $session values
     * @return LoggedClient
     */
    private function saveSession($client, $session = [])
    {
        if (!$this->isRegisteredClient($client)) throw new \InvalidArgumentException("Client isn't registered");
        if (!is_array($session)) throw new \InvalidArgumentException("Session isn't array");

        $token = $this->generateToken();
        $this->cache->set($token, [$client->getId() => $session]);

        return new LoggedClient($client, $token);
    }

    /**
     * @param LoggedClient $client
     * @return Client
     */
    private function deleteSession($client)
    {
        $token = $client->getSessionToken();
        $this->cache->delete($token);

        return null;
    }

    /**
     * Check if a token was registered before
     *
     * @param string $sessionToken
     * @return boolean
     */
    public function isRegisteredSession($sessionToken)
    {
        return (boolean) $this->cache->has($sessionToken);
    }

    /**
     * Check if a client is registered and its secret is valid
     *
     * @param Client $client
     * @return boolean
     */
    public function isRegisteredClient($client)
    {
        $cl = $this->getClient($client->getId(), $client->getSecret());

        if (!$cl) return false;

        return $cl->getSecret() == $client->getSecret();
    }

    /**
     * Check if a client is really who he claims to be
     *
     * @param LoggedClient $client
     * @return boolean
     */
    public function isLoggedClient($client)
    {
        if (!$this->isRegisteredClient($client->getClient())) return false;
        if (!$this->isRegisteredSession($client->getSessionToken())) return false;

        return true;
    }

    /**
     * Get session based on client
     *
     * @param LoggedClient $client
     * @return array
     */
    public function getSessionData($client)
    {
        if (!$this->isLoggedClient($client)) throw new \InvalidArgumentException("Client isn't logged");

        return $this->cache->get($client->getSessionToken())[$client->getClient()->getId()];
    }

    /**
     * Set session based on client
     *
     * @param LoggedClient $client
     * @param array $session
     * @return array new session values
     */
    public function setSessionData($client, $session)
    {
        if (!$this->isLoggedClient($client)) throw new \InvalidArgumentException("Client isn't logged");
        if (!is_array($session)) throw new \InvalidArgumentException("Session isn't an array");

        $oldSession = $this->getSessionData($client);
        $newSession = array_merge($session, $oldSession);

        $allSessionData = $this->cache->get($client->getSessionToken());
        $allSessionData[$client->getClient()->getId()] = $newSession;

        $this->cache->set($client->getSessionToken(), $allSessionData);

        return $newSession;
    }

    /**
     * Delete a session of the respective client
     *
     * @param LoggedClient $client
     */
    public function deleteSessionData($client)
    {
        if (!$this->isLoggedClient($client)) throw new \InvalidArgumentException("Client isn't logged");

        $allSessionData = $this->cache->get($client->getSessionToken());
        $allSessionData[$client->getClient()->getId()] = [];
        $this->cache->set($client->getSessionToken(), $allSessionData);
    }

    /**
     * Authenticate the user
     *
     * @param $username
     * @param $password
     * @return boolean TRUE on success and FALSE on failure
     */
    public abstract function authenticate($username, $password);
}
