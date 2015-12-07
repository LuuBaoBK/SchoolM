@extends('mytemplate.blankpage_ad')
@section('content')

<?php use App\Model\Subject; ?>
<?php use App\Model\Classes; ?>

<section class="content-header">
    <h1>
        Admin
        <small>View Schedule</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active"><a href="/admin/schedule">View Schedule</a></li>
    </ol>
</section>

<section class="content">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-3">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Class List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
            <!-- form start -->
                <form method="POST">
                 {!! csrf_field() !!}
                <div class="box-body">
                    <div class="form-group">
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
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <select id="grade" name="grade" class="form-control">
                            <option value="-1" selected>-- Select --</option>;                                            
                            <option>6</option>;
                            <option>7</option>;
                            <option>8</option>;
                            <option>9</option>;
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="classname">Class Name</label>
                        <select id="classname" name="classname" class="form-control">
                            <option value="-1" selected>Select Scholastic First</option>;
                        </select> 
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button id="getschedule" type="button" class="btn btn-primary">Get Schedule</button>
                </div>
                </form>
            </div><!-- /.box -->
        </div>

        <div class="col-xs-9 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Schedule</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive">
                    <table id="schedule_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:25px"></th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
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
<!-- /.box -->
</section><!-- DATA TABES SCRIPT -->

<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $('#schedule_table').dataTable(
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
            success:function(record){
                $("#classname").empty();
                if(record.count > 0){
                    $('#classname').append("<option value='-1' selected>-- Select --</option>");
                    $count = 1;
                    $.each(record.data, function(i, row){
                        $('#classname').append("<option value=" + $count +">"+row.id+"  |  "+row.classname+"</option>");
                        $count++;
                    });
                    //$('#classname').append("<option value='0'>-- All --</option>");
                }
                else{
                    $('#classname').append("<option value='-1'>No Record</option>");
                }
                
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }

    $('#getschedule').click(function(){
            var classname = $('#classname option:selected').text().substr(0,8);
            var token = $('input[name="_token"]').val();

           $.ajax({
                url     :"<?= URL::to('/admin/schedule/getschedule') ?>",
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
                        $('#schedule_table').dataTable().fnClearTable();
        
                        $count = 1;
                        $.each(record.mydata, function(i, row)
                        {
                            var tiet = "<b>Tiết " + $count + "</b>";
                            $('#schedule_table').dataTable().fnAddData([
                                tiet,
                                row[1],
                                row[2],
                                row[3],
                                row[4],
                                row[5],
                            ]);
                            $count++;
                        });
                    }
                }
            });
        });
    });
</script>                           
@endsection