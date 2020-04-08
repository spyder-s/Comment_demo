<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['body', 'subject', 'sent_to_id', 'sender_id'];

    /**
     * Add Blog Post
     * @param $array
     * @return array|string
     */
    public static function chat_create($array)
    {
        try {
            $data = Chat::create($array);
            return ['status' => 'ok', 'data' => $data];
        } catch (Exception $e) {
            return ['status' => 'error', 'data' => $e];
        }
    }


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // A message also belongs to a receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'sent_to_id');
    }
}
