@extends('mytemplate.blankpage_stu')

@section('content')
<style type="text/css">
    table tr.selected{
        background-color: #3399CC !important; 
    }
</style>
<div class="content">
	<div class="box box-solid box-primary">
		<div class="box-header">
			<?php 
				$year = date("Y");
				$year = (date("m") < 8) ? ($year - 1) : $year;
			?>
			<h4 class="box-title">Teacher List ({{$year}} - {{$year+1}})</h4>
		</div>
		@if($tkb == null)
		<div class="box-body">
			<div class="callout callout-warning col-lg-4">
    			<h4>No Schedule</h4>
    			<p>You don't have schedule</p>
    		</div>
		</div>
		@else
		<div class="box-body">
			<div class="col-md-3">
				<div>
					<h4><b><u>Subject List</u></b></h4>
				</div>
				<table id="subject_table" class="table table-hover text-center">
					@foreach($tkb as $key => $row)
					<tr>
						<td style="display:none">{{$row->teacher_id}}</td>
						<td>{{$row->subject_name}}</td>
					</tr>
					@endforeach
				</table>
			</div>
			<div class="col-md-9">
				<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
				<div class="text-center">
					<h4><b><u>Teacher Profile</u></b></h4>
				</div>
				<div class="box box-widget widget-user" style="width:80%; margin:auto">
            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div class="widget-user-header bg-aqua-active">
	            	<div class="col-xs-6">
		              <h2 id="fullname" class="widget-user-username">{{$teacher->user->fullname}}</h2>
		              <h4 id="position_name" class="widget-user-desc">{{$teacher->my_position->position_name}}</h4>
		          	</div>
		          	<div class="col-xs-6">
		              <h3 id="subject_name" class="widget-user-username pull-right">{{$teacher->teach->subject_name}}</h3>
		          	</div>
	            </div>
	            <div class="widget-user-image">
	              <img id="avatar_img" class="img-round" src={{$src}} alt="User Avatar">
	            </div>
	            <div class="box-footer">
	              <div class="row">
	                <div class="col-sm-6 border-right">
	                  <div class="description-block">
	                    <h5 class="description-header">Mobile</h5>
	                    <span id="mobilephone" class="description-text" style="font-size:25px">{{$teacher->mobilephone}}</span>
	                  </div>
	                </div>
	                <div class="col-sm-6 border-right">
	                  <div class="description-block">
	                    <h5 class="description-header">Home</h5>
	                    <span id="homephone" class="description-text" style="font-size:25px">{{$teacher->homephone}}</span>
	                  </div>
	                </div>
	              </div>
	              <div class="row">
	                <div class="border-top">
	                  <div class="description-block">
	                    <h5 class="description-header">Email</h5>
	                    <span id="email" style="font-size:25px">{{$teacher->id}}@schoolm.com</span>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
			</div>
		</div>
		@endif
	</div>
</div>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#sidebar_teacher_list').addClass('active');
	$('#subject_table tr:first-child').addClass('selected');
	$('#subject_table').on('click','tr',function(){
		if($(this).hasClass('selected')){
			$(this).removeClass('selected');
		}
		else{
			$('#subject_table tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var teacher_id = $('#subject_table tr.selected td:first-child').html();
			var subject_name = $('#subject_table tr.selected td:last-child').html();
			var token       = $('input[name="_token"]').val();
			$.ajax({
                url     :"<?= URL::to('/student/teacher_list/select_teacher') ?>",
                type    :"POST",
                async   :false,
                data    :{
                	'teacher_id'	   : teacher_id,
                    '_token'           :token
                },
                success:function(record){
                	console.log(record);
                  	$('#fullname').html(record.user.fullname);
                  	$('#subject_name').html(subject_name);
                  	$('#position_name').html(record.my_position.position_name);
                  	$('#mobilephone').html(record.mobilephone);
                  	$('#homephone').html(record.homephone);
                  	$('#email').html(record.id+"@schoolm.com");
                  	$('#avatar_img').attr('src',record.src);
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
		}
	});
});
</script>
@endsection