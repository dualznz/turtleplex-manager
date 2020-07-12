<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drives extends Model
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
    protected $table = 'drives';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'server_id', 'drive_name', 'slug', 'drive_folder'
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
                'source' => 'drive_name'
            ]
        ];
    }

    public function server() {
        return $this->hasOne('App\Servers', 'id', 'server_id');
    }
}
