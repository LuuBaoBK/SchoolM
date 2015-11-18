@extends('mytemplate.newblankpage')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Student - Classes</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Student - Classes</li>
    </ol>
</section>
<section>
<div class="box">
    <div class="box-body">
        
    </div>
</div>
</section>


@endsection

<script src="{{ URL::asset("mylib/js/jquery.min.js") }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

    $(function(){
        $('#example1').DataTable();


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
                url     : "<?= URL::to('/admin/class/addStudent') ?>",
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
                url     : "<?= URL::to('/admmin/class/removeStudent') ?>",
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
                url     : "<?= URL::to('/admin/class/filterstudent') ?>",
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
            url     : "<?= URL::to('admin/class/getclass') ?>",
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

