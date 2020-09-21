<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Статистика посещений
 * @property int $id
 * @property int $link_id
 * @property int $client_id
 * @property int $image_path
 * @property string $created_at
 */
class VisitStat extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visit_stats';

    const UPDATED_AT = null;

    /**
     * @var array
     */
    protected $fillable = ['link_id', 'client_id', 'image_path', 'created_at'];

    public $timestamps = [ "created_at" ];
}
