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
        <h3 class="box-title">Transcript General Setting</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div><!-- /.box-header -->
<!-- form start -->
    <form id="upload_form" name="upload_form" enctype="multipart/form-data">
     {!! csrf_field() !!}
    <div class="box-body">  
        <div class="row">
            <div class="form-group col-lg-4">
                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                <label for="scholastic">Scholastic</label>
                <select id="scholastic" name="scholastic" class="form-control">
                    <option value="-1" selected>-- Select --</option>;
                    <?php
                        $year = date("Y");
                        for($year;$year >=2010 ;$year--){
                            echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                        }
                    ?>
                    <option value="0">-- All --</option>;
                </select>
            </div>
            <div class="form-group col-lg-4">
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
        </div>
        <div class="row">
            <div class="form-group col-lg-8">
                <button id="get_class_list" type="button" class="btn btn-block btn-primary">Get Class List</button>
            </div>
        </div>
    </div><!-- /.box-body -->
    </form>
    <div class="box-footer">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Set Transcript Modify Time</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <b>Classes List</b>
                                    </div>
                                    <div class"box-body">
                                        <table id="class_list_table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <td>Id</td>
                                                    <td>Name</td>
                                                    <td>From</td>
                                                    <td>To</td>
                                                    <td>Type</td>
                                                </tr>
                                            </thead>
                                            <tbody id="class_list_table_body">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="box-footer">
                                        <button id="select_all" type="button" class="btn btn-block btn-primary">Select All</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <b>Setting Import Transcript Time</b>
                            </div>
                            <form>
                            <div class="box-body">
                                <div class="form-group col-lg-6">
                                    <label for="from_date">From Date</label>
                                    <div class="input-group">
                                        <div id="calendar_from_date" class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" name="from_date" id="from_date" placeholder="Select Date" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                    </div>
                                    <label class="error_mess" id="from_date_error" for="from_date"></label>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="to_date">To Date</label>
                                    <div class="input-group">
                                        <div id="calendar_to_date" class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" name="to_date" id="to_date" placeholder="Select Date" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>   
                                    </div>
                                    <label class="error_mess" id="to_date_error" for="to_date"></label>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="doable_type">Select Type</label>
                                    <select id="doable_type" name="doable_type" class="form-control">
                                        <option value="1" selected> HK 1 </option>;                                            
                                        <option value="2"> HK 2 </option>;
                                        <option value="3"> HK 1 & HK 2 </option>;
                                    </select>
                                </div>
                                <div class="form-group has-warning">
                                    <label id="result_message"></label>
                                    <button id="set_button" type="button" class="btn btn-block btn-primary">Set For Selected Class</button>
                                </div>
                            </div>
                            <div class="box-footer">
                                <!-- <label id="result_message"></label> -->
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div><!-- /.box -->
</section>

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>

