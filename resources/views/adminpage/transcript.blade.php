@extends('mytemplate.blankpage_ad')
@section('content')
<?php use App\Transcript; ?>

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

<div class="col-xs-8 col-lg-8">
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
                            <th> Subject </th>
                            <?php $type = Transcript::select('type')->distinct()->orderBy('type', 'asc')
                                                                        // ->orderByRaw("CASE
                                                                        // WHEN type = 15 phút lần 1 THEN 1
                                                                        // WHEN type = 15 phút lần 2 THEN 2
                                                                        // WHEN type = 1 tiết lần 1 THEN 3
                                                                        // WHEN type = Thi giữa kì THEN 4
                                                                        // WHEN type = 15 phút lần 3 THEN 5
                                                                        // WHEN type = 15 phút lần 4 THEN 6
                                                                        // WHEN type = 1 tiết lần 2 THEN 7
                                                                        // WHEN type = Thi cuối kì THEN 8 END ASC, created_at ASC")
                                                                        ->get();
                            foreach ($type as $value) { ?>
                            <th> {{$value->type}} </th>
                            <?php } ?>
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

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#sidebar_list_6').addClass('active');
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

                        $.each(record.mydata, function(i, row){
                            // var monhoc = "<b>" + row[0] + "</b>";
                            $('#transcript_table').dataTable().fnAddData([
                               // monhoc,
                               row[0],
                               row[1],
                               row[2],
                               row[3],
                               row[4],
                               row[5],
                               row[6],
                               row[7],
                               row[8],
                               row[9],

                            ]);
                         });
                    },
                    // error:function(){
                    //     alert("Something went wrong ! Please Contact Your Super Admin");
                    //}
                });
            }   
            
        });
    });

    
</script> 

@endsection