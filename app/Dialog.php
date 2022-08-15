<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{


    protected $fillable = ['id', 'owner_id', 'respondent_id'];
    public $currentRespondent;

    public function respondent()
    {
        return $this->hasOne('\App\User', 'id', 'respondent_id');
    }

    public function owner()
    {
        return $this->hasOne('\App\User', 'id', 'owner_id');
    }

    public function messages()
    {
        return $this->hasMany('\App\Message');
    }

    public function messagesSorted()
    {
        return $this->hasMany('\App\Message')->orderBy('created_at', 'desc')->get();
    }

    public function getUnreadedMessagesCount()
    {
        return $this->getUnreadedMessages()->count();
    }

    public function getUnreadedMessages()
    {
        return $this->hasMany('\App\Message', 'dialog_id', 'id')
            ->where('status', '=', null)
            ->where('respondent_id', '=', \Auth::user()->id);

    }

    public function messagesStatusToReaded()
    {
        return $this->getUnreadedMessages()->update(['status' => 1]);
    }

    public function lastMessage()
    {
        return $this->hasMany('\App\Message', 'dialog_id', 'id')->where('owner_id', '=', $this->currentRespondent)
            ->orderBy('created_at', 'desc')->first();
    }

    public function setCurrentRespondent()
    {
        if (optional($this->respondent)->id == \Auth::user()->id)
            $this->currentRespondent = $this->owner->id;
        else
            $this->currentRespondent = optional($this->respondent)->id;
    }

    public function getSingleDialog($respondent_id)
    {
        $dialog = $this->where([
            ['owner_id', '=', \Auth::user()['id']],
            ['respondent_id', '=', $respondent_id]
        ])->orWhere([
            ['respondent_id', '=', \Auth::user()['id']],
            ['owner_id', '=', $respondent_id]
        ])->get();
        if (count($dialog) == 0) {
            $dialog = $this->create([
                'owner_id' => \Auth::user()->id,
                'respondent_id' => $respondent_id
            ]);
        } else {
            $dialog = $dialog->first();
        }

        return $dialog;
    }

}
