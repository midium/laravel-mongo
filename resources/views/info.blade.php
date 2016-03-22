@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">MongoDB Server Status</div>

                <div class="panel-body">
                    Below the current MongoDB server status. Refresh the page to update.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <ul class="list-group" id="accordion">
            <li class="list-group-item list-group-item-info"><i class="glyphicon glyphicon-cog">&nbsp;</i>Server Details<a class="pull-right" href="{{url('/info')}}"><i class="glyphicon glyphicon-refresh"></i></a></li>
            @foreach($info as $key => $detail)
              @if(!is_array($detail))
                @if($key == 'localTime')
                  <li class="list-group-item"><strong>{{$key}}:</strong> {{date('Y-m-d H:i:m',strtotime($detail))}}
                @else
                  <li class="list-group-item"><strong>{{$key}}:</strong> {{$detail}}</li>
                @endif
              @else
                @if($key != 'globalLock' && $key != 'locks' && $key != 'tcmalloc' && $key != 'wiredTiger' && $key != 'metrics')
                  <li class="list-group-item" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><strong>{{$key}}:</strong><li>
                  <li id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    @foreach($detail as $subkey => $subdetail)
                        {{$subkey}} [{{$subdetail}}]
                    @endforeach
                  </li>
                @endif
              @endif
            @endforeach
          </ul>
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
