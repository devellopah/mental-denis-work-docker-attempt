<?php

namespace App\Http\Controllers;

use App\Files;
use App\Http\Requests;
use App\Message;
use App\TaskCategory;
use App\TaskComments;
use App\Tasks;
use App\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    private $task;
    private $taskFiles;

    /**
     * @var array messages for template 'code' => 'text'
     */
    private $messages = [];

    public function storeTask(Requests\CreateTaskRequest $request)
    {
        $this->attachUserIdToRequest($request, 'creator_id');
        $request->request->add(['status' => 'start']);
        $createdTask = Tasks::create($request->all());
        $attachedFiles = $this->storeFiles($request->file('files'));
        foreach ($attachedFiles as $i => $id) {
            $createdTask->files()->attach($id);
        }
        if (!empty($request->image)) {
            $taskAvatar = new Files();
            $createdTask->image_id = $taskAvatar->storeTaskAvatar($request->image, $createdTask->id)->id;
            $createdTask->save();
        }

        Message::sendMessage($request->creator_id, $request->executor_id, "Вам поставлена задача $request->name <br> <a href=" . url('/task/' . $createdTask->id) . ">Ссылка </a> ");

        return redirect(url('/tasks'))->with([
            'messages' => [
                ['code' => 'success'],
                ['text' => 'Задача успешно добавлена']
            ]
        ]);
    }

    public function createForm($data = [])
    {
        $executors_display = $this->getExecutors();
        $categories_display = TaskCategory::allForSelect();

        return view('forms.create_task')->with([
            'executors_display' => $executors_display,
            'categories_display' => $categories_display,
        ]);
    }

    public function updateForm($id)
    {
        $this->task = Tasks::find($id);
        $this->taskFiles = $this->task->filesByType()->toArray();
        $executors_display = $this->getExecutors();
        $categories_display = TaskCategory::allForSelect();

        return view('forms.update_task', compact(['executors_display', 'categories_display']))
            ->with(['task' => $this->task, 'messages' => $this->messages, 'taskFiles' => $this->taskFiles]);
    }

    public function updateTask(Requests\CreateTaskRequest $request)
    {
        $this->task = Tasks::find($request->id);
        $this->taskFiles = $this->task->filesByType();

        $updatedTask = $this->task->update($request->all());
        $storedFiles[] = $this->storeFiles($request->file('files'));
        foreach ($storedFiles as $i => $id) {
            foreach ($id as $index => $file) {
                $this->task->files()->attach($file->id);
            }
        }
        if (!empty($request->removeFiles)) {
            foreach ($request->removeFiles as $id => $value) {
                $this->task->files()->detach($id);
                \File::delete($value);
                \App\Files::find($id)->delete();
            }
        }

        if (!empty($request->image)) {
            if ($this->task->image_id == null) {
                $taskAvatar = new Files();
            } else {
                $taskAvatar = Files::find($this->task->image_id);
            }
            $this->task->image_id = $taskAvatar->storeTaskAvatar($request->image, $this->task->id)->id;
        }

        $this->task->save();
        if ($updatedTask) {
            $this->messages[] = ['code' => 'success', 'text' => 'Задача успешно обновлена'];
        } else {
            $this->messages[] = ['error' => 'Произошла ошибка, попробуйте позже'];
        }

        $this->taskFiles->toArray();

        return redirect(url('/task/' . $request->id));
    }

    public function detailPage($id)
    {
        $this->task = Tasks::find($id);
        $this->taskFiles = $this->task->filesByType()->toArray();

        $creator = $this->task->creator()->first()->toArray();
        $comments = $this->task->commentsSorted();

        foreach ($comments as $i => $comment) {
            $comments[$i]->author = $comment->getAuthor()[0];
            $comments[$i]->files = $comment->getFiles();
        }
        $task = $this->task;

        return view('task.detail', compact(['creator', 'comments']))
            ->with(['task' => $this->task, 'taskFiles' => $this->taskFiles]);
    }

    public function createComment(Requests\TaskCreateComment $request)
    {
        $request->request->add(['tasks_id' => (int)$request->id]);
        $this->attachUserIdToRequest($request, 'user_id');

        $createdComment = TaskComments::create($request->all());
        if (!empty($request->file('files'))) {
            $createdFiles = $this->storeFiles($request->file('files'));
            foreach ($createdFiles as $i => $id) {
                $createdComment->files()->attach($id);
            }
        }

        return redirect(url('/task/' . $request->id));
    }

    private function attachUserIdToRequest($request, $field)
    {
        $request->request->add([$field => \Auth::user()['id']]);
    }

    private function storeFiles($files)
    {
        $createdFiles = [];
        if (!empty($files)) {
            foreach ($files as $file) {
                $createdFiles[] = \App\Files::create([
                    'size' => (int)$file->getClientSize(),
                    'mimetype' => $file->getMimeType(),
                    'type' => explode('/', $file->getMimeType())[0],
                    'name' => $file->getClientOriginalName(),
                    'src' => $file->store('task_files')
                ]);
            }
        }

        return $createdFiles;
    }

    private function getExecutors()
    {
        return User::all()->mapWithKeys(function ($el) {
            return [$el->id => $el->name];
        });
    }

    public function setStartStatus($id)
    {
        $task = Tasks::find($id);
        $task->status = 'start';
        $task->save();
        Message::sendMessage($task->creator_id, $task->executor_id, "Задача: $task->name, снова открыта \n" . url('/task/' . $task->id));

        return redirect(url('/task/' . $id))->with([
            'messages' => [
                'code' => 'success',
                'text' => 'Статус задачи обновлён'
            ]
        ]);


    }

    public function setCompleteStatus($id)
    {
        $task = Tasks::find($id);
        $task->status = 'complete';
        $task->save();
        Message::sendMessage(\Auth::user()->id, $task->creator_id, "Задача: $task->name, сдана на проверку \n" . url('/task/' . $task->id));

        return redirect(url('/task/' . $id))->with([
            'messages' => [
                'code' => 'success',
                'text' => 'Статус задачи обновлён'
            ]
        ]);


    }

    public function setCloseStatus($id)
    {
        $task = Tasks::find($id);
        $task->status = 'close';
        $task->save();
        Message::sendMessage($task->creator_id, $task->executor_id, "Задача: $task->name, закрыта \n" . url('/task/' . $task->id));

        return redirect(url('/task/' . $id))->with([
            'messages' => [
                'code' => 'success',
                'text' => 'Статус задачи обновлён'
            ]
        ]);

    }

    public function delete($id)
    {
        if (\Auth::user()->rang === 'A') {
            Tasks::findOrFail($id)->delete();
            return redirect(url('/tasks/'))->with([
                'messages' => [
                    'code' => 'success',
                    'text' => 'Задание удалено'
                ]
            ]);
        } else {
            return redirect(url('/tasks/'))->with([
                'messages' => [
                    'code' => 'danger',
                    'text' => 'Ошибка'
                ]
            ]);
        }
    }
}
