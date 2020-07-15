<?php

namespace Webikevn\AuthenticateShopping\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $kaiin_shop_code
 * @property string $kaiin_id
 * @property string $kaiin_passwd
 * @property string $kaiin_email
 * @property string $kaiin_last_name
 * @property string $kaiin_last_furi
 * @property string $kaiin_first_name
 * @property string $kaiin_first_furi
 * @property string $kaiin_yubin
 * @property string $kaiin_todouhuken
 * @property string $kaiin_sikutyoson
 * @property string $kaiin_banti
 * @property string $kaiin_tel
 * @property string $kaiin_fax
 * @property string $kaiin_co_name
 * @property string $kaiin_branch_name
 * @property string $kaiin_haisou_last_name
 * @property string $kaiin_haisou_last_furi
 * @property string $kaiin_haisou_first_name
 * @property string $kaiin_haisou_first_furi
 * @property string $kaiin_haisou_yubin
 * @property string $kaiin_haisou_todouhuken
 * @property string $kaiin_haisou_sikutyoson
 * @property string $kaiin_haisou_banti
 * @property string $kaiin_haisou_tel
 * @property string $kaiin_haisou_fax
 * @property integer $kaiin_point
 * @property string $kaiin_touroku_date
 * @property string $kaiin_kousin_date
 * @property string $kaiin_syubetu
 * @property string $kaiin_mukou_date
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinShopCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinId($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinPasswd($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinLastFuri($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinFirstFuri($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinYubin($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinTodouhuken($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinSikutyoson($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinBanti($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinTel($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinFax($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinCoName($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinBranchName($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouLastFuri($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouFirstFuri($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouYubin($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouTodouhuken($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouSikutyoson($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouBanti($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouTel($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinHaisouFax($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinPoint($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinTourokuDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinKousinDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinSyubetu($value)
 * @method static \Illuminate\Database\Query\Builder|\Webikevn\AuthenticateShopping\Models\MstKaiin whereKaiinMukouDate($value)
 * @mixin \Eloquent
 */
class MstKaiin extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'mst_kaiin';

    /**
     * The primary key for the model.
     * @var string
     */
    protected $primaryKey = 'kaiin_id';

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