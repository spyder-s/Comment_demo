<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillable = ['user_id', 'group_id'];

    public static function add_member_group($array)
    {
        try {
            $data = UserGroup::create($array);
            return ['status' => 'ok', 'data' => $data];
        } catch (Exception $e) {
            return ['status' => 'error', 'data' => $e];
        }
    }

}
