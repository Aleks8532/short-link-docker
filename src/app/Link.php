<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $link_full
 * @property string $link_alias
 * @property string $expire_date
 * @property boolean $is_commercial
 * @property int $visitColumn
 * @property string $created_at
 * @property string $updated_at
 * @property array RESERVED_ALIAS
 */
class Link extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'link_full',
        'link_alias',
        'expire_date',
        'is_commercial',
        'created_at',
        'updated_at'
    ];

    // зарезервированные страницы
    const RESERVED_ALIAS = [
        'stats'
    ];

    /**
     * @param string $aliasLink
     * @param string $fullLink
     * @param string $expireDate
     * @param bool $isCommercial
     * @return array
     */
    public function shorteningLink(
        string $fullLink,
        string $aliasLink,
        string $expireDate,
        bool $isCommercial = false
    ) {

        $existLink = $this->checkExistLink($fullLink);
        // проверка на существование целевой ссылки.
        /** FIXME хорошо бы на фронте предупреждать, что ссылка уже есть,
        * поэтому псевдоним не изменился на новый, если указан руками. Либо,
        * если указана короткая ссылка, то все равно добавлять в базу
        */
        if ($existLink) {
            $aliasLink = $existLink;
        } else {
            if ($aliasLink) {
                $isExist = $this->checkIsExistAlias($aliasLink);
                if ($isExist) {
                    return
                        array(
                            'error' => 1,
                            'text' => 'link_exist'
                        );
                }
            } else {

                do {
                    $aliasLink = $this->generateRandomString(5);
                } while ($this->checkIsExistAlias($aliasLink));

            }
            $link = new Link;
            $link->link_alias = $aliasLink;
            $link->link_full = $fullLink;
            $link->expire_date = $expireDate ? Carbon::parse($expireDate) : Carbon::now()->addDay();
            $link->is_commercial = $isCommercial;
            try {
                $link->save();

            } catch (\Exception $e) {
                dd($e);
                return array(
                    'error' => 1,
                    'text' => 'unknown_error'
                );
            }
        }
        return array(
            'error' => 0,
            'text' => request()->getHost() . "/$aliasLink"
        );

    }

    public function checkIsExistAlias($alias)
    {
        return (Link::where('link_alias', $alias)->first() || in_array($alias, self::RESERVED_ALIAS)) ? true : false;
    }

    public function checkExistLink($linkFull)
    {
        return (Link::where('link_full', $linkFull)->first()->link_alias) ?? false;;
    }

    public function visitStat()
    {
        return $this->hasMany('App\VisitStat');
    }

    public function generateRandomString($length = 5)
    {
        return (string)base_convert(bin2hex(random_bytes($length)), 16, 36);;
    }


}
