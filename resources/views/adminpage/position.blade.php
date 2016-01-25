@extends('mytemplate.blankpage_ad')

@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
</style>
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
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-solid box-primary">
				<div class="box-header">
					<h3 class="box-title">Position List	</h3>
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
				                <th>Total</th>
				            </tr>
				        </thead>

				        <tbody class="displayrecord">
				            <?php foreach ($position as $row) :?>
				                <tr>
				                    <td> <?php echo $row->position_name ?></td>
				                    <td> <?php echo $row->total ?></td>
				                </tr>
				            <?php endforeach;?>
				        </tbody>
				        </table>
				    </div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="box box-solid box-primary">
				<div class="box-header">
					<h3 class="box-title">Position Info</h3>
					<div class="box-tools pull-right">
			            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
			        </div>
				</div>
				<div class="box-body">
					<form>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
    $(function() {
    	$('#position_table').dataTable({
            "lengthChange": false,
            "searching": false,
            "ordering": false,
        });
    	$('#position_table tbody').on( 'click', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('#position_table').dataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');          
            }
	    });
    	$('#position_table tbody').on( 'click', 'button', function () {
    		var $tr      = $(this).closest('tr');
        	var myRow    = $tr.index();
    	});
    });
</script>
@endsection
