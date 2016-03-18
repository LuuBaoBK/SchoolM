@extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
.trung {
	color: blue;
	}

.selected{
	background:#5882FA;
}

</style>

<section class="content-header">
    <h1>
        Admin
        <small>Schedule Manager</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin > Schedule Manager</a></li>
    </ol>
</section>
<input type="hidden" name="token" value="<?= csrf_token(); ?>">
<section class="content">
	<div class="box-body">
	    <div class="box box-primary">
	        <div class="box-header">
	            <h3 class="box-title">QUẢN LÝ THỜI KHÓA BIỂU GIÁO VIÊN (HIỆN TẠI)</h3>
	        </div>
	        <div class="box-body">
	    		<button class="btn btn-primary" id="menuschedule">MENU</button>
        		<button class="btn btn-primary" id="tkblopcu">XEM TKB THEO LỚP</button>
        		<button class="btn btn-primary" id="editupdate" disabled >CẬP NHẬT CHỈNH SỬA</button>
	        </div>
	    </div>
	</div>
    <div class="box-body table-responsive col-md-10" style="">
	    <div class="box box-primary">
	    	<div class="box-body box-primary table-responsive" style="height:570px">
	    		<table id="tkb_gv_table" class="table table-bordered table-hover data-table table-stripped" border="1">
			        <thead>
			            <tr>
			            	<th rowspan="2">MSGV</th>
			            	<th style="width:100px" rowspan ="2">Họ và tên</th>
			            	<th rowspan="2">Môn</th>
			            	<th rowspan="2">Lớp chủ nhiệm</th>
			            	<th rowspan="2">Số tiêt chưa phân</th>
			            	<th colspan="5">Sáng thứ 2</th>
			            	<th colspan="5">Chiều thứ 2</th>
			            	<th colspan="5">Sáng thứ 3</th>
			            	<th colspan="5">Chiều thứ 3</th>
			            	<th colspan="5">Sáng thứ 4</th>
			            	<th colspan="5">Chiều thứ 4</th>
			            	<th colspan="5">Sáng thứ 5</th>
			            	<th colspan="5">Chiều thứ 5</th>
			            	<th colspan="5">Sáng thứ 6</th>
			            	<th colspan="5">Chiều thứ 6</th>
			            </tr>
						<tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
						<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
						<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
						<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
						<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th></tr> 
			        </thead>
			        <tbody id="displayrecord">
			           <?php
					   		foreach ($thoikhoabieu as $gv) {
					   			echo "<tr><td>".$gv[0]."</td><td>".$gv[1]."</td><td>".$gv[2]."</td><td>".$gv[3]."</td><td>".$gv[4]."</td>";
					   			for($i = 0 ; $i < 50; $i++){
					   				$kiemtra = true;

					   				if($chuaphan)
					   					foreach ($chuaphan as $cp) {
						   					if( $cp[1] == $i and $cp[0] == $gv[$i + 5]){
						   						$kiemtra = false;
						   						echo "<td class='trung'>".$gv[$i + 5]."</td>";
						   						break;
						   					}
						   				}

					   				if($kiemtra)
					   					echo "<td>".$gv[$i + 5]."</td>";
					   			}
					   			echo "</tr>";
					   		}
					   ?>
        			</tbody>
	    		</table>
	    	</div>
	    </div>
	</div>
	<div class="col-md-2 box-solid box-body">
		<div class="box box-primary">
			<div class="box-body">
				<table class="table table-hover ">
					<thead class="box-solid bg-red">
						<tr><th>Lớp bị trùng</th></tr>
					</thead>
					<tbody>
						<?php
							if($chuaphan != null){
								foreach ($chuaphan as $tmp) {
									$tiet = $tmp[1]%10;
									$date = (int)(($tmp[1] - $tiet)/10) + 2;
									$tiet++;
									echo "<tr><td>".$tmp[0]."-thứ ".$date."-tiết ".$tiet."-".$tmp[2]." lần</td></tr>";
								}
							}
							echo "<tr><td>NONE</td></tr>";
						?>
					</tbody>
				</table>	
			</div>
		</div>		
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
		//alert("van minh");
		var numselected = 0;
		var row1 = 0, cell1 = 0;
		var row2 = 0, cell2 = 0;
		var dem1, dem2;
		$('#checkit').click(function(){
			var token = $('input[name ="token"]').val();
			$.ajax({
				url:"<?= URL::to('admin/tkbgv/check')?>",
				type:"POST",
				async:false,
				data:{
					"_token":token
				},
				success:function(rs){
					console.log("oke");
				},
				error:function(){
					console.log("chuong trinh bi loi");
				}


			});
		});

		$('#menuschedule').click(function(){
			$(location).attr('href', 'menuschedule');
		});

		$('#tkblopcu').click(function(){
			window.open('tkblopcu','_blank');
		});

		$('#displayrecord tr').on('click', 'td',function(){
			if($(this).text() == "cc" || $(this).text() == "sh" || this.cellIndex < 5)
				return;
			console.log($(this).text());
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
				numselected--;
			}
			else{
				if(numselected == 0){
					numselected ++;
					$(this).addClass("selected");
					cell1 = this.cellIndex;
					row1  = this.parentNode.rowIndex - 2;
					dem1   = $(this).text();
				}
				else{
					numselected = 0;
					var kiemtra = true;
					var cell2 = this.cellIndex;
					var dem2 = $(this).text();
					var row2 = this.parentNode.rowIndex - 2;
					$('#displayrecord').children().eq(row1).children().eq(cell1).removeClass('selected');
					if(row1 != row2)
						return;
					$('#displayrecord tr').each(function(){
						if($(this).children().eq(cell2).text() == dem1 || $(this).parent().children().eq(cell1) == dem2)
							kiemtra = false;
					});
					if(kiemtra){
						$('#displayrecord').children().eq(row1).children().eq(cell1).text(dem2);
						$(this).text(dem1);
						$('#editupdate').prop('disabled',false);
					}
					
				}
			} 
		});


		$('#editupdate').click(function(){
			var tkb = [];
			var gv = [];
			var row = 0;
			var col = 0;
			var token = $("input[name='token']").val();
			$("#displayrecord tr").each(function(){
				gv = [];
				col = 0;
				$(this).children().each(function(){
					gv[col] = $(this).text();
					col++;
				});
				tkb[row] = gv; 
				row++;
			});
			console.log(tkb);
			$.ajax({
				url:"<?=URL::to('admin/tkbhientai/updatetkbgv')?>",
				type:"POST",
				async:false,
				data:{
					"_token":token,
					"tkbgv"	: tkb
				},
				success:function(rs){
					//console.log("success!!");
					console.log(rs);
				},
				error:function(){
					console.log("error!!");
				}
			});
		});
	});
});
</script>
@endsection