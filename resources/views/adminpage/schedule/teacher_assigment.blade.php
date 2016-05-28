@extends('adminpage.schedule.schedule_template')
@section('schedule_message')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
</style>
<div class="box box-warning box-solid">
	<div class="box-header">Error List</div>
	<div id="error_list" class="box-body">
		<ul class="list-group">
			<li class="list-group-item list-group-item-danger">Duplicated Subject</li>
			@foreach($duplicated_list as $row)
			<li class="list-group-item">{{$row}}</li>
			@endforeach
		</ul>
		<ul class="list-group">
			<li class="list-group-item list-group-item-danger">No Assigment</li>
			@foreach($no_assigment_list as $row)
			<li class="list-group-item">{{$row}}</li>
			@endforeach
		</ul>
	</div>
</div>
@endsection
@section('schedule_content')
<div class="box box-primary">
    <div class="box-header">
        <p class="text-center" style="font-size:25px">Teacher Assigment</p>
        <?php 
        	$year = date("Y");
        	$year = (date("m") < 8) ? ($year -1) : $year;
        	$data_show = $year."-".($year+1);
        ?>
        <p class="text-center" style="font-size:17px">{{$data_show}}</p>
    </div>
    <div class="box-body">
    	<ul class="list-group">
	    	<li class="list-group-item" style="border:none">
	    		<button id="btn_create_assigment" class="btn btn-primary btn-flat">Create New Assigment</button>
	    		<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
	    	</li>
	    	<li class="list-group-item text-center" style="display:none; border:none"><i id="onloading" class="fa fa-refresh fa-spin" ></i>&nbsp Loading new assigment ... <i class="fa fa-refresh fa-spin" ></i></li>
	    	
	        <li class="list-group-item" style="border:none">
	        	@if(count($teacher_list) > 0)
	        	<ul class="nav nav-tabs">
		        	<li class="active"><a href="#show_by_teacher"  data-toggle="tab" aria-expanded="false">Show by teacher</a></li>
		        	<li class=""><a href="#show_by_class" data-toggle="tab" aria-expanded="true">Show by class</a></li>
		        </ul>
		        <div id="tab-content" class="tab-content">
		        	<div class="tab-pane active" id="show_by_teacher">
		                <div class="box-body table-responsive">
					        <table id="table_show_by_teacher" class="table table-striped table-hover">
						        <thead>
						            <tr>
						              <th>ID</th>
						              <th>Full name</th>
						              <th>Subject</th>
						              <th>Homeroom Class</th>
						              <th width="50%">Assigment</th>
						            </tr>
						        </thead>
					          	<tbody>
					          		@foreach($teacher_list as $teacher)
					          		<tr>
					          			<td>{{$teacher->id}}</td>
					          			<td>{{$teacher->teacher_fullname}}</td>
					          			<td>{{$teacher->subject}}</td>
					          			<td>{{$teacher->homeroom}}</td>
					          			<td>{{$teacher->assigment}}</td>
					          		</tr>
					          		@endforeach
					          	</tbody>
						        <tfoot>
						        	
						        </tfoot>
					        </table>
					    </div>
		            </div>
		            <div class="tab-pane" id="show_by_class">
		                <div class="box-body table-responsive">
		                	<table id="table_show_by_class" class="table table-striped table-hover dataTable">
							    <thead>
							        <tr>
							        	<th>Class</th>
							        @foreach($subject_list as $subject)
							        	<th>{{$subject->subject_name}}</th>
						        	@endforeach
							      </tr>
							    </thead>
							  	<tbody>
							  		@foreach($class_list as $class)
							  		<tr>
							  			<td>{{$class->id}}</td>
							  			@foreach($subject_list as $subject)
							  			<td>{{$class[$subject->subject_name]}}</td>
							  			@endforeach
							  		</tr>
							  		@endforeach
							  	</tbody>
							</table>
					        
					    </div>
		            </div> 
		        </div>
		        @else
		        <div class="alert alert-warning alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
	               	No assigment
              	</div>
              	@endif
		    </li>
		</ul>
	</div>
