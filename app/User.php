<?php

namespace App;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // A user can send a message
    public function sent()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    // A user can also receive a message
    public function received()
    {
        return $this->hasMany(Chat::class, 'sent_to_id');
    }

    /**
     * Get User Info
     * @param $user_id
     * @return array|string
     */
    public static function get_user_info($user_id = '')
    {
        try {

            $user = User::where('id', $user_id)->first();
            if (empty($user)) {
                return ['status' => 'error', 'data' => 'User data not found'];
            }
            return $user;
        } catch (Exception $e) {
            return ['status' => 'error', 'data' => $e];
        }
    }


}
