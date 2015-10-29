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
<div class="content">
    <form action="/auth/register" method="post" role="form">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Quick Example</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control">
                        <option>admin</option>
                        <option>teacher</option>
                        <option>studentet</option>
                        <option>parent</option>
                    </select>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        
    </div><!-- /.box -->
    </form>
</div>
@endsection