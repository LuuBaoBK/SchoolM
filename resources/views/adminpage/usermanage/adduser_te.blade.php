@extends('mytemplate.blankpage_ad')
@section('content')

<section class="content-header">
    <h1>
        Admin
        <small>Regist Teacher</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Regist Teacher</li>
    </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
        <!-- My page start here --> 
        <div class="col-xs-12 col-lg-12">
            <div class="box box-solid box-primary collapsed-box">
                <div class="box-header">
                    <h3  class="box-title">Regist New Teacher</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
            <!-- form start -->
            <form id="te_form" method="POST" role="form">
            {!! csrf_field() !!}
            <div style = " " class="box-body">
                 <div id="success_mess" style = "display: none" class="alert alert-success">
                    <h4><i class="icon fa fa-check"></i>Success Add New Teacher</h4>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="firstname">First Name</label>
                        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
                        <label class="error_mess" id="firstname_error" style="display:none" for="firstname"></label>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name">
                        <label class="error_mess" id="middlename_error" style="display:none" for="middlename"></label>
                    </div>
                    <div class="form-group col-lg-3 col-xs-12">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
                        <label class="error_mess" id="lastname_error" style="display:none" for="lastname"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                        <label class="error_mess" id="address_error" style="display:none" for="homephone"></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="homephone">Home Phone</label>
                        <input type="text" class="form-control" name="homephone" id="homephone" placeholder="Home Phone">
                        <label class="error_mess" id="homephone_error" style="display:none" for="homephone"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="mobilephone">Mobile Phone</label>
                        <input type="text" class="form-control" name="mobilephone" id="mobilephone" placeholder="Mobile Phone">
                        <label class="error_mess" id="mobilephone_error" style="display:none" for="mobilephone"></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="dateofbirth">Date Of Birth</label>
                        <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                        <label class="error_mess" id="dateofbirth_error" style="display:none" for="dateofbirth"></label>
                    </div>
                     <div class="form-group col-lg-3">
                        <label for="incomingday">Incoming Day</label>
                        <input type="text" id="incomingday" name="incomingday" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                        <label class="error_mess" id="incomingday_error" style="display:none" for="incomingday"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="group">Group</label>
                        <input type="text" class="form-control" name="group" id="group" placeholder="Group">
                        <label class="error_mess" id="group_error" style="display:none" for="group"></label>
                    </div>
                   <div class="form-group col-lg-3">
                        <label for="specialized">Specialized</label>
                        <input type="text" class="form-control" name="specialized" id="specialized" placeholder="Specialized">
                        <label class="error_mess" id="specialized_error" style="display:none" for="specialized"></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" name="position" id="position" placeholder="Position">
                        <label class="error_mess" id="position_error" style="display:none" for="position"></label>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div style = " " class="box-footer">
                    <button id ="te_form_submit" type="button" class="btn btn-primary">Create New Teacher</button>
            </div>
            </form>
            </div><!-- /.box -->
        </div>

        <div class="col-xs-12 col-lg12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Teacher List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive">
                    <table id="teacher_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Home Phone</th>
                            <th>Mobile Phone</th>
                            <th>Group</th>
                            <th>Specialized</th>
                            <th>Position</th>
                            <th>Date Of Birth</th>
                            <th>Incoming Day</th>
                            <th>Address</th>
                            <th>role</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="displayrecord">
                        <?php foreach ($teacherlist as $row) :?>
                            <tr>
                                <td> <?php echo $row->id ?></td>
                                <td> <?php echo $row->user->firstname." ".$row->user->middlename." ".$row->user->lastname ?></td>
                                <td> <?php echo $row->user->email ?></td>
                                <td> <?php echo $row->homephone ?></td>
                                <td> <?php echo $row->mobilephone ?></td>
                                <td> <?php echo $row->group ?></td>
                                <td> <?php echo $row->specialized ?></td>
                                <td> <?php echo $row->position ?></td>
                                <td> <?php 
                                    $dateofbirth = $row->user->dateofbirth;
                                    if($dateofbirth != "0000-00-00"){
                                        $dateofbirth = date_create($row->user->dateofbirth);
                                        $dateofbirth = date_format($dateofbirth,"d/m/Y");
                                    }
                                    else{
                                       $dateofbirth = "";
                                    }
                                    echo $dateofbirth;
                                ?></td>
                                <td> <?php 
                                    $incomingday = $row->incomingday;
                                    if($incomingday != "0000-00-00"){
                                        $incomingday = date_create($row->incomingday);
                                        $incomingday = date_format($incomingday,"d/m/Y");
                                    }
                                    else{
                                       $incomingday = "";
                                    }
                                    echo $incomingday;
                                ?></td>
                                <td> <?php echo $row->user->address ?></td>
                                <td> <?php echo $row->user->role ?></td>
                                <td>
                                    <a href="<?php echo 'teacher/edit/'.$row->id ?>"><i class = "glyphicon glyphicon-edit"></i></a>
                                   <!-- <a href="<?php echo 'teacher/edit/'.$row->id ?>">Edit</a> -->
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Home Phone</th>
                            <th>Mobile Phone</th>
                            <th>Group</th>
                            <th>Specialized</th>
                            <th>Position</th>
                            <th>Date Of Birth</th>
                            <th>Incoming Day</th>
                            <th>Address</th>
                            <th>role</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</div>
