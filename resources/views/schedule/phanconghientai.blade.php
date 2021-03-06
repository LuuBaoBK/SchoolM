@extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}

.trung {
    color: blue;
}

.thieu {
    color: red;
}

</style>


<input type="hidden" name="_token" value="<?= csrf_token(); ?>">

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
	<div class="box">
		<div class="box-header"><h3 class="box-title">QUẢN LÝ PHÂN CÔNG GIẢNG DẠY (HIỆN TẠI)</h3></div>
		<div class="box-body">
			<button class="btn btn-primary" id="menuschedule">MENU</button>	
			<button class="btn btn-primary" id = "tkb_lop">TẠO MỚI THỜI KHÓA BIỂU GIÁO VIÊN</button>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-9">
		    <div class="nav-tabs-custom">
		        <ul class="nav nav-tabs">
		        	<li class="active"><a href="#searchbyclass" data-toggle="tab">PHÂN CÔNG THEO GIÁO VIÊN</a></li>
		            <li><a href="#searchbyid" class="first_time" value="0" data-toggle="tab">PHÂN CÔNG THEO LỚP</a></li>
		        </ul>
		        <div class="tab-content">
		            <div class="active tab-pane box" id="searchbyclass">
		                <div id="loading" class="box-body table-responsive">
					        <table id="messages_table" class="table table-hover dataTable" >
						        <thead style="background:#CECEF6">
						            <tr>
						              <th>ID</th>
						              <th>Giáo viên</th>
						              <th>Môn</th>
						              <th>Lớp CN</th>
						              <th>Phân công</th>
						            </tr>
						        </thead>
					          	<tbody>
					          	<?php
				           		
					           		foreach ($danhsachgv as $gv) {
					           			echo "<tr><td>". $gv[0]. "</td><td>".$gv[1]. "</td><td>". $gv[2]. "</td><td>". $gv[3]."</td><td>";
					           			$sll = 0;
					           			$sll = count($gv) - 4;
					           			for($i = 0; $i < $sll; $i++){
					           				echo "<span>" . $gv[$i + 4] . "</span>&nbsp;";
					           			}
					           		}
				           		?>
					          	</tbody>
						        <tfoot>
						        	
						        </tfoot>
					        </table>
					    </div>
		            </div>
		            <div class="tab-pane" id="searchbyid">
		                <div class="box-body table-responsive">
					        <table id="table_lop" class="table table-hover dataTable">
							    <thead>
							        <tr>
							          <th>Lớp</th>
							          <?php 
							          	foreach ($listsubject as $value) {
							          		echo "<th>". $value. "</th>";
							          	}
							          ?>
							        </tr>
							    </thead>
							  	<tbody>
							       	<?php
							    	   		
							    	   	$dsmon = null;
							    	   	//$append
							       		foreach ($dshtheolop as $lop) {
							       			echo "<tr><td>". $lop[0]. "</td>";
							       			$slmon = count($listsubject);
							       			for($i = 0; $i < $slmon; $i++){
							       				echo "<td>".$lop[$i+1]."</td>";
							       			}
							       		}
							       	?>
							  	</tbody>
							</table>
					    </div>
		            </div>
		        </div>
		    </div>      
		</div> <!-- </.half left>  -->


		<div class="col-md-3">
			<div class="box box-primary box-solid bg-yellow">
		  		<div class="box-header with-border ">
		    		<h3 class="box-title">Thông báo</h3>
		  		</div><!-- /.box-header -->
		  		<div class="box-body table-responsive">
		    		<table id="loptrung_table" class="table dataTable">
			          <thead>
			          	<tr>
			              <td>Lớp bị trùng</td>
			            </tr>
			          </thead>
			          <tbody>
			           	<tr><td>
			           		<?php 
			           		$dsloptrung = $check['dsloptrung'];
			           		if($dsloptrung)
			           		foreach ($dsloptrung as $key => $value) {
			           			echo "<span> ".$value[0]."(".$value[1].") </span>";
			           			}
			           		?>
			           	</td></tr>
			          </tbody>
		    		</table>
		  		</div>
		  		<div class="box-body table-responsive">
		    		<table id="lopchuaxep_table" class="table dataTable">
			          <thead>
			          	<tr>
			              <td>Lớp chứa xếp môn</td>
			            </tr>
			          </thead>
			          <tbody>
			          <tr><td>
			          	<?php 
			           		$dschuaphan = $check['dschuaphan'];
			           		if($dschuaphan)
			           		foreach ($dschuaphan as $key => $value) {
			           			echo "<span> ".$value[0]."(".$value[1].") </span>";
			           			}
			           		?>
			          </td></tr>
			          </tbody>
		    		</table>
		  		</div>
			</div>
		</div>
	</div><!-- end div row -->
