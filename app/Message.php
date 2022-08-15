<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['id', 'owner_id', 'respondent_id', 'dialog_id', 'message_text', 'status'];

    public function author()
    {
        return $this->hasOne('\App\User', 'id', 'owner_id');
    }

    public function belongToAuthUser()
    {
        if ($this->author->id == \Auth::user()->id)
            return true;
        return false;
    }

    static function sendMessage($owner_id, $respondent_id, $text)
    {
        $dialog = new \App\Dialog;
        $dialog = $dialog->getSingleDialog($respondent_id);
        $createdMessage = \App\Message::create([
            'owner_id' => $owner_id,
            'respondent_id' => $respondent_id,
            'dialog_id' => $dialog->id,
            'status' => 0,
            'message_text' => $text
        ]);

        $dialog->updated_at = $createdMessage->created_at;
    }
}
