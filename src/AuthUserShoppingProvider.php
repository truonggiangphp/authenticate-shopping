<?php

namespace Webikevn\AuthenticateShopping;

use GuzzleHttp\RequestOptions;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use GuzzleHttp\Client;

class AuthUserShoppingProvider extends EloquentUserProvider implements UserProvider
{
    /**
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $response = $this->execute($credentials);
        if (!$response) {
            return false;
        }

        $response = json_decode($response, true);
        $data = isset($response['data']) ? $response['data'] : [];
        $kaiinId = isset($data['kaiin_id']) ? $data['kaiin_id'] : '';
        if (!$kaiinId) {
            return false;
        }
        $data['id'] = $kaiinId;
        return new WebikeUser($data);
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials($user, array $credentials)
    {
        return isset($user->kaiin_id) && $user->kaiin_id;
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
