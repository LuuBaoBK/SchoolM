@extends('mytemplate.printpage')
@section('mycontent')
<div class="wrapper">
  <div class="box box-primary box-solid">
    <div class="box-header">
      <h3 class="text-center">Password Reset</h3>
    </div>
    <div class="box-body">
      <table id="info_table" class="table table-bordered table-striped">
        <thead>
          <tr>
          <td>Id</td>
          <td>{{$teacher->id}}</td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>Email</td>
          <td>{{$teacher->user->email}}</td>
        </tr>
        <tr>
          <td>Role</td>
          <td>teacher</td>
        </tr>
        <tr>
          <td>Date Of Birth</td>
          <td>{{$teacher->user->dateofbirth}}</td>
        </tr>
        <tr>
          <td>Address</td>
          <td>{{$teacher->user->address}}</td>
        </tr>
        <tr>
          <td>New Password</td>
          <td>{{$password}}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="box-footer">
      SchooM IT-Apartment
    </div>
  </div>
</div>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- jQuery 2.1.4 -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<script type="text/javascript">
  $(function(){
    $("#info_table").DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "columns": [
         { "width": "40%" },
         { "width": "60%" }]
   });
  });
  


</script>

