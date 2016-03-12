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
        <small>Edit subject</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="editsubject"><i class="active"></i>Edit Subject</a></li>
    </ol>
</section>
<section class="content">
<div class="box box-solid box-primary" style="collapsed=false">
    <div class="box-header">
        <h3 class="box-title">Edit Subject Information</h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>                                 
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
    <form id="edit_form">
         {!! csrf_field() !!}
        <div style class="box-body">
            <div id="error_mess" style = "display: none" class="alert alert-warning alert-dismissable">
                <h4></h4>        
            </div>
             <div id="success_mess" style = "display: none" class="alert alert-success">
                <h4><i class="icon fa fa-check"></i>Success Add New Subject</h4>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" name="id_show" id="id_show" value="{{$record['subject']['id']}}" disabled>
                        <input style="display: none" type="text" class="form-control" name="id" id="id" value="{{$record['subject']['id']}}">
                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control" name="subject_name" id="subject_name" value="{{$record['subject']['subject_name']}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="total_time">Total Time</label>
                        <input type="text" class="form-control" name="total_time" id="total_time" value="{{$record['subject']['total_time']}}">
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
        <div style class="box-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
    </div>
</div><!-- /.box -->
<div class="box box-solid box-primary">
     <div class="box-header">
        <h3 class="box-title">Edit Subject Score List</h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>                              
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <div style class="box-body">
            <div class="row">
                <!-- half left -->
                <div class="col-lg-4 col-xs-12">
                    <div class="box box-primary">
                        <form id="score_list_form">
                            {!! csrf_field() !!}
                            <div style class="box-body">
                                <div class="form-group">
                                    <label for="score_type">Score Type</label>
                                    <label id="score_type_error" for="score_type" style="display:none">Score type is required and may not be greater than 40 characters</label>
                                    <label id="my_score_type_error" for="score_type" style="display:none">Score type cannot have more than 40character and not containt ' or "</label>
                                    <input type="text" class="form-control" name="score_type" id="score_type" data-mask/>          
                                </div>
                                <div class="form-group">
                                    <label for="factor">Factor</label>
                                    <select id="factor" name="factor" class="form-control">
                                        <option value='1' selected>1</option>
                                        <option value='2' >2</option>
                                        <option value='3' >3</option>
                                        <option value='4' >4</option>
                                        <option value='5' >5</option>
                                        <option value='6' >6</option>
                                        <option value='7' >7</option>
                                        <option value='8' >8</option>
                                        <option value='9' >9</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="month">Month</label>
                                    <select id="month" name="month" class="form-control">
                                        <?php
                                            $month = date("m");
                                            for($i=8;$i<=12;$i++){
                                                if($i == $month){
                                                    $selected = "selected";
                                                }
                                                else{
                                                    $selected = "";
                                                }
                                                echo ("<option ".$selected.">".$i."</option>");
                                            }
                                            for($i=1;$i<=5;$i++){
                                                if($i == $month){
                                                    $selected = "selected";
                                                }
                                                else{
                                                    $selected = "";
                                                }
                                                echo ("<option ".$selected.">".$i."</option>");
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="applyfrom">Apply From</label>
                                    <select id="applyfrom" name="applyfrom" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            $month = date("M");
                                            if($month <= 8){
                                                $year = $year - 1;
                                            }
                                            for($i=$year;$i<=$year+2;$i++){
                                                echo ("<option value='".substr($i, 2)."' >".$i."</option>");
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /.box-body -->
                            <div style class="box-footer">
                                <button type="submit" class="btn btn-primary btn-block">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- half right -->
                <div class="col-lg-8 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <table id="score_type_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</td>
                                        <th>Type</th>
                                        <th>Factor</th>
                                        <th>Month</th>
                                        <th>Apply From</th>
                                        <th>Disable From</th>
                                    </tr>
                                </thead>
                                <tbody class="displayrecord">
                                    <?php foreach ($record['score_type'] as $row) :?>
                                        <tr>
                                            <td> <?php echo $row->id ?></td>
                                            <td> <?php echo $row->type ?></td>
                                            <td> <?php echo $row->factor ?></td>
                                            <td> <?php echo $row->month ?></td>
                                            <td> <?php echo ($row->applyfrom < 10 ? '200' : '20').$row->applyfrom  ?></td>
                                            <td> 
                                                <?php 
                                                    $disablefrom = ($row->disablefrom < 10 ? '200' : '20');
                                                    if($row->disablefrom == 3000){
                                                        echo "Enable";
                                                    }
                                                    else{
                                                        echo $disablefrom.$row->disablefrom;
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="editModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Score Type</h4>
            </div>
            <form id="modal_form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control" name="subject_name" id="subject_name" value="{{$record['subject']['subject_name']}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="modal_score_type">Score Type</label>
                        <label id="modal_score_type_error" for="modal_score_type" style="display:none">Score type is required and may not be greater than 40 characters</label>
                        <input type="text" class="form-control" name="modal_score_type" id="modal_score_type">
                        <input type="hidden" class="form-control" name="modal_score_type" id="modal_old_score_type">
                        <input type="hidden" class="form-control" name="modal_scoretype_id" id="modal_scoretype_id">          
                    </div>
                    <div class="form-group">
                        <label for="modal_factor">factor</label>
                        <select id="modal_factor" name="modal_factor" class="form-control">
                            <option value='1' selected>1</option>
                            <option value='2' >2</option>
                            <option value='3' >3</option>
                            <option value='4' >4</option>
                            <option value='5' >5</option>
                            <option value='6' >6</option>
                            <option value='7' >7</option>
                            <option value='8' >8</option>
                            <option value='9' >9</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modal_month">Month</label>
                        <select id="modal_month" name="modal_month" class="form-control">
                            <?php
                                $month = date("m");
                                for($i=8;$i<=12;$i++){
                                    if($i == $month){
                                        $selected = "selected";
                                    }
                                    else{
                                        $selected = "";
                                    }
                                    echo ("<option ".$selected.">".$i."</option>");
                                }
                                for($i=1;$i<=5;$i++){
                                    if($i == $month){
                                        $selected = "selected";
                                    }
                                    else{
                                        $selected = "";
                                    }
                                    echo ("<option ".$selected.">".$i."</option>");
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modal_applyfrom">Apply From</label>
                        <input type="text" class="form-control" id="modal_applyfrom" name="modal_applyfrom" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="modal_edit" type="button" class="btn btn-primary btn-info btn-block">Edit</button>
                    <button id="modal_disable" type="button" class="btn btn-primary btn-danger btn-block">Disable</button>
                    <button type="button" class="btn btn-primary btn-block pull-right" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
</div>
</section><!-- DATA TABES SCRIPT -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
    $(function() {
        $('#score_type_table').dataTable({
            "scrollCollapse": true,
            "scrollY" : "450px",
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "order": [[ 2, "desc" ],[1, "asc"]],
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "columns": [
                { "width": "0%", "visible":false },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" }
            ]
        });
        $('#score_type').on('input',function(){
            var data = $(this).val();
            var count = data.length;
            if(count > 40 || (data.search('\'') >= 0) || (data.search('\"') >= 0)){
                $('#my_score_type_error').parent().addClass('has-warning');
                $('#my_score_type_error').css("display","block");
            }
            else{
                $('#my_score_type_error').parent().removeClass('has-warning');
                $('#my_score_type_error').css("display","none");
            }
        });
        $('#edit_form').on('submit',function(e){
            e.preventDefault();
            var subject_id     = $('#id').val();
            var subject_name   = $('#subject_name').val();
            var total_time  = $('#total_time').val();
            var token       = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('admin/editsubject') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'id'              : subject_id,
                    'subject_name'    :subject_name,
                    'total_time'      :total_time,
                    '_token'        :token
                },
                success:function(record){
                    if(record.isDone == 1){
                        $('#error_mess').slideUp('slow');
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                    }
                    else{
                        $('#error_mess').show("medium");
                        $('#error_mess').empty();
                        $.each(record, function(i, item){
                          $('#error_mess').append("<h4><i class='icon fa fa-warning'></i>"+item+"</h4>");
                        });
                    }
                }
            });
        });

        $('#score_list_form').on('submit',function(e){
            e.preventDefault();
            $('#score_type_error').parent().removeClass('has-warning');
            $('#score_type_error').css("display","none");
            $('#score_type_error').empty();
            var score_type = $('#score_type').val();
            var factor     = $('#factor').val();
            var subject_id = $('#id').val();
            var month      = $('#month').val();
            var applyfrom  = $('#applyfrom').val();
            var token      = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('admin/editsubject/add_type') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'score_type'      : score_type,
                    'factor'          :factor,
                    'subject_id'      :subject_id,
                    'month'           :month,
                    'applyfrom'       :applyfrom,
                    '_token'        :token
                },
                success:function(record){
                    if(record.isDone == 1){
                        $('#score_type_table').dataTable().fnAddData( [
                            record.data.id,
                            score_type,
                            factor,
                            month,
                            '20'+applyfrom,
                            "Enable",
                        ]);
                    }
                    else{
                        $('#score_type_error').parent().addClass('has-warning');
                        $('#score_type_error').css("display","block");
                        $('#score_type_error').append("<i class='icon fa fa-warning'></i> "+record.score_type);
                    }
                }
            });
        });

        var selected_row_index;
        $('#score_type_table tbody').on( 'click', 'tr', function () {
            $('#score_type_table').dataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            selected_row_index = $('#score_type_table').dataTable().fnGetPosition(this);
            if( $('#score_type_table').dataTable().fnGetData(this) != null){
                var scoretype_id = $('#score_type_table').dataTable().fnGetData(this)[0];
                var score_type = $('#score_type_table').dataTable().fnGetData(this)[1];
                var factor = $('#score_type_table').dataTable().fnGetData(this)[2];
                var month = $('#score_type_table').dataTable().fnGetData(this)[3];
                var year = $('#score_type_table').dataTable().fnGetData(this)[4];
                var disablefrom = $('#score_type_table').dataTable().fnGetData(this)[5];
                $('#modal_scoretype_id').val(scoretype_id);
                $('#modal_score_type').val(score_type);
                $('#modal_old_score_type').val(score_type);
                $('#modal_factor').val(factor);
                $('#modal_month').val(month);
                $('#modal_applyfrom').val(year);
                $('#editModal').modal('show');
                if(disablefrom != "Enable"){
                    $('#modal_disable').empty();
                    $('#modal_disable').append('Disable From '+disablefrom);
                    $('#modal_disable').prop('disabled', true);
                    $('#modal_edit').prop('disabled', true);
                }
                else{
                    $('#modal_disable').empty();
                    $('#modal_disable').append('Disable');
                    $('#modal_disable').prop('disabled', false);
                    $('#modal_edit').prop('disabled', false);
                }
            }
            else{   
                //do nothing
            }          
        });

        $('#modal_edit').on('click',function(){
            $('#modal_score_type_error').parent().removeClass('has-warning');
            $('#modal_score_type_error').css("display","none");
            $('#modal_score_type_error').empty();
            var subject_id = $('#id').val();
            var scoretype_id = $('#modal_scoretype_id').val();
            var score_type = $('#modal_score_type').val();
            var old_score_type = $('#modal_old_score_type').val();
            var factor     = $('#modal_factor').val();
            var month      = $('#modal_month').val();
            var token      = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('admin/editsubject/edit_type') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'scoretype_id'  : scoretype_id,
                    'score_type'    : score_type,
                    'factor'        :factor,
                    'subject_id'    :subject_id,
                    'old_score_type':old_score_type,
                    'month'         :month,
                    '_token'        :token
                },
                success:function(record){
                    if(record.isDone == 1){
                        $('#editModal').modal('hide');
                        $('#score_type_table').dataTable().fnUpdate( score_type, selected_row_index, 1 );
                        $('#score_type_table').dataTable().fnUpdate( factor, selected_row_index, 2 );
                        $('#score_type_table').dataTable().fnUpdate( month, selected_row_index, 3 );
                    }
                    else{
                        $('#modal_score_type_error').parent().addClass('has-warning');
                        $('#modal_score_type_error').css("display","block");
                        $('#modal_score_type_error').append("<i class='icon fa fa-warning'></i> "+record.score_type);
                    }
                }
            });              
        });

        $('#modal_disable').on('click',function(){
            var scoretype_id = $('#modal_scoretype_id').val();
            var token      = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('admin/editsubject/disable_scoretype') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'scoretype_id'    : scoretype_id,
                    '_token'        :token
                },
                success:function(record){
                    console.log(record);
                    $('#editModal').modal('hide');
                    $('#score_type_table').dataTable().fnUpdate( '20'+record.year, selected_row_index, 5 );
                }
            });              
        });
    });
</script>

@endsection