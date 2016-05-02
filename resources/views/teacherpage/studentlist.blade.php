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
	<div class="col-xs-3">
		<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">Class List</h4>
			</div>
			<div class="box-body">
				<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
				<table id="class_list_table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Id</th>
							<th>Class Name</th>
							<th>Homeroom Teacher</th>
							<th>Total Student</th>
						</tr>
					</thead>
					<tbody>
						@foreach($class_list as $key => $class)
						<tr>
							<td>{{$class->id}}</td>
							<td>{{$class->classname}}</td>
							<td>{{$class->teacher->user->fullname}}</td>
							<td>{{$class->total}}</td>
						</tr>	
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-9">
		<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">Student List</h4>
			</div>
			<div class="box-body">
				<table id="student_list_table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th rowspan="2">Full Name</th>
							<th rowspan="2">Email</th>
							<th colspan="5">Parent Info</th>	
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
	</div>
</section>

<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#list_student_list').addClass('active');
	$('#student_list_table').dataTable({
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "pageLength": 5,
            "scrollY": "600px",
			"scrollCollapse": true,
			"paging": false
        });
	$('#class_list_table').dataTable({
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "pageLength": 5,
            "scrollY": "600px",
			"scrollCollapse": true,
			"paging": false,
			"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
            ]
        });
	$('#class_list_table').on('click','tbody tr',function(){
		if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $('#class_list_table').dataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            var index	  = $('#class_list_table tbody tr.selected').index();
	    	var token = $('input[name="_token"]').val();
	    	var data = $('#class_list_table').dataTable().fnGetData(index);
	    	if(data != null){
	    		$.ajax({
	                url     :"<?= URL::to('/teacher/student-list/get_student_list') ?>",
	                type    :"POST",
	                async   :false,
	                data    :{
	                	'id'			:data[0],
	                    '_token'        :token
	                },
	                success:function(record)
	                {
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
	    	}   
        }	
	});
});
</script>
@endsection