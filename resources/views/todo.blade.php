@extends('layouts.app')

@section('content')
<style>
  .done:before{
    /*opacity: 0.5;*/
      content: " ";
      position: absolute;
      top: 50%;
      left: 0;
      border-bottom: 1px solid #111;
      width: 100%;
  }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">MongoDB Test TODO Application</div>

                <div class="panel-body">
                    This is a small application showing how to implement a todo system with Laravel and MongoDB
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (session('flash_error'))
            <div class="alert alert-danger" role="alert">
              {{ session('flash_error') }}
              <a href="#" id="closer" class="alert-link"><i class="fa fa-btn fa-remove pull-right" data-toggle="tooltip" data-placement="top" title="Close alert"></i></a>
            </div>
            @endif
            @if (session('flash_success'))
            <div class="alert alert-success" role="alert">
              {{ session('flash_success') }}
              <a href="#" id="closer" class="alert-link"><i class="fa fa-btn fa-remove pull-right" data-toggle="tooltip" data-placement="top" title="Close alert"></i></a>
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">User Todos: {{(isset($todos) && $todos != null)?$todos->where('done', '0')->count().'/'.$todos->count():'0/0'}}</div>

                <div class="panel-body">
                  <form class="new-comment clearfix" action="{{url('/add_task')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                      <label for="todo">Insert a new task</label>
                      <div class="input-group">
                        <input id="todo" name="todo" type="text" class="form-control"/>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="submit"><i class="fa fa-send"></i></button>
                        </span>
                      </div>
                    </div>
                  </form>
                  <hr>
                  <div class="tasks-container clearfix">
                    <ul class="list-group">
                      <li class="list-group-item list-group-item-info"><i class="glyphicon glyphicon-unchecked">&nbsp;</i>Todo</li>
                      <?php $is_first_done = true; ?>
                    @foreach($todos as $todo)
                      @if($todo->done == 1 && $is_first_done == true)
                        <?php $is_first_done = false; ?>
                      <li class="list-group-item list-group-item-success"><i class="glyphicon glyphicon-check">&nbsp;</i>Completed</li>
                      @endif
                      <li class="list-group-item {{($todo->done == 1)?'done':''}}">
                        <input type="checkbox" id="task_done" data-id="{{$todo->id}}" {{($todo->done == 1)?'checked="checked"':''}}>&nbsp;
                        <span class="text-warning small">{{date('d M. H:i', strtotime($todo->created_at))}}</span>&nbsp;
                        {{$todo->todo}}
                        <a href="{{url('/delete_task/'.$todo->id)}}" class="pull-right"><i class="fa fa-btn fa-remove" data-toggle="tooltip" data-placement="top" title="Delete task"></i></a>
                      </li>
                    @endforeach
                    </ul>
                    <a href="{{url('/clear_done')}}" class="btn btn-default pull-right"><i class="fa fa-eraser">&nbsp;</i>Clear completed tasks</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
  <script>
  $(document).on('click','#closer', function(){
    $(this).parent().fadeOut();
  });

  $('[data-toggle="tooltip"]').tooltip();

  $(document).on('click', '#task_done', function(){
    var done = ($(this).is(':checked'))?1:0;
    var uri = "{{url('/task_done/')}}/" + $(this).data('id') + "/" + done;
    window.location.href = uri;
  });

  </script>
@endsection
