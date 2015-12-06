@extends('mytemplate.newblankpage')
@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
</style>
<section class="content-header">
    <h1>
        Admin
        <small>Transcript</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="schedule"><i class="active"></i>Create Transcript</a></li>
    </ol>
</section>
<section class="content">
<div class="col-xs-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Select Class</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
            <!-- form start -->
                <form method="POST">
                 {!! csrf_field() !!}
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-lg-3 col-xs-7">
                            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                            <label for="scholastic">Scholastic</label>
                            <select id="scholastic" name="scholastic" class="form-control">
                                <option value="-1" selected>-- Select --</option>;
                                <?php
                                    $year = date("Y") + 2;
                                    for($year;$year >=2010 ;$year--){
                                        echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                                    }
                                ?>
                                <option value="0">-- All --</option>;
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-xs-7">
                            <label for="grade">Grade</label>
                            <select id="grade" name="grade" class="form-control">
                                <option value="-1" selected>-- Select --</option>;                                            
                                <option>6</option>;
                                <option>7</option>;
                                <option>8</option>;
                                <option>9</option>;
                                <option value="0">-- All --</option>;
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-xs-7">
                            <label for="classname">Class Name</label>
                            <select id="classname" name="classname" class="form-control">
                                <option value="-1" selected>Select Scholastic First</option>;
                            </select> 
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button id="getstudent" type="button" class="btn btn-primary">Get Student List</button>
                </div>
                </form>
            </div><!-- /.box -->
        </div>
</section>
<section class="content">
    <div class="row">
<div class="col-xs-4">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Student List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>                                    
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="student_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:70px">Student ID</th>
                            <th>Fullname</th>
                        </tr>
                    </thead>

                    <tbody class="displayrecord">
                        <?php
                            // for($i=1;$i<=10;$i++){
                            //     $string = "<tr> <td><b>Tiết ".$i."</b></td>";
                            //     for($j=1;$j<=5;$j++){
                            //         $string .= "<td>".$schedulelist[$i][$j]."</td>";
                            //     }
                            //     $string .= "</tr>";
                            //     echo $string;
                            // }
                         ?>
                    </tbody>
                    </table>
        </div>
    </div><!-- /.box -->
</div>

<div class="col-xs-8 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Transcript</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive">
                    <table id="transcript_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:25px"></th>
                            <th>15 phút lần 1</th>
                            <th>15 phút lần 2</th>
                            <th>1 tiết</th>
                            <th>Thi giữa kì</th>
                            <th>1 tiết lần 2</th>
                            <th>Thi cuối kì</th>
                        </tr>
                    </thead>

                    <tbody class="displayrecord">
                        <?php
                            // for($i=1;$i<=10;$i++){
                            //     $string = "<tr> <td><b>Tiết ".$i."</b></td>";
                            //     for($j=1;$j<=5;$j++){
                            //         $string .= "<td>".$schedulelist[$i][$j]."</td>";
                            //     }
                            //     $string .= "</tr>";
                            //     echo $string;
                            // }
                         ?>
                    </tbody>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- DATA TABES SCRIPT -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function()
    {
        $(function() {
            //$('#student_table_filter').css("float","left");
            
            $('#student_table').dataTable(
            {

                "bSort" : false,
                "bLengthChange": false,
                "bInfo": false,
                //"bFilter": false,
                "bPaginate": false
            });
        });
        $(function() {
            $('#transcript_table').dataTable(
            {
                "bSort" : false,
                "bLengthChange": false,
                "bInfo": false,
                "bFilter": false,
                "bPaginate": false
            });
        });
        $( "#scholastic" ).change(function() {
            if($('#scholastic').val() != -1){
                updateClassname();
                $("#scholastic option[value='-1']").remove();
            }
            else{
                // do nothing
            }
        });
        $( "#grade" ).change(function() {
            if($('#grade').val() != -1){
                updateClassname();
                $("#grade option[value='-1']").remove();
            }
            else{
                // do nothing
            }
        });

        function updateClassname(){
            var scholastic      = $('#scholastic').val();
            var grade           = $('#grade').val();
            var group           = $('#group').val();
            var token           = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('/admin/class/studentclassinfo/updateclassname') ?>",
                type    :"POST",
                async   :false,
                data    :{
                        'scholastic'    :scholastic,
                        'grade'         :grade,
                        'group'         :group,
                        '_token'        :token
                        },
                success:function(record)
                {
                    $("#classname").empty();
                    if(record.count > 0){
                        $('#classname').append("<option value='-1' selected>-- Select --</option>");
                        $count = 1;
                        $.each(record.data, function(i, row){
                            $('#classname').append("<option value=" + $count +">"+row.id+"  |  "+row.classname+"</option>");
                            $count++;
                        });
                        $('#classname').append("<option value='0'>-- All --</option>");
                    }
                    else{
                        $('#classname').append("<option value='-1'>No Record</option>");
                    }
                    
                },
                error:function()
                {
                    alert("something went wrong, contact master admin to fix");
                }
            });
        }

     $('#getstudent').click(function()
     {
            var classname = $('#classname option:selected').text().substr(0,8);
            var token = $('input[name="_token"]').val();

           $.ajax({
                url     :"<?= URL::to('/admin/transcript/getstudent') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'classname'     :classname,
                    '_token'        :token
                },
                success:function(record)
                {
                    console.log(record);
                    if(record.isSuccess == 1)
                    {
                        $('#student_table').dataTable().fnClearTable();
        
                        $.each(record.mydata, function(i, row)
                        {
                            $('#student_table').dataTable().fnAddData([
                                row[2],
                                row[1],
                            ]);
                        });
                    }
                }
            });
        });

    $('#student_table tbody').on('click', 'tr', function() {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('#student_table').dataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');          
            }

            if( $('#student_table').dataTable().fnGetData(this) != null){
                $('#empty_mess').slideUp('medium');
                var token = $('input[name="_token"]').val();
                $.ajax({
                    url     :"<?= URL::to('/admin/transcript/gettranscript') ?>",
                    type    :"POST",
                    async   :false,
                    data    :{
                        'id'     :$('#student_table').dataTable().fnGetData(this)[0],
                        '_token'        : token
                    },
                    success:function(record){
                        console.log(record);
                        
                        $('#transcript_table').dataTable().fnClearTable();

                        $.each(record.student, function(i, row){
                            
                            $('#transcript_table').dataTable().fnAddData([
                               
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
    });

    
</script> 

@endsection