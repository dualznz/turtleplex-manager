<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servers extends Model
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
    protected $table = 'servers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'server_name', 'slug', 'server_host', 'network_path', 'ping_status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'pinged_at', 'created_at', 'updated_at', 'deleted_at'
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
                'source' => 'server_name'
            ]
        ];
    }

    public function ping_status()
    {
        $st = '';
        if ($this->ping_status == 1) {
            $st = '<i class="far fa-ethernet" style="font-size: 20px; color: #5DFF00;" title="Server Online"></i>';
        } else {
            $st = '<i class="far fa-ethernet" style="font-size: 20px; color: #FF0000;" title="Server Offline"></i>';
        }
        return $st;
    }

    public function ping_status_detailed()
    {
        $st = '';
        if ($this->ping_status == 1) {
            $st = '<i class="far fa-ethernet" style="font-size: 20px; color: #5DFF00;" title="Server Online"></i>&nbsp;&nbsp;&nbsp;<b>Online</b> | <b>Last Checked:</b> ' .  \App\Timezone::getDate($this->pinged_at->getTimestamp());
        } else {
            $st = '<i class="far fa-ethernet" style="font-size: 20px; color: #FF0000;" title="Server Offline"></i>&nbsp;&nbsp;&nbsp;<b>Offline</b> | <b>Last Checked:</b> ' .  \App\Timezone::getDate($this->pinged_at->getTimestamp());
        }
        return $st;
    }
}
