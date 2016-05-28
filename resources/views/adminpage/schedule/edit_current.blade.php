@extends('adminpage.schedule.schedule_template')
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
        <p class="text-center" style="font-size:25px">Schedule</p>
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
                <li class="list-group-item" style="border:none">
                    <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                    <button id="btn_confirm" class="btn btn-primary btn-flat">Confirm Change</button>
                </li>
                <li id="onloading" class="list-group-item text-center" style="display:none; border:none"><i class="fa fa-refresh fa-spin" ></i>&nbsp Loading ... <i class="fa fa-refresh fa-spin" ></i></li>
                <li class="list-group-item" style="border:none">
                    <div id="success_mess" style = "display: none" class="alert alert-success">
                        <h4><i class="icon fa fa-check"></i>Success</h4>
                    </div>
                </li>
                <table id="tkb_gv_table" class="table table-bordered table-striped" style='overflow: auto; display: inline-block; width: 100%; height:600px' border="1">
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
                        @for($i=0;$i<=4;$i++)
                            @for($k=1;$k<=10;$k++)
                                <th>{{$k}}</th>
                            @endfor
                        @endfor
                    </thead>
                    <tbody id="displayrecord">
                       <?php
                            foreach ($thoikhoabieu as $gv) {
                                echo "<tr><td>".$gv['teacher_id']."</td><td>".$gv['teacher_name']."</td><td>".$gv['subject']."</td><td>".$gv['homeroom_class']."</td><td>".$gv['sotietconlai']."</td>";
                                for($i = 0 ; $i < 50; $i++){
                                        echo "<td>".$gv['T'.$i]."</td>";
                                }
                                echo "</tr>";
                            }
                       ?>
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
        $('#btn_edit_schedule').addClass('active');
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

        $('#btn_confirm').on('click',function(){
            var token = $("input[name='_token']").val();
            $('#onloading').css('display','block');
            var tkb = [];
            var gv = [];
            var row = 0;
            var col = 0;
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
});
</script>
@endsection