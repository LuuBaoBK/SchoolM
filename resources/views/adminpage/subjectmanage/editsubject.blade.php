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

</section><!-- DATA TABES SCRIPT -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
    $(function() {
        $('#score_type_table').dataTable({
            "scrollCollapse": true,
            "scrollY" : "350px",
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "order": [[ 1, "asc" ]],
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "columns": [
                { "width": "50%" },
                { "width": "50%" },
            ]
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

        // $('#score_list_form').on('submit',function(e){
        //     e.preventDefault();
        //     $('#score_type_error').parent().removeClass('has-warning');
        //     $('#score_type_error').css("display","none");
        //     $('#score_type_error').empty();
        //     var score_type = $('#score_type').val();
        //     var factor     = $('#factor').val();
        //     var subject_id = $('#id').val();
        //     var token      = $('input[name="_token"]').val();
        //     $.ajax({
        //         url     :"<?= URL::to('admin/editsubject/add_type') ?>",
        //         type    :"POST",
        //         async   :false,
        //         data    :{
        //             'score_type'      : score_type,
        //             'factor'          :factor,
        //             'subject_id'      :subject_id,
        //             '_token'        :token
        //         },
        //         success:function(record){
        //             if(record.isDone == 1){
        //                 $('#score_type_table').dataTable().fnAddData( [
        //                     score_type,
        //                     factor    
        //                 ]);
        //             }
        //             else{
        //                 $('#score_type_error').parent().addClass('has-warning');
        //                 $('#score_type_error').css("display","block");
        //                 $('#score_type_error').append("<i class='icon fa fa-warning'></i> "+record.score_type);
        //             }
        //         }
        //     });
        // });

        // var selected_row_index;
        // $('#score_type_table tbody').on( 'click', 'tr', function () {
        //     $('#score_type_table').dataTable().$('tr.selected').removeClass('selected');
        //     $(this).addClass('selected');
        //     selected_row_index = $('#score_type_table').dataTable().fnGetPosition(this);
        //     if( $('#score_type_table').dataTable().fnGetData(this) != null){
        //         var score_type = $('#score_type_table').dataTable().fnGetData(this)[0];
        //         var factor = $('#score_type_table').dataTable().fnGetData(this)[1];
        //         $('#modal_score_type').val(score_type);
        //         $('#modal_old_score_type').val(score_type);
        //         $('#modal_factor').val(factor);
        //         $('#editModal').modal('show');
        //     }
        //     else{   
        //         //do nothing
        //     }          
        // });

        // $('#modal_edit').on('click',function(){
        //     $('#modal_score_type_error').parent().removeClass('has-warning');
        //     $('#modal_score_type_error').css("display","none");
        //     $('#modal_score_type_error').empty();
        //     var subject_id = $('#id').val();
        //     var score_type = $('#modal_score_type').val();
        //     var old_score_type = $('#modal_old_score_type').val();
        //     var factor     = $('#modal_factor').val();
        //     var token      = $('input[name="_token"]').val();
        //     if(score_type == old_score_type){
        //         $('#editModal').modal('hide');
        //     }
        //     else{
        //         $.ajax({
        //             url     :"<?= URL::to('admin/editsubject/edit_type') ?>",
        //             type    :"POST",
        //             async   :false,
        //             data    :{
        //                 'score_type'    : score_type,
        //                 'factor'        :factor,
        //                 'subject_id'    :subject_id,
        //                 'old_score_type':old_score_type,
        //                 '_token'        :token
        //             },
        //             success:function(record){
        //                 if(record.isDone == 1){
        //                     $('#editModal').modal('hide');
        //                     $('#score_type_table').dataTable().fnUpdate( score_type, selected_row_index, 0 );
        //                     $('#score_type_table').dataTable().fnUpdate( factor, selected_row_index, 1 );
        //                 }
        //                 else{
        //                     $('#modal_score_type_error').parent().addClass('has-warning');
        //                     $('#modal_score_type_error').css("display","block");
        //                     $('#modal_score_type_error').append("<i class='icon fa fa-warning'></i> "+record.score_type);
        //                 }
        //             }
        //         });
        //     }                
        // });

        // $('#modal_delete').click(function(){
        //     var subject_id = $('#id').val();
        //     var score_type = $('#modal_score_type').val();
        //     var token      = $('input[name="_token"]').val();
        //     $.ajax({
        //         url     :"<?= URL::to('admin/editsubject/delete_type') ?>",
        //         type    :"POST",
        //         async   :false,
        //         data    :{
        //             'score_type'      : score_type,
        //             'subject_id'      :subject_id,
        //             '_token'        :token
        //         },
        //         success:function(record){
        //             if(record.isDone == 1){
        //                 $('#score_type_table').dataTable().fnAddData( [
        //                     score_type,
        //                     factor    
        //                 ]);
        //             }
        //             else{
        //                 $('#score_type_error').parent().addClass('has-warning');
        //                 $('#score_type_error').css("display","block");
        //                 $('#score_type_error').append("<i class='icon fa fa-warning'></i> "+record.score_type);
        //             }
        //         }
        //     });
        // });
    });
</script>

@endsection