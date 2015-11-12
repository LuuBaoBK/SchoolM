@extends('mytemplate.newblankpage')
@section('content')

<section class="content-header">
    <h1>
        Admin
        <small>Edit subject</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="editsubject"><i class="active"></i>Edit Subject</a></li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary collapsed-box" style="collapsed=false">
    <div class="box-header">
        <h3 class="box-title">Edit Subject Information</h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>                                 
    </div><!-- /.box-header -->
        <div class="box-body table-responsive">
        <form method="POST" action="{{action('Admin\EditsubjectController@update')}}">
                 {!! csrf_field() !!}
                <div style = "display: none" class="box-body">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input style="width:80%" type="text" class="form-control" name="id" id="id" value="{{$row['id']}}">
                    </div>
                    <div class="form-group">
                        <label for="fullname">Subject Name</label>
                        <input style="width:80%" type="text" class="form-control" name="name" id="name" value="{{$row['subject_name']}}">
                    </div>
                    <div class="form-group">
                        <label for="id">Total Time</label>
                        <input style="width:80%" type="text" class="form-control" name="totaltime" id="totaltime" value="{{$row['total_time']}}">
                    </div>
                </div><!-- /.box-body -->
                <div style = "display: none" class="box-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
          </form>
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
                $('#example2').dataTable({
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