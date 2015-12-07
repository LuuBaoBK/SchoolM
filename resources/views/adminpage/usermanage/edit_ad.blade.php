@extends('mytemplate.blankpage_ad')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Edit Admin Info</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Edit_Admin_Info</li>
    </ol>
</section>

<section class="content">
<!-- My page start here --> 
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Edit Admin Info</h3>
        </div><!-- /.box-header -->
    <!-- form start -->
    <form id="ad_form" method="POST" role="form">
    {!! csrf_field() !!}
    <div class="box-body">
         <div id="success_mess" style = "display: none" class="alert alert-success">
            <h4><i class="icon fa fa-check"></i>Success edit admin info</h4>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-3">
                <label for="id">Id</label>
                <input type="text" class="form-control" name="id" id="id" value={{$admin->id}} disabled>
            </div>
            <div class="col-xs-12 col-lg-3">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" value={{$admin->user->email}} disabled>
            </div>
            <div class="col-xs-12 col-lg-3">
                <label for="create_by">Create By</label>
                <input type="text" class="form-control" name="create_by" id="create_by" value={{$admin->create_by}} disabled>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-3 col-xs-12">
                <label for="firstname">First Name</label>
                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value='<?=$admin->user->firstname?>'>
                <label class="error_mess" id="firstname_error" style="display:none" for="firstname"></label>
            </div>
            <div class="form-group col-lg-3 col-xs-12">
                <label for="middlename">Middle Name</label>
                <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value='<?=$admin->user->middlename?>'>
                <label class="error_mess" id="middlename_error" style="display:none" for="middlename"></label>
            </div>
            <div class="form-group col-lg-3 col-xs-12">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value='<?=$admin->user->lastname?>'>
                <label class="error_mess" id="lastname_error" style="display:none" for="lastname"></label>        
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="mobilephone">Mobile Phone</label>
                <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone" value={{$admin->mobilephone}}>
                <label class="error_mess" id="mobilephone_error" style="display:none" for="mobilephone"></label>
            </div>
            <div class="form-group col-lg-3">
                <label for="dateofbirth">Date Of Birth:</label>
                <input type="text" id="dateofbirth" name="dateofbirth" class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" data-mask / value={{$admin->mydateofbirth}} >
                <label class="error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value='<?=$admin->user->address?>'>
                <label class="error_mess" id="address_error" style="display:none" for="address"></label>
            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <button id ="ad_form_submit" type="button" class="btn btn-primary">Edit</button>
        <a href="/admin/manage-user/admin"><button id ="back" type="button" class="btn btn-primary">Back To Admin Table</button></a>
        <button id ="reset_password" type="button" class="btn btn-warning">Reset Password</button>
    </div>
</form>
</section>
<div id="confirmModal" class="modal modal-warning">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Error</h4>
        </div>
        <div class="modal-body">
            <p>Please Confirm That You Want To Reset Password Of This Admin</p>
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

        $("#ad_form_submit").click(function() {
            /* Act on the event */
            var id          = $('#id').val()
            var firstname   = $('#firstname').val();
            var middlename  = $('#middlename').val();
            var lastname    = $('#lastname').val();
            var mobilephone = $('#mobilephone').val();
            var dateofbirth = $('#dateofbirth').val();
            var address     = $('#address').val();
            var token       = $('input[name="_token"]').val();

            $(".form-group").removeClass("has-warning");
            $(".error_mess").empty();
            
            $.ajax({
                url     :"<?= URL::to('/admin/manage-user/admin/edit') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'id'            :id,
                    'firstname'     :firstname,
                    'middlename'    :middlename,
                    'lastname'      :lastname,
                    'mobilephone'   :mobilephone,
                    'dateofbirth'   :dateofbirth,
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

        $('#reset_password').click(function(){
            $('#confirmModal').modal('show');
        });

        $('#confirm_button').click(function(){
            $('#confirmModal').modal('hide');
            window.open('/admin/manage-user/admin/edit/'+$('#id').val()+'/reset_password', '_blank');
        });
    });
});
</script>

@endsection