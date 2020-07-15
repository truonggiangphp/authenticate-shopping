<?php

namespace Webikevn\AuthenticateShopping\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblSession.
 *
 * dobar tbl_session model.
 * @property string $session_id_a
 * @property string $session_id_b
 * @property string $session_kaiin_id
 * @property string $session_touroku_date
 * @property string $session_kousin_date
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\TblSession whereSessionIdA($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\TblSession whereSessionIdB($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\TblSession whereSessionKaiinId($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\TblSession whereSessionTourokuDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\TblSession whereSessionKousinDate($value)
 * @mixin \Eloquent
 */
class TblSession extends Model implements Authenticatable
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tbl_session';

    /**
     * The primary key for the model.
     * @var string
     */
    protected $primaryKey = 'session_id_a';

    /**
     * The connection name for the model.
     * @var string
     */
    protected $connection = 'wb_shopping_dobar';

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;
}