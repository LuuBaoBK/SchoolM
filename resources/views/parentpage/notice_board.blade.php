@extends('mytemplate.blankpage_pa')
@section('content')
<style type="text/css">
    table tr.selected{
        background-color: #3399CC !important; 
    }
</style>
<section class="content-header">
    <h1>
        Parent
        <small>Notice Board</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/parents/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
	<div class="row form-group">
		<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
		<div class="col-lg-4">
			<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
	        <label for="student">Student</label>
	        <select id="student" name="student" class="form-control">
	        	<option value="-1" selected>-- Select Student --</option>
	        	@if($notice_list == null)
		            @foreach($student_list as $key => $student)
		            	<option value={{$student->id}}>{{$student->user->fullname}}</option>
		            @endforeach
	            @else
	            	@foreach($student_list as $key => $student)
	            		@if($student->id == $student_id)
		            		<option value={{$student->id}} selected>{{$student->user->fullname}}</option>
	            		@else
            				<option value={{$student->id}}>{{$student->user->fullname}}</option>
            			@endif
		            @endforeach
	            @endif
	        </select>
		</div>
	</div>
	@if($notice_list == null)
		<div class="callout callout-info col-lg-4">
			<h4>No Student</h4>
			<p>Please Select One Student</p>
		</div>
	@else
		<div class="row">
			<div class="col-lg-4">
				<div class="box box-primary box-solid">
					<div class="box-header">
						<h4 class="text text-center">Monday</h4>
					</div>
					<div class="box-body">
						<table id="notice_table_2" class="table table-striped" width="100%" height="350px">
							<thead>
								<tr>
									<th>NId</th>
									<th>Notice</th>
									<th>Level</th>
									<td>Deadline</td>
								</tr>
							</thead>
							<tbody>
								@foreach($notice_list[2] as $key => $notice)
								<?php 
									$notice->title = substr($notice->title, 0,45)."..."; 
									if($notice->level == 1){
										$level = "danger";
										$level_show = "Straightway";
									}
									else{
										$level = ($notice->level == 2) ? "warning" : "success";
										$level_show = ($notice->level == 2) ? "Gradual" : "Behindhand";
									}
								?>
								<tr> 
									<td>{{$notice->id}}</td>
									<td>{{$notice->title}}</td>
									<td><small class='pull-left label label-{{$level}}'>{{$level_show}}</small></td>
									<td>{{$notice->notice_date}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="box box-primary box-solid">
					<div class="box-header">
						<h4 class="text text-center">Tuesday</h4>
					</div>
					<div class="box-body">
						<table id="notice_table_3" class="table table-striped" width="100%" height="350px">
							<thead>
								<tr>
									<th>NId</th>
									<th>Notice</th>
									<th>Level</th>
									<td>Deadline</td>
								</tr>
							</thead>
							<tbody>
								@foreach($notice_list[3] as $key => $notice)
								<?php 
									$notice->title = substr($notice->title, 0,45)."..."; 
									if($notice->level == 1){
										$level = "danger";
										$level_show = "Straightway";
									}
									else{
										$level = ($notice->level == 2) ? "warning" : "success";
										$level_show = ($notice->level == 2) ? "Gradual" : "Behindhand";
									}
								?>
								<tr> 
									<td>{{$notice->id}}</td>
									<td>{{$notice->title}}</td>
									<td><small class='pull-left label label-{{$level}}'>{{$level_show}}</small></td>
									<td>{{$notice->notice_date}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="box box-primary box-solid">
					<div class="box-header">
						<h4 class="text text-center">Wednesday</h4>
					</div>
					<div class="box-body">
						<table id="notice_table_4" class="table table-striped" width="100%" height="350px">
							<thead>
								<tr>
									<th>NId</th>
									<th>Notice</th>
									<th>Level</th>
									<td>Deadline</td>
								</tr>
							</thead>
							<tbody>
								@foreach($notice_list[4] as $key => $notice)
								<?php 
									$notice->title = substr($notice->title, 0,45)."..."; 
									if($notice->level == 1){
										$level = "danger";
										$level_show = "Straightway";
									}
									else{
										$level = ($notice->level == 2) ? "warning" : "success";
										$level_show = ($notice->level == 2) ? "Gradual" : "Behindhand";
									}
								?>
								<tr> 
									<td>{{$notice->id}}</td>
									<td>{{$notice->title}}</td>
									<td><small class='pull-left label label-{{$level}}'>{{$level_show}}</small></td>
									<td>{{$notice->notice_date}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="box box-primary box-solid">
					<div class="box-header">
						<h4 class="text text-center">Thursday</h4>
					</div>
					<div class="box-body">
						<table id="notice_table_5" class="table table-striped" width="100%" height="350px">
							<thead>
								<tr>
									<th>NId</th>
									<th>Notice</th>
									<th>Level</th>
									<td>Deadline</td>
								</tr>
							</thead>
							<tbody>
								@foreach($notice_list[5] as $key => $notice)
								<?php 
									$notice->title = substr($notice->title, 0,45)."..."; 
									if($notice->level == 1){
										$level = "danger";
										$level_show = "Straightway";
									}
									else{
										$level = ($notice->level == 2) ? "warning" : "success";
										$level_show = ($notice->level == 2) ? "Gradual" : "Behindhand";
									}
								?>
								<tr> 
									<td>{{$notice->id}}</td>
									<td>{{$notice->title}}</td>
									<td><small class='pull-left label label-{{$level}}'>{{$level_show}}</small></td>
									<td>{{$notice->notice_date}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="box box-primary box-solid">
					<div class="box-header">
						<h4 class="text text-center">Friday</h4>
					</div>
					<div class="box-body">
						<table id="notice_table_6" class="table table-striped" width="100%" height="350px">
							<thead>
								<tr>
									<th>NId</th>
									<th>Notice</th>
									<th>Level</th>
									<td>Deadline</td>
								</tr>
							</thead>
							<tbody>
								@foreach($notice_list[6] as $key => $notice)
								<?php 
									$notice->title = substr($notice->title, 0,45)."..."; 
									if($notice->level == 1){
										$level = "danger";
										$level_show = "Straightway";
									}
									else{
										$level = ($notice->level == 2) ? "warning" : "success";
										$level_show = ($notice->level == 2) ? "Gradual" : "Behindhand";
									}
								?>
								<tr> 
									<td>{{$notice->id}}</td>
									<td>{{$notice->title}}</td>
									<td><small class='pull-left label label-{{$level}}'>{{$level_show}}</small></td>
									<td>{{$notice->notice_date}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="box box-primary box-solid">
					<div class="box-header">
						<h4 class="text text-center">Saturday & Sunday</h4>
					</div>
					<div class="box-body">
						<table id="notice_table_7" class="table table-striped" width="100%" height="350px">
							<thead>
								<tr>
									<th>NId</th>
									<th>Notice</th>
									<th>Level</th>
									<td>Deadline</td>
								</tr>
							</thead>
							<tbody>
								@foreach($notice_list[7] as $key => $notice)
								<?php 
									$notice->title = substr($notice->title, 0,45)."..."; 
									if($notice->level == 1){
										$level = "danger";
										$level_show = "Straightway";
									}
									else{
										$level = ($notice->level == 2) ? "warning" : "success";
										$level_show = ($notice->level == 2) ? "Gradual" : "Behindhand";
									}
								?>
								<tr> 
									<td>{{$notice->id}}</td>
									<td>{{$notice->title}}</td>
									<td><small class='pull-left label label-{{$level}}'>{{$level_show}}</small></td>
									<td>{{$notice->notice_date}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Teacher</span>
                                            <input id="modal_notice_wrote_by" type="text" class="form-control" readonly>
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
</section>	
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/mylib/ckeditor/ckeditor.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#sidebar_tkb').addClass('active');
	$('#student').on('change',function(){
		var student_id = $(this).val();
		if(student_id != -1){
			var token = $('input[name="_token"]').val();
			$("#student option[value='-1']").remove();
			url = "/parents/notice_board/student_noticeboard/"+student_id;
			window.location.replace(url);
		}
		else{
			//Do nothing
		}
	});
	setup_table();
	CKEDITOR.replace('modal_content', {
        toolbarGroups: [
          
        ]
        // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });
	function setup_table(){
		var i;
		for(i=2; i<=7; i++){
			$('#notice_table_'+i).dataTable({
				"lengthChange": false,
		        "searching": true,
		        "ordering": false,
		        "info" : false,
		        "paging": true,
		        "pageLength": 5,
		        "bAutoWidth": true,
		        "dom": '<"top">frt<"clear"><"bottom"p>',
		        "columns": [
		        	{ "width": "5%" },
		        	{ "width": "65%" },
		        	{ "width": "10%" },
		        	{ "width": "20%" }
		        ]
			});
		}
	}
	$(document).on('click', 'table tbody tr',function(){
		var id = $(this).parent().parent().attr('id');
		var data = $('#'+id).dataTable().fnGetData(this);
		var token = $('input[name="_token"]').val();
		if(data != null){
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
			}
			else{
				$('table tbody tr.selected').removeClass('selected');
				$(this).addClass('selected');
				$.ajax({
	                url     :"<?= URL::to('/parents/notice_board/read_notice') ?>",
	                type    :"POST",
	                async   :false,
	                data    :{
	                        'notice_id'     :data[0],
	                        '_token'        :token
	                        },
	                success:function(record){
	                	// console.log(record);
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
	                    $('#modal_notice_wrote_by').val(record.wrote_by.user.fullname);
	                    // $('#modal_notice_date').val(record.notice_date);
	                    CKEDITOR.instances['modal_content'].setData(record.content);
	                    $('#modal_wrote_date').val(record.wrote_date);
	                    $('#received_list tbody').empty();
	                },
	                error:function(){
	                    alert("something went wrong, contact master admin to fix");
	                }
            	});
			}
		}
	});
});
</script>
@endsection