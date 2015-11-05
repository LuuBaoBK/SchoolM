@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Create Record Student Of A Class</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="addsubject"><i class="active"></i>Create Class</a></li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
            <h3 class="box-title">Add New Student In Class</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <p style="color:red">{{ $errors->first('class_id')}}</p>
    <p style="color:red">{{ $errors->first('student_id')}}</p>

    <form action="{{action('StudentInClass\StudentInClassController@save')}}" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
         {!! csrf_field() !!}
        <div style = "display: none" class="box-body">
            <div class="form-group">
                <label for="class_id">Class Id</label>
                <input style="width:80%" type="text" name="class_id" class="form-control">       
            </div>
            <div class="form-group">
                <label for="student_id">Student Id</label>
                <input style="width:80%" type="text" name="student_id" class="form-control">
            </div>
        </div><!-- /.box-body -->
        <div style = "display: none" class="box-footer">
            <button type="submit" class="btn btn-primary">Save Record</button>
        </div>
    </form>    
</div><!-- /.box -->
</div>
</section>
<section class="content">
<div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Student Of Classes List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>                                    
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <p style="color:red" ><?php echo Session::get('message'); ?></p>
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Class Id</th>
                        <th>Student Id</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row->class_id ?></td>
                            <td><?php echo $row->student_id ?></td>
                            <td>
                                <a href="<?php echo 'studentclassedit/'.$row->class_id.'/'.$row->student_id ?>">Edit</a> | 
                                <a href="<?php echo 'studentclassedit/'.$row->class_id.'/'.$row->student_id ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                
                </tbody>
                <tfoot>
                    <tr>
                        <th>Class Id</th>
                        <th>Student Id</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
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