@extends('mytemplate.newblankpage')
@section('content')

<?php use App\Model\Subject; ?>
<?php use App\Model\Classes; ?>

<section class="content-header">
    <h1>
        Admin
        <small>View Schedule</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active"><a href="/admin/schedule">View Schedule</a></li>
    </ol>
</section>

<section class="content">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-3">
            <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Class List</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form method="POST">
         {!! csrf_field() !!}
        <div class="box-body">
            <div class="form-group">
                <label>Class</label>
                <select class="form-control select2 select2-hidden-accessible" name="semester" id="semester" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <?php $class = Classes::all() ?> 

                    <?php foreach ($class as $key) { ?>
                        <option><?php echo $key->classname ?></option>
                    <?php } ?>
                </select>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button id="nut" type="button" class="btn btn-primary">Get Schedule</button>
        </div>
    </form>
            </div><!-- /.box -->
        </div>

        <div class="col-xs-9 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Schedule</h3>
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
                       <!--<?php for ($i=1;$i<=10;$i++) { ?>
                            <tr>
                                <td><b>Tiết <?=$i ?></b></td>
                                <?php for ($j=1;$j<=5;$j++) { ?>
                                    <td> <? echo "a".$schedulelist[$i][$j] ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?><!--  -->
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
            $('#nut').click(function(){
                var abc = "<tr><td> $abc </td><td> $abc</td></tr>";
                $('.displayrecord').append(abc);
            });
        </script>

@endsection