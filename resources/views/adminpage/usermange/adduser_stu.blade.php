@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Regist Student</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Regist Student</li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
            <h3 class="box-title">Regist New Student</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST" role="form">
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
                <label for="fullname">Full Name</label>
                <input style="width:80%" type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value={{old('fullname')}}>
            </div>
            <div class="form-group">
                <label for="enrolled_year">Enrolled Year</label>
                <input style="width:80%" type="text" class="form-control" name="enrolled_year" id="enrolled_year" placeholder="Enrolled Year" value={{old('enrolled_year')}}>
            </div>
            <div class="form-group">
                <label for="graduated_year">Graduated Year</label>
                <input style="width:80%" type="text" class="form-control" name="graduated_year" id="graduated_year" placeholder="Graduated Year" value={{old('graduated_year')}}>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent's ID</label>
                <input style="width:80%" type="text" class="form-control" name="parent_id" id="parent_id" placeholder="Parent's ID" value={{old('parent_id')}}>
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
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div><!-- /.box -->
</div>
</section>
<section class="content">
<div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Student List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>                                    
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Enrolled Year</th>
                        <th>Graduated Year</th>
                        <th>Parent Name</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentlist as $row) :?>
                    <tr>
                            <td> <?php echo $row->id ?></td>
                            <td> <?php echo $row->user->fullname ?></td>
                            <td> <?php echo $row->user->email ?></td>
                            <td> <?php echo $row->enrolled_year ?></td>
                            <td> <?php echo $row->graduated_year ?></td>
                            <td> <?php echo $row->parent->user->fullname?></td>
                            <td> <?php echo $row->user->role ?></td>
                            <td>
                                <i class = "fa fa-fw fa-edit"></i>
                                <a href="<?php echo 'edit/'.$row->id ?>">Edit</a>
                            </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Enrolled Year</th>
                        <th>Graduated Year</th>
                        <th>Parent Name</th>
                        <th>Role</th>
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