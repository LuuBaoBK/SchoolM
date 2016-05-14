@extends('mytemplate.blankpage_pa')
@section('content')
<style type="text/css">
table, th, td {
    border: 1px solid black;
}
p.text{
	font-size: 120%;
}
</style>
<section class="content-header">
    <h1>
        Parent
        <small>Schedule</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/parent/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
	<div class="box box-solid box-primary">
		<div class="box-header">
			<h4 class="box-title">Schedule</h4>
		</div>
		<div class="box-body">
			<div class="row form-group">
				<div class="col-lg-4">
	    			<label>Updated time</label>
	    			<input class="form-control" value={{$updatetime}} readonly>
	    		</div>
				<div class="col-lg-4">
					<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
		            <label for="student">Student</label>
		            <select id="student" name="student" class="form-control">
		                @if($tkb == 'select_student')
		                	<option value="-1" selected>-- Select Student --</option>
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
			@if($tkb == 'no_class')
	    		<div class="callout callout-warning">
	    			<h4>No Placement</h4>
	    			<p>You have noplacement</p>
	    		</div>
	    	@elseif($tkb == 'no_schedule')
	    		<div class="callout callout-warning col-lg-4">
	    			<h4>No Schedule</h4>
	    			<p>Your class have not scheduled</p>
	    		</div>
	    	@elseif($tkb == 'select_student')
	    		<div class="callout callout-info col-lg-4">
	    			<h4>Select Children</h4>
	    			<p>Please select one child from children list</p>
	    		</div>
	    	@else
	    		<div>
	    			<h3><b><i><u>Schedule class {{$class->classname}} </u>({{$student_name}})</i></b></h4>
	    			<table id="tkb_table" class="table table-striped" width="100%">
	    				<thead>
	    					<tr>
	    						<td width="5%">#</td>
	    						<td><p class='text text-center'><b>T2</b></p></td>
	    						<td><p class='text text-center'><b>T3</b></p></td>
	    						<td><p class='text text-center'><b>T4</b></p></td>
	    						<td><p class='text text-center'><b>T5</b></p></td>
	    						<td><p class='text text-center'><b>T6</b></p></td>
	    					</tr>
	    				</thead>
	    				<tbody>
	    					@for ($i = 0; $i <= 9; $i++)
							    <tr>
							    	<td><p class='text text-center'>{{$i + 1}}</p></td>
							    	<td><p class='text text-center'>{{$tkb[$i]['subject']}}</p></td>
							    	<td><p class='text text-center'>{{$tkb[$i+10]['subject']}}</p></td>
							    	<td><p class='text text-center'>{{$tkb[$i+20]['subject']}}</p></td>
							    	<td><p class='text text-center'>{{$tkb[$i+30]['subject']}}</p></td>
							    	<td><p class='text text-center'>{{$tkb[$i+40]['subject']}}</p></td>
							    </tr>
							    @if ($i == 4)
							    	<tr>
							    		<td colspan='6'><h5 class="text text-center"><b>Break Time</b></h5></td>
							    	</tr>
							    @endif
							@endfor
	    				</tbody>
	    			</table>
	    		</div>
	    	@endif
		</div>
	</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#sidebar_tkb').addClass('active');
	$('#student').on('change',function(){
		var student_id = $(this).val();
		if(student_id != -1){
			var token = $('input[name="_token"]').val();
			$("#student option[value='-1']").remove();
			url = "/parents/schedule/student_schedule/"+student_id;
			window.location.replace(url);
		}
		else{
			//Do nothing
		}
	});
});
</script>
@endsection