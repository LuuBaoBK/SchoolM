@extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
.trung {
	color: blue;
	}
</style>

<div class="box-body table-responsive col-md-10" style="height:700px">
	<input type="hidden" name="token" value="<?= csrf_token(); ?>">
    <div class="box box-primary">
        <div class="box-header">
            <p class="box-title">THOI KHOA BIEU GIAO VIEN (NEW)</p>
        </div>
    </div>
    <table id="class_table" class="table table-bordered table-striped form-inline">
        <thead>
            <tr><th rowspan="2">MSGV</th><th rowspan ="2">Ten</th><th rowspan="2">Mon</th><th rowspan="2">So tiet con lai</th><th colspan="5">Sang thu 2</th><th colspan="5">Chieu thu 2</th><th colspan="5">Sang thu 3</th><th colspan="5">Chieu thu 3</th><th colspan="5">Sang thu 4</th><th colspan="5">Chieu thu 4</th><th colspan="5">Sang thu 5</th><th colspan="5">Chieu thu 5</th><th colspan="5">Sang thu 6</th><th colspan="5">Chieu thu 6</th></tr>
			<!--<tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th></tr> -->
			<tr><th>0</th>
			<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
			<th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th>
			<th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th>
			<th>31</th><th>32</th><th>33</th><th>34</th><th>35</th><th>36</th><th>37</th><th>38</th><th>39</th><th>40</th>
			<th>41</th><th>42</th><th>43</th><th>44</th><th>45</th><th>46</th><th>47</th><th>48</th><th>49</th></tr>
        </thead>

        <tbody class="displayrecord">
           <?php
		   		foreach ($thoikhoabieu as $gv) {
		   			echo "<tr><td>".$gv[0]."</td><td>".$gv[1]."</td><td>".$gv[2]."</td><td>".$gv[3]."</td>" ;
		   			for($i = 0 ; $i < 50; $i++){
		   				$kiemtra = true;

		   				if($chuaphan)
		   					foreach ($chuaphan as $cp) {
			   					if( $cp[1] == $i and $cp[0] == $gv[$i + 4]){
			   						$kiemtra = false;
			   						echo "<td class='trung'>".$gv[$i + 4]."</td>";
			   						break;
			   					}
			   				}

		   				if($kiemtra)
		   					echo "<td>".$gv[$i + 4]."</td>";

		   			}
		   			echo "</tr>";
		   		}
		   ?>

        </tbody>
        <tfoot>
        	<button><a href="/admin/menuschedule">MENU</a></button>
        	<button id =""><a href="/admin/tkblop">XEM THỜI KHÓA BIỂU HỌC SINH</a></button>
        </tfoot>
    </table>
</div>
<div class="col-md-2 box-solid bg-yellow">
	<table class="table table-hover ">
		<thead class="box-solid bg-red">
			<tr><th>Lớp chưa phân công</th></tr>
		</thead>
		<tbody>
			<?php
				if($chuaphan != null){
					foreach ($chuaphan as $tmp) {
						//echo "<tr><td>".$tmp[0]."-".$tmp[1]."-".$tmp[2]."(".$tmp[3].")</td></tr>";
						echo "<tr><td>".$tmp[0]."-".$tmp[1]."-".$tmp[2]."</td></tr>";
					}
				}
			?>

		</tbody>
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

	});
});
</script>
@endsection