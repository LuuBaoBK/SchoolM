@extends('adminpage.schedule.schedule_template')

@section('schedule_message')
<div class="box box-warning box-solid">
    <div class="box-header">Error List</div>
    <div id="error_list" class="box-body">
        <ul id="dsloptrung" class="list-group">
            <li class="list-group-item list-group-item-danger">Duplicated Class</li>
            <li class="list-group-item">None</li>
        </ul>
    </div>
</div>
@endsection
@section('schedule_content')
<style type="text/css">
.trung {
    color: black;
}
td.selected{
    background:#5882FA;
}
</style>
<div class="box box-primary">
    <div class="box-header">
        <p class="text-center" style="font-size:25px">Create New Schedule</p>
        <?php 
            $year = date("Y");
            $year = (date("m") < 8) ? ($year -1) : $year;
            $data_show = $year."-".($year+1);
        ?>
        <p class="text-center" style="font-size:17px">{{$data_show}}</p>
    </div>
    <div class="box-body">
        <ul class="list-group">
            <li class="list-group-item" style="border:none">
                <button id="btn_create_new_schedule" class="btn btn-primary btn-flat">Create New Schedule</button>
                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                <button id="editupdate" style="display:none" class="btn btn-primary btn-flat">Update Schedule</button>
                <button id="btn_confirm" style="display:none" class="btn btn-primary btn-flat">Confirm</button>
            </li>
            <li class="list-group-item" style="border:none">
                <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success</h4>
                </div>
            </li>
            <li id="onloading" class="list-group-item text-center" style="display:none; border:none"><i class="fa fa-refresh fa-spin" ></i>&nbsp Loading ... <i class="fa fa-refresh fa-spin" ></i></li>
            <li id="error_list" class="list-group-item" style="display:none; border:none">  
                <ul class="list-group">
                    <li class="list-group-item list-group-item-danger"><h4>Teacher overtime error</h4></li>
                </ul>
                <table id="error_table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Teacher ID</th>
                            <th>Full name</th>
                            <th>Total Time</th>
                            <th>Max Time</th>
                        </tr>
                    </thead>
                </table>
            </li>
            <li class="list-group-item table-responsive" style="border:none">
                <h4>Schedule</h4>
                <table id="tkb_gv_table" class="table table-bordered table-hover table-striped" style='overflow: auto; display: inline-block; width: 100%; height:600px;'>
                    <thead>
                        <tr>
                            <th rowspan="2">Teacher Id</th>
                            <th rowspan="2">Full name</th>
                            <th rowspan="2">Subject</th>
                            <th rowspan="2">Homeroom class</th>
                            <th rowspan="2">Remained Period</th>
                            <th colspan="10">Monday</th>
                            <th colspan="10">Tuesday</th>
                            <th colspan="10">Wednesday</th>
                            <th colspan="10">Thursday</th>
                            <th colspan="10">Friday</th>
                        </tr>
                        @for($i=0;$i<=4;$i++)
                            @for($k=1;$k<=10;$k++)
                                <th>{{$k}}</th>
                            @endfor
                        @endfor 
                    </thead>
                    <tbody id="tkb_gv">
                    </tbody>
                </table>
            </li>
        </ul>
    </div>
