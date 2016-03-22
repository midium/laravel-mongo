<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Todo extends Eloquent {
  protected $collection = 'todos';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'done',
      'todo',
      'user_id',
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
