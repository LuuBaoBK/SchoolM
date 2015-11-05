@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Admin
        <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Edit</li>
    </ol>
</section>
<section class="content">
<div class="col-xs-12 col-lg-6">
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
            <h3 class="box-title">Edit Admin</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST" role="form">
         {!! csrf_field() !!}
        <div style = "display: none" class="box-body">
            <div class="form-group">
                <label for="Email">Email address</label>
                <input style="width:80%" type="email" class="form-control" name="email" id="email" placeholder="Enter email" value={{old('email')}}>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input style="width:80%" type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input style="width:80%" type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value={{old('fullname')}}>
            </div>
            <div class="form-group">
                <label for="mobilephone">Mobile Phone</label>
                <input style="width:80%" type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone" value={{old('mobile')}}>
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
                <input style="width:80%" type="text" class="form-control" name="address" id="role" placeholder="Address" value={{old('address')}}>
            </div>
        </div><!-- /.box-body -->
        <div style = "display: none" class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div><!-- /.box -->
</div>
</section>  
<!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                $("[data-mask]").inputmask();
            });
        </script>

@endsection