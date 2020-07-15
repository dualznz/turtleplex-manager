<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaIssues extends Model
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
    protected $table = 'media_issues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'server_id', 'drive_id', 'drive_asset_id', 'accent_id', 'tmdb_url', 'tmdb_id', 'tmdb_media_type'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function server()
    {
        return $this->hasOne('App\Servers', 'id', 'server_id');
    }

    public function drive()
    {
        return $this->hasOne('App\Drives', 'id', 'drive_id');
    }

    public function asset()
    {
        return $this->hasOne('App\DriveAssets', 'id', 'drive_asset_id');
    }

    public function stateAsset()
    {
        return $this->hasOne('App\StateAssets', 'id', 'state_asset_id');
    }
}
