@extends('mytemplate.newblankpage')
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
  <div class="box">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Edit Admin Info</h3>
                </div><!-- /.box-header -->
            <!-- form start -->
            <form id="te_form" method="POST" role="form">
            {!! csrf_field() !!}
            <div class="box-body">
                <div id="error_mess" style = "display: none" class="alert alert-warning alert-dismissable">
                    <h4></h4>        
                </div>
                 <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Add New Admin</h4>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-3">
                        <label for="id">Id</label>
                        <input type="text" class="form-control" name="id" id="id" placeholder="Id" value={{$teacher->id}} disabled>
                    </div>
                    <div class="col-xs-12 col-lg-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value={{$teacher->user->email}} disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="firstname">First Name</label>
                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value={{$teacher->user->firstname}}>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value={{$teacher->user->middlename}}>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value={{$teacher->user->lastname}}>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value='<?=$teacher->user->address?>'>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="homephone">Home Phone</label>
                        <input type="text" class="form-control" name="homephone" id="homephone" placeholder="Home Phone" value={{$teacher->homephonne}}>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="mobilephone">Mobile Phone</label>
                        <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone" value={{$teacher->mobilephone}}>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="dateofbirth">Date Of Birth</label>
                        <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/ value={{$teacher->mydateofbirth}}>
                    </div>
                     <div class="form-group col-lg-3">
                        <label for="incomingday">Incoming Day</label>
                        <input type="text" id="incomingday" name="incomingday" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/ value={{$teacher->myincomingday}}>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="group">Group</label>
                        <input type="text" class="form-control" name="group" id="group" placeholder="Group" value='<?=$teacher->group?>'>
                    </div>
                   <div class="form-group col-lg-3">
                        <label for="specialized">Specialized</label>
                        <input type="text" class="form-control" name="specialized" id="specialized" placeholder="Specialized" value='<?=$teacher->specialized?>'>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" name="position" id="position" placeholder="Position" value='<?=$teacher->position?>'}>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                    <button id ="te_form_submit" type="button" class="btn btn-primary">Edit</button>
                    <a href="/admin/manage-user/teacher"><button id ="back" type="button" class="btn btn-primary">Back To Teacher Table</button></a>
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
            var token       = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('admin/manage-user/teacher/edit') ?>",
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
                    '_token'        :token
                },
                success:function(user){
                   if(user.isDone == 1){
                        $('#error_mess').slideUp('slow');
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                   }
                   else{
                        $('#error_mess').show("medium");
                        $('#error_mess').empty();
                        $.each(user, function(i, item){
                          $('#error_mess').append("<h4><i class='icon fa fa-warning'></i>"+item+"</h4>");
                        });
                        
                   }    
                }
            });
        });
    });


</script>

@endsection