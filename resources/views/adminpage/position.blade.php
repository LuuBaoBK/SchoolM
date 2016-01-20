@extends('mytemplate.blankpage_ad')

@section('content')

<section class="content-header">
    <h1>
        Admin
        <small>Position Manager</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Position_Manager</a></li>
    </ol>
</section>
<section class="content">
	<div class="box box-solid box-primary">
		<div class="box-header">
			<h3 class="box-title">Position Manager</h3>
			<div class="box-tools pull-right">
	            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        </div>
		</div>
		<div class="box-body">
			<div class="box-body table-responsive">
		        <table id="position_table" class="table table-bordered table-striped">
		        <thead>
		            <tr>
		                <th>Position</th>
		            </tr>
		        </thead>

		        <tbody class="displayrecord">
		            
		        </tbody>
		        </table>
		    </div>
		</div>
	</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
    $(function() {
    
    });
</script>
@endsection
