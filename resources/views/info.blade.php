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
                  <li class="list-group-item"><strong>{{$key}}:</strong> {{$detail->toDateTime()->format('Y-m-d H:i:s')}}
                @else
                  <li class="list-group-item"><strong>{{$key}}:</strong> {{$detail}}</li>
                @endif
              @else
                <li class="list-group-item"><strong>{{$key}}</strong> <i class="pull-right glyphicon glyphicon-chevron-down"></i></li>
                @foreach($detail as $subkey => $subdetail)
                  <?php
                  //dd($info);
                  //if($key == 'globalLock') dd($detail);
                   echo drawItemAndCollapsedPanel($subkey, $subdetail, 1);
                   ?>
                @endforeach
              @endif
            @endforeach
          </ul>
        </div>
    </div>
</div>
<?php
function drawItemAndCollapsedPanel($key, $detail, $level){
  $result = '';
  if(!is_array($detail)){
    $result = "<div class=\"col-md-$level\">&nbsp;</div><li class=\"list-group-item sub-items\"><strong>$key:</strong> $detail</li>";
  } else {

    $result = "<div class=\"col-md-$level\">&nbsp;</div><li class=\"list-group-item\"><strong>$key</strong> <i class=\"pull-right glyphicon glyphicon-chevron-down\"></i></li>";
    //$result .= "<div class=\"collapsed\">";
    foreach ($detail as $subkey => $subdetail) {
      $result .= drawItemAndCollapsedPanel($subkey, $subdetail, $level+1);
    }
    //$result .= "</div>";
  }

  return $result;
}
?>

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
