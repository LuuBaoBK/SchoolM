@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Create subject</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="addsubject"><i class="active"></i>Create Subject</a></li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
            <h3 class="box-title">Add New Subject</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST">
         {!! csrf_field() !!}
        <div style = "display: none" class="box-body">
            <div class="form-group">
                <label for="id">ID</label>
                <input style="width:80%" type="text" class="form-control" name="id" id="id" value={{old('id')}}>
            </div>
            <div class="form-group">
                <label for="fullname">Subject Name</label>
                <input style="width:80%" type="text" class="form-control" name="name" id="fullname" value={{old('name')}}>
            </div>
            <div class="form-group">
                <label for="id">Total Time</label>
                <input style="width:80%" type="text" class="form-control" name="totaltime" id="totaltime" value={{old('totaltime')}}>
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
            <h3 class="box-title">Subject List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>                                    
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject Name</th>
                        <th>Total time</th>
                        <th style="width:35px"></th>
                        <th style="width:45px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjectlist as $row) :?>
                    <tr class="item_row">
                            <td> <?php echo $row->id ?></td>
                            <td> <?php echo $row->subject_name ?></td>
                            <td> <?php echo $row->total_time ?></td>
                            <td> <a href="<?php echo 'editsubject/'.$row->id ?>">Edit</a> </td>
                            <td> <a href="<?php echo 'deletesubject/'.$row->id ?>">Delete</a> </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div><!-- /.box -->
</div>
</section>

<!-- InputMask -->
        <script src="../../js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="../../js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="../../js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- page script -->
        <script type="text/javascript">
            $(function() {
                $('#example1').dataTable({
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