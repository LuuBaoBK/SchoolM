@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Edit Admin</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Edit Admin</li>
    </ol>
</section>
<section class="content">
<div class="col-xs-12 col-lg-6">
<div class="box box-solid box-primary">
    <div class="box-header">
            <h3 class="box-title">Edit New Admin</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST" role="form">
         {!! csrf_field() !!}
        <div class="box-body">
            <div class="form-group">
                <label for="Email">Email address</label>
                <input style="width:80%" type="email" class="form-control" name="email" id="email" value="{{$admin->user->email}}">
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input style="width:80%" type="text" class="form-control" name="firstname" id="firstname" value="{{$admin->user->firstname}}">
            </div>
            <div class="form-group">
                <label for="middlename">Middle Name</label>
                <input style="width:80%" type="text" class="form-control" name="middlename" id="middlename" value="{{$admin->user->middlename}}">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input style="width:80%" type="text" class="form-control" name="lastname" id="lastname" value="{{$admin->user->lastname}}">
            </div>
            <div class="form-group">
                <label for="mobilephone">Mobile Phone</label>
                <input style="width:80%" type="text" class="form-control" name="mobilephone" id="mobilephone" value="{{$admin->mobilephone}}">
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
                <input style="width:80%" type="text" class="form-control" name="address" id="role" value="{{$admin->user->address}}">
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
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
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                $("[data-mask]").inputmask();
            });
        </script>

@endsection