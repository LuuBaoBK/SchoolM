@extends('adminpage.schedule.schedule_template')
@section('schedule_content')
<style type="text/css">
td.sang{
    background-color: #E6E6E6 !important; 
}

td.selected{
color:#B40431;      
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
                <table id="class_table" class="table table-bordered" style='overflow: auto; display: inline-block; width: 100%; height:600px'>
                    <thead>
                        <tr class="le">
                            <th style="width:130px" rowspan="2">STT</th>
                            <th rowspan ="2">Lớp</th>
                            <?php
                                for($i=2; $i<=6; $i++){
                                    echo "<th colspan='5'>Sáng thứ ".$i."</th>";
                                    echo "<th colspan='5'>Chiều thứ ".$i."</th>";
                                }
                            ?>
                        </tr>
                        <tr class="chan">
                            <?php
                                // $mau = "sang"; 
                                for($i=1;$i<=10;$i++){
                                    for($k=1;$k<=5;$k++){
                                        echo "<td class=''>".$k."</th>";
                                    }
                                    // if($mau == "sang"){
                                    //     $mau = "chieu";
                                    // }
                                    // else{
                                    //     $mau = "sang";
                                    // }
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody id="displayrecord">
                       <?php
                            foreach ($thoikhoabieu as $key => $lophoc) {
                                $mau = ($key % 2 == 0 )? "sang" : "chieu";
                                echo "<tr>";
                                    echo "<td class='".$mau."'>".$lophoc[0]."</td>";
                                    echo "<td class='".$mau."'>".$lophoc[1]."</td>";
                                    $k=0;
                                    for($i=2;$i<= 51;$i++){
                                        $k++;
                                        echo "<td class='".$mau."'>".$lophoc[$i]."</td>";
                                        if($k==5){
                                            $k = 0;
                                            if($mau == "sang")
                                                $mau = "chieu";
                                            else
                                                $mau = "sang";
                                        }
                                    }
                                echo "</tr>";
                            }
                       ?>
                    </tbody>
                    <tfoot>   
                    </tfoot>
                </table>
            </li>
        </ul>
    </div>
</div>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#btn_edit_schedule_stu').addClass('active');
        $(function(){
        var x1 = 0, y1 = 0, x2 = 0, y2 = 0, v1, v2;
        var count = 0;

        $('#displayrecord tr').on("click", "td", function(){
            if($(this).text() == "cc" || $(this).text() == "sh" || $(this).cellIndex < 2 )
                return;
            if($(this).hasClass("selectd")){
                $(this).removeClass("selected");
                count--;
            }
            else{
                if(count == 0){
                    count++;
                    x1 = this.cellIndex;
                    y1 = this.parentNode.rowIndex;
                    v1 = $(this).html();
                    $(this).addClass("selected");
                }else{
                    count = 0;
                    x2 = this.cellIndex;
                    y2 = this.parentNode.rowIndex;
                    v2 = $(this).html();
                    
                    $('#displayrecord').children().eq(y1 - 2).children().eq(x1).removeClass('selected');
                    if(y2 != y1)
                        return;

                    //console.log("x1=" + x1 + ",y1=" + y1 + ",v1=" + v1 + ",x2=" + x2 + ",y2=" + y2 + ",v2="+ v2);

                    var num1 = 0;
                    var num2 = 0;
                    $('#displayrecord tr').each(function(){
                        if($(this).children().eq(x1).html() == v2)
                            num2++;
                        if($(this).children().eq(x2).html() == v1)
                            num1++;
                    });
                    if(v1 == "")
                        num1 = 0;
                    if(v2 == "")
                        num2 = 0;
                    // if(v1 == v2)
                    //     console.log("co trung");
                    // console.log("num1 " + num1 + ",num2 " + num2);

                    if(num1 == 0 && num2  == 0 && v1 != v2){
                        $(this).html(v1);
                        $('#displayrecord').children().eq(y1 - 2).children().eq(x1).html(v2);
                        $("#capnhat").prop('disabled', false);
                    }
                }
            }
        });

        $("#capnhat").click(function(){
            var listclass =[];
            var demclass = 0;
            var token = $("input[name='token']").val();
            $("#displayrecord tr").each(function(){
                var oneclass = [];
                var demrow = 0;
                $(this).children().each(function (){
                    oneclass[demrow++] = $(this).children().eq(2).text();
                    //console.log($(this).children().eq(2).text());
                });
                oneclass[0] = $(this).children().eq(0).text(); 
                oneclass[1] = $(this).children().eq(1).text(); 
                listclass[demclass++] = oneclass;
            });
            //console.log(listclass);

            $.ajax({
                url:"<?=URL::to('/admin/tkblopcu/updatetkbclass')?>",
                type:"POST",
                async:false,
                data:{
                    "_token":token,
                    "listclass":listclass
                },
                success:function(rs){
                    console.log(rs);
                    console.log("oke");
                },
                error:function(){
                    console.log("error!!");
                }
            });

        });

        $('#btn_confirm').on('click',function(){
            var token = $("input[name='_token']").val();
            $('#onloading').css('display','block');
            var listclass =[];
            var demclass = 0;
            $("#displayrecord tr").each(function(){
                var oneclass = [];
                var demrow = 0;
                $(this).children().each(function (){
                    oneclass[demrow++] = $(this).children().eq(2).text();
                    //console.log($(this).children().eq(2).text());
                });
                oneclass[0] = $(this).children().eq(0).text(); 
                oneclass[1] = $(this).children().eq(1).text(); 
                listclass[demclass++] = oneclass;
            });
            setTimeout(function(){
                $.ajax({
                    url :"<?= URL::to('admin/tkblopcu/updatetkbclass')?>" ,
                    type: "POST",
                    async: false,
                    data:{
                        "listclass":listclass,
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