@extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
.trung {
	color: blue;
	}
table, th, td {
    border: 1px solid black;
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
	            <h3 class="box-title">QUẢN LÝ THỜI KHÓA BIỂU GIÁO VIÊN (NEW)</h3>
	        </div>
	        <div class="box-body">
	        	<button class="btn btn-primary" id="menuschedule">MENU</button>
	        	<button class="btn btn-primary" id ="createNewSchedule">
	        		TẠO TKB MỚI
	        	</button>
	        	<button class="btn btn-primary" id ="tkblop_index">XEM TKB THEO LỚP</button>
	    		<button class="btn btn-primary" id ="editupdate" disabled="true">CẬP NHẬT CHỈNH SỬA</button>
	        </div>
	    </div>
	</div>
    <div class="box-body table-responsive col-md-10" style="">
	    <div class="box box-primary">
	    	<div class="box-body box-primary table-responsive" style="height:600px">
	    		<table id="tkb_gv_table" class="table table-bordered table-hover data-table table-stripped" style='overflow: auto; display: inline-block; width: 100%; height:600px' border="1">
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
			        <tbody id="tkb_gv">
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
					<tbody id="dsloptrung">
						<tr><td>NONE</td></tr>
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
		
		var numselected = 0;
		var row1 = 0, cell1 = 0;
		var row2 = 0, cell2 = 0;
		var dem1, dem2;

		$('#menuschedule').click(function(){
			$(location).attr('href', 'menuschedule');
		});


		$('#tkblop_index').click(function(){
			//$(location).attr('href', 'tkblop_index').attr('target','_blank');
			window.open('tkblop_index','_blank');
		});

		$('#createNewSchedule').click(function(){
			
			var token = $('input[name="token"]').val();
			$.ajax({
				url:"<?=URL::to('/admin/tkbgv_index/createNewSchedule')?>",
				type:"POST",
				async:false,
				data:{
					'_token' : token
				},
				success:function(rs){
					var append = "";					
					var dsloptrung = rs['dsloptrung']; 
        			var thoikhoabieu = rs['thoikhoabieu']; 
        			// console.log(rs);

					$('#tkb_gv').empty();
					for (var i = 0; i < thoikhoabieu.length; i++) {
						gv = thoikhoabieu[i];
		   				append += "<tr><td>" + gv[0] + "</td><td>" + gv[1] + "</td><td>" + gv[2] + "</td><td>" + gv[3] + "</td><td>"+ gv[4] + "</td>" ;
			   			for(var j = 0 ; j < 50; j++){
			   				var kiemtra = true;
			   				if(dsloptrung)
			   					for (var k = 0; k < dsloptrung.length; k++) {
				   					if( dsloptrung[k][1] == j && dsloptrung[k][0] == gv[j + 5]){
				   						kiemtra = false;
				   						append += "<td class='trung'>" + gv[j + 5] + "</td>";
				   						break;
				   					}
				   				}
			   				if(kiemtra)
			   					append +=  "<td>" + gv[j + 5] + "</td>";
		   				}
	   					append += "</tr>";
	   				}

	   				$('#tkb_gv').append(append);

	   				$('#dsloptrung').empty();
	   				append ="";
	   				if(dsloptrung){
						for( var i = 0; i < dsloptrung.length; i++) {
							tmp = dsloptrung[i];
							tiet = tmp[1]%10;
							date = (tmp[1] - tiet)/10 + 2;
							tiet++;
							append += "<tr><td>"+tmp[0]+"-thứ "+date+"-tiết "+tiet+"-"+tmp[2]+" lần</td></tr>";
						}
						$('#dsloptrung').append(append);
					}
   					$('#dsloptrung').append("<tr><td>NONE</td></tr>");
				},
				error:function(){
					console.log("error!!");
				}
			})	
		});

		$('#tkb_gv').delegate('tr td', 'click',function(){
			///console.log($(this).text() + ", cell" + this.cellIndex + ", row " + this.parentNode.rowIndex);
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
					$('#tkb_gv').children().eq(row1).children().eq(cell1).removeClass('selected');
					if(row1 != row2)
						return;
					$('#tkb_gv tr').each(function(){
						if($(this).children().eq(cell2).text() == dem1 || $(this).parent().children().eq(cell1) == dem2)
							kiemtra = false;
					});
					if(kiemtra){
						$('#tkb_gv').children().eq(row1).children().eq(cell1).text(dem2);
						$(this).text(dem1);
						$("#editupdate").prop("disabled", false);
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
			$("#tkb_gv tr").each(function(){
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