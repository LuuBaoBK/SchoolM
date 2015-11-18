@extends('mytemplate.newblankpage')
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
  <div class="box">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Edit Student Info</h3>
                </div><!-- /.box-header -->
            <!-- form start -->
            <form id="stu_form" method="POST" role="form">
            {!! csrf_field() !!}
            <div class="box-body">
                 <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Edit Student</h4>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-3">
                        <label for="id">Id</label>
                        <input type="text" class="form-control" name="id" id="id" placeholder="Id" value={{$student->id}} disabled>
                    </div>
                    <div class="col-xs-12 col-lg-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value={{$student->user->email}} disabled>
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
                        <label for="enrolled_year">Enrolled Year</label>
                        <input type="text" class="form-control" name="enrolled_year" id="enrolled_year" placeholder="Mobile Phone" value={{$student->enrolled_year}}>
                        <label class="error_mess" id="enrolled_year_error" style="display:none" for="enrolled_year"></label>
                    </div>
                     <div class="form-group col-lg-3">
                        <label for="graduated_year">Graduated Year</label>
                        <input type="text" class="form-control" name="graduated_year" id="graduated_year" placeholder="Mobile Phone" value={{$student->graduated_year}}>
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
            </div><!-- /.box-body -->
            <div class="box-footer">
                    <button id ="stu_form_submit" type="button" class="btn btn-primary">Edit</button>
                    <a href="/admin/manage-user/student"><button id ="back" type="button" class="btn btn-primary">Back To student Table</button></a>
            </div>

            </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>
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
    });
});
</script>

@endsection