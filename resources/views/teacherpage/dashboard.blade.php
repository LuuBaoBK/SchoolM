@extends('mytemplate.blankpage_te')

@section('content')

<section class="content-header">
    <h1>
        Teacher
        <small>Dash Board</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-4 col-xs-12">
			<div class="box box-primary">
	            <div class="box-header text-center">
	              	<h4 class="text">{{$teacher->user->firstname}} {{$teacher->user->middlename}} {{$teacher->user->lastname}}</h4>
	              	<?php 
	            		$src = "/uploads/teachers/".$currentUser->id;
	            		if(file_exists(".".$src.".jpg")){
	            			$src = $src.".jpg";
	            		}
	            		else if(file_exists(".".$src.".png")){
	            			$src = $src.".png";
	            		}
	            		else{
	            			$src = "/uploads/userAvatar.png";
	            		}
	            	?>
	            	<img src="{{$src}}" class="img-circle" alt="Can't Load Image" style="margin:auto; width:160px; height:160px">
	            </div>
	            <div class="box-body">
		      		<ul class="list-group list-group-unbordered">
		                <li class="list-group-item">
		                  <b>Homeroom Class</b> <a class="pull-right">{{$homeroom_class}}</a>
		                </li>
		                <li class="list-group-item">
		                  <b>Position</b> <a class="pull-right">{{$teacher->my_position->position_name}}</a>
		                </li>
		                <li class="list-group-item">
		                  <b>Mobile Phone</b> <a class="pull-right"><?php $mobilephone = ($teacher->mobilephone =="")? "N/A" : $teacher->mobilephone; echo $mobilephone ?></a>
		                </li>
		                <li class="list-group-item">
		                  <b>Home Phone</b> <a class="pull-right"><?php $homephone = ($teacher->homephone =="")? "N/A" : $teacher->homephone; echo $homephone ?></a>
		                </li>
		                <li class="list-group-item"><b>Date Of Birth</b><a class="pull-right">{{$teacher->mydateofbirth}}</a>
		                </li>
		                <li class="list-group-item">
		                  <b>Specialize</b> <a class="pull-right">{{$teacher->specialized}}</a>
		                </li>
		                <li class="list-group-item">
		                  <b>Group</b> <a class="pull-right">{{$teacher->group}}</a>
		                </li>
		                <li class="list-group-item">
		                  <b>Incoming Day</b> <a class="pull-right">{{$teacher->myincomingday}}</a>
		                </li>
	              	</ul>
		      	</div>
	      	</div>
		</div>
		<div class="col-md-8 col-xs-12">
			<div class="nav-tabs-custom">
		        <ul class="nav nav-tabs">
		          <li class="active"><a href="#info" data-toggle="tab">Personal Info</a></li>
		          <li><a href="#changepassword" data-toggle="tab">Change Password</a></li>
		        </ul>
		        <div class="tab-content">
		            <div class="active tab-pane" id="info">       
			            <form id="te_form" method="POST" role="form">
				            {!! csrf_field() !!}
				            <div class="box-body">
				                 <div id="success_mess" style = "display: none" class="alert alert-success">
				                    <h4><i class="icon fa fa-check"></i>Success edit teacher info</h4>
				                </div>
				                <div class="row form-group">
				                    <div class="col-xs-12 col-lg-3">
				                        <label for="id">Id</label>
				                        <input type="text" class="form-control" name="id" id="id" value={{$teacher->id}} disabled>
				                    </div>
				                    <div class="col-xs-12 col-lg-3">
				                        <label for="email">Email</label>
				                        <input type="text" class="form-control" name="email" id="email" value={{$teacher->user->email}} disabled>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="form-group col-lg-3 col-xs-12">
				                        <label for="firstname">First Name</label>
				                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
				                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value='<?=$teacher->user->firstname?>' readonly>
				                        <label class="error_mess" id="firstname_error" style="display:none" for="firstname"></label>
				                    </div>
				                    <div class="form-group col-lg-3 col-xs-12">
				                        <label for="middlename">Middle Name</label>
				                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value='<?=$teacher->user->middlename?>' readonly>
				                        <label class="error_mess" id="middlename_error" style="display:none" for="middlename"></label>
				                    </div>
				                    <div class="form-group col-lg-3 col-xs-12">
				                        <label for="lastname">Last Name</label>
				                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value='<?=$teacher->user->lastname?>'readonly>
				                        <label class="error_mess" id="lastname_error" style="display:none" for="lastname"></label>        
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="form-group col-lg-3">
				                        <label for="mobilephone">Mobile Phone</label>
				                        <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone" value={{$teacher->mobilephone}}>
				                        <label class="error_mess" id="mobilephone_error" style="display:none" for="mobilephone"></label>
				                    </div>
				                    <div class="form-group col-lg-3">
				                        <label for="homephone">Home Phone</label>
				                        <input type="text" class="form-control" name="homephone" id="homephone" placeholder="Mobile Phone" value={{$teacher->homephone}}>
				                        <label class="error_mess" id="homephone_error" style="display:none" for="homephone"></label>
				                    </div>
				                    <div class="form-group col-lg-3">
				                        <label for="dateofbirth">Date Of Birth:</label>
				                        <input type="text" id="dateofbirth" name="dateofbirth" class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" data-mask / value={{$teacher->mydateofbirth}} >
				                        <label class="error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="form-group col-lg-6">
				                        <label for="address">Address</label>
				                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value='<?=$teacher->user->address?>'>
				                        <label class="error_mess" id="address_error" style="display:none" for="address"></label>
				                    </div>
				                </div>
				                <button id ="te_form_submit" type="button" class="btn btn-primary">Edit Info</button>
				            </div><!-- /.box-body -->
				            <div class="box-footer">
				            	<div class="input-group">
		                            <div class="input-group-btn">
		                                <button id="choose_file" type="button" class="btn btn-primary" >Choose File (.xlsx)</button>
		                            </div>
		                            <input id="import_text" name="import_text" type="text" class="form-control" disabled>
		                            <input id="import_text_hidden" name="import_text_hidden" type="text" class="form-control" style="display:none">
		                            <input type="file" name="fileToUpload" id="fileToUpload" style="display:none">
		                        </div>
		                        <div class="has-warning form-group">
		                        	<label class="error_mess" id="import_error" style="display:none"  for="import">Please Select File To Import</label>
	                        		<label class="error_mess" id="type_error" style="display:none"  for="import">Wrong file type (png | jpg is required)</label>
				                </div>
				                <button id ="upload_avatar" type="submit" class="btn btn-primary">Upload Image</button> 		                
				            </div>
			            </form>
		            </div>

		          	<div class="tab-pane" id="changepassword">
		          		<form id="change_password_form" method="POST" role="form">
				            {!! csrf_field() !!}
				            <div class="box-body">
				                 <div id="success_mess_psw" style = "display: none" class="alert alert-success">
				                    <h4><i class="icon fa fa-check"></i>Success Change Password</h4>
				                </div>
				                <div class="row">
				                    <div class="form-group col-lg-7 col-xs-12">
				                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
				                        <label for="new_password">New Password</label>
				                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value='<?=$teacher->user->new_password?>'>
				                        <label class="error_mess" id="new_password_error" style="display:none" for="new_password"></label>
				                    </div>
				                    <div class="form-group col-lg-7 col-xs-12">
				                        <label for="confirm_password">Confirm Passworld</label>
				                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Passworld" value='<?=$teacher->user->confirm_password?>'>
				                        <label class="error_mess" id="confirm_password_error" style="display:none" for="confirm_password"></label>        
				                    </div>
				                </div>
				            </div><!-- /.box-body -->
				            <div class="box-footer">
			                    <button id ="change_password_form_submit" type="button" class="btn btn-primary">Change</button>		                
				            </div>
			            </form>
		          	</div>
			          <!-- /.tab-pane -->
		        </div>
		        <!-- /.tab-content -->
	      	</div>
	      <!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
    $(function() {
    	$('#list_1').addClass("active");
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();

        $("#te_form_submit").click(function() {
            /* Act on the event */
            var id 			= $('#id').val();
            var firstname   = $('#firstname').val();
            var middlename  = $('#middlename').val();
            var lastname    = $('#lastname').val();
            var mobilephone = $('#mobilephone').val();
            var homephone = $('#homephone').val();
            var dateofbirth = $('#dateofbirth').val();
            var address     = $('#address').val();
            var token       = $('input[name="_token"]').val();
            console.log(token);

            $(".form-group").removeClass("has-warning");
            $(".error_mess").empty();

            $.ajax({
                url     :"<?= URL::to('/teacher/dashboard') ?>",
                type    :"POST",
                async   :false,
                data    :{
                	'id'			:id,
                    'firstname'     :firstname,
                    'middlename'    :middlename,
                    'lastname'      :lastname,
                    'mobilephone'   :mobilephone,
                    'homephone'		:homephone,
                    'dateofbirth'   :dateofbirth,
                    'address'       :address,
                    '_token'        :token
                },
                success:function(record){
                   if(record.isDone == 1){
                   	location.reload();                       
                   }
                   else{
                        $('#error_mess').show("medium");
                        $('#error_mess').empty();
                        $.each(record, function(i, item){
                          $('#'+i).parent().addClass('has-warning');
                          $('#'+i+"_error").css("display","block").append("<i class='icon fa fa-warning'></i> "+item);
                        });                      
                   }    
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        });

		$("#change_password_form_submit").click(function() {
			var new_password 	 = $('#new_password').val();
			var confirm_password = $('#confirm_password').val();
			var token       	 = $('input[name="_token"]').val();
			$(".form-group").removeClass("has-warning");
            $(".error_mess").empty();
			$.ajax({
                url     :"<?= URL::to('/teacher/dashboard/changepassword') ?>",
                type    :"POST",
                async   :false,
                data    :{
                	'new_password'	   : new_password,
                	'confirm_password' : confirm_password,
                    '_token'           :token
                },
                success:function(record){
                  	if(record['isSuccess'] == 1){
                  		$('#new_password').val('');
                  		$('#confirm_password').val('');
                  		$('#success_mess_psw').show('medium');
                  		setTimeout(function() {
                            $('#success_mess_psw').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                  	}
                  	else{
                  		$('#error_mess').show("medium");
                        $('#error_mess').empty();
                        $.each(record, function(i, item){
                          $('#'+i).parent().addClass('has-warning');
                          $('#'+i+"_error").css("display","block").append("<i class='icon fa fa-warning'></i> "+item);
                        });
                  	}
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
		});

		$('#choose_file').click(function(){
	        $('#fileToUpload').click();
	    });
	    $('#fileToUpload').change(function(){
	        var filename = $(this).val();
	        var lastIndex = filename.lastIndexOf("\\");
	        if (lastIndex >= 0) {
	            filename = filename.substring(lastIndex + 1);
	        }
	        $('#import_text').val(filename);
	        $('#import_text_hidden').val(filename);
	    });

	    $('#te_form').submit(function(e) {
        	e.preventDefault();
            $('#import_error').slideUp('fast');
			$('#type_error').slideUp('fast');

            var fd = new FormData(this); // XXX: Neex AJAX2
	        var filename = $('#import_text').val();
	        var file_ext = filename.substr(filename.lastIndexOf('.')+1);
            var token       = $('input[name="_token"]').val();

            if(filename == ""){
	            $('#import_error').show('medium');
	        }
	        else if(file_ext == "png" || file_ext == "jpg" ){
	            $('#import_error').slideUp('fast');
	            $('#type_error').slideUp('fast');
	            $.ajax({
	                url: '/teacher/dashboard/upload_image',
	                xhr: function() { // custom xhr (is the best)

	                    var xhr = new XMLHttpRequest();
	                    var total = 0;

	                    // Get the total size of files
	                    $.each(document.getElementById('fileToUpload').files, function(i, file) {
	                        total += file.size;
	                    });

	                    //   Called when upload progress changes. xhr2
	                    xhr.upload.addEventListener("progress", function(evt) {
	                        // show progress like example
	                        var loaded = (evt.loaded / total).toFixed(2)*100; // percent

	                        $('#progress').text('Uploading... ' + loaded + '%' );
	                    }, false);

	                    return xhr;
	                },
	                type: 'post',
	                processData: false,
	                contentType: false,
	                data: fd,
	                success: function(record) {
	                    location.reload();
	                }
	            });
	        }
	        else{
	        	$('#type_error').show('medium');
	        }
	        
        });
    });


</script>
@endsection
