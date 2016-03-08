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
</style>
<div class="box-body table-responsive">
        <div class="box box-primary">
            <div class="box-header">
                <p class="box-title">THOI KHOA BIEU CAC	LOP</p>
            </div>
        </div>
        <table id="class_table" class="table table-bordered" height="600px">
        <thead>
            <tr class="le">
                <th style="width:130px" rowspan="2">STT</th>
                <th rowspan ="2">Lop</th>
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
        <tbody class="displayrecord">
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
        	<button><a href="/admin/menuschedule">MENU</a></button>
        </tfoot>
        </table>
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
		//alert("van minh");
	});
});
</script>
@endsection