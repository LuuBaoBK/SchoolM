@extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
</style>
<section class="content-header">
    <h1>
        Admin
        <small>Student_Class</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Student_Class</li>
    </ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-6 col-xs-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#searchbyclass" data-toggle="tab">Search By Class</a></li>
          <li><a href="#searchbyid" class="first_time" value="0" data-toggle="tab">Search By Student</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="searchbyclass">
                <form id="student_search_form" method="POST" role="form">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                <label for="scholastic">Scholastic</label>
                                <select id="scholastic" name="scholastic" class="form-control">
                                    <option value="-1" selected>-- Select --</option>;
                                    <?php
                                        $year = date("Y") + 2;
                                        for($year;$year >=2010 ;$year--){
                                            echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                                        }
                                    ?>
                                    <option value="0">-- All --</option>;
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="grade">Grade</label>
                                <select id="grade" name="grade" class="form-control">
                                    <option value="-1" selected>-- Select --</option>;                                            
                                    <option>6</option>;
                                    <option>7</option>;
                                    <option>8</option>;
                                    <option>9</option>;
                                    <option value="0">-- All --</option>;
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="group">Group</label>
                                <select id="group" name="group" class="form-control">
                                    <option value="-1" selected>-- Select --</option>;
                                    <option value="A">A</option>;
                                    <option value="B">B</option>;
                                    <option value="C">C</option>;
                                    <option value="D">D</option>;
                                    <option value="MT">MT</option>;
                                    <option value="0">-- All --</option>
                                </select>     
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="classname">Class Name</label>
                                <select id="classname" name="classname" class="form-control">
                                    <option value="-1" selected>Select Scholastic First</option>;
                                </select> 
                            </div>
                             <div class="form-group col-lg-4">
                                <label for="isPassed">Type</label>
                                <select id="isPassed" name="isPassed" class="form-control">
                                    <option value="-1" selected>--- Select --</option>;
                                    <option value="1">Passed</option>;
                                    <option value="0">Not Passed</option>;
                                    <option value="2" selected>-- All --</option>;
                                </select> 
                            </div>
                        </div>
                    </div><!-- /.box-body -->   
                </form>
                <div class="box">
                    <div class="box-body">
                        <table id="student_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Full Name</th>
                                    <th>Date Of Birth</th>
                                    <th>IsPassed</th>
                                    <th>
                                        <button type="button" id="selectall_button" class="btn btn-block btn-primary btn-sm">Select All</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="student_table_info">
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="button" value="0" id="addtonewclass" class="btn btn-block btn-primary btn-sm">Add To New Class</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="searchbyid">
                <form id="student_search_form_2" method="POST" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="enrolled_year">Enrolled Year</label>
                                <select id="enrolled_year" name="enrolled_year" class="form-control">
                                    <option value="-1" selected>-- Select --</option>;
                                    <?php
                                        $year = date("Y") + 2;
                                        for($year;$year >=2010 ;$year--){
                                            echo ("<option value='".$year."'>".$year."</option>");
                                        }
                                    ?>
                                    <option value="0">-- All --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4 col-xs-7">
                                <label for="search_firstname">First Name</label>
                                <input id="search_firstname" type="text" class="form-control" name="search_firstname" id="search_firstname" placeholder="Student First Name">
                            </div>
                            <div class="form-group col-lg-4 col-xs-7">
                                <label for="search_middlename">Middle Name</label>
                                <input id="search_middlename" type="text" class="form-control" name="search_middlename" id="search_middlename" placeholder="Student Middle Name">
                            </div>
                            <div class="form-group col-lg-4 col-xs-7">
                                <label for="search_lastname">Last Name</label>
                                <input id="search_lastname" type="text" class="form-control" name="search_lastname" id="search_lastname" placeholder="Student Last Name">
                            </div>        
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button style="margin-top: 1.7em" type="button" id="search" class="pull-right btn btn-block btn-primary btn-flat">Search</button>  
                            </div>
                        </div>
                        
                    </div><!-- /.box-body --> 
                </form>
                <div style="display: none" class="box needdisplay">
                    <div  class="box-body">
                        <table  id="student_table_2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Full Name</th>
                                    <th>Date Of Birth</th>
                                    <th>Enrolled Year</th>
                                    <th>
                                        <button type="button" id="selectall_button_2" class="btn-primary">Select All</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="student_table_info_2">
                            </tbody> 
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="button" value="0" id="addtonewclass_2" class="btn btn-block btn-primary btn-sm">Add To New Class</button>
                    </div>
                </div>
            </div>
        </div>
    </div>      