</section>
	<div id="edit" class="modal fade modal-default">
		<div class="modal-dialog modal-lg">
		    <div class="modal-content">
		        <div class="modal-header" style="background-color: #3c8dbc; color: white">
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		              <span aria-hidden="true">&times;</span></button>
		            <p><h4 class="2 modal-title">Edit</h4><p>
		            <table id="messages_" class="table table-hover dataTable">
				        <thead>
				            <tr>
				              <td>ID</td>
				              <td>Giáo viên</td>
				              <td>Môn</td>
				              <td>Lớp CN</td>
				            </tr>
				        </thead>
				        <thead>
				           	<tr>
				                <td id="id_t">t_0001</td>
				                <td id="name_t">Nguyen Bao Thi</td>
				                <td id="subj_t">Van</td>
				                <td id="cls_t">6A1</td>
				           	</tr>
				        </thead>
			        </table>
		        </div>
		        <div class="modal-body">
			          <div class="content">
				          <div class="col-lg-6 col-xs-12">
					           <div class="box">
						           <div class="dataTables_scrossBody" style="overflow: auto; height: 350px; width: 100%">
					                    <div class="box-body">
					                        <table id="student_table" class="table table-bordered table-striped">
					                            <thead>
					                                <tr>
					                                    <th>Lớp chưa thêm</th>
					                                </tr>
					                            </thead>
					                            <tbody id="lopchuathem_t"class="student_table_info">
					                            <tr><td>6A2</td></tr>
					                            <tr><td>6A4</td></tr>
					                            <tr><td>8A3</td></tr>
					                            <tr><td>9A6</td></tr>
					                            </tbody>
					                        </table>
					                    </div>
				                    </div>
				                    <div class="box-footer">
			                        	<button type="button" value="0" id="addnewclass" class="btn btn-block btn-primary btn-sm">Add</button>
			                    	</div>
		                   		</div><!--end box-->
		                   </div>
		                   <div class="col-lg-6 col-xs-12">
			                   <div class="box">
				                   <div class="dataTables_crossBody" style="overflow: auto; height: 350px; width: 100%">
					                   	<div class="box-body">
					                   		<table class="table table-bordered table-striped">
					                   			<thead>
					                   				<tr>
					                   					<th>Lớp đã thêm</th>	
					                   				</tr>
					                   			</thead>
					                   			<tbody id = "lopdathem_t"class="student_table_info">
					                   				<tr><td>6A1</td></tr>
					                   				<tr><td>7A2</td></tr>
					                   				<tr><td>8A1</td></tr>
					                   			</tbody>
					                   		</table>
					                   	</div>
				                   	</div>
				                   	<div class="box-footer">
				                   		<button type="button" value="1" id="removeclass" class="btn btn-block btn-primary btn-sm">Remove</button>
				                   	</div>
			                   </div>
		                   </div>
			          </div>
		        </div>
	      	 	<div class="modal-footer">
	       		</div>
	    	</div>
		<!-- /.modal-content -->
		</div>
