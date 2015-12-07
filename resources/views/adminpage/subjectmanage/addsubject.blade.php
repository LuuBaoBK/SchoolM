@extends('mytemplate.blankpage_ad')
@section('content')

<section class="content-header">
    <h1>
        Admin
        <small>Create Subject</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active"><a href="/admin/addsubject">Create Subject</a></li>
    </ol>
</section>

<section class="content">
<div class="box">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg-12">
            <div class="box box-solid box-primary collapsed-box">
            <div class="box-header">
                <h3 class="box-title">Create New Subject</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="subject_form" method="POST" role="form">
            {!! csrf_field() !!}
            <div style = "display: none" class="box-body">
                <div id="error_mess" style = "display: none" class="alert alert-warning alert-dismissable">
                    <h4></h4>        
                </div>
                 <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Add New Subject</h4>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control" name="subject_name" id="subject_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="totaltime">Total Time</label>
                        <input type="text" class="form-control" name="total_time" id="total_time">
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div style = "display: none" class="box-footer">
                    <button id ="subject_form_submit" type="button" class="btn btn-primary">Create New Subject</button>
            </div>
            </form>
            </div><!-- /.box -->
        </div>

        <div class="col-xs-12 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Subject List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive">
                    <table id="subject_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Subject Name</th>
                            <th>Total Time</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="displayrecord">
                        <?php foreach ($subjectlist as $row) :?>
                            <tr>
                                <td> <?php echo $row->id ?></td>
                                <td> <?php echo $row->subject_name ?></td>
                                <td> <?php echo $row->total_time ?></td>
                                <td> <i class = "fa fa-fw fa-edit"></i> <a href="<?php echo '/admin/editsubject/'.$row->id ?>">Edit</a> </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</div>
<!-- /.box -->
</section>

<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>

<!-- page script -->
<script>
    $(function () {
        $("#subject_table").DataTable(
            {"order": [[ 0, "desc" ]]}
        );

        $("#subject_form_submit").click(function() {
            /* Act on the event */
            var subject_name   = $('#subject_name').val();
            var total_time  = $('#total_time').val();
            var token       = $('input[name="_token"]').val();
            $.ajax({
                url     :"<?= URL::to('admin/addsubject') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'subject_name'    :subject_name,
                    'total_time'      :total_time,
                    '_token'        :token
                },
                success:function(subject){
                   if(subject.isDone == 1){
                        $('#error_mess').slideUp('slow');
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                        $('#subject_table').dataTable().fnAddData( [
                             subject.id,
                             subject.subject_name,
                             subject.total_time,
                             subject.button
                             ]
                            );
                   }
                   else{
                        $('#error_mess').show("medium");
                        $('#error_mess').empty();
                        $.each(subject, function(i, item){
                          $('#error_mess').append("<h4><i class='icon fa fa-warning'></i>"+item+"</h4>");
                        });
                        
                   }    
                }
            });
        });
    });

</script>

@endsection