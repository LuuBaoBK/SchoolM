@extends('mytemplate.blankpage_te')
@section('content')
<style type="text/css">
    table tr.selected{
        background-color: #3399CC !important; 
    }
    span.tab{
        padding: 0 25px; /* Or desired space*/
    }
</style>
<section class="content-header">
    <h1>
        Teacher
        <small>Notice Board</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/teacher/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h4 class="box-title">Notice Board</h4>   
        </div>
        <div class="box-body">
            <div class="col-lg-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4 class="box-title">Class List</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-goup">
                            <label for="scholastic">Scholastic</label>
                            <?php
                                $year = date("Y");
                                $month = date("m");
                                $year = ($month < 8) ? $year - 1 : $year;
                                $year = $year." - ".($year+1);
                                echo "<input class='form-control' type='text' name='scholastic' id='scholastic' value='".$year."' readonly>";
                            ?>
                        </div>
                        <br>
                        <div id="div_class_list_table">    
                            <table id="class_list_table" class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>Class Name</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class_list as $key => $class)
                                        <tr>
                                            <td>{{$class->id}}</td>
                                            <td>{{$class->classname}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box box-primary box-solid collapsed-box">
                    <div id="add_notice_header" class="box-header">
                        <h4 class="box-title">Add New Notice</h4>
                        <div class="box-tools pull-right">
                            <button id="add_notice_header_button" class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form>
                            <div class="form-group">
                                <label><b>Notice Level :</b></label><br>
                                <label class="col-lg-2 col-xs-4">
                                  <input id="radio_1" value="1" type="radio" name="r1" class="minimal">
                                  Straightway 
                                </label>
                                <label class="col-lg-2 col-xs-4">
                                  <input id="radio_2" value="2" type="radio" name="r1" class="minimal" checked>
                                  Gradual 
                                </label>
                                <label class="col-lg-2 col-xs-4">
                                  <input id="radio_3" value="3" type="radio" name="r1" class="minimal">
                                  Behindhand 
                                </label> 
                            </div><br>
                            <div class="form-group">
                                <label><b>Notice Time :</b></label>
                                <div class="input-group col-lg-5 col-xs-12">
                                    <div id="calendar_from_date" class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                    <input type="text" class="form-control" name="from_date" id="from_date" placeholder="Select Date" readonly/>
                                </div>
                                <label><input id="checkbox" type="checkbox" name="checkbox class="minimal> Notice for next class</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Title</span>
                                <input id="notice_title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea id="notice_content" name="notice_content" class="textarea" rows="10" cols="80"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="error_mess" id="add_notice_error" for="add_notice"></label>
                                <button id="add_notice" type="button" class="btn btn-primary btn-block">Add</button>
                            </div>  
                        </form>

                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h4 class="box-title">Your Notice</h4>
                    </div>
                    <div class="box-body">
                        <table id="notice_table" width="100%" class="table">
                            <thead>
                                <tr>
                                    <th width="10%">Id</th>
                                    <th width="70%">Title</th>
                                    <th width="20%">Wrote Date</th>
                                </tr>
                            </thead>
                            @foreach($notice_list as $key => $notice)
                                <?php

                                    if($notice->level == 1){
                                        $level = "danger";
                                        $level_show = "Straightway";
                                    }
                                    else if($notice->level == 2){
                                        $level = "warning";
                                        $level_show = "Gradual";
                                    }                   
                                    else{
                                        $level = "success";
                                        $level_show = "Behindhand";
                                    }       
                                ?>
                                <tr>
                                    <td>{{$notice->id}}</td>
                                    <td><small class="label label-{{$level}} pull-right">{{$level_show}}</small>{{$notice->title}}</td>
                                    <td>{{$notice->wrote_date}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="noticeModal" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Notice</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Notice Level</span>
                                            <input id="modal_notice_level" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Wrote Date</span>
                                            <input id="modal_wrote_date" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Title</span>
                                    <input id="modal_title" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea id="modal_content" name="notice_content" class="textarea form-control" rows="10" cols="80" readonly></textarea>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-4">
                            <div id="div_modal_class"  class="box box-info">
                                <table id="received_list" class="table table-stripted table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Class Name</td>
                                            <td>Notice Date</td>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
                    <button id="modal_forward" type="button" class="btn btn-primary pull-right">Forward</button>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
    </div>    
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- CK Editor -->
<script src="{{asset("/mylib/ckeditor/ckeditor.js")}}"></script>
<link rel="stylesheet" href="{{asset("/mylib/jquery-ui-custom/jquery-ui.css")}}">
<script type="text/javascript">
$(document).ready(function() {
	$('#sidebar_noticeboard').addClass('active');

    $('#class_list_table').dataTable({
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "bAutowidth" :false,
        "info" : false,
        "paging": true,
        "pageLength": 10,
        "dom": '<"top">frt<"clear"><"bottom"p>',
    });

    $('#notice_table').dataTable({
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "bAutowidth": false,
        "info" : false,
        "paging": false,
        "columnDefs": [
            { targets: 0, visible: true },
            { targets: [1], orderable: false }
        ]
    });
    $('#radio_1').iCheck({
      radioClass: 'iradio_flat-red'
    });
    $('#radio_2').iCheck({
      radioClass: 'iradio_flat-yellow'
    });
    $('#radio_3').iCheck({
      radioClass: 'iradio_flat-blue'
    });
    $('#checkbox').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
    });
    $('#from_date').datepicker({
        dateFormat: 'D/dd/mm/yy',
        minDate: new Date()
    });
    $('#calendar_from_date').click(function(){ $('#from_date').select();});

    $('#add_notice_header').on('click',function(){
        document.getElementById('add_notice_header_button').click();
    });

    CKEDITOR.replace('notice_content', {
        toolbarGroups: [
          { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup',  ] },
          { name: 'document',    groups: [ 'mode', 'document' ] },
          { name: 'tools' },
        ]
        // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });
    CKEDITOR.instances['notice_content'].setData('');

    CKEDITOR.replace('modal_content', {
        toolbarGroups: [
          
        ]
        // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });

    $('#div_modal_class').slimScroll({
        height: '325px'
    });

    $('#notice_title').on('input',function(e){
        check_count_note();
    });

     $(document).on('click', '#class_list_table tbody tr',function(){
        if($(this).hasClass('selected')){
            $(this).removeClass('selected');
        }
        else{
            $(this).addClass('selected');
        }
    });

    $('#notice_table tbody tr').on('click',function(){
        if($(this).hasClass('selected')){
            $(this).removeClass('selected');
        }
        else{
            $('#notice_table tbody tr.selected').removeClass('selected');
            $(this).addClass('selected');
            var notice_id = $('#notice_table').dataTable().fnGetData(this)[0];
            var token = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('/teacher/noticeboard/read_notice') ?>",
                type    :"POST",
                async   :false,
                data    :{
                        'notice_id'          :notice_id,
                        '_token'        :token
                        },
                success:function(record){
                    $('#noticeModal').modal({
                        keyboard: false,
                    });
                    var level;
                    $('#modal_title').val(record.title);
                    if(record.level == '1')
                        level = 'Straightway';
                    else if(record.level == '2')
                        level = 'Gradual';
                    else
                        level = 'Behindhand';    
                    $('#modal_notice_level').val(level);
                    $('#modal_notice_date').val(record.notice_date);
                    CKEDITOR.instances['modal_content'].setData(record.content);
                    $('#modal_wrote_date').val(record.wrote_date);
                    $('#received_list tbody').empty();
                    $.each(record.notice_classes,function(i,j){
                        $('#received_list tbody').append(
                            "<tr><td>"+j['classname']+"</td><td>"+j.notice_date+"</td></tr>"
                        );
                    })
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        }
    });
    $('#add_notice').on('click',function(){
        $('#add_notice_error').parent().removeClass('has-warning');
        $('#add_notice_error').empty();
        var content = CKEDITOR.instances['notice_content'].getData();
        var title = $('#notice_title').val();
        var notice_date = $('#from_date').val();
        var class_list = [];
        var error_mess = [];
        var token = $('input[name="_token"]').val();
        var level = $('input[name="r1"]:checked').val();
        var next_class = $('#checkbox').is(":checked");
        var check = true;
        $('#class_list_table tbody tr.selected td:first-child').each(function(i,j){
            class_list.push(j.innerHTML);
        })
        if(class_list.length == 0){
            check = false;
            error_mess.push("Please Select Class To Add Notice");
        }
        if(notice_date == "" && next_class == false){
            check = false;
            error_mess.push("Please Select Notice Date");
        }
        if(title == "" || content == ""){
            check = false;
            error_mess.push("Notice Title And Notice Content Can Not Empty");
        }
        if(!check){
            $('#add_notice_error').empty();
            $.each(error_mess,function(i,j){
                $('#add_notice_error').append(j+"<br>");
            });
            $('#add_notice_error').parent().addClass('has-warning');
        }
        else{
            $.ajax({
                url     :"<?= URL::to('/teacher/noticeboard/add_notice') ?>",
                type    :"POST",
                async   :false,
                data    :{
                        'content'          :content,
                        'title'         :title,
                        'class_list'    :class_list,
                        'notice_date'     :notice_date,
                        'level'         :level,
                        'next_class'    :next_class,
                        '_token'        :token
                        },
                success:function(record){
                    // location.reload();
                    console.log(record);
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        }
    });
    $('#modal_forward').on('click', function(){
        $('#noticeModal').modal('hide');
        console.log($('#modal_title').val());
        $('#notice_title').val($('#modal_title').val());
        CKEDITOR.instances['notice_content'].setData(CKEDITOR.instances['modal_content'].getData());
        if($('#add_notice_header_button').children().hasClass('fa-plus')){
            document.getElementById('add_notice_header_button').click();
        }
    });

    function check_count_note(){
        var data = $('#notice_title').val();
        var count = data.length;
        if(count > 100){
            $('#notice_title').parent().addClass('has-warning');
        }
        else{
            $('#notice_title').parent().removeClass('has-warning');
        }
    };
});
</script>
@endsection