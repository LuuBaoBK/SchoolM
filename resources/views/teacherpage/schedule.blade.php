@extends('mytemplate.blankpage_te')

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
        Teacher
        <small>Schedule</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/teacher/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
	<div class="box box-solid box-primary">
		 <div class="box-header">
	        <h3 class="box-title">Schedule</h3>
	        <div class="box-tools pull-right">
	            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        </div>
	    </div><!-- /.box-header -->
	    <div class="box-body">
	    	@if($tkb == 'no_placement')
	    		<div class="callout callout-warning col-lg-4">
	    			<h4>No Placement</h4>
	    			<p>You have noplacement</p>
	    		</div>
	    	@elseif($tkb == 'no_schedule')
	    		<div class="callout callout-warning col-lg-4">
	    			<h4>No Schedule</h4>
	    			<p>Your class have not scheduled</p>
	    		</div>
	    	@else
	    		<div class="row">
		    		<div class="form-group col-lg-4">
		    			<label>Updated time</label>
		    			<input class="form-control" value={{$tkb_date}} readonly>
		    		</div>
	    		</div>
	    		<div>
	    			<h3><b><i><u>Teaching Schedule</u></i></b></h4>
	    			<table id="tkb_table" class="table table-striped" width="100%">
	    				<thead>
	    					<tr>
	    						<td <p style="font-size:14px" class='text text-center' width="5%">#</p></td>
	    						<td><p style="font-size:14px" class='text text-center'><b>T2</b></p></td>
	    						<td><p style="font-size:14px" class='text text-center'><b>T3</b></p></td>
	    						<td><p style="font-size:14px" class='text text-center'><b>T4</b></p></td>
	    						<td><p style="font-size:14px" class='text text-center'><b>T5</b></p></td>
	    						<td><p style="font-size:14px" class='text text-center'><b>T6</b></p></td>
	    					</tr>
	    				</thead>
	    				<tbody>
	    					@for ($i = 0; $i <= 9; $i++)
							    <tr>
							    	<td><p style="font-size:14px" class='text text-center'>{{$i + 1}}</p></td>
							    	<td><p style="font-size:14px" class='text text-center'>{{$tkb[$i]}}</p></td>
							    	<td><p style="font-size:14px" class='text text-center'>{{$tkb[($i+10)]}}</p></td>
							    	<td><p style="font-size:14px" class='text text-center'>{{$tkb[($i+20)]}}</p></td>
							    	<td><p style="font-size:14px" class='text text-center'>{{$tkb[($i+30)]}}</p></td>
							    	<td><p style="font-size:14px" class='text text-center'>{{$tkb[($i+40)]}}</p></td>
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
	$('#sidebar_schedule').addClass('active');
});
</script>
@endsection