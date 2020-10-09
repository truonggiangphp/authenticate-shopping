<?php

namespace Webikevn\AuthenticateShopping\Services;

use Carbon\CarbonImmutable;
use Webikevn\AuthenticateShopping\Models\TblMpSession;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SessionManager
{
    /**
     * @param string $sessionKey
     * @param array $content
     * @param string|null $kaiinSessionId
     * @param CarbonImmutable|null $expiryDate
     * @return string
     */
    public function storeSession(string $sessionKey, array $content, string $kaiinSessionId = null, CarbonImmutable $expiryDate = null): string
    {
        if (!$expiryDate) {
            $expiryDate = CarbonImmutable::today()->addMinutes(config('shopping_authenticate.session_expiry'));
        }

        $tblMpSession = new TblMpSession;
        $tblMpSession->session_id = Str::orderedUuid()->toString();
        $tblMpSession->session_key = $sessionKey;
        $tblMpSession->session_kaiin_id = $kaiinSessionId;
        $tblMpSession->expiry_date = $expiryDate;
        $tblMpSession->content = $content;
        $tblMpSession->save();

        return $tblMpSession->session_id;
    }

    /**
     * @param string $sessionKey
     * @return Collection
     */
    public function getSessions(string $sessionKey): Collection
    {
        return TblMpSession::where('session_key', $sessionKey)
            ->whereDate('expiry_date', '>', CarbonImmutable::today())
            ->get();
    }
}