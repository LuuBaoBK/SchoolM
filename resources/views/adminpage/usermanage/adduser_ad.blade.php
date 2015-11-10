@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Regist Admin</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Regist Admin</li>
    </ol>
</section>
<section class="content">
<div class="col-xs-12 col-lg-6">
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
            <div class="form-group">
                <label for="Email">Email address</label>
                <input style="width:80%" type="email" class="form-control" name="email" id="email" placeholder="Enter email" value={{old('email')}}>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input style="width:80%" type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input style="width:80%" type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value={{old('firstname')}}>
            </div>
            <div class="form-group">
                <label for="middlename">Middle Name</label>
                <input style="width:80%" type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value={{old('middlename')}}>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input style="width:80%" type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value={{old('lastname')}}>
            </div>
            <div class="form-group">
                <label for="mobilephone">Mobile Phone</label>
                <input style="width:80%" type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone" value={{old('mobile')}}>
            </div>
            <div class="form-group">
                <label>Date Of Birth:</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input style="width:80%" type="text" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
            <div class="form-group">
                <label for="role">Address</label>
                <input style="width:80%" type="text" class="form-control" name="address" id="role" placeholder="Address" value={{old('address')}}>
            </div>
        </div><!-- /.box-body -->
        <div style = "display: none" class="box-footer">
            <button id ="ad_form_submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div><!-- /.box -->
</div>
</section>
<section class="content">
<div class="col-xs-12 col-lg12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Admin List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>                                    
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Onwer Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($adminlist as $row) :?>
                    <tr>
                            <td> <?php echo $row->id ?></td>
                            <td> <?php echo $row->user->firstname." ".$row->user->middlename." ".$row->user->lastname ?></td>
                            <td> <?php echo $row->user->email ?></td>
                            <td> <?php echo $row->mobilephone ?></td>
                            <td> <?php echo $row->user->role ?></td>
                            <td>
                                <i class = "fa fa-fw fa-edit"></i>
                                <a href="<?php echo 'admin/edit/'.$row->id ?>">Edit</a> |
                                <i class = "fa fa-fw fa-trash-o"></i> 
                                <a href="<?php echo 'admin/delete/'.$row->id ?>">Delete</a>
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
                        <th>role</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div><!-- /.box -->
</div>
</section>
<!-- DATA TABES SCRIPT -->
        <script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
        
<!-- page script -->
        <script type="text/javascript">
            $(function() {
                $('#example').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                });
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                $("[data-mask]").inputmask();
            });
        </script>

@endsection