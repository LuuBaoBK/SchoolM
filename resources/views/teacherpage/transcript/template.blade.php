@extends('mytemplate.blankpage_te')

@section('content')
<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
table tr.waiting{
    background-color: #CAF97A !important; 
}
table tr.missing{
    background-color: #FA6060 !important; 
}
table tr.one{
    background-color: #f9f9f9; 
}
table tr td i.glyphicon-import.enable{
    color: blue;
}
table tr td i.glyphicon-edit.enable{
    color: green;
}
</style>
<section class="content-header">
    <h1>
        Teacher
        <small>Transcript Template</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/teacher/dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
    </ol>
</section>
<section class="content">
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Import Transcript</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="form-group col-lg-6">
            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
            <label for="scholastic">Scholastic</label>
            <?php
                $year = date("Y");
                $month = date("m");
                if($month < 8){
                    $year = $year - 1;
                }
                echo ("<input class='form-control' type='text' id='scholastic_show' name='scholastic_show' value='".$year." - ".($year+1)."' disabled>");
                echo ("<input class='form-control' type='hidden' id='scholastic' name='scholastic' value='".substr($year,2)."' dioptionabled>");
            ?>
        </div>
        <div class="form-group col-lg-6">
            <label for="grade">Grade</label>
            <select id="grade" name="grade" class="form-control">
                <option value='all' selected>All</option>
                <?php
                    for($i=6; $i<=9; $i++){
                        if($i == $grade){
                            $selected = "selected";
                        }
                        else{
                            $selected = "";
                        }
                        echo ("<option value='".$i."' ".$selected." >".$i."</option>");
                    }
                ?>
            </select>
        </div>
        <div class="form-group col-lg-12">
            <button class="btn btn-primary btn-block" type="button" id="get_button" name="get_button">get</button>
        </div>
        <table id="class_list_table" class="table row-border">
            <thead>
                <tr>
                    <th rowspan="2">Class Name</th>
                    <th colspan="2">Import Detail</th>
                    <th colspan="5">Score Type Detail</th>
                </tr>
                <tr>
                    <th>Duration</th>
                    <th>Month</th>
                    <th>#</th>
                    <th>Score Type</th>
                    <th>Factor</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="class_list_table_tbody">
                <?php
                    foreach($class_list as $key => $value){
                        $row = "<tr class='".$value->addclass." ".($key%2 ? 'one' : 'two')."'>";
                        $row .= "<td>".$value->classname."<br><span class='pull-left'><a href='/teacher/transcript/download/".$value->id."' target='_blank'>Student List <i class='glyphicon glyphicon-download-alt' value='".$value->id."'></i></span></td>";
                        $row .= "<td>".$value->duration."</td>";
                        $row .= "<td>".$value->doable_month."</td>";
                        $row .= "<td> </td>";
                        $row .= "<td> </td>";
                        $row .= "<td> </td>";
                        $row .= "<td> </td>";
                        $row .= "<td> </td></tr>";
                        echo $row;
                        foreach ($value['score_type_list'] as $key2 => $scoretype) {
                            $badge_color = ($scoretype->status == "new" ? "bg-blue" : "bg-green");
                            $row = "<tr class='".$value->addclass." ".($key%2 ? 'one' : 'two')."'>";
                            $row .= "<td></td>";
                            $row .= "<td></td>";
                            $row .= "<td></td>";
                            $row .= "<td>".($key2+1)."</td>";
                            $row .= "<td>".$scoretype->type."</td>";
                            $row .= "<td>".$scoretype->factor."</td>";
                            $row .= "<td><span class='badge ".$badge_color."' my_value='".$value->classname."|".$value->id."|".$scoretype->type."|".$scoretype->id."'>".$scoretype->status."</span></td>";
                            if($value->addclass == "enable"){
                                
                                if($scoretype->status == "new"){
                                    $row .= "<td><a href='#'><i class='glyphicon glyphicon-import ".$value->addclass."' my_value='".$value->classname."|".$value->id."|".$scoretype->type."|".$scoretype->id."'> Import</i></td>";
                                }
                                else{
                                    $row .= "<td><a href='#'><i class='glyphicon glyphicon-edit ".$value->addclass."' my_value='".$value->classname."|".$value->id."|".$scoretype->type."|".$scoretype->id."'> Edit</i></td>";
                                }
                            }
                            else{
                                if($scoretype->status == "new"){
                                    $row .= "<td><i class='glyphicon glyphicon-import ".$value->addclass."' my_value='".$value->classname."|".$value->id."|".$scoretype->type."|".$scoretype->id."'> Import</i></td>";
                                }
                                else{
                                    $row .= "<td><i class='glyphicon glyphicon-edit ".$value->addclass."' my_value='".$value->classname."|".$value->id."|".$scoretype->type."|".$scoretype->id."'> Edit</i></td>";
                                }
                            }

                            $row .= "</tr>";
                            echo $row;
                        }
                    }
                ?>
            </tbody>
        </table> 
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div id="waiting_record" style="display:none"  class="text-center">
            <i class="fa fa-spin fa-refresh"></i>&nbsp; Loading...
        </div>
        <div style="display:none" id="div_result" class="box box-primary">
            <div class="box-header">
                <h3 id="result_table_header" class="box-title"></h3>
                <h3 id="result_table_header_hidden" class="box-title" style="display:none"></h3>
            </div>
            <div class="box box-body">
                <div id="success_import_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Import Transcript</h4>
                </div>
                <div id="success_edit_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Edit Transcript</h4>
                </div>
                <table id="result_table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Score</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody id="result_table_body">
                    </tbody>
                </table>
            </div>
            <button id="confirm_table" type="button" class="btn btn-primary pull-right">Confirm</button>
            <button id="edit_table" type="button" class="btn btn-primary pull-right">Edit</button>
        </div>
    </div>
