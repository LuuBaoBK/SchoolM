@extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
button.list-group-item.active{
    background-color: #00c0ef !important;
    border: none;
}
</style>
<section class="content-header">
    <h1>
        Admin
        <small>Position Manager</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i>Position_Manager</a></li>
        <li><a href="#"><i class="active"></i>Create Transcript</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h4>Schedule Manager</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <li class="list-group-item list-group-item active">Schedule Menu</li>
                        <button id="btn_home" type="button" class="list-group-item">General Info</button>
                        <button id="btn_teacher_assigment" type="button" class="list-group-item">Teacher Assigment</button>
                        <button id="btn_new_schedule" type="button" class="list-group-item">New Schedule</button>
                        <button id="btn_edit_schedule" type="button" class="list-group-item">Edit Current Schedule (Teacher View)</button>
                        <button id="btn_edit_schedule_stu" type="button" class="list-group-item">Edit Current Schedule (Student View)</button>
                        <li id="loading" style="display:none" class="list-group-item list-group-item"><i class="fa fa-refresh fa-spin" ></i>&nbsp Loading ... <i class="fa fa-refresh fa-spin" ></i></li>
                    </div>
                    @yield('schedule_message')
                </div>
                <div class="col-md-9">
                    @yield('schedule_content')
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#sidebar_list_7').addClass('active');
        $('#btn_home').on('click',function(){
            if(!$(this).hasClass('active'))
                location.href = "/admin/schedule/main_menu";
        });
        $('#btn_teacher_assigment').on('click',function(){
            if(!$(this).hasClass('active'))
                location.href = "/admin/schedule/teacher_assigment";
        });
        $('#btn_new_schedule').on('click',function(){
            if(!$(this).hasClass('active'))
                location.href = "/admin/schedule/new_schedule_index";
        });
        $('#btn_edit_schedule').on('click',function(){
            if(!$(this).hasClass('active')){
                location.href = "/admin/schedule/edit_current_index";
                $('#loading').css('display','block');
            }
        });
        $('#btn_edit_schedule_stu').on('click',function(){
            if(!$(this).hasClass('active')){
                location.href = "/admin/schedule/edit_current_index_stu";
                $('#loading').css('display','block');
            }
        });
        
    });
    
</script> 

@endsection