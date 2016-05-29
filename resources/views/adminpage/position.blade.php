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
		<!-- <div class="col-xs-4">
			<div class="box box-solid box-primary">
				<div class="box-header">
					<h3 class="box-title">Position Info</h3>
					<div class="box-tools pull-right">
			            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
			        </div>
				</div>
				<form id="create_position_form">
					<div class="box-body">
						<div class="form-group col-lg-8">
							<label for="position_name">Position Name</label>
							<input type="text" class="form-control" name="position_name" id="position_name">
						</div>
					</div>
					<div class="box-footer">
						<button id ="create_position_form_submit" type="button" class="btn btn-primary pull-right">Add</button>
					</div>
				</form>
			</div>
		</div> -->
		<div class="col-lg-6">
			<div class="box box-solid box-primary">
				<div class="box-header">
					<h3 class="box-title">Position List	</h3>
					<div class="box-tools pull-right">
			            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
			        </div>
				</div>
				<div class="box-body">
					<div class="box-body">
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
				                    <td class="td_name"><?php echo $row->position_name ?></td>
				                    <td><?php echo $row->total ?></td>
				                </tr>
				            <?php endforeach;?>
				        </tbody>
				        </table>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<div id="editModal" class="modal modal-info">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Edit</h4>
	            </div>
	            <form id="create_position_form">
		            <div class="modal-body">
						<label for="position_name">Position Name</label>
						<input type="text" class="form-control" name="position_name" id="position_name">
						<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
		            </div>
		            <div class="modal-footer">
		                <button id="edit_name" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Edit</button>
		            </div>
	            </form>
	        </div>
	    <!-- /.modal-content -->
	    </div>
	  <!-- /.modal-dialog -->
	</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
    $(function() {
    	$('#sidebar_list_4_2').addClass('active');
        $('#sidebar_list_4').addClass('active');
    	$('#position_table').dataTable({
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "pageLength": 5,
            "scrollY": "600px",
			"scrollCollapse": true,
			"paging": false
        });

        var selected_row_index;
    	$('#position_table tbody').on( 'click', 'tr', function () {
    		var name = "";
    		selected_row_index = $('#position_table').dataTable().fnGetPosition(this);
    		if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('#position_table').dataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');          
            }
            $('#editModal').modal('show');
            $('#position_table tr.selected td:first-child').each(function(i,j){
	           	name = j.innerHTML;
	        });
            $('#position_name').val(name);
	    });
	    $('#edit_name').click(function(){
	    	var name  = $('#position_name').val();
	    	var id	  = $('#position_table tbody tr.selected').index();
	    	var token = $('input[name="_token"]').val();
	    	$('#position_name').val('');
	    	console.log(id);
	    	$.ajax({
                url     :"<?= URL::to('/admin/position') ?>",
                type    :"POST",
                async   :false,
                data    :{
                	'id'			:id,
                    'name'     		:name,
                    '_token'        :token
                },
                success:function(record)
                {
                    $('#position_table').dataTable().fnUpdate( record, selected_row_index, 0 );
                }
            });
	    });
    	
    });
</script>
@endsection
