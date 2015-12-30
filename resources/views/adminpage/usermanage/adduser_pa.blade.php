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
        <div class="box-body">
            <!-- <form action ="/admin/manage-user/parent/show" method="POST" id="parent_filter"> -->
            <form id="parent_filter">    
                <div id="from_to_warning" style="display: none"class="alert alert-warning">
                    <i class="icon fa fa-warning"></i>From_Year can not be greater than To_Year
                </div>
                <div class="row">
                    <div class="form-group col-lg-4 col-xs-6">
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
                    <div class="form-group col-lg-4 col-xs-6">
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
                    <div class="form-group col-lg-4 col-xs-7">
                        <label for="search_firstname">First Name</label>
                        <input id="search_firstname" type="text" class="form-control" name="search_firstname" id="search_firstname" placeholder="Parent First Name">
                    </div>
                    <div class="form-group col-lg-4 col-xs-7">
                        <label for="search_middlename">Middle Name</label>
                        <input id="search_middlename" type="text" class="form-control" name="search_middlename" id="search_middlename" placeholder="Parent Middle Name">
                    </div>
                    <div class="form-group col-lg-4 col-xs-7">
                        <label for="search_lastname">Last Name</label>
                        <input id="search_lastname" type="text" class="form-control" name="search_lastname" id="search_lastname" placeholder="Parent Last Name">
                    </div>        
                </div>                                    
                            
                <p>(* Search Parents Of Students Enrolled In Selected Range With Given Name )</p>                        
                <div class="box-footer">
                    <button id ="parent_search" type="button" class="btn btn-primary btn-flatt">Search</button>
                </div>
            </form>                            
        </div> <!-- /.box left body -->  
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
                                <input type="text" class="form-control" name="id" id="id"  disabled>
                                <input type="hidden" class="form-control" name="id" id="id">
                            </div>
                            <div class="col-lg-8">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email"  disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="firstname">First Name</label>
                                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" >
                                <label class="info_error_mess" id="firstname_error" style="display:none" for="firstname"></label>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="middlename">Middle Name</label>
                                <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" >
                                <label class="info_error_mess" id="middlename_error" style="display:none" for="middlename"></label>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" >
                                <label class="info_error_mess" id="lastname_error" style="display:none" for="lastname"></label>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="mobilephone">Mobile Phone</label>
                                <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone">
                                <label class="info_error_mess" id="mobilephone_error" style="display:none" for="mobilephone"></label>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="homephone">Home Phone</label>
                                <input type="text" class="form-control" name="homephone" id="homephone" placeholder="Mobile Phone">
                                <label class="info_error_mess" id="homephone_error" style="display:none" for="homephone"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="dateofbirth">Date Of Birth</label>
                                <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                <label class="info_error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
                            </div>
                            <div class="form-group col-lg-8">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Address">
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
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Enrolled Year</th>
                            <th>Graduated Year</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="children_table_info">
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Enrolled Year</th>
                            <th>Graduated Year</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </tfoot>
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
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();

        $('#parent_search').click(function(){
            var from_year           = $('#from_year').val();
            var to_year             = $('#to_year').val();
            var search_firstname    = $('#search_firstname').val();
            var search_middlename   = $('#search_middlename').val();
            var search_lastname     = $('#search_lastname').val();
            var token       = $('input[name="_token"]').val();

           $.ajax({
                url     :"<?= URL::to('/admin/manage-user/parent/show') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'from_year'             :from_year,
                    'to_year'               :to_year,
                    'search_firstname'      :search_firstname,
                    'search_middlename'     :search_middlename,
                    'search_lastname'       :search_lastname,
                    '_token'                :token
                },
                success:function(record)
                {
                    if(record.isSuccess == 1){
                        $('#to_year').parent().removeClass('has-warning');
                        $('#from_year').parent().removeClass('has-warning');
                        $('#from_to_warning').slideUp('medium');
                        $('#parent_table').dataTable().fnClearTable();
                        var button="";
                        var mydateofbirth,formattedDate,d,m,y;
                        $.each(record.mydata, function(i, row){
                            $('#parent_table').dataTable().fnAddData([
                                row.id,
                                row.firstname+" "+row.middlename+" "+row.lastname,
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

                        var button_1="";
                        var children_dateofbirth,formattedDate,d,m,y;
                        $('#student_table').dataTable().fnClearTable();
                        $.each(record.student, function(i, row){
                            button_1 = "<a href='/admin/manage-user/student/edit/"+row.id+"'><i class='glyphicon glyphicon-edit'></i></a>";
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
                                row.id,
                                row.user.firstname+" "+row.user.middlename+" "+row.user.lastname,
                                row.user.email,
                                row.enrolled_year,
                                row.graduated_year,
                                children_dateofbirth,
                                row.user.address,
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
            var token       = $('input[name="_token"]').val();
            $(".form-group").removeClass("has-warning");
            $(".info_error_mess").empty();
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
                    '_token'        :token
                },
                success:function(record){
                    console.log(record);
                    if(record.isSuccess == 1){
                        $('#success_mess').show('medium');
                        setTimeout(function() {
                                $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                        $('#parent_table').dataTable().fnUpdate( firstname+" "+middlename+" "+lastname, selected_row_index, 1 );;
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