</div> <!-- box -->
<!-- Edit Modal -->
<div id="importModal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Transcript</h4>
            </div>
            <form id="upload_form">
                <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="import_class">Class Name</label>
                                <input class="form-control" type="text" id="import_class" disabled>
                                <input class="form-control" type="text" style="display:none" id="import_class_hidden" name="import_class_hidden">  
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="import_typeid">Type</label>
                                <input class="form-control" type="text" id="import_type" disabled>
                                <input class="form-control" type="text" style="display:none" id="import_type_hidden" name="import_type_hidden">  
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button id="choose_file" type="button" class="btn btn-primary" >Choose File (.xlsx)</button>
                            </div>
                            <input id="import_text" name="import_text" type="text" class="form-control" disabled>
                            <input id="import_text_hidden" name="import_text_hidden" type="text" class="form-control" style="display:none">
                        </div>
                        <div id="waiting_record2" style="display:none"  class="text-center">
                            <br>
                            <i class="fa fa-spin fa-refresh"></i>&nbsp; Loading...
                        </div>
                        <div class="error_display">
                            <br>
                            <div id="error_box" style="display:none" class="box box-solid box-danger">
                                <div class="box-header">
                                    <div class="box-toll pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                    <h4 class="box-title">File Format Error</h4>
                                </div>
                                <div class="box-body">
                                    <div id="key_missing" style="display:none" class="box box-danger collapsed-box">
                                        <div class="box-header">
                                            <div class="box-toll pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <h4 class="box-title"><i class="fa fa-warning"></i> Key Missing Error!</h4>
                                        </div>
                                        <div class="box-body" style="color:red"><h4></div>
                                    </div>
                                    <div id="row_missing" style="display:none" class="box box-danger collapsed-box">
                                        <div class="box-header">
                                            <div class="box-toll pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <h4 class="box-title"><i class="fa fa-warning"></i>Row Missing Error!</h4>
                                        </div>
                                        <div class="box-body" style="color:red"></div>
                                    </div>
                                    <div id="row_redundancy" style="display:none" class="box box-danger">
                                        <div class="box-header">
                                            <h4 class="box-title"><i class="fa fa-warning"></i>Row Redundancy Error!</h4>
                                        </div>
                                        <div class="box-body" style="color:red"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="has-warning form-group">
                        <label class="error_mess" id="import_error" style="display:none"  for="import">Please Select File To Import</label>
                        <label class="error_mess" id="type_error" style="display:none"  for="import">Wrong file type (.xlsx is required)</label>
                        <label id="process"></label>
                        <button id="import" type="submit" class="btn btn-primary btn-block submit" >Import</button>
                        <input type="file" name="fileToUpload" id="fileToUpload" style="display:none"> 
                    </div>
                    <button type="button" class="btn btn-primary btn-block pull-right" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
