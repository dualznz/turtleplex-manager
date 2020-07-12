<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateAssets extends Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'state_assets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'group_id', 'asset_name', 'text_color', 'background_color'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function stateGroup()
    {
        return $this->hasOne('App\StateGroups', 'id', 'accent_id');
    }
}
