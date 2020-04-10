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
        'name', 'email', 'password', 'role', 'user_id'
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

    public static function get_user_info($user_id = '')
    {
        try {
            $user_data = User::where('id', $user_id)->first();
            if (empty($user_data)) {
                return ['status' => 'error', 'data' => 'User not found'];
            }
            return $user_data;
        } catch (Exception $e) {
            return ['status' => 'error', 'data' => $e];
        }
    }

    public static function group_create($array)
    {
        try {
            $data = User::create($array);
            return ['status' => 'ok', 'data' => $data];
        } catch (Exception $e) {
            return ['status' => 'error', 'data' => $e];
        }
    }


}
