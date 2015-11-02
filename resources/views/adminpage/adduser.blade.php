@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Create user</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Create User</li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
            <h3 class="box-title">Add New User</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST" role="form">
         {!! csrf_field() !!}
        <div style = "display: none" class="box-body">
            <div class="form-group">
                <label for="id">Id</label>
                <input style="width:80%" type="text" class="form-control" name="id" id="id" placeholder="Enter id" value={{old('id')}}>
            </div>
            <div class="form-group">
                <label for="Email">Email address</label>
                <input style="width:80%" type="email" class="form-control" name="email" id="email" placeholder="Enter email" value={{old('email')}}>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input style="width:80%" type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <input style="width:80%" type="text" class="form-control" name="role" id="role" placeholder="Enter role" value={{old('role')}}>
            </div>
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input style="width:80%" type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value={{old('fullname')}}>
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
            <h3 class="box-title">User List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>                                    
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>User Full Name</th>
                        <th>User Role</th>
                        <th>User Email(s)</th>
                        <th>Delete Item</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userlist as $row) :?>
                    <tr>
                            <td> <?php echo $row->id ?></td>
                            <td> <?php echo $row->fullname ?></td>
                            <td> <?php echo $row->role ?></td>
                            <td> <?php echo $row->email ?></td>
                            <td> <input type="checkbox"/></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>User Id</th>
                        <th>User Full Name</th>
                        <th>User Role</th>
                        <th>User Email(s)</th>
                        <th>Delete Item</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div><!-- /.box -->
</div>
</section><!-- DATA TABES SCRIPT -->
        <script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- page script -->
        <script type="text/javascript">
            $(function() {
                var table = $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                });
            });

            
        </script>

@endsection