</div>
<div id="edit_modal" class="modal fade modal-default">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #3c8dbc; color: white">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              	<span aria-hidden="true">&times;</span></button>
	            <p><h4 class="modal-title text-center">Edit Assigment</h4><p>
	            <table id="edit_info" class="table table-hover dataTable">
			        <thead>
			            <tr>
			              <th>ID</th>
			              <th>Giáo viên</th>
			              <th>Môn</th>
			              <th>Lớp CN</th>
			            </tr>
			            <tr id="tr_teacher_info">

			            </tr>
			        </thead>
			        <tbody>
			        </tbody>
		        </table>
			</div> 
			<div class="modal-body">
				<div class="col-lg-6 col-xs-12">
					<div class="box">
						<div class="box-header"><h4 class="box-title">Classes List</h4></div>
			           	<div class="dataTables_scrossBody" style="overflow: auto; height: 350px; width: 100%">
	                    	<div class="box-body">
		                        <table id="not_add_classes" class="table table-bordered table-striped">
		                            <thead>
		                                <tr>
		                                	<th style="display:none">Class id</th>
		                                    <th style="display:none">Class List</th>
		                                </tr>
		                            </thead>
	                            	<tbody>
                            		</tbody>
	                        	</table>
		                    </div>
	                    </div>
	                    <div class="box-footer">
                        	<button type="button" value="0" id="btn_add_class" class="btn btn-block btn-primary btn-sm">Add</button>
                    	</div>
               		</div><!--end box-->
				</div>
				<div class="col-lg-6 col-xs-12">
					<div class="box">
						<div class="box-header"><h4 class="box-title">Classes Assigment</h4></div>
	                   	<div class="dataTables_crossBody" style="overflow: auto; height: 350px; width: 100%">
		                   	<div class="box-body">
		                   		<table id = "added_classes" class="table table-bordered table-striped">
		                   			<thead>
		                   				<tr>
		                   					<th style="display:none">Class id</th>
		                   					<th style="display:none">Classes Assigment</th>	
		                   				</tr>
		                   			</thead>
		                   			<tbody>
		                   			</tbody>
		                   		</table>
		                   	</div>
	                   	</div>
	                   	<div class="box-footer">
	                   		<button type="button" value="1" id="btn_remove_class" class="btn btn-block btn-primary btn-sm">Remove</button>
	                   	</div>
	               </div>
				</div>
				<div class="text-center" id="onloading_model" style="display:none"><i class="fa fa-refresh fa-spin"  ></i>&nbsp Loading new assigment ... <i class="fa fa-refresh fa-spin" ></i></div>
				<button type="button" class="btn btn-block btn-primary text-center" id="btn_update_change">Update</button>
			</div>
			<div class="modal-footer" style="border:none">
			</div>
		</div>	
	</div>
</div>
<div id="confirm_modal" class="modal fade modal-warning">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				Warning
			</div>
			<div class="modal-body">
				This Action Will Delete Your Old Assigment For This Scholastic.
				<p>Please Confirm That You Want To Create New Teacher Assigment.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<button id="btn_reconfirm" type="button" class="btn btn-default pull-right" data-dismiss="modal">Confirm</button>
			</div>
		</div>
	</div>
