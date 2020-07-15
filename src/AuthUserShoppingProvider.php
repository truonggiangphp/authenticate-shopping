<?php

namespace Webikevn\AuthenticateShopping;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Webikevn\AuthenticateShopping\Models\MstKaiin;
use Webikevn\AuthenticateShopping\Models\TblSession;

class AuthUserShoppingProvider extends EloquentUserProvider implements UserProvider
{
    /**
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (!$credentials) {
            return null;
        }

        $query = $this->createModel()->newQuery()
            ->join(
                with(new MstKaiin())->getTable(),
                with(new TblSession())->getTable() . '.session_kaiin_id',
                '=',
                with(new MstKaiin())->getTable() . '.kaiin_id'
            );

        foreach ($credentials as $key => $value) {
            if ($key === with(new TblSession())->getTable() . '.session_id_a') {
                // monoris9
                $cut = 1;
                $value = substr($value, $cut, strlen($value) - $cut);
            }
            $query->where($key, $value);
        }

        return $query->first();
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $kaiin_mukou_date = $user->kaiin_mukou_date;

        return is_null($kaiin_mukou_date) || $kaiin_mukou_date === '';
    }
}