</div>
<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 id="modal_title" class="modal-title"></h4>
                <form id="modal_edit_form">
                    <div class="form-group col-lg-8">
                        <label for="modal_score">Score</label>
                        <input type="text" id="modal_score" name="modal_score" class="form-control" data-mask/>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="modal_note">Note</label>
                        <input type="text" id="modal_note" class="form-control" name="modal_note">
                        <label id="count_text" for="modal_note" class="pull-right"></label>
                        <input type="hidden" id="modal_hidden_index" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal_save_button" class="btn btn-primary pull-right" data-dismiss="">Save</button>
                <button type="button" id="modal_close_button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
</div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>        
<!-- page script -->
<script type="text/javascript">
$(document).ready(function() {
	$("#sidebar_list_2").addClass('active');
    // $('#modal_score').inputmask("[1]9|[1]9[9]");
    $("#modal_score").inputmask({ mask: ["[1]9", "[1]9.9"], keepStatic: true });
    // First Box
    $('#class_list_table').dataTable({
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "scrollY": "500px",
            "scrollCollapse": true,
            "info" : false,
            "paging": false,
            "columns": [
                { "width": "10%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "5%" },
                { "width": "15%" },
                { "width": "5%" },
                { "width": "10%" },
                { "width": "35%" }
            ]
        });
    $('#result_table').dataTable({
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        //"scrollX": true,
       //"scrollCollapse": true,
        "columns": [
            { "width": "7%",  },
            { "width": "15%" },
            { "width": "8%" },
            { "width": "70%" }
        ],
    });

    $('i.glyphicon.glyphicon-import.enable').on('click',function(){
        $('#importModal').modal('show');
        var data = $(this).attr('my_value').split("|");
        $('#import_class').val(data[0]);
        $('#import_class_hidden').val(data[1]);
        $('#import_type').val(data[2]);
        $('#import_type_hidden').val(data[3]);
    });

    $(document).on('click', 'i.glyphicon.glyphicon-edit.enable', function(){
        var temp = $(this).attr('my_value').split("|");
        var class_id = temp[1];
        var scoretype_id = temp[3];
        var class_name = temp[0];
        var scoretype = temp[2];
        get_result_table(class_id,scoretype_id);
        $('#result_table_header').empty();
        $('#result_table_header').append(class_name+" | "+scoretype);
        $('#result_table_header_hidden').empty();
        $('#result_table_header_hidden').append(class_id+"|"+scoretype_id);
        $('#div_result').css('display','block');
        $('#confirm_table').css('display','none');
        $('#edit_table').css('display','block');
    });

    $('#get_button').click(function(){
        window.location.replace("/teacher/transcript/"+$('#grade').val());
    })

    // Import File *******************************************************************************************************
    $('#choose_file').click(function(){
        $('#fileToUpload').click();
    });
    $('#fileToUpload').change(function(){
        var filename = $(this).val();
        var lastIndex = filename.lastIndexOf("\\");
        if (lastIndex >= 0) {
            filename = filename.substring(lastIndex + 1);
        }
        $('#import_text').val(filename);
        $('#import_text_hidden').val(filename);
    });
    $('#upload_form').submit(function(e) { // capture submit
        e.preventDefault();
        //do some css
        $('#error_box').css('display','none');
        $('#row_missing').css('display','none');
        $('#row_missing div.box-body').empty();
        $('#row_redundancy').css('display','none');
        $('#row_redundancy div.box-body').empty();
        $('#key_missing').css('display','none');
        $('#key_missing div.box-body').empty();
        $('#import_error').slideUp('fast');
        $('#type_error').slideUp('fast');
        // start code
        var fd = new FormData(this); // XXX: Neex AJAX2
        var filename = $('#import_text').val();
        var file_ext = filename.substr(filename.lastIndexOf('.')+1);

        if(filename == ""){
            $('#import_error').show('medium');
        }
        else if(file_ext != "xlsx"){
            $('#type_error').show('medium');
        }
        else{
            $('#import_error').slideUp('fast');
            $('#type_error').slideUp('fast');
            $('#waiting_record').css('display','block');
            $('#waiting_record2').css('display','block');
            $.ajax({
                url: '/teacher/transcript/import_file',
                xhr: function() { // custom xhr (is the best)

                    var xhr = new XMLHttpRequest();
                    var total = 0;

                    // Get the total size of files
                    $.each(document.getElementById('fileToUpload').files, function(i, file) {
                        total += file.size;
                    });

                    //   Called when upload progress changes. xhr2
                    xhr.upload.addEventListener("progress", function(evt) {
                        // show progress like example
                        var loaded = (evt.loaded / total).toFixed(2)*100; // percent

                        $('#progress').text('Uploading... ' + loaded + '%' );
                    }, false);

                    return xhr;
                },
                type: 'post',
                processData: false,
                contentType: false,
                data: fd,
                success: function(record) {
                    $('#waiting_record2').css('display','none');
                    if(record.error_list != null){
                        $('#error_box').css('display','block');
                        $.each(record.error_list, function(key,value){
                            if(key == "key_missing"){
                                $('#key_missing').css('display','block');
                                $('#key_missing div.box-body').append("You are missing these columns in xlsx file:");
                                $.each(record.key_missing, function(i,j){
                                    $('#key_missing div.box-body').append("<br>+ "+j);
                                }); 
                            }
                            if(key == "row_missing"){
                                $('#row_missing').css('display','block');
                                $('#row_missing div.box-body').append("You are missing these students in xlsx file:");
                                $.each(record.row_missing, function(i,j){
                                    $('#row_missing div.box-body').append("<br>+ "+j.id+" "+j.fullname);
                                }); 
                            }
                            if(key == "row_redundancy"){
                                $('#row_redundancy').css('display','block');
                                $('#row_redundancy div.box-body').append("You are having "+record.row_redundancy+" excess rows in xlsx file");
                            }
                        })
                    }
                    else{
                        $('#importModal').modal('hide');
                        $('#waiting_record').css('display','none');
                        $('#result_table_header').empty();
                        $('#result_table_header').append($('#import_class').val()+" | "+$('#import_type').val());
                        $('#result_table_header_hidden').empty();
                        $('#result_table_header_hidden').append($('#import_class_hidden').val()+"|"+$('#import_type_hidden').val());
                        $('#result_table').dataTable().fnClearTable();
                        $.each(record, function(i, row){
                            $('#result_table').dataTable().fnAddData([
                                row.id,
                                row.full_name,
                                row.score,
                                row.note
                            ]);
                        });
                        $('#div_result').css('display','block');
                        $('#confirm_table').css('display','block');
                        $('#edit_table').css('display','none');
                        $('#error_box').css('display','none');
                        $('#row_missing').css('display','none');
                        $('#row_missing div.box-body').empty();
                        $('#row_redundancy').css('display','none');
                        $('#row_redundancy div.box-body').empty();
                        $('#key_missing').css('display','none');
                        $('#key_missing div.box-body').empty();
                    }
                }
            });
        }
    });
    $("#importModal").on('hidden.bs.modal',function(){
        $('#waiting_record').css('display','none');
        $('#import_text').val("");
        $('#import_text_hidden').val("");
        $('#fileToUpload').val("");
        $('#import_error').slideUp('fast');
        $('#type_error').slideUp('fast');
        $('#error_box').css('display','none');
        $('#row_missing').css('display','none');
        $('#row_missing div.box-body').empty();
        $('#row_redundancy').css('display','none');
        $('#row_redundancy div.box-body').empty();
        $('#key_missing').css('display','none');
        $('#key_missing div.box-body').empty();
    });

    // Edit Result Table *********************************************************************************************
    $('#result_table tbody').on('click', 'tr', function(){
        $('#result_table').dataTable().$('tr.selected').removeClass('selected');
        $(this).addClass('selected');          
        var index = $('#result_table').dataTable().fnGetPosition(this);
        var data = $('#result_table').dataTable().fnGetData(index);
        if(data != null){
            $('#modal_hidden_index').val(index);
            $('#editModal').modal('show');
            $('#modal_title').empty();
            $('#modal_title').append(data[0]+" "+data[1]);
            $('#modal_score').val(data[2]);
            $('#modal_note').val(data[3]);
            $('#count_text').empty();
            $('#count_text').append($('#modal_note').val().length+"/100");
        }        
    });

    $('#modal_save_button').on('click',function(){
        var table = $('#result_table').dataTable();
        var index = $('#modal_hidden_index').val();
        if($('#modal_note').parent().hasClass('has-warning')){
            //do nothing
        }
        else{
            table.fnUpdate($('#modal_score').val(), index, 2);
            table.fnUpdate($('#modal_note').val(), index, 3);
            $('#editModal').modal('hide');
        }
    });

    $('#modal_note').on('input',function(){
        check_count_note();
    });

    $('#confirm_table').on('click',function(){
        var data  = $('#result_table').dataTable().fnGetData();
        var class_n_type = $('#result_table_header_hidden').html();
        var token = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/teacher/transcript/save_transcript') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'data'          :data,
                    'class_n_type'  :class_n_type,
                    '_token'        :token
                    },
            success:function(record){
                if(record == "success"){
                    $("#success_import_mess").show('medium');
                    setTimeout(function() {
                        $('#success_import_mess').slideUp('slow');
                    }, 2500); // <-- time in milliseconds
                    $('#confirm_table').css('display','none');
                    $('#edit_table').css('display','block');
                    var class_n_type1 = $('#result_table_header').html().split(" | ");
                    var class_n_type2 = $('#result_table_header_hidden').html().split("|");
                    var value = class_n_type1[0]+"|"+class_n_type2[0]+"|"+class_n_type1[1]+"|"+class_n_type2[1];
                    var temp = $("i[my_value='"+value+"']").parent();
                    $("i[my_value='"+value+"']").remove();
                    temp.append("<i class='glyphicon glyphicon-edit enable' my_value='"+value+"'> Edit");
                    //$("i[my_value='"+value+"']").addClass('glyphicon-edit enable');
                    // $("i[my_value='"+value+"']").empty();
                    // $("i[my_value='"+value+"']").append(" Edit");
                    $("span[my_value='"+value+"']").addClass('bg-green');
                    $("span[my_value='"+value+"']").removeClass('bg-blue');
                    $("span[my_value='"+value+"']").empty();
                    $("span[my_value='"+value+"']").append("Imported");
                }
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });

    $('#edit_table').on('click',function(){
        var data  = $('#result_table').dataTable().fnGetData();
        var class_n_type = $('#result_table_header_hidden').html();
        var token = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/teacher/transcript/edit_transcript') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'data'          :data,
                    'class_n_type'  :class_n_type,
                    '_token'        :token
                    },
            success:function(record){
                if(record == "success"){
                    $("#success_edit_mess").show('medium');
                    setTimeout(function() {
                        $('#success_edit_mess').slideUp('slow');
                    }, 2500); // <-- time in milliseconds
                }
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });

    function get_result_table(class_id,scoretype_id){
        var token = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/teacher/transcript/get_transcript') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'class_id'      :class_id,
                    'scoretype_id'  :scoretype_id,
                    '_token'        :token
                    },
            success:function(record){
                $('#result_table').dataTable().fnClearTable();
                $.each(record, function(i, row){
                    $('#result_table').dataTable().fnAddData([
                        row.student_id,
                        row.full_name,
                        row.score,
                        row.note
                    ]);
                });  
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    }

    function check_count_note(){
        var data = $('#modal_note').val();
        var count = data.length;
        $('#count_text').empty();
        $('#count_text').append(count+"/100");
        if(count > 100){
            $('#modal_note').parent().addClass('has-warning');
        }
        else{
            $('#modal_note').parent().removeClass('has-warning');
        }
    };
    
});
</script>
@endsection