<link rel="stylesheet" href="{{asset("/mylib/jquery-ui-custom/jquery-ui.css")}}">
<!-- page script -->
<script type="text/javascript">
$(document).ready(function()
{
    $( "#scholastic" ).change(function() {
        if($('#scholastic').val() != -1){
            $("#scholastic option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $( "#grade" ).change(function() {
        if($('#grade').val() != -1){
            $("#grade option[value='-1']").remove();
        }
        else{
            // do nothing
        }
    });
    $('#get_class_list').on('click',function(){
        updateClassname();
    });

    $('#class_list_table').dataTable({
        "scrollCollapse": true,
        "scrollY" : "550px",
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "order": [[ 1, "desc" ]],
        "columns": [
            { "width": "20%" },
            { "width": "20%" },
            { "width": "20%" },
            { "width": "20%" },
            { "width": "20%" }
        ],
    });

    $('#from_date').datepicker();
    $('#from_date').datepicker( "option", "dateFormat", 'dd/mm/yy' );
    $('#to_date').datepicker();
    $('#to_date').datepicker( "option", "dateFormat", 'dd/mm/yy' );
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    $("[data-mask]").inputmask();
    $('#calendar_from_date').click(function(){ $('#from_date').select();});
    $('#calendar_to_date').click(function(){ $('#to_date').select(); });

    $('#class_list_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $(this).addClass('selected');          
        }
    });
    $('#select_all').click(function(){
        var count = 0;
        $('#class_list_table tbody tr').each(function() {
            if( $(this).hasClass('selected') ){
                //do nothing
            }
            else{
                $(this).addClass('selected');
                count ++;
            }
        });
        if(count == 0){
            $('#class_list_table tr').each(function() {
                $(this).removeClass('selected');
            });
        }
    });

    $('#set_button').click(function(){
        //remove last state
        $('#from_date_error').parent().removeClass('has-warning');
        $('#to_date_error').parent().removeClass('has-warning');
        $('#from_date_error').empty();
        $('#to_date_error').empty();
        //start
        var to_date = $('#to_date').val();
        var from_date = $('#from_date').val();
        var class_list = [];
        var doable_type = $('#doable_type').val();
        var token      = $('input[name="_token"]').val();
        var count = 0;
        $('#result_message').empty();
        $('#class_list_table tr.selected td:first-child').each(function(i,j){
            if(j.innerHTML != "No data available in table"){
                class_list.push(j.innerHTML);
                count++;
            }
        });
        if(count == 0){
            $('#result_message').append('Please select some classes first to set import transcript time');
        }
        else{
            $.ajax({
                url     :"<?= URL::to('/admin/transcript/general/set_time') ?>",
                type    :"POST",
                async   :false,
                data    :{
                        'to_date'    :to_date,
                        'from_date'  :from_date,
                        'class_list' :class_list,
                        'doable_type':doable_type,
                        '_token'        :token
                        },
                success:function(record){
                    if(record.isSuccess == 1){
                        var temp_index;
                        $.each(record.data,function(i,j){
                            temp_index = $('#class_list_table').dataTable().fnFindCellRowIndexes(record.data[i]['id'],0);
                            $('#class_list_table').dataTable().fnUpdate( [j.id, j.classname, j.doable_from, j.doable_to, j.doable_type], temp_index ); // updating row
                        });
                    }
                    else{
                        $.each(record, function(i,item){
                            $('#'+i+'_error').parent().addClass('has-warning');
                            $('#'+i+'_error').append(item);
                        });
                    }
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        }
    });


    function updateClassname(){
        var scholastic      = $('#scholastic').val();
        var grade           = $('#grade').val();
        var token           = $('input[name="_token"]').val();
        if(scholastic != -1){
            $.ajax({
                url     :"<?= URL::to('/admin/transcript/general/updateclassname') ?>",
                type    :"POST",
                async   :false,
                data    :{
                        'scholastic'    :scholastic,
                        'grade'         :grade,
                        '_token'        :token
                        },
                success:function(record){
                    updateClassTable(record);
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        }
    }

    function updateClassTable(class_list){
        $('#class_list_table').dataTable().fnClearTable();
        $.each(class_list, function(i,item){
            $('#class_list_table').dataTable().fnAddData( [
                item.id,
                item.classname,
                item.doable_from,
                item.doable_to,
                item.doable_type
            ]);
        });
    }

    jQuery.fn.dataTableExt.oApi.fnFindCellRowIndexes = function ( oSettings, sSearch, iColumn )
    {
        var
            i,iLen, j, jLen, val,
            aOut = [], aData,
            columns = oSettings.aoColumns;

        for ( i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
        {
            aData = oSettings.aoData[i]._aData;

            if ( iColumn === undefined )
            {
                for ( j=0, jLen=columns.length ; j<jLen ; j++ )
                {
                    val = this.fnGetData(i, j);

                    if ( val == sSearch )
                    {
                        aOut.push( i );
                    }
                }
            }
            else if (this.fnGetData(i, iColumn) == sSearch )
            {
                aOut.push( i );
            }
        }

        return aOut;
    };  
});

</script> 

@endsection