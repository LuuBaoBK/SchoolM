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
                <div id="error_mess" style = "display: none" class="alert alert-warning alert-dismissable">
                    <h4></h4>        
                </div>
                 <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Add New Admin</h4>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="firstname">First Name</label>
                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name">
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="mobilephone">Mobile Phone</label>
                        <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="dateofbirth">Date Of Birth</label>
                        <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address">
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
                                {{$row}}
                                <td> <?php echo $row->id ?></td>
                                <td> <?php echo $row->user->firstname." ".$row->user->middlename." ".$row->user->lastname ?></td>
                                <td> <?php echo $row->user->email ?></td>
                                <td> <?php echo $row->mobilephone ?></td>
                                <td> <?php echo $row->user->dateofbirth ?></td>
                                <td> <?php echo $row->user->address ?></td>
                                <td> <?php echo $row->create_by ?></td>
                                <td> <?php echo $row->user->role ?></td>
                                <td>
                                <i class = "fa fa-fw fa-edit"></i>
                                <a href="<?php echo 'admin/edit/'.$row->id ?>">Edit</a>
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
            $.ajax({
                url     :"<?= URL::to('admin/manage-user/admin') ?>",
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
                success:function(user){
                   if(user.isDone == 1){
                        $('#error_mess').slideUp('slow');
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                        $('#admin_table').dataTable().fnAddData( [
                             user.id,
                             user.fullname,
                             user.email,
                             user.mobilephone,
                             user.dateofbirth,
                             user.address,
                             user.create_by,
                             user.role,
                             user.button
                             ]
                            );
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