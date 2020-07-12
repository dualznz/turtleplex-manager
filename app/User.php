<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Rackbeat\UIAvatars\HasAvatar;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasRoles, HasAvatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'timezone', 'time_format'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /*
     * UI Avatar
     */
    public function getAvatarNameKey( ) {
        return 'username';
    }

    public function avatar() {
        $length = 2;
        $avatar = $this->getAvatarGenerator();

        $u = $this->roles()->pluck('name')[0];
        $c = '';
        switch ($u) {
            case 'Staff':
                $c = '#FFBD00';
                break;
            case 'Developer':
                $c = 'CC99FF';
                break;
        }

        return $avatar->name($this->getInitials($length))->backgroundColor($c)->base64();
    }
}
