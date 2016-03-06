@extends('mytemplate.blankpage_ad')
@section('content')
	<section class="content-header">
      <h1>
          THỜI KHÓA BIỂU
      </h1>
    </section>
    <section class="content">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="text-center">My School</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-lg-7">
              <div class="box box-primary">
                <div class="box-header">
                  <h4 class="text-center">THÔNG TIN NHÂN SỰ && LỚP HỌC</h3>
                </div>
                <div class="box-body">
                  <ul class="list-group list-group-unbordered">
                      <?php
                      	foreach ($nguonluc as $mon) {
                      		echo "<li class='list-group-item'><b>Bộ môn ".$mon[0]."</b><a class='pull-right'>".$mon[1]. "/". $mon[2]."</a></li>";
                      	}
                      ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="box box-primary">
                <div class="box-header">
                  <h4 class="text-center">MAIN MENU</h3>
                </div>
                <div class="box-body">
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <button id = "taomoi"><?php
                      			if($dk)
                      				echo "<a href='/admin/phancong'>TẠO THỜI KHÓA BIỂU MỚI</a>";
                      			else
                      				echo "TẠO THỜI KHÓA BIỂU MỚI";
                      							?>
                      </button>
                    </li>
                    <li class="list-group-item">
                      <button id = "xemhientai"><?php
                            if($cotkb)
                              echo "<a href='/admin/tkbhientai'>XEM THỜI KHÓA BIỂU HIỆN TẠI</a>";
                            else
                              echo "XEM THỜI KHÓA BIỂU HIỆN TẠI";
                                    ?>
                      </button>
                    </li>
                    <li class="list-group-item">
                      <button id = "suacu"><?php
                            if($cotkb)
                              echo "<a href='/admin/xemphancongcu'>CHỈNH SỬA THỜI KHÓA BIỂU HIỆN TẠI</a>";
                            else
                              echo "CHỈNH SỬA THỜI KHÓA BIỂU HIỆN TẠI";
                                    ?>
                      </button>
                    </li>
                    <li class="list-group-item">
                      <button id="xemcu"><a href="/admin/phancongcacnam">XEM BẢNG PHÂN CÔNG CÁC NĂM TRƯỚC</a></button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  

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
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(function(){
		//alert("da an");
		
	});

})
</script>
@endsection
