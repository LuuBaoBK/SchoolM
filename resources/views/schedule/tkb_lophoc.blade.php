@extends('mytemplate.blankpage_ad')
@section('content')

<div class="box-body table-responsive">
        <div class="box box-primary">
            <div class="box-header">
                <p class="box-title">THOI KHOA BIEU CAC	LOP</p>
            </div>
        </div>
        <table id="class_table" class="table table-bordered table-striped">
        <thead>
            <tr><th rowspan="2">STT</th><th rowspan ="2">Lop</th><th colspan="5">Sang thu 2</th><th colspan="5">Chieu thu 2</th><th colspan="5">Sang thu 3</th><th colspan="5">Chieu thu 3</th><th colspan="5">Sang thu 4</th><th colspan="5">Chieu thu 4</th><th colspan="5">Sang thu 5</th><th colspan="5">Chieu thu 5</th><th colspan="5">Sang thu 6</th><th colspan="5">Chieu thu 6</th></tr>
			<tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th></tr>
        </thead>

        <tbody class="displayrecord">
           <?php
		   		foreach ($thoikhoabieu as $lophoc) {
		   			echo "<tr><td>".$lophoc[0]."</td><td>".$lophoc[1]."</td>" ;
		   			for($i = 0 ; $i < 50; $i++)
		   				echo "<td>".$lophoc[$i + 2]."</td>";
		   			echo "</tr>";
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