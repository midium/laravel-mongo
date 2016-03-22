<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Comment;
use App\Todo;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Auth::user()->comments;
        return view('home')->with('comments', $comments);
    }

    public function addComment(Request $request){
      $comment = new Comment();
      $comment->user_id = Auth::user()->id;
      $comment->comment = $request->comment;
      $comment->save();

      return redirect('/home');
    }

    public function deleteComment($id){
      $comment = Comment::find($id);
      if(!isset($comment) || $comment == null){
        return redirect('/home')->with('flash_error', 'Comment not found');

      } else {
        $comment->delete();
        return redirect('/home')->with('flash_success', 'Comment removed successfully');

      }
    }

    public function todo()
    {
        $todos = Auth::user()->todos()->orderBy('done')->get();
        return view('todo')->with('todos', $todos);
    }

    public function addTask(Request $request){
      $task = new Todo();
      $task->user_id = Auth::user()->id;
      $task->todo = $request->todo;
      $task->done = "0";
      $task->save();

      return redirect('/todo');
    }

    public function deleteTask($id){
      $task = Todo::find($id);
      if(!isset($task) || $task == null){
        return redirect('/todo')->with('flash_error', 'Task not found');

      } else {
        $task->delete();
        return redirect('/todo')->with('flash_success', 'Task removed successfully');

      }
    }

    public function doneTask($id, $done){
      if(!isset($done) || $done === null){
        return redirect('/todo')->with('flash_error', 'Task status not specified');
      }

      $task = Todo::find($id);
      if(!isset($task) || $task == null){
        return redirect('/todo')->with('flash_error', 'Task not found');

      } else {
        $task->done = $done;
        $task->save();

        return redirect('/todo');

      }
    }

    public function info(){
      if (phpversion() != "7") {
        $c = new \MongoClient();
        $db = 'mongo';
        $mongo = new \MongoDB($c, $db);

        $mongodb_info = $mongo->command(array('serverStatus'=>true));

        return view('info')->with('info', $mongodb_info);
      } else {
        return 'TODO';
      }
    }

    public function clearDoneTask(){
      Auth::user()->todos()->where('done', '1')->delete();
      return redirect('/todo');
    }

}
