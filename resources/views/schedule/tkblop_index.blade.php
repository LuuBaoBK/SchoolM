@extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
th.sang{
    background-color: #AFA4FC !important; 
}
th.chieu{
    background-color: #95DBFF !important; 
}
tr.le td.sang{
    background-color: #AFA4FC !important; 
}
tr.le td.chieu{
    background-color: #95DBFF !important; 
}
tr.chan td.sang{
background-color: #9A8CFF !important; 
}
tr.chan td.chieu{
background-color: #65CAFD !important;     
}

td.selected{
color:#B40431;      
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

<input type="hidden" name = "token" value="<?=csrf_token(); ?>">
<section class="content">
    <div class="box-body table-responsive">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">QUẢN LÝ THỜI KHÓA BIỂU HỌC SINH</h3>
            </div>
            <div class="box-body">
                <button class="btn btn-primary" id="menuschedule">MENU</button>
                <button class="btn btn-primary" id="capnhat" disabled >CẬP NHẬT TKB</button>
            </div>
            <div class="box-footer" style="height:600px">
                <div class="box-body table-responsive">
                    <table id="class_table" class="table table-bordered" style='overflow: auto; display: inline-block; width: 100%; height:600px'>
                    <thead>
                        <tr class="le">
                            <th style="width:130px" rowspan="2">STT</th>
                            <th rowspan ="2">Lớp</th>
                            <?php
                                for($i=2; $i<=6; $i++){
                                    echo "<th class='sang' colspan='5'>Sáng thứ ".$i."</th>";
                                    echo "<th class='chieu' colspan='5'>Chiều thứ ".$i."</th>";
                                }
                            ?>
                        </tr>
                        <tr class="chan">
                            <?php
                                $mau = "sang"; 
                                for($i=1;$i<=10;$i++){
                                    for($k=1;$k<=5;$k++){
                                        echo "<td class='".$mau."'>".$k."</th>";
                                    }
                                    if($mau == "sang"){
                                        $mau = "chieu";
                                    }
                                    else{
                                        $mau = "sang";
                                    }
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody id="displayrecord">
                       <?php
                            $class="le";
                            foreach ($thoikhoabieu as $key => $lophoc) {
                                echo "<tr class='".$class."'>";
                                    echo "<td class='chieu'>".$lophoc[0]."</td>";
                                    echo "<td class='chieu'>".$lophoc[1]."</td>";
                                    $k=0;
                                    $mau = "sang";
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
                                if($class == "le"){
                                    $class="chan";
                                }
                                else{
                                    $class="le";
                                }
                            }
                       ?>

                    </tbody>
                    <tfoot>
                        
                    </tfoot>
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

        $('#menuschedule').click(function(){
            $(location).attr('href','menuschedule');
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
	});
});
</script>
@endsection