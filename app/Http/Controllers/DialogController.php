<?php

namespace App\Http\Controllers;

use App\Dialog;
use App\Message;
use Illuminate\Http\Request;

use App\Http\Requests;

class DialogController extends Controller
{
    public function detail($id)
    {
        $dialog = \App\Dialog::find($id);
        $dialog->setCurrentRespondent();
        $respondent = $dialog->owner_id == \Auth::user()['id'] ? $dialog->respondent : $dialog->owner;
        $respondent_id = $respondent->id;
        $dialogMessages = $dialog->messages()->orderBy('created_at', 'desc')->paginate(10);
        $dialog->messagesStatusToReaded();
        return view('dialog.detail', compact(['dialog', 'dialogMessages', 'respondent_id', 'respondent']));
    }

    public function send(Requests\SendMessageRequest $request)
    {
        $dialog = Dialog::where([
            ['owner_id', '=', \Auth::user()['id']],
            ['respondent_id', '=', $request->respondent_id]
        ])->orWhere([
            ['respondent_id', '=', \Auth::user()['id']],
            ['owner_id', '=', $request->respondent_id]
        ])->get();
        if (count($dialog) == 0) {
            $dialog = Dialog::create([
                'owner_id' => \Auth::user()['id'],
                'respondent_id' => $request->respondent_id
            ]);
        } else {
            $dialog = $dialog->first();
        }

        $request->request->add(['dialog_id' => $dialog->id, 'owner_id' => \Auth::user()['id']]);

        $createdMessage = Message::create($request->all());
        $dialog->updated_at = $createdMessage->created_at;
        $dialog->save();
        return redirect(url('/dialog/' . $dialog->id));
    }
}
