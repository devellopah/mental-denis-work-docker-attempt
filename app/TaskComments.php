<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskComments extends Model
{
  protected $fillable = ['description_detail', 'tasks_id', 'user_id'];
  protected $guarded = [];


  /**
   * creator of comment
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function author()
  {
    return $this->belongsTo('App\User', 'user_id', 'id');
  }

  public function getAuthor()
  {
    return $this->author()->get();
  }

  /**
   * comment created in task
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function task()
  {
    return $this->belongsTo('App\Tasks');
  }

  /**
   * files attached to coment
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function files()
  {
    return $this->belongsToMany('App\Files');
  }

  public function getFilesByType(){
      return $this->files()->get()->groupBy('type');
  }

  public function getFiles()
  {
    return $this->files()->get();
  }
}
