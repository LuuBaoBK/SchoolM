@extends('class.template')
@section('content')

<div class="box box-primary" style="width:49%; display: inline-block;">
    <div class="box-header">
        <h3 class="box-title">Student</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" style="width: 100%; height: 230px;">
            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
            <input type="hidden" id="id">

        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputPassword1">Hoc Ky</label>
                <select name="hocky" id="hocky" class="form-control">
                    <option value="">Select Hoc Ky</option>
                    <?php
                        foreach ($data as $row) {
                    ?>
                    <option value="<?php echo $row->semester ?>"><?php echo $row->semester ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Khoi</label>
                <select name="khoi" id="khoi" class="form-control">
                    <option value="">Select Khoi lop</option>
                    <option value="6">Khoi 6</option>
                    <option value="7">Khoi 7</option>
                    <option value="8">Khoi 8</option>
                    <option value="9">Khoi 9</option>
                </select>
            </div>
            
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="button" class="btn btn-primary filtercord">Filter</button>
        </div>
        
    </form>
    <div class="box">
        <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="displayrecord">
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.box -->

<!--displaydata -->

<div class="box box-primary" style="width:49%; display: inline-block;vertical-align: top; float:right;">
    <div class="box-header">
        <h3 class="box-title">Student</h3>
    </div><!-- /.box-header -->
    <div class="form-group">
         <form role="form" style="width: 100%; height: 230px;">
            <label for="exampleInputPassword1">Lop hoc</label>
            <select name="lophoc" id="lophoc" class="form-control lophoc">
                <option value="">MS|Ten lop</option>
                <?php
                    foreach ($classlist as $row) {
                ?>
                <option value="<?php echo $row->id ?>"><?php echo $row->id ?> | <?php echo $row->classname; ?></option>
                <?php } ?>
            </select>
        </form>
        <div class="box">
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="liststudent">
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div><!-- /.box -->


@endsection

<script src="{{ URL::asset("mylib/js/jquery.min.js") }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

$(function(){
    
//    displaydata();


    $('.lophoc').change(function(){
        displaystudent();
    });


    $('.filtercord').click(function() {
        displaydata();
    });

    $('body').delegate('.addStudentIntoClass', 'click', function(){
        var student_id = $(this).data('id');
        var class_id = $('#lophoc').val();
        var token = $('input[name="_token"]').val();

        alert(student_id+class_id);
        $.ajax({
            url     : "<?= URL::to('addStudent') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'student_id' : student_id,
                'class_id'   : class_id,
                '_token'     : token
            },
            success:function(re){
                if(re == 0)
                {
                    alert('save success');
                    displaydata();
                    displaystudent();
                }
                else
                {
                    alert('error');
                }
            }
        });

    });

    $('body').delegate('.removeStudentFromClass', 'click', function(){
        var student_id = $(this).data('id');
        var class_id = $('#lophoc').val();
        var token = $('input[name="_token"]').val();
        
        $.ajax({
            url     : "<?= URL::to('removeStudent') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'student_id' : student_id,
                'class_id'   : class_id,
                '_token'     : token
            },
            success:function(re){
                if(re == 0)
                {
                    alert('Remove success');
                    displaydata();
                    displaystudent();
                }
                else
                {
                    alert('error');
                }
            }
        });

    });
    
});


function displaydata(){
        var hocky = $('#hocky').val();
        var khoi      = $('#khoi').val();
        var token       = $('input[name="_token"]').val();

        $.ajax({
            url     : "<?= URL::to('filterstudent') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'hocky':  hocky,
                'khoi' :  khoi,
                '_token': token
            },
            success:function(re){
                $('.displayrecord').html(re);       
            }
        });
}

function displaystudent(){
var id = $('#lophoc').val();
        var token = $('input[name="_token"]').val();


        $.ajax({
            url     : "<?= URL::to('getclass') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'id'    :   id,
                '_token': token
            },
            success:function(re){
                $('.liststudent').html(re);       
            }
        });





};

});
</script>

