@section('content')
<style type="text/css">
.nav-pills > li.active > a:hover {
	background-color: 	#F8F8F8   !important;
}
.nav-pills > li.active > a:focus {
	color: black !important;
	background-color: white !important;
}
.table tbody tr.read {
  background-color: #F8F8F8;
}
.table tbody tr.not_read {
  background-color: white;
}
.table tbody tr:hover{
  background-color: #E0E0E0 !important;
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
        <table id="messages_table" class="table table-hover dataTable">
          <thead>
            <tr>
              <td>id</td>
              <td>Author</td>
              <td>Title</td>
              <td>Content</td>
              <td>Time</td>
            </tr>
          </thead>
          <tbody>
          <div class="mess_list">
            @foreach ($msg_list['msg_recv_new'] as $message)
              <tr class={{$message->class}} >
                <td>{{$message->id}}</td>
                <td>{{$message->author_name}}</td>
                <td><?= $message->content->title ?></td>
                <td><?= $message->content->mycontent ?></td>
                <td><?= $message->content->date_diff ?></td>
              </tr>
            @endforeach
            @foreach ($msg_list['msg_recv_read'] as $message)
              <tr class={{$message->class}} >
                <td>{{$message->id}}</td>
                <td>{{$message->author_name}}</td>
                <td><?= $message->content->title ?></td>
                <td><?= $message->content->mycontent ?></td>
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
<div id="editor" class="modal fade modal-info">
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
            <button id="confirm_button" type="button" class="btn btn-default pull-right">Confirm</button>
            <button id="save_draft" type="button" class="btn btn-default pull-left" data-dismiss="modal">Save</button>
        </div>
    </div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</section>
<section class="mail_content">
<div id="mail_content" class="modal fade modal-default">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #3c8dbc; color: white">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <p><h4 class="2 modal-title">Mail Box</h4><p>
            <p><h4 class="1 modal-title text-center">Mail Box</h4><p>
        </div>
        <div class="modal-body">
          <div class="content">
          </div>
        </div>
        <div class="modal-footer">
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
<script src="{{asset("/mylib/ckeditor/ckeditor.js")}}"></script>
<script type="text/javascript">
$(document).ready(function(){

    CKEDITOR.replace('mail_editor', {
      toolbarGroups: [
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup',  ] },
      { name: 'document',    groups: [ 'mode', 'document' ] },
      { name: 'tools' },
    ]

    // NOTE: Remember to leave 'toolbar' property with the default value (null).
    });
  CKEDITOR.instances['mail_editor'].setData('');

  var messages_table = $('#messages_table').dataTable({
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "iDisplayLength": 15,
      "columnDefs":[
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [1],
                "width" : "12%"
            },
            {
                "targets": [4],
                "width" : "12%"
            }]
  });

  $(function () {
  	$("#compose").click(function(){
  		$('#editor').modal('toggle',{keyboard:true});
  	});

    $('#save_draft').click(function(){
      var content = CKEDITOR.instances['mail_editor'].getData();
      var title   = $('#title').val();
      var type    = $("ul#folder li.active").index();
      var token   = $('input[name="_token"]').val();
      CKEDITOR.instances['mail_editor'].setData('');
      $.ajax({
        url     :"<?= URL::to('/mailbox/save_draft') ?>",
        type    :"POST",
        async   :false,
        data    :{
                'content'       :content,
                'title'         :title,
                'type'          :type,
                '_token'        :token
                },
        success:function(record){
          if(record==2){
            update_mailbox(2);
          }
        },
        error:function(){
            alert("something went wrong, contact master admin to fix");
        }
      });
    });

    $('#confirm_button').click(function(){
      var content = CKEDITOR.instances['mail_editor'].getData();
      var title   = $('#title').val();
      var to_list = $('#to').val();
      var type    = $("ul#folder li.active").index();
      var token   = $('input[name="_token"]').val();
      CKEDITOR.instances['mail_editor'].setData('');
      $.ajax({
        url     :"<?= URL::to('/mailbox/send_mail') ?>",
        type    :"POST",
        async   :false,
        data    :{
                'content'       :content,
                'title'         :title,
                'type'          :type,
                'to_list'       :to_list,
                '_token'        :token
                },
        success:function(record){
          console.log(record);
        },
        error:function(){
            alert("something went wrong, contact master admin to fix");
        }
      });
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

  $('#messages_table tbody').on( 'click', 'tr', function () {
     if( $('#messages_table').dataTable().fnGetData(this) != null){
        var id = $('#messages_table').dataTable().fnGetData(this)[0];
        $(this).removeClass('not_read');
        $(this).addClass('read');
        read_msg(id);
     }
     else{
     }          
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
        //console.log(record);
        messages_table.fnClearTable();
        if(record.type == 0 || record.type == 3){
          $.each(record.msg_list.msg_recv_new ,function(i,row){
            var newrow = messages_table.fnAddData([
              row.id,
              row.author_name,
              row.content.title,
              row.content.mycontent,
              row.content.date_diff
            ]);
            messages_table.fnSettings().aoData[ newrow[0] ].nTr.className = "not_read";
          });
          $.each(record.msg_list.msg_recv_read ,function(i,row){
            var newrow = messages_table.fnAddData([
              row.id,
              row.author_name,
              row.content.title,
              row.content.mycontent,
              row.content.date_diff
            ]);
            messages_table.fnSettings().aoData[ newrow[0] ].nTr.className = "read";
          });
        }
        else{
          $.each(record.msg_list ,function(i,row){
            var newrow = messages_table.fnAddData([
              row.id,
              row.author_name,
              row.content.title,
              row.content.mycontent,
              row.content.date_diff
            ]);
            messages_table.fnSettings().aoData[ newrow[0] ].nTr.className = "not_read";
          });
        }
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  }

  function read_msg(id){
    var type  = $("ul#folder li.active").index();
    var token = $('input[name="_token"]').val();
    $.ajax({
      url     :"<?= URL::to('/mailbox/read_msg') ?>",
      type    :"POST",
      async   :false,
      data    :{
              'id'            :id,
              'type'          :type,
              '_token'        :token
              },
      success:function(record){
          console.log(record);
          $('#mail_content div.modal-header h4.2').empty();
          $('#mail_content div.modal-header h4.2').append("Author : "+record.msg_list[0].author_name);
          $('#mail_content div.modal-header h4.1').empty();
          $('#mail_content div.modal-header h4.1').append(record.msg_list[0].content.title);
          $('#mail_content div.modal-body div.content').empty();
          $('#mail_content div.modal-body div.content').append(record.msg_list[0].content.content);
          $('#mail_content').modal('show');
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  }

})
</script>
@endsection