@extends('mytemplate.newblankpage')
@section('content')

<section class="content-header">
    <h1>
        Admin
        <small>Regist Admin</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Regist Admin</li>
    </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg-12">
            <div class="box box-solid box-primary collapsed-box">
            <div class="box-header">
                <h3 class="box-title">Regist New Admin</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="ad_form" method="POST" role="form">
            {!! csrf_field() !!}
            <div style = "display: none" class="box-body">
                 <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Add New Admin</h4>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="firstname">First Name</label>
                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
                        <label class="error_mess" id="firstname_error" style="display:none" for="firstname"></label>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name">
                        <label class="error_mess" id="middlename_error" style="display:none" for="middlename"></label>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
                        <label class="error_mess" id="lastname_error" style="display:none" for="lastname"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="mobilephone">Mobile Phone</label>
                        <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone">
                        <label class="error_mess" id="mobilephone_error" style="display:none" for="mobilephone"></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="dateofbirth">Date Of Birth</label>
                        <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                        <label class="error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                        <label class="error_mess" id="address_error" style="display:none" for="address"></label>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div style = "display: none" class="box-footer">
                    <button id ="ad_form_submit" type="button" class="btn btn-primary">Create New Admin</button>
            </div>
            </form>
            </div><!-- /.box -->
        </div>

        <div class="col-xs-12 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Admin List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive">
                    <table id="admin_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Onwer Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th>Create By</th>
                            <th>role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="displayrecord">
                        <?php foreach ($adminlist as $row) :?>
                            <tr>
                                <td> <?php echo $row->id ?></td>
                                <td> <?php echo $row->user->firstname." ".$row->user->middlename." ".$row->user->lastname ?></td>
                                <td> <?php echo $row->user->email ?></td>
                                <td> <?php echo $row->mobilephone ?></td>
                                <td> <?php 
                                    $dateofbirth = $row->user->dateofbirth;
                                    if($dateofbirth != "0000-00-00"){
                                        $dateofbirth = date_create($row->user->dateofbirth);
                                        $dateofbirth = date_format($dateofbirth,"d/m/Y");
                                    }
                                    else{
                                       $dateofbirth = "";
                                    }
                                    echo $dateofbirth;
                                ?></td>
                                <td> <?php echo $row->user->address ?></td>
                                <td> <?php echo $row->create_by ?></td>
                                <td> <?php echo $row->user->role ?></td>
                                <td>
                                    <?php
                                    if($row->user->id == Auth::user()->id){
                                        echo ("<a href='/admin/dashboard'><i class = 'glyphicon glyphicon-edit'></i></a>");
                                    }
                                    else{
                                        echo ("<a href='/admin/edit/$row->id'><i class = 'glyphicon glyphicon-edit'></i></a>");  
                                    }?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Onwer Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th>Create By</th>
                            <th>role</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</div>
<!-- /.box -->
</section>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>

<script>
    $(function () {
        $("#admin_table").DataTable(
            {"order": [[ 0, "desc" ]]}
        );
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();

        $("#ad_form_submit").click(function() {
            /* Act on the event */
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
                url     :"<?= URL::to('/admin/manage-user/admin') ?>",
                type    :"POST",
                async   :false,
                data    :{
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

                        $('#admin_table').dataTable().fnAddData( [
                             record.mydata.id,
                             record.mydata.user.firstname+" "+record.mydata.user.middlename+" "+record.mydata.user.lastname,
                             record.mydata.user.email,
                             record.mydata.mobilephone,
                             dateofbirth,
                             record.mydata.user.address,
                             record.mydata.create_by,
                             record.mydata.user.role,
                             record.button
                             ]
                            );
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

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });
    });

    
</script>
@endsection