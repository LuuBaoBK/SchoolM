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
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Quick Example</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form method="POST" role="form">
         {!! csrf_field() !!}
        <div class="box-body">
             <div class="form-group">
                <label for="id">Id</label>
                <input style="width:50%" type="text" class="form-control" name="id" id="id" placeholder="Enter id" value={{old('id')}}>
            </div>
            <div class="form-group">
                <label for="Email">Email address</label>
                <input style="width:50%" type="email" class="form-control" name="email" id="email" placeholder="Enter email" value={{old('email')}}>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input style="width:50%" type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
             <div class="form-group">
                <label for="password_confirmation">Password</label>
                <input style="width:50%" type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="password_confirmation">
            </div>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input style="width:50%" type="text" class="form-control" name="name" id="name" placeholder="Full Name" value={{old('name')}}>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div><!-- /.box -->
</section>
@endsection