@extends('mytemplate.blankpage_te')

@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
table.dataTable {
  width: auto;
  margin: 0;
}
.dataTables_scroll
{
    overflow:fixed;
}
</style>
<section class="content-header">
    <h1>
        Teacher
        <small>View Transcript</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/teacher/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
	<div class="box box-solid box-primary">
		<div class="box-header">
			<h3 class="box-title">View Transcript</h3>
	        <div class="box-tools pull-right">
	            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        </div>
		</div>
		<div class="box-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Class List</h3>
                        </div>
                        <div class="box-body">
                            <form>
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                    <label for="scholastic">Scholastic</label>
                                    <?php
                                        $year = date("Y");
                                        $month = date("m");
                                        if($month <= 8){
                                            $year = $year - 1;
                                        }
                                        echo "<select name='scholastic' id='scholastic' class='form-control'>";
                                        $selected = "selected";
                                        for($i=$year; $i>=2010; $i--){
                                            echo ("<option value='".substr($i, 2, 2)."' ".$selected." >".$i." - ".($i+1)."</option>");
                                            $selected = "";
                                        }
                                        echo "</select>";
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="grade">Grade</label>
                                    <?php
                                        echo "<select name='grade' id='grade' class='form-control'>";
                                        echo "<option value='0' selected> -- All --";
                                        for($i=9; $i>=6; $i--){
                                            echo ("<option value='".$i."'>".$i."</option>");
                                        }
                                        echo "</select>";
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <table id="class_list_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Class Id</th>
                                        <th>Class Name</th>
                                        <th>Homeroom Teacher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($class_list as $key => $class) {
                                            echo "<tr>";
                                            echo "<td>".$class->id."</td>";
                                            echo "<td>".$class->classname."</td>";
                                            echo "<td>".$class->teacher->user->fullname."</td>";
                                            echo "</tr>";
                                        } 
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Result Box</h3>
                        </div>
                        <div class="box-body">
                            <div class="filter_board">
                                <div class="form-group col-lg-4">
                                    <label for="classname">Class Name</label>
                                    <input type="text" name="classname" id="classname" class="form-control" placeholder="Class Name" readonly>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="total_student">Total Students</label>
                                    <input type="text" name="total_student" id="total_student" class="form-control" placeholder="Total Students" readonly>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="homeroomteacher">Homeroom Teacher</label>
                                    <input type="text" name="homeroomteacher" id="homeroomteacher" class="form-control" placeholder="Homeroom Teacher" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div id="waiting_record" style="display:none"  class="text-center">
                                <i class="fa fa-spin fa-refresh"></i>&nbsp; Loading...
                            </div>
                            <div id="div_view_transcript_table">
                                <table id="view_transcript_table" class="table table-border" witdh="100%">
                                    <thead id='view_transcript_table_header'>
                                        <tr>
                                            <th>Result Table</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
	$('#sidebar_list_2').addClass('active');
    $('#class_list_table').dataTable({
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "scrollY": "400px",
        "scrollCollapse": true,
        "info" : true,
        "paging": false,
        "dom": '<"pull-left"flp>'
    });
    // $('#view_transcript_table').DataTable({
    //     "lengthChange": true,
    //     "searching": true,
    //     "ordering": false,
    //     "scrollY": "750px",
    //     "scrollCollapse": true,
    //     "info" : true,
    //     "paging": false,
    // });

    $(document).on('click','a',function(e){
        if($(this).html() == "HK 1" || $(this).html() == "HK 2"){
            var col_list = $(this).attr('col_list').split("_");
            var i = 0;
            var vis;
            for(i=0;  i < col_list.length - 1; i++){
                vis = $('#view_transcript_table').dataTable().fnSettings().aoColumns[col_list[i]].bVisible;
                $('#view_transcript_table').dataTable().fnSetColumnVis(col_list[i], vis? false : true);
            }   
        }        
    });

    $('#scholastic').on('change',function(){
        update_class_list();
    });
    $('#grade').on('change',function(){
        update_class_list();
    });
    $('#class_list_table tbody').on('click','tr',function(){
        if($(this).hasClass('selected')){
            $(this).removeClass('selected');
        }
        else{
            $('#waiting_record').css('display','block');
            $('#class_list_table tr.selected').removeClass('selected');
            $(this).addClass('selected');
            var data = $('#class_list_table').dataTable().fnGetData(this);
            if(data != null){
                var class_id = data[0];
                var token = $('input[name="_token"]').val();
                $.ajax({
                    url     :"<?= URL::to('/teacher/transcript/view_transcript_get_score') ?>",
                    type    :"POST",
                    async   :false,
                    data    :{
                            'class_id'      :class_id,
                            '_token'        :token
                            },
                    success:function(record){
                        $('#classname').val(data[1]);
                        $('#homeroomteacher').val(data[2]);
                        $('#total_student').val(record.length);
                        update_view_transcript_table(record);
                    },
                    error:function(){
                        alert("something went wrong, contact master admin to fix");
                    }
                });
            }
        }
    });

	// $('th#1').on('click',function(){
	// 	console.log("abc");
	// 	$('#view_transcript_table').DataTable().column(0).visible(false);
	// })

    function update_class_list(){
        var scholastic = $('#scholastic').val();
        var grade      = $('#grade').val();
        var token = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/teacher/transcript/view_transcript_get_class') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'      :scholastic,
                    'grade'         :grade,
                    '_token'        :token
                    },
            success:function(record){
                $('#class_list_table').dataTable().fnClearTable();
                $.each(record,function(key,row){
                    $('#class_list_table').dataTable().fnAddData([
                        row.id,
                        row.classname,
                        row.teacher.user.fullname
                    ]);
                });
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }

    function update_view_transcript_table(record){
        create_table(record);
        var month_list = [];
        var score_list = [];
        var temp = [];
        var i = 0;
        if(record.length == 0){
            return true;
        }
        for(i=8;i<=12;i++){
            score_list = [];
            $.each(record[0].score_list,function(score_list_key,score_list_item){
                if(score_list_key == "month_"+i){
                    $.each(score_list_item,function(scoretype_key,score){
                        if(scoretype_key != "__proto__" && scoretype_key != "month_average"){
                            score_list.push(scoretype_key);
                        }
                    });
                    score_list.push('month_average');
                    month_list.push({month : "month_"+i, score_list : score_list});
                }
            });
        }
        for(i=1;i<=5;i++){
            score_list = [];
            $.each(record[0].score_list,function(score_list_key,score_list_item){
                if(score_list_key == "month_"+i){
                    $.each(score_list_item,function(scoretype_key,score){
                        if(scoretype_key != "__proto__" && scoretype_key != "month_average"){
                            score_list.push(scoretype_key);
                        }
                    });
                    score_list.push('month_average');
                    month_list.push({month : "month_"+i, score_list : score_list});
                }
            });
        }
        $.each(record, function(student_list_key, student){
            temp = [];
            temp.push(student.student_id);
            temp.push(student.fullname);
            $.each(month_list,function(key,score_list){
                $.each(score_list.score_list,function(score_key,score){
                    temp.push(student.score_list[score_list.month][score]);
                });
            });
            temp.push(student.score_list['hk1_average']);
            temp.push(student.score_list['hk2_average']);
            temp.push(student.score_list['scholastic_average']);
            $('#view_transcript_table').dataTable().fnAddData(temp);
        });
        //console.log(month_list);
    }

    function create_table(record){
        var total_score_type = 0;
        var total_score_type_hk1 = 0;
        var total_score_type_hk2 = 0;
        var total_month = 0;
        var i = 0;
        if(record[0] != null){
            $.each(record[0].score_list,function(score_list_key,score_list_item){
                if(score_list_key.search("month_") > -1){
                    $.each(score_list_item, function(scoretype_key, score_type){
                        if(scoretype_key != "__proto__"){
                            total_score_type ++;
                            if(score_list_key.split("_")[1] < 8){
                                total_score_type_hk2 +=1; 
                            }
                            else{
                                total_score_type_hk1 +=1;
                            }
                        }
                        total_month ++;
                    })
                }
            });
            $('#view_transcript_table').dataTable().fnDestroy();
            $('#div_view_transcript_table').empty();
            $('#div_view_transcript_table').append("<table width='auto' style='witdh:auto' id='view_transcript_table' class='table table-border table-striped'><thead id='view_transcript_table_header'></thead><tbody></tbody></table>");
            var header  = "<tr>";
                header += "<th rowspan='3'>Id</th>";
                header += "<th rowspan='3'>Full_Name</th>";
                if(total_score_type_hk1 > 0){
                    header += "<th colspan='"+total_score_type_hk1+"' ><a href='#!'>HK 1</a></th>";
                }
                if(total_score_type_hk2 > 0){
                    header += "<th colspan='"+total_score_type_hk2+"' ><a href='#!'>HK 2</a></th>";
                }
                header += "</tr>";
            $('#view_transcript_table_header').append(header);
            header = "<tr>";
            for(i=8;i<=12;i++){
                $.each(record[0].score_list,function(score_list_key,score_list_item){
                    if(score_list_key.search("month_"+i) > -1){
                        total_score_type = 0;
                        $.each(score_list_item, function(scoretype_key, score_type){
                            total_score_type ++;
                        });
                        header += "<th colspan='"+(total_score_type)+"'>"+i+"</th>";
                        return false; // Break Loop Score_list
                    }
                });
            }
            for(i=1;i<=5;i++){
                $.each(record[0].score_list,function(score_list_key,score_list_item){
                    if(score_list_key.search("month_"+i) > -1){
                        total_score_type = 0;
                        $.each(score_list_item, function(scoretype_key, score_type){
                            total_score_type ++;
                        });
                        header += "<th colspan='"+(total_score_type)+"'>"+i+"</th>";  
                        return false; // Break Loop Score_list
                    }
                });
            }
            header += "<th colspan='3'>Sumary</th>";
            header += "</tr>";
            $('#view_transcript_table_header').append(header);

            header = "<tr>";
            total_score_type = 1; // use as count throught
            for(i=8;i<=12;i++){
                $.each(record[0].score_list,function(score_list_key,score_list_item){
                    if(score_list_key == "month_"+i){
                        $.each(score_list_item,function(scoretype_key,score){
                            if(scoretype_key != "__proto__" && scoretype_key != "month_average"){
                                total_score_type += 1;
                                header += "<th class='"+score_list_key+" hk1' data-col_index='"+total_score_type+"' >"+scoretype_key+"</th>"
                            }
                        });
                        header += "<th>Month Average</th>";
                        total_score_type +=1;
                    }
                });
            }
            for(i=1;i<=5;i++){
                $.each(record[0].score_list,function(score_list_key,score_list_item){
                    if(score_list_key == "month_"+i){
                        $.each(score_list_item,function(scoretype_key,score){
                            if(scoretype_key != "__proto__" && scoretype_key != "month_average"){
                                total_score_type +=1;
                                header += "<th class='"+score_list_key+" hk2' data-col_index='"+total_score_type+"' >"+scoretype_key+"</th>"
                            }
                        });
                        header += "<th>Month Average</th>";
                        total_score_type +=1;
                    }
                });
            }
            header += "<th>HK1 Average</th>";
            header += "<th>HK2 Average</th>";
            header += "<th>Scholastic Average</th>";
            header += "</tr">

            $('#view_transcript_table_header').append(header);

            $('#view_transcript_table').dataTable({
                "bAutoWidth": false,
                "bFilter":true,
                "bSort":true,
                "bLengthChange":false,
                "bInfo":false,
                "bPaginate":false,
                "sScrollX": "100%",
                "sScrollY": "450px"
            });

            var temp = -1;
            var hk1 = "";
            var hk2 = "";
            $('#view_transcript_table th.hk1').each(function(){
                temp = $(this).attr('data-col_index');
                $('#view_transcript_table').dataTable().fnSetColumnVis(temp,true);
                hk1 += temp+"_";
            });
            $('#view_transcript_table').dataTable().fnAdjustColumnSizing();
            $('#view_transcript_table').dataTable().fnDraw();
            $('#view_transcript_table th.hk2').each(function(){
                temp = $(this).attr('data-col_index');
                $('#view_transcript_table').dataTable().fnSetColumnVis(temp,true);
                hk2 += temp+"_";
            });
            $('#view_transcript_table').dataTable().fnAdjustColumnSizing();
            $('#view_transcript_table').dataTable().fnDraw();
            $("a:contains('HK 1')").attr('col_list',hk1);
            $("a:contains('HK 2')").attr('col_list',hk2);
            $('#waiting_record').css('display','none');
        }
        else{
            $('#waiting_record').css('display','none');
            $('#view_transcript_table').dataTable().fnClearTable();
        }
    }
});
</script>
@endsection