</div>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function()
    {	
    	// $('#duplicated_table').slimScroll({
    	// 	height: '250px'
    	// });
    	// $('#no_assigment_table').slimScroll({
    	// 	height: '250px'
    	// });
    	$('#table_show_by_teacher').dataTable({
            "bAutoWidth": false,
            "bFilter":true,
            "bSort": true,
            "bLengthChange":false,
            "bInfo":false,
            "bPaginate":true,
            "pageLength": 10,
            // "scrollCollapse":true,
            "columnDefs": [ {
				"targets": 4,
				"orderable": false
			} ]
        });
        $('#table_show_by_class').dataTable({
            "bAutoWidth": false,
            "bFilter":true,
            "bSort":false,
            "bLengthChange":false,
            "bInfo": false,
            "bPaginate":true,
            "pageLength": 6
        });
        $('#added_classes').dataTable({
            "bAutoWidth": false,
            "bFilter":false,
            "bSort": true,
            "bLengthChange":false,
            "bInfo":false,
            "bPaginate":false,
            "columnDefs": [ {
				"targets": 0,
				"visible": false
			} ]
        });
        $('#not_add_classes').dataTable({
            "bAutoWidth": false,
            "bFilter":false,
            "bSort": true,
            "bLengthChange":false,
            "bInfo":false,
            "bPaginate":false,
            "columnDefs": [ {
				"targets": 0,
				"visible": false
			} ]
        });
        $('#btn_teacher_assigment').addClass('active');
        $('#btn_create_assigment').on('click',function(){
        	$('#confirm_modal').modal('show');
        });

        $('#btn_reconfirm').on('click',function(){
        	$('#confirm_modal').modal('hide');
        	$('#onloading').parent().css('display','block');
        	var token = $("input[name='_token']").val();
        	setTimeout(function(){ 
        		$.ajax({
					url :"<?= URL::to('admin/schedule/create_new_assigment')?>" ,
					type: "POST",
					async: false,
					data:{
						'_token': token
					}, 
					success:function(gv){
						location.reload();
					},
					error:function(){
						alert("Has something go wrong!!");
					}
				});
        	}, 1000);
        })

        $('#table_show_by_teacher tbody').on('click','tr',function(){
        	if($(this).hasClass('selected')){
        		$(this).removeClass('selected');
        	}
        	else{
        		$('#table_show_by_teacher tr.selected').removeClass('selected');
        		$(this).addClass('selected');
        		selected_row_index = $('#table_show_by_teacher').dataTable().fnGetPosition(this);
	        	data = $('#table_show_by_teacher').dataTable().fnGetData(this);
	            if( data != null){
	            	$('#edit_modal').modal('show');
	            	$('#tr_teacher_info').empty();
	            	$('#tr_teacher_info').append("<td>"+data[0]+"</td><td>"+data[1]+"</td><td>"+data[2]+"</td>"+"</td><td>"+data[3]+"</td>");
	            	var token = $("input[name='_token']").val();
	            	var teacher_id = data[0];
	            	$.ajax({
						url :"<?= URL::to('admin/schedule/get_classes_list')?>" ,
						type: "POST",
						async: false,
						data:{
							'teacher_id' : teacher_id,
							'_token'	 : token
						}, 
						success:function(record){
							$('#added_classes').dataTable().fnClearTable();
							$('#not_add_classes').dataTable().fnClearTable();
							$.each(record['added_classes'],function(i,j){
								$('#added_classes').dataTable().fnAddData( [
		                            j.class_id,
		                            j.classname
	                            ]);
							})
							$.each(record['not_add_classes'],function(i,j){
								$('#not_add_classes').dataTable().fnAddData( [
		                            j.id,
		                            j.classname
	                            ]);
							})
						},
						error:function(){
							alert("Has something go wrong!!");
						}
					});
	            }
        	}
        });

		$('#added_classes').on('click','tbody tr',function(){
			var data = $('#added_classes').dataTable().fnGetData(this);
			var homeroom = $('#tr_teacher_info td:last-child').html();
			if(data[1] == homeroom)
				return;
			if($(this).hasClass('selected')){
        		$(this).removeClass('selected');
        	}
        	else{
        		$(this).addClass('selected');
			}
		});
		$('#not_add_classes').on('click','tbody tr',function(){
			if($(this).hasClass('selected')){
        		$(this).removeClass('selected');
        	}
        	else{
        		$(this).addClass('selected');
			}
		});

		$('#btn_add_class').on('click',function(){
			var class_id_list = [];
			$('#not_add_classes tr.selected').each(function(i,j){
				class_id_list.push($('#not_add_classes').dataTable().fnGetData(j)[0]);
				$('#added_classes').dataTable().fnAddData([
					$('#not_add_classes').dataTable().fnGetData(j)[0],
					$('#not_add_classes').dataTable().fnGetData(j)[1]
				]);
				$('#not_add_classes').dataTable().fnDeleteRow(j);
			});
		});

		$('#btn_remove_class').on('click',function(){
			var class_id_list = [];
			$('#added_classes tr.selected').each(function(i,j){
				class_id_list.push($('#added_classes').dataTable().fnGetData(j)[0]);
				$('#not_add_classes').dataTable().fnAddData([
					$('#added_classes').dataTable().fnGetData(j)[0],
					$('#added_classes').dataTable().fnGetData(j)[1]
				]);
				$('#added_classes').dataTable().fnDeleteRow(j);
			});
		});

		$('#btn_update_change').on('click',function(){
			$('#onloading_model').css('display','block');
			var class_id_list = [];
			var temp_data;
			$('#added_classes tbody tr').each(function(i,j){
				temp_data = $('#added_classes').dataTable().fnGetData(j);
				if(temp_data != null)
					class_id_list.push(temp_data[0]);
			});
			var teacher_id = $('#show_by_teacher tr.selected td:first-child').html();
			var token = $("input[name='_token']").val();
			setTimeout(function(){
            	$.ajax({
					url :"<?= URL::to('admin/schedule/update_assigment')?>" ,
					type: "POST",
					async: false,
					data:{
						'teacher_id' : teacher_id,
						'class_list' : class_id_list,
						'_token'	 : token
					}, 
					success:function(record){
						location.reload();
					},
					error:function(){
						alert("Has something go wrong!!");
					}
				});
            },10);
		});
		
    });
</script>
@endsection