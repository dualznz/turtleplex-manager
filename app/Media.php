<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes, Sluggable;

    public static function boot()
    {
        parent::boot();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'server_id', 'drive_id', 'drive_asset_id', 'state_asset_id', 'tmdb_id', 'media_title', 'slug', 'release_year', 'vote_average', 'poster_92_path', 'poster_154_path', 'backdrop_path', 'media_type', 'overview'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'media_title'
            ]
        ];
    }

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
