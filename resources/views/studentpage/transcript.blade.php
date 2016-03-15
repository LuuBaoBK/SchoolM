@extends('mytemplate.blankpage_stu')
@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
table {
    table-layout: fixed !important;
}

table tr.odd{
	background-color: #FCFBFF !important
}
table tr.sumary{
	background-color: #C1A5FC !important
}
</style>
<section class="content-header">
    <h1>
        Student
        <small>Dash Board</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/student/dashboard"><i class="fa fa-home"></i>Student</a> -> Transcript</li>
    </ol>
</section>
<section class="content">
<div class="box box-primary box-solid">
	<div class="box-header">
		<h4 class="box-title">View Transcript</h4>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-lg-4">
				<div id="class_list_div" class="box box-primary">
					<div class="box-header">
						<h4 class="box-title">Attended Class</h4>
						<div class="box-tools pull-right">
				            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
				        </div>
					</div>
					<div class="box-body">
						<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
						<table width="100%" id="class_list_table" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Class Id</th>
									<th>Class Name</th>
									<th>Scholastic</th>
									<th>Homeroom Teacher</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($class_list as $key => $class) {
										echo "<tr>";
										echo "<td>".$class->id."</td>";
										echo "<td>".$class->classname."</td>";
										echo "<td>20".substr($class->id, 0,2)."</td>";
										echo "<td>".$class->home_teacher->fullname."</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="subject_div" style="display:none" class="box box-primary">
					<div class="box-header">
						<h4 class="box-title">Subject List</h4>
						<div class="box-tools pull-right">
				            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
				        </div>
					</div>
					<div class="box-body">
						<table width="100%" id="subject_list_table" class="table table-striped table-bordered">
							<thead>
								<th>Subject_id</th>
								<th>Class_id</th>
								<th>Subject</th>
								<th>Teacher</th>
							</thead>
							<tbody></tbody>	
						</table>
					</div>
				</div>
			</div>
			<div  class='col-lg-8'>
				<div id="score_div" class="box box-primary">
					<div class="box-header">
						<h4 class="box-title">Score List</h4>
					</div>
					<div class="box-body">
						<table width="100%" style="witdh:100%" id="score_list_table" class="table">
							<thead>
								<th width="25%">#</th>
								<th width="25%">Score</th>
								<th width="50%">Note</th>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#sidebar_transcript').addClass('active');

		$('#class_list_table').dataTable({
			"bAutoWidth": false,
            "bFilter":false,
            "bSort":false,
            "bLengthChange":false,
            "bInfo":false,
            "bPaginate":false,
            //"sScrollX": true
            "columnDefs": [
		        { targets: [0], visible: false},
		    ]

		});

		$('#subject_list_table').dataTable({
			"bAutoWidth": true,
            "bFilter":false,
            "bSort":false,
            "bLengthChange":false,
            "bInfo":false,
            "bPaginate":false,
            //"sScrollX": true
            "columnDefs": [
		        { targets: [0,1], visible: false},
		    ]
		});


		$('#subject_div').slimScroll({
            height: '550px'
        });

        $('#score_div').slimScroll({
            height: '650px'
        });

		$('#score_list_table').dataTable({
			"bAutoWidth": true,	
            "bFilter":false,
            "bSort":false,
            "bLengthChange":false,
            "bInfo":false,
            "bPaginate":false,
            //"sScrollX": true

		});

		$('#class_list_table tbody tr').on('click',function(){
			if($(this).hasClass('selected')){
	            $(this).removeClass('selected');
	        }
	        else{
	            $('#class_list_table tr.selected').removeClass('selected');
	            $(this).addClass('selected');
				var data = $('#class_list_table').dataTable().fnGetData(this);
				var token = $('input[name="_token"]').val();
				if(data != null){
					$.ajax({
			            url     :"<?= URL::to('/student/transcript/select_class') ?>",
			            type    :"POST",
			            async   :false,
			            data    :{
			                    'data'      :data,
			                    '_token'        :token
			                    },
			            success:function(record){
			                if(record[0].length > 0){
			                	$('#subject_div').css('display','block');
			                	$("#class_list_div button").click();
			                	$('#subject_list_table').dataTable().fnClearTable();
			                	$('#subject_list_table').dataTable().fnAddData([
			                		"all",
			                		record[0][0].class_id,
			                		"Sumary",
			                		""
		                		]);
			                	$.each(record[0], function(i,j){
			                		$('#subject_list_table').dataTable().fnAddData([
			                			j.subject.id,
			                			j.class_id,
			                			j.subject.subject_name,
			                			j.teacher_name	
		                			]);
			                	});
			                }
			                $('#score_list_table').dataTable().fnClearTable();
			                $.each(record[1],function(i,j){
			                	$('#score_list_table').dataTable().fnAddData([
			                		i,
			                		j,
			                		"Trung Binh Tong Mon Hoc"
		                		]);
			                });
			            },
			            error:function(){
			                alert("something went wrong, contact master admin to fix");
			            }
			        });
				}
			}
		})

		$(document).on('click','#subject_list_table tbody tr',function(){
			if($(this).hasClass('selected')){
	            $(this).removeClass('selected');
	        }
	        else{
	            $('#subject_list_table tr.selected').removeClass('selected');
	            $(this).addClass('selected');
				var data = $('#subject_list_table').dataTable().fnGetData(this);
				var token = $('input[name="_token"]').val();
				if(data != null){
					$.ajax({
			            url     :"<?= URL::to('/student/transcript/select_subject') ?>",
			            type    :"POST",
			            async   :false,
			            data    :{
			                    'data'      :data,
			                    '_token'        :token
			                    },
			            success:function(record){
			            	console.log(record);
			            	if(record.type == "all"){
			            		$('#score_list_table').dataTable().fnClearTable();
				                $.each(record.data,function(i,j){
				                	$('#score_list_table').dataTable().fnAddData([
				                		i,
				                		j,
				                		"Trung Binh Tong Mon Hoc"
			                		]);
				                });
				                console.log("done");
			            	}
			            	else{
			            		$('#score_list_table').dataTable().fnClearTable();
			            		var i = 0;
			            		var myclass = 'odd';
			            		for(i=8;i<=12;i++){
			            			var a = $('#score_list_table').dataTable().fnAddData([
			            				"<b><u>Month : "+i+"</u></b",
			            				"",
			            				""
		            				]);
									var nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;									
									$(nTr).removeClass('odd');
									$(nTr).removeClass('even');
									$(nTr).addClass(myclass);
			            			$.each(record['month_'+i],function(i,j){
			            				if(i.search("average") == -1 ){
			            					a = $('#score_list_table').dataTable().fnAddData([
				            					i,
				            					j['0'],
				            					j['1']
			            					]);
			            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
											$(nTr).removeClass('odd');
											$(nTr).removeClass('even');
											$(nTr).addClass(myclass);
			            				}
			            				if(i.search("average") > 0 ){
			            					if(j == "noscore"){
			            						a = $('#score_list_table').dataTable().fnAddData([
					            					i,
					            					j,
					            					"No Score"
				            					]);
				            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
												$(nTr).removeClass('odd');
												$(nTr).removeClass('even');
												$(nTr).addClass(myclass);
			            					}
			            					else{
			            						a = $('#score_list_table').dataTable().fnAddData([
					            					i,
					            					j[0],
					            					j[1]
				            					]);
				            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
												$(nTr).removeClass('odd');
												$(nTr).removeClass('even');
												$(nTr).addClass(myclass);
			            					}
				            			}
			            			});
			            			myclass = (myclass == "odd") ? "even" : "odd";
			            		}
			            		for(i=1;i<=5;i++){
			            			var a = $('#score_list_table').dataTable().fnAddData([
			            				"<b><u>Month : "+i+"</u></b>",
			            				"",
			            				""
		            				]);
									var nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;									
									$(nTr).removeClass('odd');
									$(nTr).removeClass('even');
									$(nTr).addClass(myclass);
			            			$.each(record['month_'+i],function(i,j){
			            				if(i.search("average") == -1 ){
			            					a = $('#score_list_table').dataTable().fnAddData([
				            					i,
				            					j['0'],
				            					j['1']
			            					]);
			            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
											$(nTr).removeClass('odd');
											$(nTr).removeClass('even');
											$(nTr).addClass(myclass);
			            				}
			            				if(i.search("average") > 0 ){
			            					if(j == "noscore"){
			            						a = $('#score_list_table').dataTable().fnAddData([
					            					i,
					            					j,
					            					"No Score"
				            					]);
				            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
												$(nTr).removeClass('odd');
												$(nTr).removeClass('even');
												$(nTr).addClass(myclass);
			            					}
			            					else{
			            						a = $('#score_list_table').dataTable().fnAddData([
					            					i,
					            					j[0],
					            					j[1]
				            					]);
				            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
												$(nTr).removeClass('odd');
												$(nTr).removeClass('even');
												$(nTr).addClass(myclass);
			            					}
				            			}
			            			});
			            			myclass = (myclass == "odd") ? "even" : "odd";
			            		}

			            		a = $('#score_list_table').dataTable().fnAddData([
	            					"HK1 Average",
	            					record['hk1_average'],
	            					""
            					]);
            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
								$(nTr).removeClass('odd');
								$(nTr).removeClass('even');
								$(nTr).addClass('sumary');

								a = $('#score_list_table').dataTable().fnAddData([
	            					"HK2 Average",
	            					record['hk2_average'],
	            					""
            					]);
            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
								$(nTr).removeClass('odd');
								$(nTr).removeClass('even');
								$(nTr).addClass('sumary');

								a = $('#score_list_table').dataTable().fnAddData([
	            					"Scholastic Average",
	            					record['scholastic_average'],
	            					""
            					]);
            					nTr = $('#score_list_table').dataTable().fnSettings().aoData[ a[0] ].nTr;
								$(nTr).removeClass('odd');
								$(nTr).removeClass('even');
								$(nTr).addClass('sumary');

			            	}
			            },
			            error:function(){
			                alert("something went wrong, contact master admin to fix");
			            }
			        });
				}
			}
		})

	});

</script>

@endsection
