@extends('mytemplate.blankpage_stu')

@section('content')
<section class="content-header">
    <h1>
        Student
        <small>Dash Board</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/student/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-4 col-xs-12">
			<div class="box box-primary">
	            <div class="box-header text text-center">
	            	<h4 class="">{{$student->user->firstname}} {{$student->user->middlename}} {{$student->user->lastname}}</h4>
	            	<?php 
	            		$src = "\uploads\\".$student->enrolled_year."\\".$currentUser->id;
	            		if(file_exists(".".$src.".jpg")){
	            			$src = $src.".jpg";
	            		}
	            		else if(file_exists(".".$src.".png")){
	            			$src = $src.".png";
	            		}
	            		else{
	            			$src = "\uploads\userAvatar.png";
	            		}
	            	?>
	            	<img src="{{$src}}" class="img-circle" alt="Can't Load Image" style="margin:auto; width:160px; height:160px">
	            </div>
	            <div class="box-body">
		      		<ul class="list-group list-group-unbordered">
		                <li class="list-group-item">
		                  	<b>Role</b> <a class="pull-right">Student</a>
		                </li>
		                <li class="list-group-item">
                			<b>Date Of Birth</b><a class="pull-right">{{$student->mydateofbirth}}</a>
		                </li>
		                <li class="list-group-item">
		                  	<b>Class</b> <a class="pull-right">{{$student->nowClass}}</a>
		                </li>
		                <li class="list-group-item">
		                  	<b>Enrolled Year</b> <a class="pull-right">{{$student->enrolled_year}}</a>
		                </li>
		      			<li class="list-group-item">
		                  	<h5 class="text text-center">Parent Info</h5>
		                  	<a class="pull-left">{{$student->parent->user->id}}</a> <a class="pull-right">{{$student->parent->user->fullname}}</a>
		                  	</br>	
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
			            <form id="stu_form" method="POST" role="form">
				            {!! csrf_field() !!}
				            <div class="box-body">
				                 <div id="success_mess" style = "display: none" class="alert alert-success">
				                    <h4><i class="icon fa fa-check"></i>Success edit student info</h4>
				                </div>
				                <div class="row form-group">
				                    <div class="col-xs-12 col-lg-3">
				                        <label for="id">Id</label>
				                        <input type="text" class="form-control" name="id" id="id" value={{$student->id}} readonly>
				                    </div>
				                    <div class="col-xs-12 col-lg-3">
				                        <label for="email">Email</label>
				                        <input type="text" class="form-control" name="email" id="email" value={{$student->user->email}} readonly>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="form-group col-lg-3 col-xs-12">
				                        <label for="firstname">First Name</label>
				                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
				                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value='<?=$student->user->firstname?>' readonly>
				                        <label class="error_mess" id="firstname_error" style="display:none" for="firstname"></label>
				                    </div>
				                    <div class="form-group col-lg-3 col-xs-12">
				                        <label for="middlename">Middle Name</label>
				                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value='<?=$student->user->middlename?>' readonly>
				                        <label class="error_mess" id="middlename_error" style="display:none" for="middlename"></label>
				                    </div>
				                    <div class="form-group col-lg-3 col-xs-12">
				                        <label for="lastname">Last Name</label>
				                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value='<?=$student->user->lastname?>' readonly>
				                        <label class="error_mess" id="lastname_error" style="display:none" for="lastname"></label>        
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="form-group col-lg-3">
				                        <label for="dateofbirth">Date Of Birth:</label>
				                        <input type="text" id="dateofbirth" name="dateofbirth" class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" data-mask / value={{$student->mydateofbirth}} readonly>
				                        <label class="error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
				                    </div>
				                    <div class="form-group col-lg-6">
				                        <label for="address">Address</label>
				                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value='<?=$student->user->address?>' readonly>
				                        <label class="error_mess" id="address_error" style="display:none" for="address"></label>
				                    </div>
				                </div>
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
				            </div><!-- /.box-body -->
				            <div class="box-footer">
				            	<button id ="stu_form_submit" type="submit" class="btn btn-primary">Upload Image</button>
				                    <!-- <button id ="stu_form_submit" type="button" class="btn btn-primary">Edit</button>		                 -->
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
				                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value='<?=$student->user->new_password?>'>
				                        <label class="error_mess" id="new_password_error" style="display:none" for="new_password"></label>
				                    </div>
				                    <div class="form-group col-lg-7 col-xs-12">
				                        <label for="confirm_password">Confirm Passworld</label>
				                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Passworld" value='<?=$student->user->confirm_password?>'>
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

        $('#stu_form').submit(function(e) {
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
	                url: '/student/dashboard/upload_image',
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

		$("#change_password_form_submit").click(function() {
			var new_password 	 = $('#new_password').val();
			var confirm_password = $('#confirm_password').val();
			var token       	 = $('input[name="_token"]').val();
			$(".form-group").removeClass("has-warning");
            $(".error_mess").empty();
			$.ajax({
                url     :"<?= URL::to('/student/dashboard/changepassword') ?>",
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
    });
</script>
@endsection
