<?php

namespace Webikevn\AuthenticateShopping;

use GuzzleHttp\RequestOptions;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use GuzzleHttp\Client;

class AuthUserShoppingProvider extends EloquentUserProvider implements UserProvider
{
    const SUCCESS = 'success';

    /**
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $response = $this->execute($credentials);
        if (!$response) {
            return false;
        }

        $response = json_decode($response, true);

        if ($response['result'] != self::SUCCESS) {
            return false;
        }
        $response['id'] = $response['kaiin_id'];

        return new GenericUser($response);
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials($user, array $credentials)
    {
        return isset($user->result) && $user->result == self::SUCCESS;
    }

    /**
     * @param array $data
     * @return string
     */
    private function execute(array $data): string
    {
        $client = new Client([
            'headers' => ['content-type' => 'application/json', 'Accept' => 'applicatipon/json', 'charset' => 'utf-8'],
            'verify' => false
        ]);
        $option[RequestOptions::QUERY] = $data;
        $request = $client->get(config('shopping_authenticate.webike_api_verify_session'), $option);
        $response = $request->getBody()->getContents();
        $response = mb_convert_encoding($response, 'UTF-8', 'Shift-JIS');
        return $response;
    }
}
