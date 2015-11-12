@extends('mytemplate.newblankpage')
@section('content')

<section class="content-header">
    <h1>
        Admin
        <small>Regist Student</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Regist Student</li>
    </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Student List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive">
                    <div class="box box-primary">
                        <div class="box-header">
                            <p class="box-title">Select Enrolled Year Range</p>
                        </div>
                        <div class="box-body">
                            <form id="student_filter">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                        <label for="from_year">From</label>
                                        <select id="from_year" name="from_year" class="form-control">
                                            <?php
                                                $year = date("Y") + 2;
                                                for($year;$year >=2010 ;$year--){
                                                    if($year == date("Y"))
                                                    {
                                                        echo "<option selected>".$year."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option>".$year."</option>";
                                                    }
                                                }  
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <label for="to_year">To</label>
                                        <select id="to_year" name="to_year" class="form-control">
                                            <?php
                                                $year = date("Y") + 2;
                                                for($year;$year >=2010 ;$year--){
                                                    if($year == date("Y"))
                                                    {
                                                        echo "<option selected>".$year."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option>".$year."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button id ="student_search" type="button" class="btn btn-primary btn-flatt">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table id="teacher_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Enrolled Year</th>
                            <th>Graduated Year</th>
                            <th>Parent Name</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th>role</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="displayrecord">
                       
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Enrolled Year</th>
                            <th>Graduated Year</th>
                            <th>Parent Name</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th>role</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</div>
<!-- /.box -->
</section>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>

<script>
    $(function () {
        $("#teacher_table").DataTable();
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();

        $('#student_search').click(function(){
            var from_year = $('#from_year').val();
            var to_year = $('#to_year').val();
            var token = $('input[name="_token"]').val();

           $.ajax({
                url     :"<?= URL::to('admin/manage-user/student/show') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'from_year'     :from_year,
                    'to_year'       :to_year,
                    '_token'        :token
                },
                success:function(record){
                   alert(record);
                },
                error:function(){
                    alert("Something went wrong ! Please Contact Your Super Admin");
                }
            });
        });

       
    });

    
</script>
@endsection