@extends('mytemplate.blankpage_te')

@section('content')

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
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
        <h3 class="box-title">Download Transcript Template</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div><!-- /.box-header -->
<!-- form start -->
    <form id="download_form" name="download_form" enctype="multipart/form-data">
     {!! csrf_field() !!}
    <div class="box-body">
        <div class="form-group col-lg-6">
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
        <div class="form-group col-lg-6">
            <label for="grade">Grade</label>
            <select id="grade" name="grade" class="form-control">
                <option value="-1" selected>-- Select --</option>;                                            
                <option>6</option>;
                <option>7</option>;
                <option>8</option>;
                <option>9</option>;
                <option value="0"> All </option>;
            </select>
        </div>
        <div class="form-group col-lg-12">
            <label for="classname">Class Name</label>
            <select id="classname" name="classname" class="form-control">
                <option value="-1" selected>Select Scholastic First</option>;
            </select> 
        </div>  
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="col-lg-12 col-xs-12">
            <div class="has-warning form-group">
                <label class="error_mess" id="download_error" style="display:none"  for="download">Please Select Class To Download</label>                              
                <button id="download" type="button" class="btn btn-primary btn-block">Download</button>
            </div>
        </div>
    </div>
    </form>
</div> <!-- box -->
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Import Transcript</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div><!-- /.box-header -->
<!-- form start -->
    <form id="upload_form" name="upload_form" enctype="multipart/form-data">
     {!! csrf_field() !!}
    <div class="box-body">
        <div class="form-group col-lg-6">
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
        <div class="form-group col-lg-6">
            <label for="grade">Grade</label>
            <select id="grade" name="grade" class="form-control">
                <option value="-1" selected>-- Select --</option>;                                            
                <option>6</option>;
                <option>7</option>;
                <option>8</option>;
                <option>9</option>;
                <option value="0"> All </option>;
            </select>
        </div>
        <div class="form-group col-lg-12">
            <label for="classname">Class Name</label>
            <select id="classname" name="classname" class="form-control">
                <option value="-1" selected>Select Scholastic First</option>;
            </select> 
        </div>  
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="col-lg-12 col-xs-12">
            <div class="has-warning form-group">
                <label class="error_mess" id="upload_error" style="display:none"  for="upload">Please Select Class To Download</label>                              
                <button id="upload" type="button" class="btn btn-primary btn-block">Download</button>
            </div>
        </div>
    </div>
    </form>
</div> <!-- box -->
</section>
<script src="{{asset("/mylib/jquery/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
        
<!-- page script -->
<script type="text/javascript">
$(document).ready(function() {
	$("#list_2").addClass('active');
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
        var fd = new FormData(this); // XXX: Neex AJAX2
        var class_id = $('#classname').val();
        var filename = $('#import_text').val();
        if(class_id == "-1" || filename == ""){
            $('#import_error').show('medium');
            setTimeout(function(){
                $('#import_error').slideUp('medium');
            }, 3500);
        }
        else{
             $.ajax({
              url: '/teacher/transcript/import_file',
              xhr: function() { // custom xhr (is the best)

                   var xhr = new XMLHttpRequest();
                   var total = 0;

                   // Get the total size of files
                   $.each(document.getElementById('fileToUpload').files, function(i, file) {
                          total += file.size;
                   });

                   // Called when upload progress changes. xhr2
                   // xhr.upload.addEventListener("progress", function(evt) {
                   //        // show progress like example
                   //        var loaded = (evt.loaded / total).toFixed(2)*100; // percent

                   //        $('#progress').text('Uploading... ' + loaded + '%' );
                   // }, false);

                   return xhr;
              },
              type: 'post',
              processData: false,
              contentType: false,
              data: fd,
              success: function(record) {
                   if(record == "type_error"){
                        $('#type_error').show('medium');
                        setTimeout(function() {
                            $('#type_error').slideUp('slow');
                        }, 4000);
                   }
                   console.log(record);
              }
            });
        }
    });
    $('#download').click(function(){
        $('#download_error').slideUp('medium');
    	var class_id = $("#classname").val();
    	if(class_id == -1){
            $('#download_error').show('medium');
        }
        else{
            window.open('/teacher/transcript/download/'+class_id,'_blank');
        }
    });
    
    function updateClassname(){
        var scholastic      = $('#scholastic').val();
        var grade           = $('#grade').val();
        var token           = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/teacher/transcript/updateclassname') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'    :scholastic,
                    'grade'         :grade,
                    '_token'        :token
                    },
            success:function(record){
               $("#classname").empty();
                if(record.count > 0){
                    $('#classname').append("<option value='-1' selected>-- Select --</option>");
                    $.each(record.data, function(i, row){
                        $('#classname').append("<option value='"+row.id+"'>"+row.id+"  |  "+row.classname+"</option>");
                    });
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
 
});
</script>
@endsection