</div> <!-- </.half left>  -->
<div class="col-lg-6 col-xs-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#newclassinfo" data-toggle="tab">Select New Class</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="newclassinfo">
                <form id="new_class_form" method="POST" role="form">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="scholastic_1">Scholastic</label>
                                <select id="scholastic_1" name="scholastic_1" class="form-control">
                                    <option value="-1" selected>-- Select --</option>;
                                    <?php
                                        $year = date("Y") + 2;
                                        for($year;$year >=2010 ;$year--){
                                            echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                                        }
                                    ?>
                                    <option value="0">-- All --</option>;
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="grade_1">Grade</label>
                                <select id="grade_1" name="grade_1" class="form-control">
                                    <option value="-1" selected>-- Select --</option>;                                            
                                    <option>6</option>;
                                    <option>7</option>;
                                    <option>8</option>;
                                    <option>9</option>;
                                    <option value="0">-- All --</option>;
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="group_1">Group</label>
                                <select id="group_1" name="group_1" class="form-control">
                                    <option value="-1" selected>-- Select --</option>;
                                    <option value="A">A</option>;
                                    <option value="B">B</option>;
                                    <option value="C">C</option>;
                                    <option value="D">D</option>;
                                    <option value="MT">MT</option>;
                                    <option value="0">-- All --</option>
                                </select>     
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="classname_1">Class Name</label>
                                <select id="classname_1" name="classname_1" class="form-control">
                                    <option value="-1" selected>Select Scholastic First</option>;
                                </select> 
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="numbersofstudents">Numbers of Students</label>
                                <input type="text" class="form-control" name="numbersofstudents" id="numbersofstudents" placeholder="Numbers of Students" disabled>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </form>
                <table id="student_table_1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Date Of Birth</th>
                            <th>IsPassed</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="student_table_info_1">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- </.half right>  -->
</div> <!-- /.row -->
<div id="errorModal" class="modal modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Please Select New Class First
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
        </div>
    </div>
</div>
<div id="resultModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Result</h4>
            </div>

            <div class="modal-body">
                <div style="color : black" class="row">
                    <div class="col-lg-4 col-xs-4">
                        <div id="resultbox_error" class="box box-danger">
                            <div id="errorlist-header" class="box-header">
                            </div>
                            <div id="errorlist-body" class="box-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-4">
                        <div id="resultbox_warning" class="box box-warning">
                            <div id="warninglist-header" class="box-header">
                            </div>
                            <div id="warninglist-body" calss="box-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-4">
                        <div id="resultbox_success" class="box box-success">
                            <div id="successlist-header" class="box-header">
                            </div>
                            <div id="successlist-body" calss="box-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
</div>
<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#resultModal"> -->
</section>
<!-- DATA TABES SCRIPT -->
        <script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
        
<!-- page script -->
<script type="text/javascript">
$(document).ready(function() {

    $(function() {
        $('#sidebar_list_3').addClass('active');
        $('#sidebar_list_3_2').addClass('active');
        $('#student_table').dataTable({
            "scrollCollapse": true,
            "scrollY" : "350px",
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "order": [[ 1, "desc" ]]
        });
        $('#student_table_2').DataTable({
            "scrollCollapse": true,
            "scrollY" : "350px",
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "order": [[ 1, "desc" ]]
        });
        $('#student_table_1').dataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "order": [[ 1, "desc" ]]
        });
        $('#resultbox_error').slimScroll({
            height: '250px'
        });
        $('#resultbox_warning').slimScroll({
            height: '250px'
        });
        $('#resultbox_success').slimScroll({
            height: '250px'
        });
    });
    
