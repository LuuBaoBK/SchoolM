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
	            <div class="box-header">
	            	<h4 class="text text-center ">{{$student->user->firstname}} {{$student->user->middlename}} {{$student->user->lastname}}</h4>
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
			            <form id="ad_form" method="POST" role="form">
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
				            </div><!-- /.box-body -->
				            <div class="box-footer">
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

        $("#stu_form_submit").click(function() {
            /* Act on the event */
            var id 			= $('#id').val();
            var firstname   = $('#firstname').val();
            var middlename  = $('#middlename').val();
            var lastname    = $('#lastname').val();
            var dateofbirth = $('#dateofbirth').val();
            var address     = $('#address').val();
            var token       = $('input[name="_token"]').val();

            $(".form-group").removeClass("has-warning");
            $(".error_mess").empty();

            $.ajax({
                url     :"<?= URL::to('/student/dashboard') ?>",
                type    :"POST",
                async   :false,
                data    :{
                	'id'			:id,
                    'firstname'     :firstname,
                    'middlename'    :middlename,
                    'lastname'      :lastname,
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
    });
</script>
@endsection
