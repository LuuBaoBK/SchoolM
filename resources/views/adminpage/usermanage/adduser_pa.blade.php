    @extends('mytemplate.blankpage_ad')
@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
</style>
<section class="content-header">
    <h1>
        Admin
        <small>Parent Info</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Parent Info</li>
    </ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-5">
    <div class="box box-primary">
        <div class="box-header">
            <p class="box-title">Parent List</p>
        </div>
        <form id="parent_filter">  
            <div class="box-body">
                <!-- <form action ="/admin/manage-user/parent/show" method="POST" id="parent_filter"> -->
                    <div id="from_to_warning" style="display: none"class="alert alert-warning">
                        <i class="icon fa fa-warning"></i>From year can not be greater than To_Year
                    </div>                    
                    <div class="form-group col-lg-8 col-xs-8">
                        <label for="filter_fullname_parent">Parent Full Name</label>
                        <input id="filter_fullname_parent" type="text" class="form-control" name="filter_fullname_parent" id="filter_fullname_parent" placeholder="Parent First Name">
                    </div>
                    <div class="form-group col-lg-8 col-xs-8">
                        <label for="filter_fullname_student">Student Full Name</label>
                        <input id="filter_fullname_student" type="text" class="form-control" name="filter_fullname_student" id="filter_fullname_student" placeholder="Student Middle Name">
                    </div>                                    
                    <div class="form-group col-lg-8 col-xs-8">
                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                        <label for="filter_enrolled_year">Enrolled Year</label>
                        <select id="filter_enrolled_year" name="filter_enrolled_year" class="form-control">
                            <?php
                                $year = date("Y") + 2;
                                for($year;$year >=2010 ;$year--){
                                    echo "<option>".$year."</option>";
                                }
                                echo "<option value='0' selected>-- All --</option>";  
                            ?>
                        </select>                                       
                    </div>
                                        
            </div> <!-- /.box left body -->
            <div class="box-footer">
                        <button id ="parent_search" type="button" class="btn btn-primary btn-flatt">Search</button>
                    </div>   
        </form>     
        <div class="box-footer">
            <table id="parent_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                        </tr>
                    </thead>

                    <tbody class="displayrecord">
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                        </tr>
                    </tfoot>
                </table>          
        </div>             
    </div>
</div> <!-- /.half left -->
<div class="col-lg-7">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#info" data-toggle="tab">Personal Info</a></li>
          <li><a href="#children" data-toggle="tab">Children</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="info">       
                <form id="pa_info_form" method="POST" role="form">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <div id="success_mess" style = "display: none" class="alert alert-success">
                            <h4><i class="icon fa fa-check"></i>Success edit parent info</h4>
                        </div>
                        <div id="empty_mess" style = "display: none" class="alert alert-warning">
                            <h4><i class="icon fa fa-check"></i>Please Select Parent From Left Table First</h4>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label for="id">Id</label>
                                <input type="text" class="form-control" name="id" id="id" readonly value={{$parent['id']}}>
                                <input type="hidden" class="form-control" name="id" id="id">
                            </div>
                            <div class="col-lg-8">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" readonly value={{$parent['email']}} >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="firstname">First Name</label>
                                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value={{$parent['firstname']}} >
                                <label class="info_error_mess" id="firstname_error" style="display:none" for="firstname"></label>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="middlename">Middle Name</label>
                                <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" value={{$parent['middlename']}} >
                                <label class="info_error_mess" id="middlename_error" style="display:none" for="middlename"></label>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value={{$parent['lastname']}} >
                                <label class="info_error_mess" id="lastname_error" style="display:none" for="lastname"></label>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="dateofbirth">Date Of Birth</label>
                                <input type="text" id="dateofbirth" name="dateofbirth" class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/ value={{$parent['dateofbirth']}} >
                                <label class="info_error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
                            </div>
                            <div class="col-lg-4">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>          
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="mobilephone">Mobile Phone</label>
                                <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone" value={{$parent['mobilephone']}}>
                                <label class="info_error_mess" id="mobilephone_error" style="display:none" for="mobilephone"></label>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="homephone">Home Phone</label>
                                <input type="text" class="form-control" name="homephone" id="homephone" placeholder="Mobile Phone" value={{$parent['homephone']}}>
                                <label class="info_error_mess" id="homephone_error" style="display:none" for="homephone"></label>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-lg-8">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value={{$parent['address']}}>
                                <label class="info_error_mess" id="address_error" style="display:none" for="address"></label>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                            <button id ="pa_info_form_submit" type="button" class="btn btn-primary">Edit</button>
                            <button id ="reset_password" type="button" class="btn btn-warning">Reset Password</button>                        
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="children">
                <table id="student_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Enrolled Year</th>
                            <th>Graduated Year</th>
                            <th>Date Of Birth</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="children_table_info">
                        <?php foreach ($parent['studentlist'] as $row) :?>
                            <tr>
                                <td> <?php echo $row->user->fullname ?></td>
                                <td> <?php echo $row->user->email ?></td>
                                <td> <?php echo $row->enrolled_year ?></td>
                                <td> <?php echo $row->graduated_year ?></td>
                                <td> <?php 
                                    $dateofbirth = $row->user->dateofbirth;
                                    if($dateofbirth != "0000-00-00"){
                                        $dateofbirth = date_create($row->user->dateofbirth);
                                        $dateofbirth = date_format($dateofbirth,"d/m/Y");
                                    }
                                    else{
                                       $dateofbirth = "";
                                    }
                                    echo $dateofbirth;
                                ?></td>
                                <td>
                                    <?php
                                    if($row->user->id == Auth::user()->id){
                                        echo ("<a href='/admin/dashboard'><i class = 'glyphicon glyphicon-edit'></i></a>");
                                    }
                                    else{
                                        echo ("<a href='/admin/manage-user/admin/edit/$row->id'><i class = 'glyphicon glyphicon-edit'></i></a>");  
                                    }?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
  <!-- /.nav-tabs-custom -->
