@extends('mytemplate.blankpage_ad')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Edit Student Info</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Edit_Student_Info</li>
    </ol>
</section>

<section class="content">
<!-- My page start here --> 
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Edit Student Info</h3>
    </div><!-- /.box-header -->
<!-- form start -->
{!! csrf_field() !!}
<div class="box-body">
    <div class="col-lg-3 text-center">
        <?php 
            $src = "\uploads\\".$student->enrolled_year."\\".$student->id;
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
        <img src="{{$src}}" class="img-circle" alt="Error Loading Image" style="margin:auto; width:160px; height:160px">
    </div>
    <div class="col-lg-9">
        <div class="box box-primary">
            <form id="stu_form" method="POST" role="form">
            <div class="box-body">
                <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Edit Student</h4>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-3">
                        <label for="id">Id</label>
                        <input type="text" class="form-control" name="id" id="id" placeholder="Id" readonly value={{$student->id}}>
                    </div>
                    <div class="col-xs-12 col-lg-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" readonly value={{$student->user->email}}>
                    </div>
                    <div class="col-lg-3">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="M" selected>Male</option>
                            @if($student->user->gender == "F")
                                <option value="F" selected>Female</option>
                            @else
                                <option value="F">Female</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="firstname">First Name</label>
                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value='<?=$student->user->firstname?>'>
                        <label class="error_mess" id="firstname_error" style="display:none" for="firstname"></label>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value='<?=$student->user->middlename?>'>
                        <label class="error_mess" id="middlename_error" style="display:none" for="middlename"></label>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value='<?=$student->user->lastname?>'>
                        <label class="error_mess" id="lastname_error" style="display:none" for="lastname"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="dateofbirth">Date Of Birth</label>
                        <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/ value={{$student->mydateofbirth}}>
                        <label class="error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="enrolled_year">Enrolled Year <small>*</small> </label>
                        <input type="text" class="form-control" name="enrolled_year" id="enrolled_year" placeholder="Enrolled Year" value={{$student->enrolled_year}}>
                        <label class="error_mess" id="enrolled_year_error" style="display:none" for="enrolled_year"></label>
                    </div>
                     <div class="form-group col-lg-3">
                        <label for="graduated_year">Graduated Year</label>
                        <input type="text" class="form-control" name="graduated_year" id="graduated_year" placeholder="Graduated Year" value={{$student->graduated_year}}>
                        <label class="error_mess" id="graduated_year_error" style="display:none" for="graduated_year"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-lg-3">
                        <label for="parent_id">Parent id</label>
                        <input type="text" class="form-control" name="parent_id" id="parent_id" placeholder="parent_id" value={{$student->parent_id}}>
                        <label class="error_mess" id="parent_id_error" style="display:none" for="parent_id"></label>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value='<?=$student->user->address?>'>
                        <label class="error_mess" id="address_error" style="display:none" for="address"></label>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button id ="stu_form_submit" type="button" class="btn btn-primary">Edit</button>
                <a href="/admin/manage-user/student"><button id ="back" type="button" class="btn btn-primary">Back To student Table</button></a>
                <button id ="reset_password" type="button" class="btn btn-warning">Reset Password</button>
            </div>
            </form>
        </div>
    </div>
</div>
</section>
<div id="confirmModal" class="modal modal-warning">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Reset Password</h4>
        </div>
        <div class="modal-body">
            <p>Please Confirm That You Want To Reset Password Of This Student</p>
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
<!-- page script -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(function() {
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();

        $("#stu_form_submit").click(function() {
            /* Act on the event */
            var id          = $('#id').val();
            var firstname   = $('#firstname').val();
            var middlename  = $('#middlename').val();
            var lastname    = $('#lastname').val();
            var dateofbirth = $('#dateofbirth').val();
            var enrolled_year = $('#enrolled_year').val();
            var graduated_year   = $('#graduated_year').val();           
            var parent_id = $('#parent_id').val();
            var address     = $('#address').val();
            var gender      = $('#gender').val();
            var token       = $('input[name="_token"]').val();

            $(".form-group").removeClass("has-warning");
            $(".error_mess").empty();

            $.ajax({
                url     :"<?= URL::to('/admin/manage-user/student/edit') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'id'            :id,
                    'firstname'     :firstname,
                    'middlename'    :middlename,
                    'lastname'      :lastname,
                    'dateofbirth'   :dateofbirth,
                    'enrolled_year' :enrolled_year,
                    'graduated_year':graduated_year,
                    'parent_id'     :parent_id,
                    'address'       :address,
                    'gender'        :gender,
                    '_token'        :token
                },
                success:function(record){
                   if(record.isDone == 1){
                        $('#error_mess').slideUp('slow');
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
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
                }
            });
        });
        $('#reset_password').click(function(){
            $('#confirmModal').modal('show');
        });

        $('#confirm_button').click(function(){
            $('#confirmModal').modal('hide');
            window.open('/admin/manage-user/student/edit/'+$('#id').val()+'/reset_password', '_blank');
        });
    });
});
</script>

@endsection