@extends('mytemplate.blankpage_ad')
@section('content')
<?php use App\Transcript; ?>

<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
</style>
<section class="content">
    <h4 style="font-size:35px" class="text text-center">Schedule Manager</h4>
    <div class="box box-primary">
        <div class="box-header">
            <button id="btn_main_page" type="button" class="btn btn-flat btn-primary">Main Page</button>
            <div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Action</a></li>
    <li><a href="#">Another action</a></li>
    <li><a href="#">Something else here</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Separated link</a></li>
  </ul>
</div>
            </div>
            <button type="button" class="btn btn-flat btn-primary">Schedule</button>
            <button type="button" class="btn btn-flat btn-primary">Edit Schedule</button>
            <button type="button" class="btn btn-flat btn-primary"></button>
        </div>
    </div>
</section>

@include('mytemplate.script_include')
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#sidebar_list_7').addClass('active');
        $('#teacher_assigment').on('click',function(){
            if($(this).parent().hasClass('open')){
                $(this).parent().removeClass('open');
            }
            else{
                $(this).parent().addClass('open');
            }
        })
    });
    
</script> 

@endsection