</div> <!-- </.half right>  -->
</div> <!-- /.row -->
</section>
<div id="confirmModal" class="modal modal-warning">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Reset Password</h4>
        </div>
        <div class="modal-body">
            <p>Please Confirm That You Want To Reset Password Of This Admin</p>
        </div>
        <div class="modal-footer">
            <button id="confirm_button" type="button" class="btn btn-warning pull-right">Confirm</button>
            <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
        </div>
    </div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- DATA TABES SCRIPT -->
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
$(document).ready(function() {
    $(function() {
        var selected_row_index;
        $('#sidebar_list_2').addClass('active');
        $('#sidebar_list_2_4').addClass('active');
        $('#parent_table').dataTable({
            "columns": [
                        { "width": "20%" },
                        { "width": "70%" },
                      ],
            "bLengthChange" : false
        });
        $('#student_table').dataTable({
            "lengthChange": false,
            "searching": false,
            "ordering": false,
        });
        $("[data-mask]").inputmask();

        $('#parent_search').click(function(){
            var filter_fullname_student = $('#filter_fullname_student').val();
            var filter_fullname_parent   = $('#filter_fullname_parent').val();
            var filter_enrolled_year   = $('#filter_enrolled_year').val();
            var token       = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('/admin/manage-user/parent/show') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'filter_enrolled_year'             :filter_enrolled_year,
                    'filter_fullname_parent'      :filter_fullname_parent,
                    'filter_fullname_student'     :filter_fullname_student,
                    '_token'                :token
                },
                success:function(record)
                {
                    $('#parent_table').dataTable().fnClearTable();
                    var button="";
                    $.each(record.mydata, function(i, row){
                        $('#parent_table').dataTable().fnAddData([
                            row.id,
                            row.fullname
                        ]);
                    });
                },
                error:function(){
                    alert("Something went wrong ! Please Contact Your Super Admin");
                }
            });
        });

       $('#parent_table tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('#parent_table').dataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');          
            }
            selected_row_index = $('#parent_table').dataTable().fnGetPosition(this);
            if( $('#parent_table').dataTable().fnGetData(this) != null){
                $('#empty_mess').slideUp('medium');
                var token = $('input[name="_token"]').val();
                $.ajax({
                    url     :"<?= URL::to('/admin/manage-user/parent/getdata') ?>",
                    type    :"POST",
                    async   :false,
                    data    :{
                        'id'     :$('#parent_table').dataTable().fnGetData(this)[0],
                        '_token'        : token
                    },
                    success:function(record){
                        if(record.user.dateofbirth != "0000-00-00"){
                            formattedDate = new Date(record.user.dateofbirth);
                            d = formattedDate.getDate();
                            m =  formattedDate.getMonth();
                            m += 1;  // JavaScript months are 0-11
                            y = formattedDate.getFullYear();
                            mydateofbirth = (d + "/" + m + "/" + y);        
                        }
                        else{
                            mydateofbirth = "N/A";
                        }

                        $('#id').val(record.id);
                        $('#email').val(record.user.email);
                        $('#firstname').val(record.user.firstname);
                        $('#middlename').val(record.user.middlename);
                        $('#lastname').val(record.user.lastname);
                        $('#mobilephone').val(record.mobilephone);
                        $('#homephone').val(record.homephone);
                        $('#address').val(record.user.address);
                        $('#dateofbirth').val(mydateofbirth);
                        $("#gender").val(record.user.gender);

                        var button_1="";
                        var children_dateofbirth,formattedDate,d,m,y;
                        $('#student_table').dataTable().fnClearTable();
                        $.each(record.student, function(i, row){
                            button_1 = "<a href='/admin/manage-user/student/edit/"+row.id+"' target='_blank'><i class='glyphicon glyphicon-edit'></i></a>";
                            if(row.user.dateofbirth != "0000-00-00"){
                                formattedDate = new Date(row.user.dateofbirth);
                                d = formattedDate.getDate();
                                m =  formattedDate.getMonth();
                                m += 1;  // JavaScript months are 0-11
                                y = formattedDate.getFullYear();
                                children_dateofbirth = (d + "/" + m + "/" + y);        
                            }
                            else{
                                children_dateofbirth = "N/A";
                            }
                            
                            $('#student_table').dataTable().fnAddData([
                                row.user.fullname,
                                row.user.email,
                                row.enrolled_year,
                                row.graduated_year,
                                children_dateofbirth,
                                button_1
                            ]);
                        });
                    },
                    error:function(){
                        alert("Something went wrong ! Please Contact Your Super Admin");
                    }
                });
            }
            else{
                $('#id').val("");
                $('#email').val("");
                $('#firstname').val("");
                $('#middlename').val("");
                $('#lastname').val("");
                $('#mobilephone').val("");
                $('#homephone').val("");
                $('#address').val("");
                $('#dateofbirth').val("");
            }        
            
        });

        $('#pa_info_form_submit').click(function(){
            var id          = $('#id').val();
            var firstname   = $('#firstname').val();
            var middlename  = $('#middlename').val();
            var lastname    = $('#lastname').val();
            var mobilephone = $('#mobilephone').val();
            var homephone   = $('#homephone').val();
            var dateofbirth = $('#dateofbirth').val();
            var address     = $('#address').val();
            var gender      = $('#gender').val();
            var token       = $('input[name="_token"]').val();
            $(".form-group").removeClass("has-warning");
            $(".info_error_mess").empty();
            console.log("abc");
           $.ajax({
                url     :"<?= URL::to('/admin/manage-user/parent/edit') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'id'            :id,
                    'firstname'     :firstname,
                    'middlename'    :middlename,
                    'lastname'      :lastname,
                    'mobilephone'   :mobilephone,
                    'homephone'     :homephone,
                    'dateofbirth'   :dateofbirth,
                    'address'       :address,
                    'gender'        :gender,
                    '_token'        :token
                },
                success:function(record){
                    console.log(record);
                    if(record.isSuccess == 1){
                        $('#success_mess').show('medium');
                        setTimeout(function() {
                                $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                        $('#parent_table').dataTable().fnUpdate( firstname+" "+middlename+" "+lastname, selected_row_index, 1 );
                    }
                    else{
                        if(record.isSuccess == 0){
                            $('#empty_mess').show('medium');
                        }
                        else{
                            $('.info_error_mess').show("medium");
                            $('.info_error_mess').empty();
                            $.each(record, function(i, item){
                                $('#'+i).parent().addClass('has-warning');
                                $('#'+i+"_error").css("display","block").append("<i class='icon fa fa-warning'></i> "+item);
                            });
                        }
                    }
                },
                error:function(){
                    alert("Something went wrong ! Please Contact Your Super Admin");
                }
            });
        });

        $('#reset_password').click(function(){
            $('#confirmModal').modal('show');
        });

        $('#confirm_button').click(function(){
            $('#confirmModal').modal('hide');
            var id = $('#id').val();
            if(id != ""){
                window.open('/admin/manage-user/parent/edit/'+$('#id').val()+'/reset_password', '_blank');
            } 
        });

    });
});
</script>

@endsection