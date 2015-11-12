@extends('mytemplate.newblankpage')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Transcript</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="schedule"><i class="active"></i>Create Transcript</a></li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
            <h3 class="box-title">Add New Score</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST">
         {!! csrf_field() !!}
        <div style = "display: none" class="box-body">
            <div class="form-group">
                <label>Semester</label>
                <select class="form-control select2 select2-hidden-accessible" name="semester" id="semester" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option>HKi1</option>
                  <option>HKi2</option>
                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-8pr1-container"><span class="select2-selection__rendered" id="select2-8pr1-container"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
            <div class="form-group">
                <label>Student ID</label>
                <select class="form-control select2 select2-hidden-accessible" name="student" id="student" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option>Huy</option>
                  <option>Nam</option>
                  <option>Thắm</option>
                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-8pr1-container"><span class="select2-selection__rendered" id="select2-8pr1-container"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <select class="form-control select2 select2-hidden-accessible" name="subject" id="subject" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option>Toán</option>
                  <option>Lý</option>
                  <option>Hóa</option>
                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-8pr1-container"><span class="select2-selection__rendered" id="select2-8pr1-container"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select class="form-control select2 select2-hidden-accessible" name="type" id="type" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option>15min</option>
                  <option>1 Tiết</option>
                  <option>Final</option>
                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-8pr1-container"><span class="select2-selection__rendered" id="select2-8pr1-container"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
            <div class="form-group">
                <label for="id">Score</label>
                <input style="width:80%" type="text" class="form-control" name="score" id="score">
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
            <h3 class="box-title">Transcript List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>                                    
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transcriptlist as $row) :?>
                    <tr class="item_row">
                            <td> <?php echo $row->semester ?></td>
                            <td> <?php echo $row->student ?></td>
                            <td> <?php echo $row->subject ?></td>
                            <td> <?php echo $row->type ?></td>
                            <td> <?php echo $row->score ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div><!-- /.box -->
</div>
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
                    "bSort": false,
                    "bInfo": true,
                    "bAutoWidth": false,
                });
            });
        </script>

@endsection