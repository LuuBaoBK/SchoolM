@extends('class.template')
@section('content')

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Student</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form">
            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
            <input type="hidden" id="id">

        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputPassword1">Khoi</label>
                <select name="khoi" id="khoi" class="form-control">
                    <option value="">Select Khoi lop</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div><div class="form-group">
                <label for="exampleInputPassword1">Gender</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="">Select gender</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Phone</label>
                <input type="text" class="form-control" id="phone" placeholder="Enter Phone">
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="button" class="btn btn-primary saverecord">Save record</button>
            <button type="button" class="btn btn-primary updaterecord">Update record</button>
        </div>
        
    </form>
</div><!-- /.box -->

<!--displaydata -->

<div class="box">
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="displayrecord">
                
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->


@endsection

 <script src="{{ URL::asset("js/jquery.min.js") }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

/*$(function(){
    
    displaydata();



    $('body').delegate('.delete', 'click', function(){
        var id = $(this).data('id');
        var token = $('input[name="_token"]').val();
        alert(id);
        $.ajax({
            url     : "<?= URL::to('deleterow') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'id'        : id,
                '_token'    : token
            },
            success:function(d)
            {
                if(d == 0)
                {
                    alert("Delete success!!");
                    displaydata();
                }
                else
                {
                    alert("Delete error");
                }
            }
        });
    });

    $('.updaterecord').click(function() {

        var id          = $('#id').val();
        var studentname = $('#studentname').val();
        var gender      = $('#gender').val();
        var phone       = $('#phone').val();
        var token       = $('input[name="_token"]').val();
        
        $.ajax({
            url     : "<?= URL::to('update') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'id'            :id,
                'studentname'   :studentname,
                'gender'        :gender,
                'phone'         :phone,
                '_token'        : token
            },
            success:function(re){
                if(re == 0)
                {
                    alert('Update success');
                    displaydata();
                }
                else
                {
                    alert('Update error');
                }
            }
        });
        
    });

    $('.saverecord').click(function() {
        var studentname = $('#studentname').val();
        var gender      = $('#gender').val();
        var phone       = $('#phone').val();
        var token       = $('input[name="_token"]').val();
    
        
        $.ajax({
            url     : "<?= URL::to('save') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'studentname':studentname,
                'gender':gender,
                'phone':phone,
                '_token': token
            },
            success:function(re){
                if(re == 0)
                {
                    alert('save success');
                    displaydata();
                }
                else
                {
                    alert('error');
                }
                
            }
        });
    });

    $('body').delegate('.edit', 'click', function(){
        var id = $(this).data('id');
        var token = $('input[name="_token"]').val();

        $.ajax({
            url     : "<?= URL::to('editrow') ?>",
            type    :"POST",
            async   :false,
            data    :{
                'id' : id,
                '_token':token
            },
            success:function(e){
                $('#id').val(e.id);
                $('#studentname').val(e.student_name);
                $('#gender').val(e.gender);
                $('#phone').val(e.phone);
            }
        });

    });
    
});

*/
function displaydata(){
var token       = $('input[name="_token"]').val();

    $.ajax({
        url:"<?= URL::to('showdata') ?>",
        type: "POST",
        async:false,
        data:{'showrecord':1, '_token':token},
        success:function(s)
        {
            $('.displayrecord').html(s);
        }
    });
}

});
</script>

