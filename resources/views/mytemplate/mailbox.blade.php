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
  background-color: #F2F2F2;
}
.table tbody tr.not_read {
  background-color: white;
}
.table tbody tr:hover{
  background-color: #E0E0E0 !important;
}
#mail_content div.modal-body div.content{
  border-color: #3c8dbc;
  border-width: 2px;
  border-style: solid;
}
span.cover_id{
  background-color: #CEF6F5;
  border-width: 0.1px;
  border-color: black;
}
</style>
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{asset("/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">
<section class="content-header">
    <h1>
        Mail Box
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i>Dashboard</a></li>
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
                  @if($msg_list['msg_recv_new_count'] > 0)
                  <span id="new_msg_count" class="label label-primary pull-right">{{$msg_list['msg_recv_new_count']}}</span></a></li>
                  @else
                  <span id="new_msg_count" class="label label-primary pull-right"></span></a></li>
                  @endif
                <li><a data-toggle="pill" href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
                <li><a data-toggle="pill" href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                </li>
                <li><a data-toggle="pill" href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
              </ul>
              <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
              <input type="hidden" id="my_id" value={{$my_id}}>
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
              <td><b>id</b></td>
              <td><b>Author</b></td>
              <td><b>Title</b></td>
              <td><b>Content</b></td>
              <td><b>Time</b></td>
              <td><b>Action</b></td>
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
                <td><a href='#'><i class="glyphicon glyphicon-trash" style='color:red'>Delete</a></i></td>
              </tr>
            @endforeach
            @foreach ($msg_list['msg_recv_read'] as $message)
              <tr class={{$message->class}} >
                <td>{{$message->id}}</td>
                <td>{{$message->author_name}}</td>
                <td><?= $message->content->title ?></td>
                <td><?= $message->content->mycontent ?></td>
                <td><?= $message->content->date_diff ?></td>
                <td><a href='#'><i class="glyphicon glyphicon-trash" style='color:red'>Delete</a></i></td>
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
<div id="editor" class="modal fade modal-primary">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" id="btn_close_editor" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center">Mail Box</h4>
        </div>
        <div class="modal-body">
          <form class="form">
            @if($role <= 1)
            <div class="form-group">
              <div class="row">
                <div class="col-xs-1">
                  <i id="btn_info" class="btn btn-primary glyphicon glyphicon-question-sign"></i>
                </div>
                <div class="col-xs-11">
                  <div id="info_box" class="box box-info collapsed-box no-border">
                    <div class="box-body">
                      <b style="color:black; font-size:17px">Group code</b>
                      <div class="row" style="color:black; font-size:15px">
                        <div class="col-lg-6">
                          <ul class="list-unstyled">
                            <li>group=role ( role: admin, teacher, student, parent )</li>
                            <li>group=classid [ Ex: 15_9; 14_8; 15_7_A; 15_6_B_3 ]</li>
                          </ul>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
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
            </textarea>
            </div>
        </form>
        </div>
        <div class="modal-footer">
            <button id="confirm_button" type="button" class="btn btn-default pull-right">Confirm</button>
            <button id="save_draft" type="button" class="btn btn-default pull-left" data-dismiss="modal">Save</button>
            <button id="draft_edit" type="button" class="btn btn-default pull-left" data-dismiss="modal">Edit</button>
            <button id="draft_send" type="button" class="btn btn-default pull-right" data-dismiss="modal">Send</button>
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
            <div class="box box-primary box-solid no-border">
              <div class="box-header no-border">
                <i id="btn_receiver_list" class="btn btn-primary glyphicon glyphicon-user"></i>
                Receiver List
              </div>
              <div id="box_receiver_list" class="box-body no-border" style="width:100%; height:auto; color:black; display:none">
              </div>
              <div id="box_receiver_list_hidden" class="box-body no-border" style="color:black; display:none">
              </div>
            </div>
            <p><h4  style="display:none" class="modal-title-hidden">Mail Box</h4><p>   
        </div>
        <div class="modal-body">
          <p><h4 id="mail_content_title" class="1 modal-title text-center">Mail Box</h4><p>
          <div class="content">
          </div>
        </div>
        <div class="modal-footer"> 
            <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
            <div class="btn-group">
              <button type="button" id="btn_forward" class="btn btn-primary pull-right" data-dismiss="modal">Forward</button>
              <button type="button" id="btn_reply" class="btn btn-primary pull-right" data-dismiss="modal">Reply</button>
              <button type="button" id="btn_reply_all" class="btn btn-primary pull-right" data-dismiss="modal">Reply All</button>
            </div>
            <button type="button" id="btn_edit_draft" class="btn btn-primary pull-right" data-dismiss="modal">Edit</button>
        </div>
    </div>
    <input type="hidden" id="id_draft_mail">
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</section>
<section class="result">
<div id="resultModal" class="modal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Result</h4>
            </div>

            <div class="modal-body">
                <div style="color : black" class="row">
                    <div class="col-lg-4 col-xs-4">
                        <div id="resultbox_error" class="box box-danger">
                            <div id="errorlist-header" class="box-header">
                            </div>
                            <div id="errorlist-body" class="box-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-4">
                        <div id="resultbox_warning" class="box box-warning">
                            <div id="warninglist-header" class="box-header">
                            </div>
                            <div id="warninglist-body" calss="box-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-4">
                        <div id="resultbox_success" class="box box-success">
                            <div id="successlist-header" class="box-header">
                            </div>
                            <div id="successlist-body" calss="box-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
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

<!-- Pusher -->
<script src="{{asset("/mylib/bower_components/pusher/dist/pusher.min.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.desktop.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.buttons.js")}}"></script>
<link rel="stylesheet" href="{{asset("/mylib/pnotify-master/src/pnotify.css")}}">
<link rel="stylesheet" href="{{asset("/mylib/pnotify-master/src/pnotify.buttons.css")}}">
<script type="text/javascript">

$(document).ready(function(){

  CKEDITOR.replace('mail_editor', {
    toolbarGroups: [
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup',  ] },
      { name: 'document',    groups: [ 'mode', 'document' ] },
      { name: 'tools' },
    ],
    uiColor: '#a7bdea',
    width: 'auto',
    height: '150',
    enterMode: CKEDITOR.ENTER_BR,
    shiftEnterMode: CKEDITOR.ENTER_P,
    // NOTE: Remember to leave 'toolbar' property with the default value (null).
  });
  CKEDITOR.instances['mail_editor'].setData('');

  $('#resultbox_error').slimScroll({
      height: '250px'
  });
  $('#resultbox_warning').slimScroll({
      height: '250px'
  });
  $('#resultbox_success').slimScroll({
      height: '250px'
  });

  $('#title').on('input',function(){
        check_count_note();
    });

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
            },
            {
                "targets": [5],
                "width" : "5%"
            }]
  });

  $('#sidebar_mailbox').addClass('active');
	$("#compose").click(function(){
		$('#editor').modal('toggle',{keyboard:true});
    $('#draft_edit').css('display','none');
    $('#draft_send').css('display','none');
    $('#save_draft').css('display','block');
    $('#confirm_button').css('display','block');
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
        $('#to').val("");
        $('#title').val("");
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
    $('#title').val('');
    $('#to').val('');
    $('#editor').modal('hide');
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
        $('#resultModal').modal('show');
        var count = 0;
        $('#errorlist-body').empty();
        $.each(record[3], function(i,item){
            $('#errorlist-body').append("<p>"+(i+1)+" | "+item+"</p");
            count = count + 1;
        });
        $('#errorlist-header').empty();
        $('#errorlist-header').append(count+" wrong format address");
        count = 0;
        $('#warninglist-body').empty();
        $.each(record[2], function(i,item){
            $('#warninglist-body').append("<p>"+(i+1)+" | "+item+"@schoolm.com"+"</p");
            count = count + 1;
        });
        $('#warninglist-header').empty();
        $('#warninglist-header').append(count+" not found address");
        count = 0;
        $('#successlist-body').empty();
        $.each(record[1], function(i,item){
            $('#successlist-body').append("<p>"+(i+1)+" | "+item.id+"@schoolm.com"+"</p");
            count = count + 1;
        });
        $('#successlist-header').empty();
        $('#successlist-header').append(count+" success address");
        var type = $('ul#folder li.active').index();
        if(type==1){
          update_mailbox(1);
        }
        // console.log(record);
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

  $('#btn_forward').on('click',function(){
    var content = $('#mail_content div.modal-body div.content').html();
    var title = $('#mail_content_title').html();
    CKEDITOR.instances['mail_editor'].setData(content);
    $('#title').val(title);
    $('#draft_edit').css('display','none');
    $('#draft_send').css('display','none');
    $('#save_draft').css('display','block');
    $('#confirm_button').css('display','block');
    $('#to').val("");
    $('#editor').modal('toggle',{keyboard:true});
  });

  $('#btn_reply').on('click',function(){
    var content = "";
    var title = "Reply: "+$('#mail_content_title').html();
    var id = $('#mail_content div.modal-content div.modal-header h4.modal-title-hidden').html()+"@schoolm.com";
    CKEDITOR.instances['mail_editor'].setData(content);
    $('#title').val(title);
    $('#to').val(id);
    $('#draft_edit').css('display','none');
    $('#draft_send').css('display','none');
    $('#save_draft').css('display','block');
    $('#confirm_button').css('display','block');
    $('#editor').modal('toggle',{keyboard:true});
  });

  $('#btn_edit_draft').on('click',function(){
    var content = $('#mail_content div.modal-body div.content').html();
    var title = $('#mail_content_title').html();

    var id = $('#mail_content div.modal-content div.modal-header h4.modal-title-hidden').html()+"@schoolm.com";
    CKEDITOR.instances['mail_editor'].setData(content);
    $('#title').val(title);
    $('#draft_edit').css('display','block');
    $('#draft_send').css('display','block');
    $('#save_draft').css('display','none');
    $('#confirm_button').css('display','none');
    $('#editor').modal('toggle',{keyboard:true});
  });

  $('#messages_table tbody').on('click','tr td:not(:has(>a))',function(){
    var position = $('#messages_table').dataTable().fnGetPosition( this );
    var data = $('#messages_table').dataTable().fnGetData(position[0]);
    if( data != null){
        var id = data[0];
        var type = $('ul#folder li.active').index();
        if(type == 0){
          if($(this).parent().hasClass('not_read')){
            $(this).parent().removeClass('not_read');
            $(this).parent().addClass('read');
            var temp = $('#new_msg_count').html() - 1;
            if(temp <= 0){
              $('#new_msg_count').empty();  
            }
            else{
              $('#new_msg_count').html(temp);
            }
          }
        }
        if(type == 2){
          $('#id_draft_mail').val(data[0]);
        }
        read_msg(id,type);
     }
     else{
     }  
  });

  $('#messages_table tbody').on('click','tr td a',function(e){
    var position = $('#messages_table').dataTable().fnGetPosition( $(this).parent()[0] );
    delete_mail(position[0]);
  });

  $('#btn_info').on('click',function(){
    if($('#info_box').hasClass('collapsed-box')){
      $('#info_box').removeClass('collapsed-box');
    }
    else{
      $('#info_box').addClass('collapsed-box');
    }
  });

  $('#btn_close_editor').on('click',function(){
    CKEDITOR.instances['mail_editor'].setData('');
    $('#to').val("");
    $('#title').val("");
  });

  $('#draft_send').on('click',function(){
    var content = CKEDITOR.instances['mail_editor'].getData();
    var id      = $('#id_draft_mail').val();
    var title   = $('#title').val();
    var token   = $('input[name="_token"]').val();
    var to_list = $('#to').val();
    CKEDITOR.instances['mail_editor'].setData('');
    $.ajax({
      url     :"<?= URL::to('/mailbox/draft_send') ?>",
      type    :"POST",
      async   :false,
      data    :{
              'content'       :content,
              'title'         :title,
              'id'            :id,
              'to_list'       :to_list,
              '_token'        :token
              },
      success:function(record){
        $('#resultModal').modal('show');
        var count = 0;
        $('#errorlist-body').empty();
        $.each(record[3], function(i,item){
            $('#errorlist-body').append("<p>"+(i+1)+" | "+item+"</p");
            count = count + 1;
        });
        $('#errorlist-header').empty();
        $('#errorlist-header').append(count+" wrong format address");
        count = 0;
        $('#warninglist-body').empty();
        $.each(record[2], function(i,item){
            $('#warninglist-body').append("<p>"+(i+1)+" | "+item+"@schoolm.com"+"</p");
            count = count + 1;
        });
        $('#warninglist-header').empty();
        $('#warninglist-header').append(count+" not found address");
        count = 0;
        $('#successlist-body').empty();
        $.each(record[1], function(i,item){
            $('#successlist-body').append("<p>"+(i+1)+" | "+item.id+"@schoolm.com"+"</p");
            count = count + 1;
        });
        $('#successlist-header').empty();
        $('#successlist-header').append(count+" success address");
        var type = $('ul#folder li.active').index();
        if(type==2){
          update_mailbox(2);
        }
        // console.log(record);
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  });

  $('#draft_edit').on('click',function(){
    var content = CKEDITOR.instances['mail_editor'].getData();
    var id      = $('#id_draft_mail').val();
    var title   = $('#title').val();
    var token   = $('input[name="_token"]').val();
    CKEDITOR.instances['mail_editor'].setData('');
    $.ajax({
      url     :"<?= URL::to('/mailbox/draft_edit') ?>",
      type    :"POST",
      async   :false,
      data    :{
              'content'       :content,
              'title'         :title,
              'id'            :id,
              '_token'        :token
              },
      success:function(record){
        update_mailbox(2);
        $('#to').val("");
        $('#title').val("");
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  });

  $('#btn_receiver_list').on('click',function(){
    if(  $("#box_receiver_list").is(":visible") == true )
      $("#box_receiver_list").css('display','none');   
    else
      $("#box_receiver_list").css('display','block');

  });

  $('#btn_reply_all').on('click',function(){
    var content = "";
    var title = "Reply: "+$('#mail_content_title').html();
    var id_list = $('#box_receiver_list_hidden').html();
    var type = $('ul#folder li.active').index();
    if(type != 1){
      var id = $('#mail_content div.modal-content div.modal-header h4.modal-title-hidden').html()+"@schoolm.com";
      id_list = id + " " + id_list;
    }
    // console.log(id_list);
    CKEDITOR.instances['mail_editor'].setData(content);
    $('#title').val(title);
    $('#to').val(id_list);
    $('#draft_edit').css('display','none');
    $('#draft_send').css('display','none');
    $('#save_draft').css('display','block');
    $('#confirm_button').css('display','block');
    $('#editor').modal('toggle',{keyboard:true});
    
  })


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
        messages_table.fnClearTable();
        if(record.type == 0 || record.type == 3){
          $.each(record.msg_list.msg_recv_new ,function(i,row){
            var newrow = messages_table.fnAddData([
              row.id,
              row.author_name,
              row.content.title,
              row.content.mycontent,
              row.content.date_diff,
              "<a href='#'><i class='glyphicon glyphicon-trash' style='color:red'>Delete</a></i>"
            ]);
            messages_table.fnSettings().aoData[ newrow[0] ].nTr.className = "not_read";
          });
          $.each(record.msg_list.msg_recv_read ,function(i,row){
            var newrow = messages_table.fnAddData([
              row.id,
              row.author_name,
              row.content.title,
              row.content.mycontent,
              row.content.date_diff,
              "<a href='#'><i class='glyphicon glyphicon-trash' style='color:red'>Delete</a></i>"
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
              row.content.date_diff,
              "<a href='#'><i class='glyphicon glyphicon-trash' style='color:red'>Delete</a></i>"
            ]);
            messages_table.fnSettings().aoData[ newrow[0] ].nTr.className = "not_read";
          });
        }
        if(record.type == 0){

          if(record.msg_list['msg_recv_new_count'] <= 0){
            $('#new_msg_count').empty();
          }
          else{
            $('#new_msg_count').empty();
            $('#new_msg_count').html(record.msg_list['msg_recv_new_count']);
          }
        }
        if(record.type == 3){
          messages_table.fnSetColumnVis(5,false);
        }
        else{
          messages_table.fnSetColumnVis(5,true);
        }
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  }

  function read_msg(id,type){
    var type  = $("ul#folder li.active").index();
    var token = $('input[name="_token"]').val();
    // console.log(type+"_"+id);
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
          var type = $('ul#folder li.active').index();
          switch(type) {
              case 0:
                  $('#btn_forward').css('display','block');
                  $('#btn_reply').css('display','block');
                  $('#btn_edit_draft').css('display','none');
                  $('#btn_reply_all').css('display','block');
                  break;
              case 1:
                  $('#btn_forward').css('display','block');
                  $('#btn_reply').css('display','none');
                  $('#btn_edit_draft').css('display','none');
                  $('#btn_reply_all').css('display','block');
                  break;
              case 2:
                  $('#btn_forward').css('display','block');
                  $('#btn_reply').css('display','none');
                  $('#btn_edit_draft').css('display','block');
                  $('#btn_reply_all').css('display','none');  
                  break;
              default:
                  $('#btn_forward').css('display','block');
                  $('#btn_reply').css('display','block');
                  $('#btn_edit_draft').css('display','none');
                  $('#btn_reply_all').css('display','block');
          }
          $('#mail_content div.modal-header h4.2').empty();
          $('#mail_content div.modal-header h4.2').append("Author : "+record.msg_list[0].author_name);
          $('#mail_content div.modal-header h4.modal-title-hidden').empty();
          $('#mail_content div.modal-header h4.modal-title-hidden').append(record.msg_list[0].author_id);
          $('#mail_content_title').empty();
          $('#mail_content_title').append(record.msg_list[0].content.title);
          $('#mail_content div.modal-body div.content').empty();
          $('#mail_content div.modal-body div.content').append(record.msg_list[0].content.content);

          $('#box_receiver_list').empty();
          $.each(record.receive_list,function(i,j){
            if(i == 0)
              $('#box_receiver_list').append("<span class='cover_id' >"+j.recvby+"@schoolm.com"+"<span>");
            else
              $('#box_receiver_list').append(" "+"<span class='cover_id' >"+j.recvby+"@schoolm.com"+"<span>");
          });

         $('#box_receiver_list_hidden').empty();
          $.each(record.receive_list,function(i,j){
            if(i == 0)
              $('#box_receiver_list_hidden').append(j.recvby+"@schoolm.com");
            else
              $('#box_receiver_list_hidden').append(" "+j.recvby+"@schoolm.com");
          }); 

          $('#mail_content').modal('show');
          // console.log(record);
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  }

  function notification(){
    var my_id = $('#my_id').val();
    var pusher = new Pusher('{{env("PUSHER_KEY")}}');
    var channel = pusher.subscribe(my_id+"-channel");
    var Notification = window.Notification || window.mozNotification || window.webkitNotification;
    var handler = function(){

      update_mailbox(0);
    };
    channel.bind("new_mail_event",handler);
  }

  function delete_mail (position) {
    var data = messages_table.fnGetData(position);
    messages_table.fnDeleteRow(position);
    var id = data[0];
    var type  = $("ul#folder li.active").index();
    var token = $('input[name="_token"]').val();
    $.ajax({
      url     :"<?= URL::to('/mailbox/delete_mail') ?>",
      type    :"POST",
      async   :false,
      data    :{
              'id'            :id,
              'type'          :type,
              '_token'        :token
              },
      success:function(record){
        update_mailbox(type);
        $('#mail_count').html();
        mail_count = parseInt(mail_count) -1;
        if(mail_count == 0)
        mail_count = "";
        $('#mail_count').html(mail_count);
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });

  }

  function check_count_note(){
        var data = $('#title').val();
        var count = data.length;
        // $('#count_text').empty();
        // $('#count_text').append(count+"/100");
        if(count > 100){
            $('#title').parent().addClass('has-warning');
        }
        else{
            $('#title').parent().removeClass('has-warning');
        }
  };

  notification();

})
</script>
@endsection