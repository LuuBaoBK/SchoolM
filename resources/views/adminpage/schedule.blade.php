@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Schedule</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="schedule"><i class="active"></i>Create Schedule</a></li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
            <h3 class="box-title">Add New Schedule</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST">
         {!! csrf_field() !!}
        <div style = "display: none" class="box-body">
            <div class="form-group">
                <label>Class</label>
                <select class="form-control select2 select2-hidden-accessible" name="class" id="class" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option>9A1</option>
                  <option>8A1</option>
                  <option>7A1</option>
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
                <label>Ngày</label>
                <select class="form-control select2 select2-hidden-accessible" name="day" id="day" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option>Thứ Hai</option>
                  <option>Thứ Ba</option>
                  <option>Thứ Tư</option>
                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-8pr1-container"><span class="select2-selection__rendered" id="select2-8pr1-container"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
            <div class="form-group">
                <label for="id">Tiết bắt đầu</label>
                <input style="width:80%" type="text" class="form-control" name="start" id="start">
            </div>
            <div class="form-group">
                <label for="id">Thời lượng</label>
                <input style="width:80%" type="text" class="form-control" name="duration" id="duration">
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
            <h3 class="box-title">Schedule List</h3>
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
                    <?php foreach ($schedulelist as $row) :?>
                    <tr class="item_row">
                            <td> <?php echo $row->id ?></td>
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
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false,
                });
            });
        </script>

@endsection