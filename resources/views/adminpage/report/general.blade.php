@extends('mytemplate.blankpage_ad')
@section('content')
<section class="content">
	<div class="box box-solid box-primary">
		<div class="box-header">
			Report By Scholastic
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-header">
					<?php 
						$year = date("Y");
						$year = (date("m") < 8 ) ? ($year - 1) : $year;
						$year_plus = $year+1;
					?>
					<h4 class="box-title">Scholastic: {{$year}} - {{$year_plus}}</h4>
				</div>
				<div class="box-body">
					<div class="row">
					<div class="col-lg-4">
						<button id="btn_print_report_1" class="btn btn-block btn-primary">Report First Semester</button>
					</div>
					<div class="col-lg-4">
						<button id="btn_print_report_2" class="btn btn-block btn-primary">Report Second Semester</button>
					</div>
					<div class="col-lg-4">
						<button id="btn_print_report_3" class="btn btn-block btn-primary">Report Scholastic</button>
					</div>
				</div>
			</div>		
			<div class="box box-primary">
				<div class="box-header">
					<h4 class="box-title">Send Report To Parent</h4>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-lg-4">

						</div>
						<div class="col-lg-8">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#btn_print_report_1').on('click',function(){
		window.open('/admin/report/report_semester_1','_blank');
	});
	$('#btn_print_report_2').on('click',function(){
		window.open('/admin/report/report_semester_2','_blank');
	});
	$('#btn_print_report_3').on('click',function(){
		window.open('/admin/report/report_semester_3','_blank');
	});
});
</script>
@endsection