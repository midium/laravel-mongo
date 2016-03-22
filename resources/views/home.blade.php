@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">MongoDB Test Comments Application</div>

                <div class="panel-body">
                    This is a small application showing how to implement a comment system with Laravel and MongoDB
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
                <div class="panel-heading">User Comments: {{(isset($comments) && $comments != null)?$comments->count():'0'}}</div>

                <div class="panel-body">
                  <form class="new-comment clearfix" action="{{url('/add_comment')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                      <label for="comment">Insert a comment</label>
                      <textarea id="comment" name="comment" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default pull-right"><i class="fa fa-btn fa-send"></i>Submit</button>
                  </form>
                  <hr>
                  <div class="comments-container clearfix">
                    @foreach($comments as $comment)
                      <div class="alert alert-info">
                        {{$comment->comment}}
                        <a href="{{url('/delete_comment/'.$comment->id)}}"><i class="fa fa-btn fa-remove pull-right" data-toggle="tooltip" data-placement="top" title="Delete comment"></i></a>
                      </div>
                    @endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
  <script>
  $(function () {
    $('#closer').on('click', function(){
      $(this).parent().fadeOut();
    });

    $('[data-toggle="tooltip"]').tooltip();
  });
  </script>
@endsection
