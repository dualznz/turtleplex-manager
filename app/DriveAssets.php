<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriveAssets extends Model
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
    protected $table = 'drive_assets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'server_id', 'drive_id', 'asset_name', 'asset_folder'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function server() {
        return $this->hasOne('App\Servers', 'id', 'server_id');
    }

    public function drive() {
        return $this->hasOne('\App\Drives', 'id', 'drive_id');
    }
}
