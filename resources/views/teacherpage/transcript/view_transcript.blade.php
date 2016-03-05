@extends('mytemplate.blankpage_te')

@section('content')
<section class="content-header">
    <h1>
        Teacher
        <small>View Transcript</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/teacher/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
	<div class="box box-solid box-primary">
		<div class="box-header">
			<h3 class="box-title">View Transcript</h3>
	        <div class="box-tools pull-right">
	            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        </div>
		</div>
		<div class="box-body">
			<table id="view_transcript_table" class="table row-border">
				<thead>
                <tr>
                    <th id="0" rowspan="2">Class Name</th>
                    <th id="1" colspan="2">Import Detail</th>
                    <th id="2" colspan="5">Score Type Detail</th>
                </tr>
                <tr>
                    <th>Duration</th>
                    <th>Month</th>
                    <th>#</th>
                    <th>Score Type</th>
                    <th>Factor</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
			</table>
		</div>
	</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#sidebar_list_2').addClass('active');
    $('#view_transcript_table').dataTable({
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "scrollY": "500px",
        "scrollCollapse": true,
        "info" : false,
        "paging": false,
        "columns": [
            { "width": "10%" },
            { "width": "10%" },
            { "width": "10%" },
            { "width": "5%" },
            { "width": "15%" },
            { "width": "5%" },
            { "width": "10%" },
            { "width": "35%" }
        ]
    });
	$('th#1').on('click',function(){
		console.log("abc");
		$('#view_transcript_table').DataTable().column(0).visible(false);
	})
});
</script>
@endsection