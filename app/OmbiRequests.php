<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OmbiRequests extends Model
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
    protected $table = 'ombi_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ombi_userid', 'media_type', 'title', 'json_data'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'release_date', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function user()
    {
        return $this->hasOne('App\OmbiUsers', 'user_id', 'ombi_userid');
    }
}
