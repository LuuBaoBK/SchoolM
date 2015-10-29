@extends('mytemplate.blankpage')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Create user</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Create User</li>
    </ol>
</section>
<section class="content">
<div class="col-xs-6">
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Quick Example</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST" role="form">
         {!! csrf_field() !!}
        <div class="box-body">
             <div class="form-group">
                <label for="id">Id</label>
                <input style="width:80%" type="text" class="form-control" name="id" id="id" placeholder="Enter id" value={{old('id')}}>
            </div>
            <div class="form-group">
                <label for="Email">Email address</label>
                <input style="width:80%" type="email" class="form-control" name="email" id="email" placeholder="Enter email" value={{old('email')}}>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input style="width:80%" type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
             <div class="form-group">
                <label for="password_confirmation">Password</label>
                <input style="width:80%" type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="password_confirmation">
            </div>
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input style="width:80%" type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value={{old('name')}}>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div><!-- /.box -->
</div>
<div class="col-xs-6">
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Quick Example</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST" role="form">
         {!! csrf_field() !!}
        <div class="box-body">
             <div class="form-group">
                <label for="id">Id</label>
                <input style="width:80%" type="text" class="form-control" name="id" id="id" placeholder="Enter id" value={{old('id')}}>
            </div>
            <div class="form-group">
                <label for="Email">Email address</label>
                <input style="width:80%" type="email" class="form-control" name="email" id="email" placeholder="Enter email" value={{old('email')}}>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input style="width:80%" type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
             <div class="form-group">
                <label for="password_confirmation">Password</label>
                <input style="width:80%" type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="password_confirmation">
            </div>
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input style="width:80%" type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value={{old('name')}}>
            </div>
        </div><!-- /.box-body -->
        <div  class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div><!-- /.box -->
</div>
</section>
@endsection