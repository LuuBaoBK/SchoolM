@extends('mytemplate.blankpage_te')

@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
textarea {
   resize: vertical;
   width: 100%;
}
</style>
<section class="content-header">
    <h1>
        Teacher
        <small>Dash Board</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/teacher/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
<div class="row">
	<div class="col-lg-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
	          <h4 class="box-title">Manage Class</h4>
	        </div>
		 	<div  class="box-body">
                @if($class==null)
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i>You're not homeroom teacher</h4>
                    This feature is only available for teachers who are homeroom teacher of one class
                </div>
                @else
		 		<div class="col-lg-12">
			 		<div class="box box-primary">
			 			<div class="box-header">
			 				<h4 class="box-title">Class Info</h4>
			 			</div>
			 			<div class="box box-body">
			 				<form role="form">
			 					<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
			 					<div class="form-group col-lg-4">
					 				<label for="scholastic">Scholastic</label>
					 				<input type="text" class="form-control" id="scholastic" value='<?=$year?>' readonly>
					 			</div>
					 			<div class="form-group col-lg-4">
					 				<label for="classname">Class Name</label>
					 				<input type="text" class="form-control" id="classname" value={{$class->classname}} readonly>
					 			</div>
					 			<div class="form-group col-lg-4">
						 			<label for="total_student">Total Student</label>
					 				<input type="text" class="form-control" id="total_student" value={{$total_student}} readonly>
					 			</div>
				 			</form>
			 			</div>
			 			<div class="box-footer">
				 			<div class="col-lg-8">
				 				<div id="waiting_record2" style="display:none"  class="text-center">
		                            <br>
		                            <i class="fa fa-spin fa-refresh"></i>&nbsp; Loading...
		                        </div>
					 			<table id="student_list_table" class="table table-bordered">
					 				<thead>
					 					<tr>
					 						<td>Id</td>
					 						<td>Full Name</td>
					 						<td>GPA</td>
					 						<td>Conduct</td>
					 						<td>Status</td>
					 						<td>Note</td>
					 					</tr>
					 				</thead>
					 				<tbody>
					 					<?php 
					 						foreach ($student_list as $key => $student) {
					 							echo "<tr>";
					 							echo "<td>".$student->student_id."</td>";
					 							echo "<td>".$student->fullname."</td>";
					 							echo "<td>".$student->GPA."</td>";
					 							echo "<td>".$student->conduct."</td>";
					 							$student->ispassed = ($student->ispassed == 1) ? "Done" : "Fail";
					 							echo "<td>".$student->ispassed."</td>";
					 							echo "<td>".$student->note."</td>";
					 							echo "</tr>";
					 						}
					 					?>
					 				</tbody>
					 				<tfoot>
					 					<tr col-span="6">
                                            <td>
                                                <button id="select_all_button" class="btn btn-block btn-primary pull-left">Select All</button>
                                            </td>
                                        </tr>
					 				</tfoot>
					 			</table>
					 		</div>
                            <div class="col-lg-4">
                                <div class='box box-primary'>
                                    <div class="box-header">
                                        <h4 class="text text-center box-title">Set Conduct</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="conduct">Total Selected Student</label>
                                            <select id="conduct" name="conduct" class="form-control" {{$disable}}>
                                                <option value="excellent" selected>Excellent</option>;
                                                <option value="good" >Good</option>;
                                                <option value="bad" >Bad</option>;
                                            </select>
                                        </div> 
                                        <button id="setConduct" class="btn btn-primary btn-block" {{$disable}} >Set Conduct</button>
                                    </div>
                                </div>
                                <div class='box box-primary'>
                                    <div class="box-header">
                                        <h4 class="text text-center box-title">Add Note</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="note_add">Note</label>
                                            <textarea id="note_add" name="note_add" maxlength="255" value="" {{$disable}}>
                                            </textarea>
                                        </div>
                                        <button id='addnote' class='btn btn-primary btn-block' {{$disable}} >Add</button>
                                    </div>
                                </div>
                                <div class='box box-primary'>
                                    <div class="box-header">
                                        <h4 class="text text-center box-title">Update Status</h4>
                                    </div>
                                    <div class="box-body">
                                        <button id='update' class='btn btn-primary btn-block' {{$disable}} >Update</button>
                                    </div>
                                </div>
                            </div>
			 			</div>
			 		</div>
			 	</div>
                @endif
		 	</div>        
		</div>
	</div>
</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#list_manage_class').addClass('active');
    $('#note_add').empty();
	$('#student_list_table').dataTable({
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "scrollY": "500px",
        "scrollCollapse": true,
        "info" : false,
        "paging": false,
        "bAutoWidth": true,
        "columns": [
            { "width": "8%" },
            { "width": "28%" },
            { "width": "7%" },
            { "width": "10%" },
            { "width": "8%" },
            { "width": "52%" }
        ],
    });
    $('#student_list_table tbody tr').on('click',function(){
    	if($(this).hasClass('selected')){
    		$(this).removeClass('selected');
    	}
    	else{
    		$(this).addClass('selected');
    	}
    });
    $('#select_all_button').on('click',function(){
    	var count = 0;
        $('#student_list_table tbody tr').each(function() {
            if( $(this).hasClass('selected') ){
                //do nothing
            }
            else{
                $(this).addClass('selected');
                count ++;
            }
        });
        if(count == 0){
            $('#student_list_table tbody tr').each(function() {
                $(this).removeClass('selected');
            });
        }
    });
    $('#update').on('click',function(){
    	$('#waiting_record2').css('display','block');
    	var token = $('input[name="_token"]').val();
    	$.ajax({
            url     :"<?= URL::to('/teacher/manage-class/update') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    '_token'        :token
                    },
            success:function(record){
                location.reload();
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });
    $('#setConduct').on('click',function(){
    	var Idlist = [];
        $('#student_list_table tr.selected td:first-child').each(function(i,j){
            Idlist.push(j.innerHTML);
        }); 
        var conduct = $('#conduct').val();
        var token = $('input[name="_token"]').val();
        if(Idlist.length > 0){
            $.ajax({
                url     :"<?= URL::to('/teacher/manage-class/set_conduct') ?>",
                type    :"POST",
                async   :false,
                data    :{
                        'Idlist'        :Idlist,
                        'conduct'       :conduct,
                        '_token'        :token
                        },
                success:function(record){
                    var index;
                    $('#student_list_table tr.selected').each(function(i,j){
                        index = $('#student_list_table').dataTable().fnGetPosition(this);
                        index = $('#student_list_table').dataTable().fnUpdate(conduct,index,3);
                    });
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        };
    });
    
    $('#addnote').on('click',function(){
        var Idlist = [];
        $('#student_list_table tr.selected td:first-child').each(function(i,j){
            Idlist.push(j.innerHTML);
        }); 
        var note_add = $('#note_add').val();
        var token = $('input[name="_token"]').val();
        if(Idlist.length > 0){
            $.ajax({
                url     :"<?= URL::to('/teacher/manage-class/add_note') ?>",
                type    :"POST",
                async   :false,
                data    :{
                        'Idlist'        :Idlist,
                        'note_add'       :note_add,
                        '_token'        :token
                        },
                success:function(record){
                    var index;
                    $('#student_list_table tr.selected').each(function(i,j){
                        index = $('#student_list_table').dataTable().fnGetPosition(this);
                        index = $('#student_list_table').dataTable().fnUpdate(note_add,index,5);
                    });
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        };
    });
});
</script>
@endsection