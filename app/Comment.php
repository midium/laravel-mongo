<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Comment extends Eloquent {
  protected $collection = 'comments';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'comment',
      'user_id',
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
