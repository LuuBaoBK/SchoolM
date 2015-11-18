@extends('mytemplate.newblankpage')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Create Class</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li><i class="active"></i>Create Class</li>
    </ol>
</section>
<section class="content">
<div class="box">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                   <h3 class="box-title">Add New Class</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>   
                </div>
                <form id="class_form" method="POST" role="form">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div id="success_mess" style = "display: none" class="alert alert-success">
                            <h4><i class="icon fa fa-check"></i>Success Add New Class</h4>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header">
                                <div class="box-title">Class Info</div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <label for="scholastic">Scholastic</label>
                                        <select id="scholastic" name="scholastic" class="form-control">
                                            <?php
                                                $year = date("Y") + 2;
                                                for($year;$year >=2010 ;$year--){
                                                    if($year == 2015)
                                                    {
                                                        echo ("<option selected>".$year." - ".($year+1)."</option>");
                                                    }
                                                    else
                                                    {
                                                        echo ("<option>".$year." - ".($year+1)."</option>");
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <label for="grade">Grade</label>
                                        <select id="grade" name="grade" class="form-control">
                                            <option selected>6</option>;
                                            <option>7</option>;
                                            <option>8</option>;
                                            <option>9</option>;
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <label for="group">Group</label>
                                        <select id="group" name="group" class="form-control">
                                            <?php
                                                $year = date("Y") + 2;
                                                for($year;$year >=2010 ;$year--){
                                                    if($year == 2017)
                                                    {
                                                        echo ("<option selected>".$year." - ".($year+1)."</option>");
                                                    }
                                                    else
                                                    {
                                                        echo ("<option>".$year." - ".($year+1)."</option>");
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>                                   
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label for="student_dateofbirth">Date Of Birth</label>
                                        <input type="text" id="student_dateofbirth" name="student_dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                        <label class="error_mess" id="student_dateofbirth_error" style="display:none" for="student_dateofbirth"></label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="enrolled_year">Enrolled Year</label>
                                        <input type="text" class="form-control" name="enrolled_year" id="enrolled_year" placeholder="Enrolled Year">
                                        <label class="error_mess" id="enrolled_year_error" style="display:none" for="enrolled_year"></label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="graduated_year">Graduated Year</label>
                                        <input type="text" class="form-control" name="graduated_year" id="graduated_year" placeholder="Graduated Year">
                                        <label class="error_mess" id="graduated_year_error" style="display:none" for="graduated_year"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="student_address">Address</label>
                                        <input type="text" class="form-control" name="student_address" id="student_address" placeholder="Address">
                                        <label class="error_mess" id="student_address_error" style="display:none" for="student_address"></label>
                                    </div>
                                </div>
                            </div> <!-- Student box body -->
                        </div> <!-- Student box -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                            <button id ="class_form_submit" type="button" class="btn btn-primary">Create New Student</button>
                    </div>
                </form>
            </div>
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
                                <div id="from_to_warning" style="display: none"class="alert alert-warning">
                                    <i class="icon fa fa-warning"></i>From_Year can not be greater than To_Year
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                        <label for="from_year">From</label>
                                        <select id="from_year" name="from_year" class="form-control">
                                            <?php
                                                $year = date("Y") + 2;
                                                for($year;$year >=2010 ;$year--){
                                                    if($year == 2010)
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
                                                    if($year == 2017)
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
                    <table id="student_table" class="table table-bordered table-striped">
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
</section>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- page script -->
        <script type="text/javascript">
            $(function() {
                $('#classes_info').dataTable();
            });
        </script>

@endsection