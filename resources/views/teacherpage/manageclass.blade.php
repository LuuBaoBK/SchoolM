@extends('mytemplate.blankpage_te')

@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
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
					 				<input type="text" class="form-control" id="scholastic" value={{$year}} readonly>
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
			 				<div class="col-lg-3">
				 				<ul class="sidebar-menu">
				 					<li><h4 class="text text-center">Select Action</h4></li>
				 					<li><button id='update' class='btn btn-primary btn-block' {{$disable}} >Update Status</button></li>
				 					<br>
				 					<li><button id="setConduct" class="btn btn-primary btn-block" {{$disable}} >Set Conduct</button></li>
			 					</ul>
				 			</div>
				 			<div class="col-lg-9">
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
					 							echo "<td>".$student->gpa."</td>";
					 							echo "<td>".$student->conduct."</td>";
					 							$student->ispassed = ($student->ispassed == 1) ? "Done" : "Fail";
					 							echo "<td>".$student->ispassed."</td>";
					 							echo "<td>".$student->note."</td>";
					 							echo "</tr>";
					 						}
					 					?>
					 				</tbody>
					 				<tfoot>
					 					<tr><td><button id="select_all_button" class="btn btn-flat btn-primary pull-left">Select All</button></td></tr>
					 				</tfoot>
					 			</table>

					 		</div>
			 			</div>
			 		</div>
			 	</div>
		 	</div>        
		</div>
	</div>
</div>
<div id="editModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 id="modal_title" class="modal-title"></h4>
                <form id="modal_edit_form">
                    <div class="form-group col-lg-8">
                        <label for="modal_score">Score</label>
                        <input type="text" id="modal_score" name="modal_score" class="form-control" data-mask/>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="modal_note">Note</label>
                        <input type="text" id="modal_note" class="form-control" name="modal_note">
                        <label id="count_text" for="modal_note" class="pull-right"></label>
                        <input type="hidden" id="modal_hidden_index" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal_save_button" class="btn btn-primary pull-right" data-dismiss="">Save</button>
                <button type="button" id="modal_close_button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
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
<script type="text/javascript">
$(document).ready(function() {
	$('#student_list_table').dataTable({
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "scrollY": "500px",
        "scrollCollapse": true,
        "info" : false,
        "paging": false,
        "bAutoWidth": true
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
                console.log(record);
                location.reload();
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });
    $('#setConduct').on('click',function(){
    	$('#editModal').modal('show');
    });
});
</script>
@endsection