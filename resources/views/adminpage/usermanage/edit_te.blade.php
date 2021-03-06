@extends('mytemplate.blankpage_ad')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Edit Teacher Info</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Edit_Teacher_Info</li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Edit Teacher Info</h3>
        </div><!-- /.box-header -->
    <div class="box-body">
        <div class="col-lg-3 text-center">
            <?php 
                $src = "/uploads/teachers/".$teacher->id;
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
                <!-- form start -->
                <form id="te_form" method="POST" role="form">
                {!! csrf_field() !!}
                <div class="box-body">
                    <div id="success_mess" style = "display: none" class="alert alert-success">
                        <h4><i class="icon fa fa-check"></i>Success edit teacher info</h4>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-3">
                            <label for="id">Id</label>
                            <input type="text" class="form-control" name="id" id="id" placeholder="Id" readonly value={{$teacher->id}} >
                        </div>
                        <div class="col-xs-12 col-lg-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" readonly value={{$teacher->user->email}} >
                        </div>
                        <div class="col-xs-12 col-lg-3">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="M" selected>Male</option>
                                @if($teacher->user->gender == "F")
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
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value='<?=$teacher->user->firstname?>'>
                            <label class="error_mess" id="firstname_error" style="display:none" for="firstname"></label>
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label for="middlename">Middle Name</label>
                            <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value='<?=$teacher->user->middlename?>'>
                            <label class="error_mess" id="middlename_error" style="display:none" for="middlename"></label>
                        </div>
                        <div class="form-group col-lg-3 col-xs-12">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value='<?=$teacher->user->lastname?>'>
                            <label class="error_mess" id="lastname_error" style="display:none" for="lastname"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Address" value='<?=$teacher->user->address?>'>
                            <label class="error_mess" id="address_error" style="display:none" for="homephone"></label>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="homephone">Home Phone</label>
                            <input type="text" class="form-control" name="homephone" id="homephone" placeholder="Home Phone" value={{$teacher->homephone}}>
                            <label class="error_mess" id="homephone_error" style="display:none" for="homephone"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label for="mobilephone">Mobile Phone</label>
                            <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone" value={{$teacher->mobilephone}}>
                            <label class="error_mess" id="mobilephone_error" style="display:none" for="mobilephone"></label>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="dateofbirth">Date Of Birth</label>
                            <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/ value={{$teacher->mydateofbirth}}>
                            <label class="error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
                        </div>
                         <div class="form-group col-lg-3">
                            <label for="incomingday">Incoming Day</label>
                            <input type="text" id="incomingday" name="incomingday" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/ value={{$teacher->myincomingday}}>
                            <label class="error_mess" id="incomingday_error" style="display:none" for="incomingday"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label for="group">Group</label>
                            <select id="group" name="group" class="form-control">
                            <option value="-1" selected>-- All --</option>
                            <?php
                                $selected = "";
                                foreach($group as $subject){
                                    if($subject->id == $teacher->group)
                                        $selected = "selected";
                                    else
                                        $selected = "";
                                    echo ("<option value='".$subject->id."'".$selected.">".$subject->subject_name."</option>");
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="specialized">Specialized</label>
                            <input type="text" class="form-control" name="specialized" id="specialized" placeholder="Specialized" value='<?=$teacher->specialized?>'>
                            <label class="error_mess" id="specialized_error" style="display:none" for="specialized"></label>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="position">Position</label>
                            <select id="position" name="position" class="form-control">
                            <option value="-1" selected>-- All --</option>
                            <?php
                                $selected = "";
                                foreach($position_list as $position){
                                    if($position->id == $teacher->position)
                                        $selected = "selected";
                                    else
                                        $selected = "";
                                    echo ("<option value='".$position->id."'".$selected.">".$position->position_name."</option>");
                                }
                            ?>
                            </select>
                            <label class="error_mess" id="position_error" style="display:none" for="position"></label>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button id ="te_form_submit" type="button" class="btn btn-primary">Edit</button>
                        <a href="/admin/manage-user/teacher"><button id ="back" type="button" class="btn btn-primary">Back To Teacher Table</button></a>     
                        <button id ="reset_password" type="button" class="btn btn-warning">Reset Password</button>
                        @if($teacher->active == 1)
                        <button type="button" class="btn btn-danger" id="deactive">Deactive</button>
                        @else
                        <button type="button" class="btn btn-info" id="active">Active</button>
                        @endif
                </div>

                </form>
            </div>
        </div>
    </div>
</div><!-- /.box -->
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
            <p>Please Confirm That You Want To Reset Password Of This Teacher</p>
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

        $("#te_form_submit").click(function() {
            /* Act on the event */
            var id          = $('#id').val();
            var firstname   = $('#firstname').val();
            var middlename  = $('#middlename').val();
            var lastname    = $('#lastname').val();
            var mobilephone = $('#mobilephone').val();
            var homephone   = $('#homephone').val();
            var dateofbirth = $('#dateofbirth').val();
            var incomingday = $('#incomingday').val();
            var address     = $('#address').val();
            var group       = $('#group').val();
            var specialized = $('#specialized').val();
            var position    = $('#position').val();
            var gender      = $('#gender').val();
            var token       = $('input[name="_token"]').val();

            $(".form-group").removeClass("has-warning");
            $(".error_mess").empty();

            $.ajax({
                url     :"<?= URL::to('/admin/manage-user/teacher/edit') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'id'            :id,
                    'firstname'     :firstname,
                    'middlename'    :middlename,
                    'lastname'      :lastname,
                    'mobilephone'   :mobilephone,
                    'homephone'     :homephone,
                    'incomingday'   :incomingday,
                    'group'         :group,
                    'specialized'   :specialized,
                    'position'      :position,
                    'dateofbirth'   :dateofbirth,
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
    });
    $('#reset_password').click(function(){
            $('#confirmModal').modal('show');
        });

    $('#confirm_button').click(function(){
        $('#confirmModal').modal('hide');
        window.open('/admin/manage-user/teacher/edit/'+$('#id').val()+'/reset_password', '_blank');
    });

    $('#deactive').click(function(){
        var token       = $('input[name="_token"]').val();
        var status = "0";
        var id          = $('#id').val();
        $.ajax({
            url     :"<?= URL::to('/admin/manage-user/teacher/change-status') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'id'            :id,
                'status'        :status,
                '_token'        :token
            },
            success:function(record){
               location.reload();
               // console.log(record);
            }
        });        
    });

    $('#active').click(function(){
        var token       = $('input[name="_token"]').val();
        var status = "1";
        var id          = $('#id').val();
        $.ajax({
            url     :"<?= URL::to('/admin/manage-user/teacher/change-status') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'id'            :id,
                'status'        :status,
                '_token'        :token
            },
            success:function(record){
               location.reload();
               // console.log(record);
            }
        }); 
    });
});
</script>

@endsection