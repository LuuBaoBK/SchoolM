@extends('mytemplate.blankpage_ad')
@section('content')

<div>

<input type="hidden" name="_token" value="<?= csrf_token(); ?>">	
</div>


<section class="content-header">
    <h1>
        Admin
        <small>Schedule Manager</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin > Schedule Manager</a></li>
    </ol>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">XEM BẢNG PHÂN CÔNG CÁC NĂM</h3>
    </div>
    <div class="box-body">
    	<button class="btn btn-primary" id="menuschedule">BACK</button>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
        <form id="class_filter">
            <div class="box-body">
	            <div class="row">
	            	<div class="form-group col-lg-3 col-xs-7">
	            	</div>
	            </div>
	            <div class="row">
	                <div class="form-group col-lg-3 col-xs-7">
	                    <label>Năm học</label>
	                    <select id="namhoc" class="form-control">
	                        <option value="-1" selected>Select One</option>
	                        <?php
	                            $year = date("Y");

	                            if(date("m") < 8)
	                            	$year--;
	                            for($year;$year >=2010 ;$year--){
	                                
	                                    echo ("<option value='".substr($year,2)."' >".$year." - ".($year+1)."</option>");
	                            }
	                        ?>
	                    </select>
	                </div>
	            </div> 
	            <table id="class_table" class="table table-bordered table-striped">
			        <thead style="background:#CECEF6">
			            <tr>
			              <th>ID</th>
			              <th>Giáo viên</th>
			              <th>Môn</th>
			              <th>Lớp CN</th>
			              <th>Phân công</th>
			            </tr>
			        </thead>
			        <tbody id="displayrecord">
			        </tbody>
		        </table>                                 
            </div>                                        
        </form>
    </div>
</div>
</section>

<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- CK Editor -->
<script src="{{asset("/mylib/ckeditor/ckeditor.js")}}"></script>
<!-- Pusher -->
<script src="{{asset("/mylib/bower_components/pusher/dist/pusher.min.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.desktop.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.buttons.js")}}"></script>
<link rel="stylesheet" href="{{asset("/mylib/pnotify-master/src/pnotify.css")}}">
<link rel="stylesheet" href="{{asset("/mylib/pnotify-master/src/pnotify.buttons.css")}}">
<script type="text/javascript">
$(document).ready(function(){
	$(function(){

		$('#menuschedule').click(function(){
			$(location).attr('href', 'menuschedule');
		});

		$('#namhoc').change(function(){
			var token = $("input[name='_token'").val();
			//console.log(token);
			var year = $('#namhoc').val();
			if(year == -1)
				return;
			$.ajax({
				url:"<?= URL::to("admin/bangphancongcu") ?>",
				type:"POST",
				async:false,
				data:{
					"_token":token,
					"year":year
				},
				success:function(rs){
					console.log(rs);
					$('#displayrecord').empty();
					var append = "";
					if(rs){
						for(var i = 0; i < rs.length; i++){
							var gv = rs[i];
							append += "<tr><td>" + gv[0] + "</td><td>" + gv[1] + "</td><td>" + gv[2] + "</td><td>" + gv[3] + "</td><td>";
							for(var j = 0; j < gv.length - 4;j++){
								append += "<span> &nbsp " + gv[j+4] + "</span>";
							}
							append += "</td></tr>";
						}
						$('#displayrecord').append(append);
					}

				},
				error:function(){
					console.log("error???");
				}
			});



		})
   });
});
</script>

@endsection

