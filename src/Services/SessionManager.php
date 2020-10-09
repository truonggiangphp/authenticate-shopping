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
    public static function storeSession(string $sessionKey, array $content, string $kaiinSessionId = null, CarbonImmutable $expiryDate = null): string
    {
        if (!$expiryDate) {
            $expiryDate = CarbonImmutable::now()->addMinutes(config('shopping_authenticate.session_expiry'));
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
     * @param string|null $sessionKaiinId
     * @return Collection
     */
    public static function getSessions(string $sessionKey, string $sessionKaiinId = null): Collection
    {
        $sessionsQuery = TblMpSession::where('session_key', $sessionKey)
            ->where('expiry_date', '>', CarbonImmutable::now());
        if ($sessionKaiinId) {
            $sessionsQuery->where('session_kaiin_id', $sessionKaiinId);
        }
        return $sessionsQuery->get();
    }

    /**
     * @param string $sessionId
     * @param array $content
     * @return bool
     */
    public static function updateSession(string $sessionId, array $content): bool
    {
        return TblMpSession::where('session_id', $sessionId)
            ->update([
                'content' => $content
            ]);
    }

    /**
     * @param $request
     * @param string $monoris
     * @return string
     */
    public static function storeAuthenticateSession($request, string $monoris)
    {
        $sessions = self::getSessions(TblMpSession::AUTHENTICATE, $monoris);
        if ($sessions->isNotEmpty()) {
            $session = $sessions->last();
            $sessionId = $session->session_id;
            self::updateSession(
                $sessionId,
                [
                    'ip' => $request->ip(),
                    'last_login_time' => CarbonImmutable::now()->timestamp
                ]
            );
        } else {
            self::storeSession(
                TblMpSession::AUTHENTICATE, [
                'ip' => $request->ip(),
                'last_login_time' => CarbonImmutable::now()->timestamp
            ],
                $monoris
            );
        }

    }
}
