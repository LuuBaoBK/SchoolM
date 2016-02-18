<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>

<form method="post" enctype="multipart/form-data">
<input type="file" name="fileToUpload" id="fileToUpload">
<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
<button class="submit" id="upload">click</button>
</form>

<script type="text/javascript">
	$(function(){
		$("#upload").click(function(){
			console.log($('#fileToUpload').val());
			var token = $('input[name="_token"]').val();
			var file = $('#fileToUpload').val();
			// $.ajax({
		 //      url     :"<?= URL::to('/test/read') ?>",
		 //      type    :"POST",
		 //      async   :false,
		 //      data    :{
		 //              'file'            :file,
		 //              '_token'        :token
		 //              },
		 //      success:function(record){
		 //          console.log(record);
		 //      },
		 //      error:function(){
		 //          alert("something went wrong, contact master admin to fix");
		 //      }
		 //    });
		})
	});
	
</script>
