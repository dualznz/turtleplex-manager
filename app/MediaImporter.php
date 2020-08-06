<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaImporter extends Model
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
    protected $table = 'media_importer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'server_id', 'drive_id', 'drive_asset_id', 'media_title', 'tmdb_media_type'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function asset()
    {
        return $this->hasOne('App\DriveAssets', 'id', 'drive_asset_id');
    }
}
