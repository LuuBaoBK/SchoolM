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
        <small>Student List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i>Teacher > Student List</a></li>
    </ol>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<h4 class="box-title">Student List</h4>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-lg-3">
					<label for="select_class_list">Select Class</label>
					<select id="select_class_list" class="form-control">
						<option value="-1">-- Select Class --</option>
						@foreach($class_list as $key => $class)
							<option value={{$class->id}}>{{$class->classname}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-4">
							<label for="class_name">Class Name</label>
							<input id="class_name" class="form-control" readonly>
						</div>
						<div class="col-lg-4">
							<label for="total_student">Total Student</label>
							<input id="total_student" class="form-control" readonly>
						</div>
						<div class="col-lg-4">
							<label for="homeroom_teacher">Homeroom Teacher</label>
							<input id="homeroom_teacher" class="form-control" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-body table-responsive">
			<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
			<div class="form-group text-center">
				<img id="student_avatar" src="/uploads/userAvatar.png" alt="Can't Load Image" class="img-circle" width="160px" height="160px">
			</div>
			<table id="student_list_table" style='overflow: auto; width: 100% !important; height:auto' class="table table-bordered table-striped">
				<thead>
					<tr>
						<th rowspan="2">Full Name</th>
						<th rowspan="2">Email</th>
						<th colspan="4">Parent Contact Info</th>	
					</tr>
					<tr>
						<th>Full Name</th>
						<th>Email</th>
						<th>Mobile Phone</th>
						<th>Home Phone</th>
						<th>Job</th>
						<th>Address</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
</section>

<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#list_student_list').addClass('active');
	$('#student_list_table').dataTable({
        "bAutoWidth": true,
        "bFilter":true,
        "bSort":false,
        "bLengthChange":false,
        "bInfo":false,
        "bPaginate":false,
        "pageLength": 10,
        "scrollCollapse":true,
    });
	$('#select_class_list').on('change',function(){
		var token = $('input[name="_token"]').val();
    	var data = $('#select_class_list').val();
    	$("#select_class_list option[value='-1']").remove();
		$.ajax({
            url     :"<?= URL::to('/teacher/student-list/get_student_list') ?>",
            type    :"POST",
            async   :false,
            data    :{
            	'id'			:data,
                '_token'        :token
            },
            success:function(record)
            {
            	$('#homeroom_teacher').val(record.teacher.fullname);
            	$('#class_name').val(record.classname);
            	$('#total_student').val(record.total_student);
                $('#student_list_table').dataTable().fnClearTable();
                // console.log(record.studentlist);
                $.each(record.studentlist, function(i,row){
                	$('#student_list_table').dataTable().fnAddData([
                		row.student.user.fullname,
                		row.student.user.id+"@schoolm.com",
                		row.student.parent.user.fullname,
                		row.student.parent.user.id+"@schoolm.com",
                		row.student.parent.mobilephone,
                		row.student.parent.homephone,
                		row.student.parent.job,
                		row.student.parent.user.address
            		]);
                })
            }
        });   
	});
	$('#student_list_table').on('click','tbody tr',function(){
		if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $('#student_list_table').dataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            var index	  = $('#student_list_table tbody tr.selected').index();
	    	var token = $('input[name="_token"]').val();
	    	var data = $('#student_list_table').dataTable().fnGetData(index);
	    	var temp = data[1].split("@");
	    	$.ajax({
	            url     :"<?= URL::to('/teacher/student-list/get_enrolled_year') ?>",
	            type    :"POST",
	            async   :false,
	            data    :{
	            	'id'			:temp[0],
	                '_token'        :token
	            },
	            success:function(record)
	            {
	            	var src = record;
	            	$("#student_avatar").attr('src', src);
	            }
	        });
	    	
	    }
	});
});
</script>
@endsection