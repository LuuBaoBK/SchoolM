@extends('mytemplate.newblankpage')
@section('content')

<?php use App\Model\Subject; ?>

<section class="content-header">
    <h1>
        Admin
        <small>Create Schedule</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active"><a href="/admin/schedule">Create Schedule</a></li>
    </ol>
</section>

<section class="content">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg-12">
            <div class="box box-solid box-primary collapsed-box">
            <div class="box-header">
                <h3 class="box-title">Create Schedule</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="schedule_form" method="POST" role="form">
            {!! csrf_field() !!}
            <div style = "display: none" class="box-body">
                <div id="error_mess" style = "display: none" class="alert alert-warning alert-dismissable">
                    <h4></h4>        
                </div>
                 <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Add New Subject To Schedule</h4>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control" name="subject_name" id="subject_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="totaltime">Total Time</label>
                        <input type="text" class="form-control" name="total_time" id="total_time">
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div style = "display: none" class="box-footer">
                    <button id ="schedule_form_submit" type="button" class="btn btn-primary">Add New Subject To Schedule</button>
            </div>
            </form>
            </div><!-- /.box -->
        </div>

        <div class="col-xs-12 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Class List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive">
                    <table id="schedule_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                        </tr>
                    </thead>

                    
                    <tbody class="displayrecord">
                        <?php for ($i=0;$i<=9;$i++) { ?>
                            <td>Tiết <?=$i+1 ?></td>
                            <?php foreach ($schedulelist[$i] as $row) { ?>
                                <td> <?php echo $row->subject->subject_name ?></td>
                            <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
<!-- /.box -->
</section><!-- DATA TABES SCRIPT -->
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