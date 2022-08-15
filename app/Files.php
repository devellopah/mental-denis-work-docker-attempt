<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
  protected $filltable = ['id', 'src', 'size', 'type', 'name'];
  protected $guarded = [];

  /**
   * many tasks which using file
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */

  public function tasks()
  {
    return $this->belongsToMany('App\Task');
  }

  public function storeTaskAvatar($file, $taskId)
  {
    $this->size = (int)$file->getClientSize();
    $this->mimetype = $file->getMimeType();
    $this->type = explode('/', $file->getMimeType())[0];
    $this->name = $file->getClientOriginalName();
    $this->src = (string)$file->move('storage/tasks/avatars', $taskId . '_' . $file->getClientOriginalName());
    $this->save();

    return $this;
  }

  public function generateFilePath($alias, $fileName)
  {
    return config('file_paths.' . $alias) . $fileName;
  }
}
