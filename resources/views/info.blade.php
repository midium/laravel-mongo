@extends('layouts.app')

@section('content')
<style>
.glyphicon-chevron-down, .glyphicon-chevron-up{
  cursor: pointer;
}
</style>

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
                <?php echo drawItemAndCollapsedPanel('', $key, $detail, 1); ?>
              @endif
            @endforeach
          </ul>
        </div>
    </div>
</div>
<?php
function drawItemAndCollapsedPanel($parent_key, $key, $detail, $level){
  $result = '';
  if(!is_array($detail)){
    $result = "<li data-child=\"$parent_key\" class=\"list-group-item sub-items\"><strong>$key:</strong> $detail</li>";
  } else {

    if($parent_key != ''){
      $result = "<li data-child=\"$parent_key\" class=\"list-group-item\"><strong>$key</strong> <i class=\"pull-right glyphicon glyphicon-chevron-down\" data-reference=\"$parent_key$key\"></i></li>";
      $result .= "<div data-child=\"$parent_key$key\" class=\"col-md-offset-$level\">";
      foreach ($detail as $subkey => $subdetail) {
        $result .= drawItemAndCollapsedPanel($parent_key.$key, $subkey, $subdetail, $level+1);
      }
      $result .= '</div>';

    } else {

      $result = "<li class=\"list-group-item\"><strong>$key</strong> <i class=\"pull-right glyphicon glyphicon-chevron-down\" data-reference=\"$key\"></i></li>";
      $result .= "<div data-child=\"$key\" class=\"col-md-offset-$level\" >";
      foreach ($detail as $subkey => $subdetail) {
        $result .= drawItemAndCollapsedPanel($key, $subkey, $subdetail, $level+1);
      }
      $result .= '</div>';

    }
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

    $('[data-child]').css('display', 'none');

    $(document).on('click','.glyphicon-chevron-down', function(){
      var childrens = $(this).data('reference');
      $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
      $('[data-child="'+childrens+'"]').fadeIn();
    });

    $(document).on('click','.glyphicon-chevron-up', function(){
      var childrens = $(this).data('reference');
      $(this).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('[data-child="'+childrens+'"]').fadeOut();
    });

  });
  </script>
@endsection