<!-- /.box -->
</section>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>

<script>
    $(function () {
        $("#teacher_table").DataTable({
            "order": [[ 0, "desc" ]],   
        });
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("[data-mask]").inputmask();

        $("#te_form_submit").click(function() {
            /* Act on the event */
            var firstname   = $('#firstname').val();
            var middlename  = $('#middlename').val();
            var lastname    = $('#lastname').val();
            var mobilephone = $('#mobilephone').val();
            var homephone   = $('#homephone').val();
            var dateofbirth = $('#dateofbirth').val();
            var incomingday = $('#incomingday').val();
            var address     = $('#address').val();
            var group       = $('#group').val();
            var specialized = $('#specialized').val();
            var position    = $('#position').val();
            var token       = $('input[name="_token"]').val();

            $(".form-group").removeClass("has-warning");
            $(".error_mess").empty();
            $.ajax({
                url     :"<?= URL::to('/admin/manage-user/teacher') ?>",
                type    :"POST",
                async   :false,
                data    :{
                    'firstname'     :firstname,
                    'middlename'    :middlename,
                    'lastname'      :lastname,
                    'mobilephone'   :mobilephone,
                    'homephone'     :homephone,
                    'incomingday'   :incomingday,
                    'group'         :group,
                    'specialized'   :specialized,
                    'position'      :position,
                    'dateofbirth'   :dateofbirth,
                    'address'       :address,
                    '_token'        :token
                },
                success:function(record){
                   if(record.isDone == 1){
                        $('#success_mess').show("medium");
                        setTimeout(function() {
                            $('#success_mess').slideUp('slow');
                        }, 2000); // <-- time in milliseconds
                        $('#teacher_table').dataTable().fnAddData( [
                            record.mydata.id,
                            record.mydata.user.firstname+" "+record.mydata.user.middlename+" "+record.mydata.user.lastname,
                            record.mydata.user.email,
                            record.mydata.homephone,
                            record.mydata.mobilephone,
                            record.mydata.group,
                            record.mydata.specialized,
                            record.mydata.position,
                            record.mydata.user.dateofbirth,
                            record.mydata.incomingday,
                            record.mydata.user.address,
                            record.mydata.user.role,
                            record.button
                             ]
                            );
                   }
                   else{
                        $('#error_mess').show("medium");
                        $('#error_mess').empty();
                        $.each(record, function(i, item){
                          $('#'+i).parent().addClass('has-warning');
                          $('#'+i+"_error").css("display","block").append("<i class='icon fa fa-warning'></i> "+item);
                        });
                   }    
                },
                error:function(){
                    alert("something went wrong, contact master admin to fix");
                }
            });
        });
    });

    
</script>
@endsection