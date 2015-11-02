@extends('mytemplate.blankpage')
@section('content')
<link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
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
<div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Edit Subject Information</h3>                                  
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">

        <?php
            $conn=mysql_connect("localhost","root","");
            mysql_select_db("schoolm",$conn);
            $id=$_GET['subjectid'];
            $data1=$_POST['id'];
            $data2=$_POST['name'];
            $data3=$_POST['total_time'];
            $sql="update subject_table set id='".$data1."', name='".$data2."', total_time='".$data3."' where id='".$id."'";
            mysql_query($sql);
            header("location:editsubject.php");
            exit();

            $sql="select * from subject_table where id='".$id."'";
            $query=mysql_query($sql);
            $row=mysql_fetch_array($query);
        ?>

        <form method="GET" role="form" action="editsubject.php?subjectid=<?=$id?>">
                 {!! csrf_field() !!}
                <div style = "display: none" class="box-body">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input style="width:80%" type="text" class="form-control" name="id" id="id" value="<?=$row[id]?>">
                    </div>
                    <div class="form-group">
                        <label for="fullname">Subject Name</label>
                        <input style="width:80%" type="text" class="form-control" name="name" id="name" value="<?=$row[name]?>">
                    </div>
                    <div class="form-group">
                        <label for="id">Total Time</label>
                        <input style="width:80%" type="text" class="form-control" name="totaltime" id="id" value="<?=$row[total_time]?>">
                    </div>
                </div><!-- /.box-body -->
                <div style = "display: none" class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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