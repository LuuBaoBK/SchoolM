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
                   <h3 class="box-title">Regist New Student</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>   
                </div>
                <form id="st_form" method="POST" role="form">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div id="success_mess" style = "display: none" class="alert alert-success">
                            <h4><i class="icon fa fa-check"></i>Success Add New Student</h4>
                        </div>

                        <div class="col-lg-6 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <div class="box-title">Student Info</div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label for="student_firstname">First Name</label>
                                            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                            <input type="text" class="form-control" name="student_firstname" id="student_firstname" placeholder="First Name">
                                            <label class="error_mess" id="student_firstname_error" style="display:none" for="student_firstname"></label>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label for="student_middlename">Middle Name</label>
                                            <input type="text" class="form-control" name="student_middlename" id="student_middlename" placeholder="Middle Name">
                                            <label class="error_mess" id="student_middlename_error" style="display:none" for="student_middlename"></label>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label for="student_lastname">Last Name</label>
                                            <input type="text" class="form-control" name="student_lastname" id="student_lastname" placeholder="Last Name">
                                            <label class="error_mess" id="student_lastname_error" style="display:none" for="student_lastname"></label>
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
                        </div> <!-- Student info -->
                        <div class="col-lg-6 col-xs-12">
                           <div class="box box-primary">
                                <div class="box-header">
                                    <div class="box-title">Parent Info</div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div style="margin-top:30px" class="form-group col-lg-4 col-xs-12">
                                                <label><input name="isNew" id="isNew" type="checkbox" class="minimal-blue" checked>Create New</label>
                                        </div>
                                        <div class="form-group col-lg-8 col-xs-12">
                                            <label>Id</label>
                                            <input id="parent_id" type="text" class="form-control" name="parent_id" id="parent_id" placeholder="Parent Id" disabled>
                                            <label class="error_mess" id="parent_id_error" style="display:none" for="parent_id"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label for="parent_firstname">First Name</label>
                                            <input type="text" class="isParent form-control" name="parent_firstname" id="parent_firstname" placeholder="Parent First Name">
                                            <label class="error_mess" id="parent_firstname_error" style="display:none" for="parent_firstname"></label>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label for="parent_middlename">Middle Name</label>
                                            <input type="text" class="isParent form-control" name="parent_middlename" id="parent_middlename" placeholder="Parent Middle Name">
                                            <label class="error_mess" id="parent_middlename_error" style="display:none" for="parent_middlename"></label>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label for="parent_lastname">Last Name</label>
                                            <input type="text" class="isParent form-control" name="parent_lastname" id="parent_lastname" placeholder="Parent Last Name">
                                            <label class="error_mess" id="parent_lastname_error" style="display:none" for="parent_lastname"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="parent_dateofbirth">Date Of Birth</label>
                                            <input type="text" id="parent_dateofbirth" name="parent_dateofbirth" class="isParent form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                            <label class="error_mess" id="parent_dateofbirth_error" style="display:none" for="parent_dateofbirth"></label>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="parent_homephone">Home Phone</label>
                                            <input type="text" class="isParent form-control" name="parent_homephone" id="parent_homephone" placeholder="Parent Home Phone">
                                            <label class="error_mess" id="parent_homephone_error" style="display:none" for="parent_homephone"></label>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="parent_mobilephone">Mobile Phone</label>
                                            <input type="text" class="isParent form-control" name="parent_mobilephone" id="parent_mobilephone" placeholder="Parent Mobile Phone">
                                            <label class="error_mess" id="parent_mobilephone_error" style="display:none" for="parent_mobilephone"></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="parent_job">Job</label>
                                            <input type="text" class="isParent form-control" name="parent_job" id="parent_job" placeholder="Parent Job">
                                            <label class="error_mess" id="parent_job_error" style="display:none" for="parent_job"></label>
                                        </div>
                                        <div class="form-group col-lg-8">
                                            <label for="parent_address">Address</label>
                                            <input type="text" class="isParent form-control" name="parent_address" id="parent_address" placeholder="Parent Address">
                                            <label class="error_mess" id="parent_address_error" style="display:none" for="parent_address"></label>
                                        </div>
                                    </div>
                                </div> <!-- Student box body -->
                            </div> <!-- Student box -->
                        </div> <!-- Praent Info -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                            <button id ="st_form_submit" type="button" class="btn btn-primary">Create New Student</button>
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
                                <div class="row">
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <label for="firstname">First Name</label>
                                        <input id="firstname" type="text" class="form-control" name="firstname" id="firstname" placeholder="Student First Name">
                                    </div>
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <label for="middlename">Middle Name</label>
                                        <input id="middlename" type="text" class="form-control" name="middlename" id="middlename" placeholder="Student Middle Name">
                                    </div>
                                    <div class="form-group col-lg-3 col-xs-7">
                                        <label for="lastname">Last Name</label>
                                        <input id="lastname" type="text" class="form-control" name="lastname" id="lastname" placeholder="Student Last Name">
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
<!-- /.box -->
</section>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset("/adminlte/plugins/iCheck/icheck.min.js")}}"></script>
<script>
$(document).ready(function() {
    $(function () {
        var isCheck = 1;
    //Flat red color scheme for iCheck
        $('input[type="checkbox"].minimal-blue').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();

        $('input[type="checkbox"].minimal-blue').on('ifChecked', function(event){
            $('input.isParent').prop('disabled', false);
            $('#parent_id').prop('disabled', true);
        });

        $('input[type="checkbox"].minimal-blue').on('ifUnchecked', function(event){
            $('input.isParent').prop('disabled', true);
            $('#parent_id').prop('disabled', false);
        });

        $("#student_table").DataTable(
            {"order": [[ 0, "desc" ]]}
        );

        $('#st_form_submit').click(function(){
            var createNew = $("#isNew").is(":checked");
            var student_firstname = $('#student_firstname').val();
            var student_middlename = $('#student_middlename').val();
            var student_lastname = $('#student_lastname').val();
            var student_dateofbirth = $('#student_dateofbirth').val();
            var enrolled_year = $('#enrolled_year').val();
            var graduated_year = $('#graduated_year').val();
            var student_address = $('#student_address').val();
            var parent_id = $('#parent_id').val();
            var parent_firstname = $('#parent_firstname').val();
            var parent_middlename = $('#parent_middlename').val();
            var parent_lastname = $('#parent_lastname').val();
            var parent_dateofbirth = $('#parent_dateofbirth').val();
            var parent_mobilephone = $('#parent_mobilephone').val();
            var parent_homephone = $('#parent_homephone').val();
            var parent_job = $('#parent_job').val();
            var parent_address = $('#parent_address').val();
            var token = $('input[name="_token"]').val();

            $(".form-group").removeClass("has-warning");
            $(".error_mess").empty();
            $.ajax({
                url     :"<?= URL::to('/admin/manage-user/student') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'createNew'             :createNew,   
                    'student_firstname'     :student_firstname,   
                    'student_middlename'    :student_middlename,   
                    'student_lastname'      :student_lastname, 
                    'student_dateofbirth'   :student_dateofbirth,   
                    'enrolled_year'         :enrolled_year,   
                    'graduated_year'        :graduated_year,   
                    'student_address'       :student_address,  
                    'parent_id'     :parent_id, 
                    'parent_firstname'      :parent_firstname,   
                    'parent_middlename'     :parent_middlename,  
                    'parent_lastname'       :parent_lastname,   
                    'parent_dateofbirth'    :parent_dateofbirth,  
                    'parent_mobilephone'    :parent_mobilephone,   
                    'parent_homephone'      :parent_homephone,   
                    'parent_job'            :parent_job,   
                    'parent_address'        :parent_address,   
                    '_token'                :token
                },
                success:function(record){
                   if(record.isSuccess == 1){
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                        var button="";
                        button = "<a href='/admin/manage-user/student/edit/"+record.id+"'><i class='glyphicon glyphicon-edit'></i></a>"
                        $('#student_table').dataTable().fnAddData([
                            record.id,
                            record.user.firstname+" "+record.user.middlename+" "+record.user.lastname,
                            record.user.email,
                            record.enrolled_year,
                            record.graduated_year,
                            record.parent.user.firstname+" "+record.parent.user.middlename+" "+record.parent.user.lastname,
                            student_dateofbirth,
                            record.user.address,
                            record.user.role,
                            button
                        ]);
                   }
                   else{
                        $('.error_mess').show("medium");
                        $('.error_mess').empty();
                        $.each(record, function(i, item){
                        $('#'+i).parent().addClass('has-warning');
                        $('#'+i+"_error").css("display","block").append("<i class='icon fa fa-warning'></i> "+item);
                    }); 
                   }
                },
                error:function(){
                    alert("Something went wrong ! Please Contact Your Super Admin");
                }
            });
        });


        $('#student_search').click(function(){
            var from_year = $('#from_year').val();
            var to_year = $('#to_year').val();
            var firstname = $('#firstname').val();
            var middlename = $('#middlename').val();
            var lastname = $('#lastname').val();
            var token = $('input[name="_token"]').val();

           $.ajax({
                url     :"<?= URL::to('/admin/manage-user/student/show') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'from_year'     :from_year,
                    'to_year'       :to_year,
                    'firstname'      :firstname,
                    'middlename'      :middlename,
                    'lastname'      :lastname,
                    '_token'        :token
                },
                success:function(record){
                    console.log(record);
                   if(record.isSuccess == 1){
                        $('#to_year').parent().removeClass('has-warning');
                        $('#from_year').parent().removeClass('has-warning');
                        $('#from_to_warning').slideUp('medium');
                        $('#student_table').dataTable().fnClearTable();
                        var button="";
                        var mydateofbirth,formattedDate,d,m,y;
                        $.each(record.mydata, function(i, row){
                            button = "<a href='/admin/manage-user/student/edit/"+row.id+"'><i class='glyphicon glyphicon-edit'></i></a>";
                            if(row.dateofbirth != "0000-00-00"){
                                formattedDate = new Date(row.dateofbirth);
                                d = formattedDate.getDate();
                                m =  formattedDate.getMonth();
                                m += 1;  // JavaScript months are 0-11
                                y = formattedDate.getFullYear();
                                mydateofbirth = (d + "/" + m + "/" + y);        
                            }
                            else{
                                mydateofbirth = "N/A";
                            }
                            
                            $('#student_table').dataTable().fnAddData([
                                row.id,
                                row.firstname+" "+row.middlename+" "+row.lastname,
                                row.email,
                                row.student.enrolled_year,
                                row.student.graduated_year,
                                row.student.parent.user.firstname+" "+row.student.parent.user.middlename+" "+row.student.parent.user.lastname,
                                mydateofbirth,
                                row.address,
                                row.role,
                                button
                            ]);
                        });
                   }
                   else{
                      $('#to_year').parent().addClass('has-warning');
                      $('#from_year').parent().addClass('has-warning');
                      $('#from_to_warning').show('medium');
                   }
                },
                error:function(){
                    alert("Something went wrong ! Please Contact Your Super Admin");
                }
            });
        });
    });
});
    
</script>
@endsection