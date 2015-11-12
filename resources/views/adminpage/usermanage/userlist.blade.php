@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>User List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">User List</li>
    </ol>
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
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Date Of Birth</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userlist as $row) :?>
                    <tr>
                            <td> <?php echo $row->id ?></td>
                            <td> <?php echo $row->firstname." ".$row->middlename." ".$row->lastsname ?></td>
                            <td> <?php echo $row->email ?></td>
                            <td> <?php echo $row->address ?></td>
                            <td> <?php echo $row->dateofbirth ?></td>
                            <td> <?php echo $row->role ?></td>
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
                        <th>Address</th>
                        <th>Date Of Birth</th>
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