/****************************************************************/
    // Half left Even
    $( "#scholastic" ).change(function() {
        if($('#scholastic').val() != -1){
            updateClassname();
            $("#scholastic option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $( "#grade" ).change(function() {
        if($('#grade').val() != -1){
            updateClassname();
            $("#grade option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $( "#group" ).change(function() {
        if($('#group').val() != -1){
            updateClassname();
            $("#group option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });

    $( "#classname" ).change(function() {
        if($('#classname').val() != -1){
            showClass();
            $("#classname option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $( "#isPassed" ).change(function() {
        if($('#isPassed').val() != -1){
            showClass();
            $("#isPassed option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $('#student_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $(this).addClass('selected');          
        }
    });
    $('#student_table_2 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $(this).addClass('selected');          
        }
    });

    $('#selectall_button').click(function(){
        var count = 0;
        $('#student_table tbody tr').each(function() {
            if( $(this).hasClass('selected') ){
                //do nothing
            }
            else{
                $(this).addClass('selected');
                count ++;
            }
        });
        if(count == 0){
            $('#student_table tbody tr').each(function() {
                $(this).removeClass('selected');
            });
        }
    });
    $('#selectall_button_2').click(function(){
        var count = 0;
        $('#student_table_2 tbody tr').each(function() {
            if( $(this).hasClass('selected') ){
                //do nothing
            }
            else{
                $(this).addClass('selected');
                count ++;
            }
        });
        if(count == 0){
            $('#student_table_2 tbody tr').each(function() {
                $(this).removeClass('selected');
            });
        }   
    });
    $('#search').click(function(){
        searchbyid();
    });
    $('#addtonewclass').click(function(){
        var Idlist = [];
        $('#student_table tr.selected td:first-child').each(function(i,j){
            Idlist.push(j.innerHTML);
        }); 
        addstudent(Idlist,1);
    });
    $('#addtonewclass_2').click(function(){
        var Idlist = [];
        $('#student_table_2 tr.selected td:first-child').each(function(i,j){
            Idlist.push(j.innerHTML);
        }); 
        addstudent(Idlist,2);
    });
    
/****************************************************************/
    // Half right Even
    $( "#scholastic_1" ).change(function() {
        if($('#scholastic_1').val() != -1){
            updateClassname_1();
            $("#scholastic_1 option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $( "#grade_1" ).change(function() {
        if($('#grade_1').val() != -1){
            updateClassname_1();
            $("#grade_1 option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $( "#group_1" ).change(function() {
        if($('#group_1').val() != -1){
            updateClassname_1();
            $("#group_1 option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });

    $( "#classname_1" ).change(function() {
        if($('#classname_1').val() != -1){
            showClass_1();
            $("#classname_1 option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
/*************************Half Left Code***********************************/
    function updateClassname(){
        var scholastic      = $('#scholastic').val();
        var grade           = $('#grade').val();
        var group           = $('#group').val();
        var token           = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/updateclassname') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'    :scholastic,
                    'grade'         :grade,
                    'group'         :group,
                    '_token'        :token
                    },
            success:function(record){
                $("#classname").empty();
                if(record.count > 0){
                    $('#classname').append("<option value='-1' selected>-- Select --</option>");
                    $.each(record.data, function(i, row){
                        $('#classname').append("<option value='"+row.id+"'>"+row.id+"  |  "+row.classname+"</option>");
                    });
                    $('#classname').append("<option value='0'>-- All --</option>");
                }
                else{
                    $('#classname').append("<option value='-1'>No Record</option>");
                }
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }
    function showClass(){
        var scholastic      = $('#scholastic').val();
        var grade           = $('#grade').val();
        var group           = $('#group').val();
        var classname       = $('#classname').val();
        var isPassed        = $('#isPassed').val();
        var token           = $('input[name="_token"]').val();
        var button          = "";
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/showclass') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'    :scholastic,
                    'grade'         :grade,
                    'group'         :group,
                    'classname'     :classname,
                    'isPassed'      :isPassed,
                    '_token'        :token
                    },
            success:function(record){
                $('#student_table').dataTable().fnClearTable();
                button="";
                $.each(record, function(i, row){
                    $('#student_table').dataTable().fnAddData([
                        row.student_id,
                        row.student.user.firstname+" "+row.student.user.middlename+" "+row.student.user.lastname,
                        row.student.user.dateofbirth,
                        row.ispassed,
                        button
                    ]);
                });
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }
    function searchbyid(){
        var enrolled_year      = $('#enrolled_year').val();
        var studentid          = $('#studentid').val();
        var search_firstname   = $('#search_firstname').val();
        var search_middlename  = $('#search_middlename').val();
        var search_lastname    = $('#search_lastname').val();
        var token              = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/showstudent') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'enrolled_year'     :enrolled_year,
                    'studentid'         :studentid,
                    'search_firstname'  :search_firstname,
                    'search_middlename' :search_middlename,
                    'search_lastname'   :search_lastname,
                    '_token'            :token
                    },
            success:function(record){
                console.log(record);
                $('.needdisplay').css("display","block");
                if(record.error == "0"){
                    $('#student_table_2').dataTable().fnClearTable();
                }
                else{
                    $('#student_table_2').dataTable().fnClearTable();
                    button="";
                    $.each(record, function(i, row){
                        $('#student_table_2').dataTable().fnAddData([
                            row.id,
                            row.user.firstname+" "+row.user.middlename+" "+row.user.lastname,
                            row.user.dateofbirth,
                            row.enrolled_year,
                            button
                        ]);
                    });
                }
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }
    function addstudent(Idlist,Type){
        var studentlist = [];
        var classid_new= $('#classname_1').val();
        if(Type == "1"){
            var classid_old = $('#classname').val();
        }
        else{
            var classid_old = "";
        }
        var token           = $('input[name="_token"]').val();
        if(Idlist != ""){
            studentlist.push(Idlist);
        }
        else{
            var error = [];
            error.push("No data available in table");
            studentlist.push(error);
        }

        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/addstudent') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'studentlist'   :studentlist,
                    'classid_old'   :classid_old,
                    'classid_new'   :classid_new,
                    'type'          :Type,
                    '_token'        :token
                    },
            success:function(record){
                if(record.error != null){
                    $('#errorModal').modal('show');
                }
                else{
                    $('#resultModal').modal('show');
                    var count = 0;
                    $('#errorlist-body').empty();
                    $.each(record.errorlist, function(i,item){
                        $('#errorlist-body').append("<p>"+(i+1)+" | "+item.id+"</p");
                        count = count + 1;
                    });
                        $('#errorlist-header').empty();
                        $('#errorlist-header').append("You have "+count+" duplicated Id");
                        count = 0;
                    $('#warninglist-body').empty();
                    $.each(record.warninglist, function(i,item){
                        $('#warninglist-body').append("<p>"+(i+1)+" | "+item.id+"</p");
                        count = count + 1;
                    });
                        $('#warninglist-header').empty();
                        $('#warninglist-header').append("You have "+count+" warning Id");
                        count = 0;
                    $('#successlist-body').empty();
                    $.each(record.successlist, function(i,item){
                        $('#successlist-body').append("<p>"+(i+1)+" | "+item.id+"</p");
                        count = count + 1;
                    });
                        $('#successlist-header').empty();
                        $('#successlist-header').append("You have "+count+" success Id");
                    showClass_1();

                }
                
                // $('#student_table_1').dataTable().fnClearTable();
                // button="";
                // $.each(record, function(i, row){
                //     $('#student_table_1').dataTable().fnAddData([
                //         row.student_id,
                //         row.student.user.firstname+" "+row.student.user.middlename+" "+row.student.user.lastname,
                //         row.student.user.dateofbirth,
                //         row.ispassed
                //     ]);
                // });
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }
/*************************Half Right Code***********************************/
    function updateClassname_1(){
        var scholastic      = $('#scholastic_1').val();
        var grade           = $('#grade_1').val();
        var group           = $('#group_1').val();
        var token           = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/updateclassname') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'    :scholastic,
                    'grade'         :grade,
                    'group'         :group,
                    '_token'        :token
                    },
            success:function(record){
                $("#classname_1").empty();
                if(record.count > 0){
                    $('#classname_1').append("<option value='-1' selected>-- Select --</option>");
                    $.each(record.data, function(i, row){
                        $('#classname_1').append("<option value='"+row.id+"'>"+row.id+"  |  "+row.classname+"</option>");
                    });
                }
                else{
                    $('#classname_1').append("<option value='-1'>No Record</option>");
                }
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }
    function showClass_1(){
        var scholastic      = $('#scholastic_1').val();
        var grade           = $('#grade_1').val();
        var group           = $('#group_1').val();
        var classname       = $('#classname_1').val();
        var token           = $('input[name="_token"]').val();
        var button          = "";
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/showclass') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'    :scholastic,
                    'grade'         :grade,
                    'group'         :group,
                    'classname'     :classname,
                    '_token'        :token
                    },
            success:function(record){
                $('#student_table_1').dataTable().fnClearTable();
                var count = 0;
                $.each(record, function(i, row){
                    button= "<button type='button' class='btn-danger' value='"+row.student_id+"'>Remove</button>";
                    $('#student_table_1').dataTable().fnAddData([
                        row.student_id,
                        row.student.user.firstname+" "+row.student.user.middlename+" "+row.student.user.lastname,
                        row.student.user.dateofbirth,
                        row.ispassed,
                        button
                    ]);
                    count = count + 1;
                });
                $('#numbersofstudents').val(count);
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }

    $('#student_table_1 tbody').on( 'click', 'button', function () {
                  //  selected_row_index = $('#parent_table').dataTable().fnGetPosition(this);
        var $tr             = $(this).closest('tr');
        var myRow           = $tr.index();
        var student_id      = $(this).val();
        var class_id         = $('#classname_1').val(); 
        var token           = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/admin/class/studentclassinfo/removestudent') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'student_id'    :student_id,
                    'class_id'      :class_id,
                    '_token'        :token
                    },
            success:function(record){
                $('#student_table_1').dataTable().fnDeleteRow(myRow);
                console.log(record);
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });
    
});
</script>

@endsection