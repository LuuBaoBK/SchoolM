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
	            <h3 class="box-title">QUẢN LÝ THỜI KHÓA BIỂU GIÁO VIÊN (UPDATE)</h3>
	        </div>
	        <div class="box-body">
	        	<button class="btn btn-primary" id ="menuschedule">MENU</button>
	    		<button class="btn btn-primary" id ="updatetheophancong">CẬP NHẬT THEO PHÂN CÔNG</button>
        		<button class="btn btn-primary" id ="tkblopcu" target="_blank">XEM TKB THEO LỚP</button>
        		<button class="btn btn-primary" id ="editupdate" disabled>CẬP NHẬT CHỈNH SỬA</button>
	        </div>
	    </div>
	</div>
    <div class="box-body table-responsive col-md-10" style="">
	    <div class="box box-primary">
	    	<div class="box-body box-primary table-responsive" style="height:570px">
	    		<table id="class_table" class="table table-bordered table-hover data-table table-stripped" border="1">
			        <thead>
			            <tr>
			            	<th rowspan="2">MSGV</th>
			            	<th rowspan="2">Họ và tên</th>
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
					<tbody id ="lopbitrung">
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

		var x1, y1, x2, y2, v1, v2, countselected = 0, num1 = 0, num2 = 0;

		$('#tkblopcu').click(function(){
			window.open("tkblopcu", "_blank");
		});

		$('#menuschedule').click(function(){
			$(location).attr('href', 'menuschedule');
		});

		$('#updatetheophancong').click(function(){
			var token  = $('input[name ="token"]').val();

			$.ajax({
				url:"<?= URL::to("/admin/tkbgvthaydoi_index/capnhat")?>",
				type:"POST",
				async:false,
				data:{
					"_token": token,
				},
				success:function(rs){
					var append = "";
					$('#displayrecord').empty();
					thoikhoabieu = rs['thoikhoabieu'] ;
        			dsloptrung 	 = rs['dsloptrung'];

        			if(thoikhoabieu){
        				for(var i = 0; i < thoikhoabieu.length; i++){
        					append += "<tr>";
        					append += "<td>" + thoikhoabieu[i][0]+ "</td>";
        					append += "<td>" + thoikhoabieu[i][1]+ "</td>";
        					append += "<td>" + thoikhoabieu[i][2]+ "</td>";
        					append += "<td>" + thoikhoabieu[i][3]+ "</td>";
        					append += "<td>" + thoikhoabieu[i][4]+ "</td>";
        					for(var j = 0; j < 50; j++){
        						if(dsloptrung){
        							var bitrung = false;
        							for(var k = 0; k < dsloptrung.length; k++){
        								if(dsloptrung[k][0] == thoikhoabieu[i][j+5] 
        									&& dsloptrung[k][1] == thoikhoabieu[i][2]){
        									bitrung = true;
        									break;
        								}
        							}

        							if(bitrung){
        								append += "<td class='trung'>" + thoikhoabieu[i][j + 5]+ "</td>";	
        							}else{
        								append += "<td>" + thoikhoabieu[i][j + 5]+ "</td>";	
        							}
        						}
        						else
        							append += "<td>" + thoikhoabieu[i][j + 5]+ "</td>";
        					}
        					append += "</tr>";
        				}
        			};

        			$("#displayrecord").append(append);
        			$('#lopbitrung').empty();
        			if(dsloptrung){
        				append = "<tr>";
        				for(var i = 0; i < dsloptrung.length; i++){
        					append += "<span>" +  dsloptrung[i][0] + "(" + dsloptrung[i][1] + ")</span>&nbsp";
        				}
        				append = "</tr>";
        				$("#lopbitrung").append(append);
        			}
				},
				error:function(){
					console.log("error!!");
				}
			});

		});

		$("#displayrecord").delegate("tr td", "click", function(){

			if($(this).hasClass('selected')){
				countselected--;
				$(this).removeClass('selected');
			}else{
				if($(this).text() == "cc" || $(this).text() == "sh" || this.cellIndex < 5)
					return;
				if(countselected == 0){
					countselected++;
					x1 = this.cellIndex;
					y1 = this.parentNode.rowIndex;
					v1 = $(this).html();
					$(this).addClass("selected");
				}else{
					x2 = this.cellIndex;
					y2 = this.parentNode.rowIndex;
					v2 = $(this).html();
					$("#displayrecord").children().eq(y1 - 2).children().eq(x1).removeClass('selected');
					countselected = 0;
					// if(y2 != y1)
					// 	return;
					console.log("x1:" + x1 +",y1:" +y1+ ",v1:" +v1+ ",x2:" +x2+ ",y2:"+y2+"v2:"+v2);
					num1  = 0;
					num2  = 0;
					$("#displayrecord tr").each(function(){
						if($(this).children().eq(x1).html() == v2)
							num2 ++;
						if($(this).children().eq(x2).html() == v1)
							num1++;
					});
					if(v1 == "") num1 = 0;
					if(v2 == "") num2 = 0;

					if(num1==0 && num2 == 0 && v1 != v2){
						$(this).html(v1);
						$("#displayrecord").children().eq(y1 - 2).children().eq(x1).html(v2);
						$('#editupdate').prop('disabled', false);
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