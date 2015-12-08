@section('content')
<style type="text/css">
.nav-pills > li.active > a:hover {
	background-color: 	#F8F8F8   !important;
}
.nav-pills > li.active > a:focus {
  	color: black !important;
  	background-color: white !important;
}
</style>
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{asset("/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">
<section class="content-header">
    <h1>
        Admin
        <small>Mail Box</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
        <li>Mail Box</li>
    </ol>
</section>
<section class="content">
<div class="row">
	<div class="col-md-3">
		<div class="box box-solid">
			<button type="button" id="compose" class="btn btn-block btn-primary">Compose</button>
		</div>
		<div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul id="folder" class="nav nav-pills nav-stacked">
                <li class="active"><a data-toggle="pill" href="#"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right">12</span></a></li>
                <li><a data-toggle="pill" href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
                <li><a data-toggle="pill" href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                </li>
                <li><a data-toggle="pill" href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
              </ul>
              <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
            </div>
            <!-- /.box-body -->
      	</div>
	</div>
	<div class="col-md-9">
		<div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Inbox</h3>
      </div><!-- /.box-header -->
      <div class="box-body table-responsive">
        <table id="messages_table" class="table table-hover">
          <thead>
            <tr>
              <td>Id</td>
              <td>Title</td>
              <td>Content</td>
              <td>Time</td>
            </tr>
          </thead>
          <tbody>
          <div class="mess_list">
            @foreach ($inbox as $message)
              <tr>
                <td>{{$message->id}}</td>
                <td><?= $message->content->title ?></td>
                <td><?= substr($message->content->content, 0, 30)."..." ?></td>
                <td><?= $message->content->date_diff ?></td>
              </tr>
            @endforeach
          </div>
          </tbody>
        </table>
      </div>
		</div>
	</div>
</div>
</section>
<section class="editor">
<div id="editor" class="modal modal-info">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center">Mail Box</h4>
        </div>
        <div class="modal-body">
          <form class="form">
            <div class="form-group ">
              <div class="input-group">
              <span class="input-group-addon">To &nbsp&nbsp&nbsp :  </span>
              <input type="text" class="form-control" name="to" id="to">
              </div>

              <div class="input-group">
              <span class="input-group-addon">Title :</span>
              <input type="text" class="form-control" name="title" id="title">
              </div>
            </div>
            <div class="form-group" style="color:black">
            <textarea style="color:black" id="mail_editor" name="mail_editor" rows="10" cols="80">
              This is my textarea to be replaced with CKEditor.
            </textarea>
            </div>
        </form>
        </div>
        <div class="modal-footer">
            <button id="confirm_button" type="button" class="btn btn-warning pull-right">Confirm</button>
            <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
        </div>
    </div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  CKEDITOR.replace('mail_editor');
  var messages_table = $('#messages_table').dataTable({
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "iDisplayLength": 15
  });

  $(function () {
  	$("#compose").click(function(){
  		$('#editor').modal({keyboard:true});
  	});

    $('#confirm_button').click(function(){
      var mycaseText = CKEDITOR.instances['mail_editor'].getData();
      var caseforlen = CKEDITOR.instances['mail_editor'].document.getBody().getText();
      
      console.log(mycaseText.length);
      console.log(caseforlen.length);
      CKEDITOR.instances['mail_editor'].setData('');
      // if (strlen(caseforlen) > 4000) {
      //     alert("maxnum is 2000");
      //     return;
      // });
    });

    $('ul#folder li').click(function(){
      var type = $(this).index();
      if(type==0){
        update_mailbox(0);
      }
      else if(type==1){
        update_mailbox(1);
      }
      else if(type==2){
        update_mailbox(2);
      }
      else{
        update_mailbox(3);
      }
    });
  });
  
  function update_mailbox(type){
    messages_table.fnClearTable();
    var token        = $('input[name="_token"]').val();
    $.ajax({
      url     :"<?= URL::to('/mailbox/update_mailbox') ?>",
      type    :"POST",
      async   :false,
      data    :{
              'type'          :type,
              '_token'        :token
              },
      success:function(record){
          console.log(record)
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  }
})
</script>
@endsection