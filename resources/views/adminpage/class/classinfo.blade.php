@extends('mytemplate.blankpage_ad')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Create Class</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li><i class="active"></i>Create Class</li>
    </ol>
</section>
<section class="content">
<!-- My page start here --> 
<div class="box box-solid box-primary collapsed-box">
    <div class="box-header">
       <h3 class="box-title">Add New Class</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>   
    </div>
    <form id="class_form" role="form">
        {!! csrf_field() !!}
        <div class="box-body">
            <div id="success_mess" style = "display: none" class="alert alert-success">
                <h4><i class="icon fa fa-check"></i>Success Add New Class</h4>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-title">Class Info</div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-lg-3 col-xs-7">
                            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                            <label for="scholastic">Scholastic</label>
                            <select id="scholastic" name="scholastic" class="form-control">
                                <?php
                                    $year = date("Y");
                                    $year = (date("m") < 8) ? ($year - 1) : $year;
                                    $end = $year + 1;
                                    for($temp = $year; $temp <= $end; $temp++){
                                        if($temp == $year)
                                        {
                                            echo ("<option value='".substr($temp,2)."' selected >".$temp." - ".($temp+1)."</option>");
                                        }
                                        else
                                        {
                                            echo ("<option value='".substr($temp,2)."'>".$temp." - ".($temp+1)."</option>");
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-xs-7">
                            <label for="grade">Grade</label>
                            <select id="grade" name="grade" class="form-control">
                                <option selected>6</option>;
                                <option>7</option>;
                                <option>8</option>;
                                <option>9</option>;
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-xs-7">
                            <label for="group">Group</label>
                            <select id="group" name="group" class="form-control">
                                <option selected>A</option>;
                                <option>B</option>;
                                <option>C</option>
                                <option>D</option>;
                                <!-- <option>MT</option>; -->
                            </select>
                        </div>                                                   
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3 col-xs-7">
                            <label for="class_identifier">Class's Identifier <small>*</small></label>
                            <input onkeydown="if (event.keyCode == 13) {return false;}" type="text" class="form-control" name="clasas_identifier" id="class_identifier" placeholder="2 characters">
                            <label class="error_mess" id="class_identifier_error" style="display:none" for="class_identifier"></label>
                        </div>
                        <div class="form-group col-lg-3 col-xs-7">
                            <label for="homeroomteacher">Homeroom Teacher</label>
                            <select id="homeroomteacher" name="homeroomteacher" class="form-control">
                                <?php
                                    foreach($record['teacherlist'] as $key => $value){
                                        echo ("<option value='".$value->id."'>".$value->id." | ".$value->user->firstname." ".$value->user->middlename." ".$value->user->lastname."</option>");
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div> <!-- Student box body -->
                <div class="box-footer">
                    <button id ="class_form_submit" type="button" class="btn btn-primary">Create New Class</button>
                </div>
            </div> <!-- Student box -->
        </div><!-- /.box-body -->
    </form>
</div>
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Classes List</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>                                    
    </div><!-- /.box-header -->

    <div class="box-body table-responsive">
        <div class="box box-primary">
            <div class="box-header">
                <p class="box-title">Select Scholastic</p>
            </div>
            <div class="box-body">
                <form id="class_filter">
                    <div class="box-body">
                    <div class="row">
                        <div class="form-group col-lg-3 col-xs-7">
                            <label for="scholastic_filter">Scholastic</label>
                            <select id="scholastic_filter" name="scholastic_filter" class="form-control">
                                <option value="" selected>Select All</option>
                                <?php
                                    $year = date("Y");
                                    $year = (date("m") < 8) ? ($year - 1) : $year;
                                    $year += 1;
                                    for($year;$year >=2010 ;$year--){
                                        if($year == 2015)
                                        {
                                            echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                                        }
                                        else
                                        {
                                            echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>                                  
                    </div>                                        
                    <div class="box-footer">
                        <button id ="class_search_submit" type="button" class="btn btn-primary btn-flatt">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <table id="class_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Class Name</th>
                <th>Scholastic</th>
                <th>Homeroom Teacher</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody class="displayrecord">
           
        </tbody>
        
        </table>
    </div>
</div><!-- /.box -->
</section>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- page script -->
<script type="text/javascript">
    $(function() {
        $('#sidebar_list_3').addClass('active');
        $('#sidebar_list_3_1').addClass('active');
        $('#class_table').dataTable({
            "columnDefs": [ { "targets": 4, "orderable": false } ]
        });
    });

    $( "#scholastic" ).change(function() {
        $("#homeroomteacher").empty();
        var scholastic   = $('#scholastic').val();
        var token        = $('input[name="_token"]').val();
        $.ajax({
            url     :"<?= URL::to('/admin/class/classinfo/updateform') ?>",
            type    :"POST",
            async   :false,
            data    :{
                    'scholastic'     :scholastic,
                    '_token'        :token
                    },
            success:function(record){
                $.each(record, function(i, row){
                    $('#homeroomteacher').append("<option>"+row.id+"  |  "+row.user.firstname+" "+row.user.middlename+" "+row.user.lastname+"</option>");
                });
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });

    $("#class_form_submit").click(function() {
        var scholastic      = $('#scholastic').val();
        var grade           = $('#grade').val();
        var group           = $('#group').val();
        var class_identifier       = $('#class_identifier').val();
        var homeroomteacher = $('#homeroomteacher').val();
        var token           = $('input[name="_token"]').val();
        

        $(".form-group").removeClass("has-warning");
        $(".error_mess").empty();

        $.ajax({
            url     :"<?= URL::to('/admin/class/classinfo/store') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'scholastic'        :scholastic,
                'class_identifier'         :class_identifier,
                'grade'             :grade,
                'group'             :group,
                'homeroom_teacher'   :homeroomteacher,
                '_token'            :token
            },
            success:function(record){
                console.log(record);
                if(record.isSuccess == 1){
                    $('#error_mess').slideUp('slow');
                    $('#success_mess').show("medium");
                    setTimeout(function() {
                        $('#success_mess').slideUp('slow');
                    }, 2000); // <-- time in milliseconds

                    $('#class_table').dataTable().fnAddData([
                        record.id,
                        record.classname,
                        record.scholastic,
                        record.homeroom_teacher,
                        "<a href='/admin/class/classinfo/edit/"+record.id+"'><i class='glyphicon glyphicon-edit'></i></a>"
                        ])
                    $("#homeroomteacher").empty();
                    $.each(record.teacherlist, function(i, row){
                        $('#homeroomteacher').append("<option>"+row.id+"  |  "+row.user.firstname+" "+row.user.middlename+" "+row.user.lastname+"</option>");
                    });
                }
                else{
                    $('#error_mess').show("medium");  
                    $.each(record, function(i, item){
                      $('#class_identifier').parent().addClass('has-warning');
                      $('#class_identifier_error').css("display","block").append("<i class='icon fa fa-warning'></i> "+item);
                    });
                }
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });

    $("#class_search_submit").click(function() {
        var scholastic   = $('#scholastic_filter').val();
        var token        = $('input[name="_token"]').val();
        var button = "";
        $.ajax({
            url     :"<?= URL::to('/admin/class/classinfo/search') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'scholastic'     :scholastic,
                '_token'        :token
            },
            success:function(record){
                $('#class_table').dataTable().fnClearTable();
                $.each(record, function(i, row){
                    button = "<a href='/admin/class/classinfo/edit/"+row.id+"'><i class='glyphicon glyphicon-edit'></i></a>";
                    $('#class_table').dataTable().fnAddData( [
                        row.id,
                        row.classname,
                        "20"+row.scholastic,
                        row.teacher.user.firstname+" "+row.teacher.user.middlename+" "+row.teacher.user.lastname,
                        button
                        ]
                    );   
                });
            },
            error:function(){
                alert("something went wrong, contact master admin to fix");
            }
        });
    });
</script>

@endsection