</div>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        // $('#tkb_gv_table').dataTable({
        //     "bAutoWidth": false,
        //     "bFilter":false,
        //     "bSort": false,
        //     "bLengthChange":false,
        //     "bInfo":false,
        //     "bPaginate":false,
        // });
        $('#error_table').dataTable({
            "bAutoWidth": false,
            "bFilter":false,
            "bSort": false,
            "bLengthChange":false,
            "bInfo":true,
            "bPaginate":true,

        });
        $('#btn_new_schedule').addClass('active');
        $('#btn_create_new_schedule').on('click',function(){
            var token = $("input[name='_token']").val();
            $('#onloading').css('display','block');
            setTimeout(function(){
                $.ajax({
                    url :"<?= URL::to('admin/schedule/create_schedule')?>" ,
                    type: "POST",
                    async: false,
                    data:{
                        '_token'     : token
                    }, 
                    success:function(record){
                        if(record.status == "error"){
                            $('#onloading').css('display','none');
                            $('#schedule_table').parent().css('display','none');
                            $('#error_list').css('display','block');
                            $.each(record,function(i,j){
                                if(i != "status"){
                                    $('#error_table').dataTable().fnAddData([
                                        j.teacher_id,
                                        j.fullname,
                                        j.total_time,
                                        j.max_time
                                    ]);
                                }
                            });
                            $('#error_list').append(record);
                        }
                        else{
                            create_schedule();
                        }
                    },
                    error:function(){
                        alert("Has something go wrong!!");
                    }
                });
            },10);
        });
        function create_schedule(){
            var token = $("input[name='_token']").val();
            $.ajax({
                url:"<?=URL::to('/admin/tkbgv_index/createNewSchedule')?>",
                type:"POST",
                async:false,
                data:{
                    '_token' : token
                },
                success:function(rs){
                    $('#onloading').css('display','none');
                    $('#editupdate').css('display','inline-block')
                    $('#btn_confirm').css('display','inline-block');
                    $('#btn_create_new_schedule').html('Remake Schedule To Fix Duplicated');
                    var append = "";                    
                    var dsloptrung = rs['dsloptrung']; 
                    var thoikhoabieu = rs['thoikhoabieu']; 
                    // // console.log(rs);

                    $('#tkb_gv').empty();
                    // $('#tkb_gv_table').dataTable().fnClearTable();
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
                        // $('#tkb_gv_table').dataTable({
                        //     "bAutoWidth": false,
                        //     "bFilter":false,
                        //     "bSort": false,
                        //     "bLengthChange":false,
                        //     "bInfo":false,
                        //     "bPaginate":false,
                        // });
                        
                        // $('#tkb_gv_table').dataTable().fnAddData([
                        //     gv[0],gv[1],gv[2],gv[3],gv[4],gv[5],gv[6],gv[7],gv[8],gv[9],gv[10],
                        //     gv[10],gv[11],gv[12],gv[13],gv[15],gv[16],gv[17],gv[18],gv[49],gv[20],
                        //     gv[20],gv[21],gv[22],gv[23],gv[25],gv[26],gv[27],gv[28],gv[39],gv[30],
                        //     gv[30],gv[31],gv[32],gv[33],gv[35],gv[36],gv[37],gv[38],gv[29],gv[40],
                        //     gv[40],gv[41],gv[42],gv[43],gv[45],gv[46],gv[47],gv[48],gv[19],gv[50],
                        //     gv[51],gv[52],gv[53],gv[54]
                        // ]);
                    }

                    $('#tkb_gv').append(append);
                    $('#dsloptrung').empty();
                    $('#dsloptrung').append("<li class='list-group-item list-group-item-danger'>Duplicated Class</li>");
                    append ="";
                    if(dsloptrung){
                        $('#btn_confirm').attr('disabled','disabled');
                        for( var i = 0; i < dsloptrung.length; i++) {
                            tmp = dsloptrung[i];
                            tiet = tmp[1]%10;
                            date = (tmp[1] - tiet)/10 + 2;
                            tiet++;
                            append += "<li class='list-group-item trung'>"+tmp[0]+"-thứ "+date+"-tiết "+tiet+"-"+tmp[2]+" lần</li>";
                        }
                        $('#dsloptrung').append(append);
                    }
                },
                error:function(){
                    console.log("error!!");
                }
            });
        }

        var numselected = 0;
        var row1 = 0, cell1 = 0;
        var row2 = 0, cell2 = 0;
        var dem1, dem2;

        $('#tkb_gv_table tbody').on('click', 'tr td',function(){
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
            $('#onloading').css('display','block');
            var token = $("input[name='_token']").val();
            var tkb = [];
            var gv = [];
            var row = 0;
            var col = 0;
            // var token = $("input[name='token']").val();
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
            setTimeout(function(){
                $.ajax({
                    url:"<?=URL::to('admin/tkbhientai/updatetkbgv')?>",
                    type:"POST",
                    async:false,
                    data:{
                        "abc"    : "abc",
                        'tkbgv'  : tkb,
                        '_token' : token
                    },
                    success:function(rs){
                        $('#onloading').css('display','none');
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                        var printed_list = [];
                        var check = false;
                        $('#dsloptrung').empty();
                        $('#dsloptrung').append("<li class='list-group-item list-group-item-danger'>Duplicated Class</li>");
                        if(rs.length > 0){
                            $.each(rs,function(i,j){
                                append ="";
                                if(printed_list.indexOf(j[0]) >= 0){
                                    // do no thing
                                }
                                else{
                                    console.log(j);
                                    tiet = j[1]%10;
                                    date = (j[1] - tiet)/10 + 2;
                                    tiet++;
                                    append += "<li class='list-group-item trung'>"+j[0]+"-thứ "+date+"-tiết "+tiet+"-"+j[2]+" lần</li>";
                                    $('#dsloptrung').append(append);
                                    apend="";
                                    printed_list.push(j[0]);
                                } 
                            });
                            if(printed_list.length >0){
                                $('#btn_confirm').prop("disabled",true);
                            }
                        }
                        else{
                            $('#btn_confirm').prop("disabled",false);
                        }
                        
                    },
                    error:function(){
                        console.log("error!!");
                    }
                });
            },10);
           
        });

        $('#btn_confirm').on('click',function(){
            var token = $("input[name='_token']").val();
            $('#onloading').css('display','block');
            var tkb = [];
            var gv = [];
            var row = 0;
            var col = 0;
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
            setTimeout(function(){
                $.ajax({
                    url :"<?= URL::to('admin/schedule/confirm_schedule')?>" ,
                    type: "POST",
                    async: false,
                    data:{
                        'tkb'        : tkb,
                        '_token'     : token
                    }, 
                    success:function(record){
                        $('#onloading').css('display','none');
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                    },
                    error:function(){
                        alert("Has something go wrong!!");
                    }
                });
            },10);
        });
    });
</script>
@endsection