<!-- /.modal-dialog -->
	</div>



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
		$('#messages_table tbody').on('click','tr', function(){
			var id = $(this).children('td').slice(0).html();
			if(!$(this).hasClass()){
				$("#messages_table tbody tr").removeClass("selected");
				$(this).addClass("selected");
			};

			var token = $("input[name='_token']").val();
			$.ajax({
				url :"<?= URL::to("admin/phancong/edit")?>" ,
				type: "POST",
				async: false,
				data:{
					'id': id,
					'_token': token
				}, 
				success:function(gv){
					$('#id_t').empty();
					$('#id_t').append(gv['id']);
					$('#name_t').empty();
					$('#name_t').append(gv['name']);
					$('#subj_t').empty();
					$('#subj_t').append(gv['subj']);
					$('#cls_t').empty();
					$('#cls_t').append(gv['lopcn']);
					
					$('#lopchuathem_t').empty();
					var chuathem = gv['chuaphancong'];
					var dathem = gv['phancong'];
					var i = 0;
					if(chuathem != null)
						for( i = 0; i < chuathem.length; i++){
							$('#lopchuathem_t').append("<tr><td>"+chuathem[i] + "</td></tr>");	
						}
					$('#lopdathem_t').empty();
					if(dathem != null)
						for(i = 0; i < dathem.length; i++){
							$('#lopdathem_t').append("<tr><td>" + dathem[i]+"</td></tr>");
						}
					$('#edit').modal('show');
					console.log(gv);
				},
				error:function(){
					alert("Has something go wrong!!");
				}

			});
		});
	$('#lopchuathem_t').on('click', 'tr', function(){
		if($(this).hasClass('selected')){
			$(this).removeClass('selected');
		}else{
			$(this).addClass('selected');
		}
	});

	$('#lopdathem_t').on('click', 'tr', function(){
		if($(this).hasClass('selected')){
			$(this).removeClass('selected');
		}else{
			if($(this).text() != $('#cls_t').text()){
				$(this).addClass("selected");
			}
		}
	});

	$('#addnewclass').click(function(){
		var listClass = [];
		var id = $('#id_t').text();
		var token = $("input[name = '_token']").val();
		$('#lopchuathem_t tr').each(function(index, element){
			if( $(this).hasClass('selected')){
			listClass.push($(this).children('td').slice(0).text());
			}
		});
		console.log(listClass);
		console.log(id);
		if(listClass.length > 0){
			$.ajax({
				url: "<?= URL::to("/admin/phancong/addnew") ?>",
				type: "POST",
				async: false,
				data:{
					'_token': token,
					'listClass': listClass,
					'id': id
				},
				success: function(rs){
					console.log("success");
					var dsloptrung = rs['dsloptrung'];
					var dschuaphan = rs["dschuaphan"];
					var loptrung = "";
					var lopchuathem = "";

					var i  = 0;
					$('#lopchuathem_t tr').each(function(index, element){
						if($(this).hasClass("selected")){
							$('#lopdathem_t').append("<tr>" + $(this).html() +"</tr>");
							$(this).remove();
						}
					});
					$('#messages_table tbody tr').each(function(index, element){
						var _length = $('#lopdathem_t').children('tr').length;
						if($(this).hasClass('selected')){
							$(this).children("td").slice(4).empty();
							if(_length >= 1){
								for( i = 0; i < _length; i++){
									$(this).children("td").slice(4).append( "<span>" + $('#lopdathem_t').children('tr').eq(i).text() + "</span>&nbsp;");
								}
							}
						}
					});
//----------------------------------------------------------------------
					$('#messages_table tbody tr').each(function(index, element){
							$(this).children('td').slice(4).children("span").each(function(index, element){
									if($(this).hasClass("trung"))
										$(this).removeClass('trung');
								});
					});
					$('#loptrung_table tbody tr').empty();
					loptrung +="<td>";
					if(dsloptrung != null){
						for(var i = 0; i < dsloptrung.length; i++){
							var lop = dsloptrung[i][0] + " ";
							var mon = dsloptrung[i][1];
							loptrung += "<span> " + dsloptrung[i][0] + "(" + dsloptrung[i][1] + ") </span>";
							$('#messages_table tbody tr').each(function(index, element){
							if($(this).children('td').slice(2,3).text() == mon)
								$(this).children('td').slice(4).children("span").each(function(index, element){
										if($(this).text() == lop)
											$(this).addClass('trung');
									});
								});
						}
					}
					loptrung += "</td>";
					$('#loptrung_table tbody tr').append(loptrung);
					$('#lopchuaxep_table tbody tr').empty();
					lopchuathem = "<td>";
					if(dschuaphan != null)
						for(var i = 0; i < dschuaphan.length; i++)
							lopchuathem += "<span> " + dschuaphan[i][0] + "(" + dschuaphan[i][1]+ ") </span>";
					lopchuathem += "</td>";
					$('#lopchuaxep_table tbody tr').append(lopchuathem);
//----------------------------------------------------------------------
					updatephanconglop();

				},
				error: function(){
					console.log("error");
				}
			});	
		}
	});

	function updatephanconglop(){

		var dslophoc = [];
					
		$('#messages_table tbody tr').each(function(index1, element){
			var row = [];	
			row[0] = $(this).children("td").slice(1,2).text();
			row[1] = $(this).children("td").slice(2,3).text();
			$(this).children("td").slice(4).children("span").each(function(index2, element){
				row[index2+2] = $(this).text();
			});
			dslophoc[index1] = row;

		});

		var printlophoc = [];
		var dsmonhoc = [];
		$('#table_lop thead tr').each(function (index1, element){
			$(this).children('th').each(function(index2, element){
					dsmonhoc[index2] = $(this).text();//bat dau tu 1
			});
		});
		var somon = dsmonhoc.length - 1;

		$("#table_lop tbody tr").each(function(index, element){
			var row = []
			row[0] = $(this).children("td").slice(0,1).text();//tenlop
			for(var i = 1; i <= somon; i++){
				row[i] = "";
				for(var j = 0; j < dslophoc.length; j++){
					if(dslophoc[j][1] == dsmonhoc[i]){
						for(var k = 2; k < dslophoc[j].length; k++){
							if( dslophoc[j][k] == row[0])
								row[i] = dslophoc[j][0];
						}
					}
				}
			}
			printlophoc[index] = row;
		});

		$('#table_lop tbody').empty();
		var append = "";
		for(var i = 0; i < printlophoc.length;i++){
				
			append+= "<tr>"
			for(var j = 0; j < printlophoc[i].length; j++)
				append+= "<td>"+ printlophoc[i][j] + "</td>"
			append += "</tr>";
		}
		$('#table_lop tbody').append(append);
		console.log(printlophoc);
	}

	$('#removeclass').click(function(){
		var listClass = [];
		var token = $('input[name="_token"]').val();
		var id = $('#id_t').text();
		$('#lopdathem_t tr').each(function(index, element){
			if($(this).hasClass('selected')){
					listClass.push($(this).children('td').slice(0).text());
				};
		});

		if($(this).length > 0){
			$.ajax({
				url: "<?= URL::to("admin/phancong/removeclass") ?>", 
				type:"POST",
				async: false,
				data:{
					'_token': token,
					'listClass': listClass,
					'id': id
				},
				success:function(rs){
					console.log("remove success");
					//console.log(rs);
					var dsloptrung = rs['dsloptrung'];
					var dschuaphan = rs["dschuaphan"];
					var loptrung = "";
					var lopchuathem = "";
					$('#lopdathem_t tr').each(function(index, element){
						if($(this).hasClass('selected')){
							$(this).remove();
							$('#lopchuathem_t').append("<tr>"+$(this).html()+"</tr>");
						}
					});	

					$('#messages_table tbody tr').each(function(index, element){
						var _length = $('#lopdathem_t').children('tr').length;
						if($(this).hasClass("selected")){
							$(this).children('td').slice(4).empty();
							if(_length >= 1){
								for(i = 0; i < _length; i++){
									$(this).children("td").slice(4).append("<span>" + $('#lopdathem_t').children('tr').eq(i).text() + "</span>&nbsp;");
								}
							}
						}
					});					
					//----------------------------------------------------
					$('#messages_table tbody tr').each(function(index, element){
							$(this).children('td').slice(4).children("span").each(function(index, element){
									if($(this).hasClass("trung"))
										$(this).removeClass('trung');
								});
					});
					$('#loptrung_table tbody tr').empty();
					loptrung +="<td>";
					if(dsloptrung != null){
						for(var i = 0; i < dsloptrung.length; i++){
							var lop = dsloptrung[i][0] + " ";
							var mon = dsloptrung[i][1];
							loptrung += "<span> " + dsloptrung[i][0] + "(" + dsloptrung[i][1] + ") </span>";
							$('#messages_table tbody tr').each(function(index, element){
							if($(this).children('td').slice(2,3).text() == mon)
								$(this).children('td').slice(4).children("span").each(function(index, element){
										if($(this).text() == lop)
											$(this).addClass('trung');
									});
								});
						}
					}
					loptrung += "</td>";
					$('#loptrung_table tbody tr').append(loptrung);
					$('#lopchuaxep_table tbody tr').empty();
					lopchuathem = "<td>";
					if(dschuaphan != null)
						for(var i = 0; i < dschuaphan.length; i++)
							lopchuathem += "<span> " + dschuaphan[i][0] + "(" + dschuaphan[i][1]+ ") </span>";
					lopchuathem += "</td>";
					$('#lopchuaxep_table tbody tr').append(lopchuathem);

					//dosomething in here
					//-------------------------------------------------------------------
					updatephanconglop();
				},
				error:function(){
					console.log('remove error');
				}
			});
		}

	});

	$('#menuschedule').click(function(){
		$(location).attr('href','menuschedule');
	});

	$('#tkb_lop').click(function(){
		var token = $('input[name="_token"]').val();
		$.ajax({
			url:"<?= URL::to('admin/phancong/check') ?>", 
			type:"POST",
			async:"false",	
			data:{
				"_token":token
			},
			success:function(rs){
				var dsloptrung = rs['dsloptrung'];
				var dschuaphan = rs["dschuaphan"];
				var loptrung = "";
				var lopchuathem = "";
				
				$('#messages_table tbody tr').each(function(index, element){
							$(this).children('td').slice(4).children("span").each(function(index, element){
									if($(this).hasClass("trung"))
										$(this).removeClass('trung');
								});
					});
				$('#loptrung_table tbody tr').empty();
				loptrung +="<td>";
				if(dsloptrung != null){
					for(var i = 0; i < dsloptrung.length; i++){
						var lop = dsloptrung[i][0] + " ";
						var mon = dsloptrung[i][1];
						loptrung += "<span> " + dsloptrung[i][0] + "(" + dsloptrung[i][1] + ") </span>";
						$('#messages_table tbody tr').each(function(index, element){
						if($(this).children('td').slice(2,3).text() == mon)
							$(this).children('td').slice(4).children("span").each(function(index, element){
									if($(this).text() == lop)
										$(this).addClass('trung');
								});
							});
					}
				}
				loptrung += "</td>";
				$('#loptrung_table tbody tr').append(loptrung);
				$('#lopchuaxep_table tbody tr').empty();
				lopchuathem = "<td>";
				if(dschuaphan != null)
					for(var i = 0; i < dschuaphan.length; i++)
						lopchuathem += "<span> " + dschuaphan[i][0] + "(" + dschuaphan[i][1]+ ") </span>";
				lopchuathem += "</td>";
				$('#lopchuaxep_table tbody tr').append(lopchuathem);

				if(dsloptrung == null && dschuaphan == null)
					$(location).attr('href', "tkbgvthaydoi_index");
				else{
					alert("Việc phân công không hoàn tất, không thể săp thời khóa biểu!!");
				}
				
			},
			error:function(){
				console.log("error lelele");
			}

		});
	});

   });
});
</script>

@endsection
















