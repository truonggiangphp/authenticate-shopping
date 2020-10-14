<?php

namespace Webikevn\AuthenticateShopping;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\InteractsWithTime;
use SessionHandlerInterface;
use Illuminate\Session\ExistenceAwareInterface;

class WebikeSessionHandler implements ExistenceAwareInterface, SessionHandlerInterface
{
    use InteractsWithTime;

    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The name of the session table.
     *
     * @var string
     */
    protected $table;

    /**
     * The number of minutes the session should be valid.
     *
     * @var int
     */
    protected $minutes;

    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The existence state of the session.
     *
     * @var bool
     */
    protected $exists;

    /**
     * Create a new database session handler instance.
     *
     * @param \Illuminate\Database\ConnectionInterface $connection
     * @param string $table
     * @param int $minutes
     * @param \Illuminate\Contracts\Container\Container|null $container
     * @return void
     */
    public function __construct(ConnectionInterface $connection, $table, $minutes, Container $container = null)
    {
        $this->table = $table;
        $this->minutes = $minutes;
        $this->container = $container;
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId)
    {
        $session = (object)$this->getQuery()->where('session_id',$sessionId)->first();

        if ($this->expired($session)) {
            $this->exists = true;

            return '';
        }

        if (isset($session->payload)) {
            $this->exists = true;

            return base64_decode($session->payload);
        }

        return '';
    }

    /**
     * Determine if the session is expired.
     *
     * @param \stdClass $session
     * @return bool
     */
    protected function expired($session)
    {
        return isset($session->expiry_date) &&
            $session->expiry_date < Carbon::now();
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
    {
        $payload = $this->getDefaultPayload($data);

        if (!$this->exists) {
            $this->read($sessionId);
        }

        if ($this->exists) {
            $this->performUpdate($sessionId, $payload);
        } else {
            $this->performInsert($sessionId, $payload);
        }

        return $this->exists = true;
    }

    /**
     * Perform an insert operation on the session ID.
     *
     * @param string $sessionId
     * @param string $payload
     * @return bool|null
     */
    protected function performInsert($sessionId, $payload)
    {
        try {
            return $this->getQuery()->insert(Arr::set($payload, 'session_id', $sessionId));
        } catch (QueryException $e) {
            $this->performUpdate($sessionId, $payload);
        }
    }

    /**
     * Perform an update operation on the session ID.
     *
     * @param string $sessionId
     * @param string $payload
     * @return int
     */
    protected function performUpdate($sessionId, $payload)
    {
        return $this->getQuery()->where('session_id', $sessionId)->update($payload);
    }

    /**
     * Get the default payload for the session.
     *
     * @param string $data
     * @return array
     */
    protected function getDefaultPayload($data)
    {
        $payload = [
            'payload' => base64_encode($data),
            'expiry_date' => Carbon::now()->addMinutes($this->minutes),
        ];

        if (!$this->container) {
            return $payload;
        }

        return tap($payload, function (&$payload) {
            $this->addUserInformation($payload)
                ->addRequestInformation($payload);
        });
    }

    /**
     * Add the user information to the session payload.
     *
     * @param array $payload
     * @return $this
     */
    protected function addUserInformation(&$payload)
    {
        if ($this->container->bound(Guard::class)) {
            $payload['kaiin_id'] = $this->userId();
        }

        return $this;
    }

    /**
     * Get the currently authenticated user's ID.
     *
     * @return mixed
     */
    protected function userId()
    {
        return $this->container->make(Guard::class)->user()->kaiin_id ?? null;
    }

    /**
     * Add the request information to the session payload.
     *
     * @param array $payload
     * @return $this
     */
    protected function addRequestInformation(&$payload)
    {
        if ($this->container->bound('request')) {
            $payload = array_merge($payload, [
                'ip_address' => $this->ipAddress(),
            ]);
        }

        return $this;
    }

    /**
     * Get the IP address for the current request.
     *
     * @return string
     */
    protected function ipAddress()
    {
        return $this->container->make('request')->ip();
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        $this->getQuery()->where('session_id', $sessionId)->delete();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($lifetime)
    {
        $this->getQuery()->where('expiry_date', '<=', Carbon::now())->delete();
    }

    /**
     * Get a fresh query builder instance for the table.
     *
     * @return Builder
     */
    protected function getQuery()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Set the existence state for the session.
     *
     * @param bool $value
     * @return $this
     */
    public function setExists($value)
    {
        $this->exists = $value;

        return $this;
    }
}
