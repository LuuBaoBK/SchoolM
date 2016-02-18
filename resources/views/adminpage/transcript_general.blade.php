@extends('mytemplate.blankpage_ad')
@section('content')
<?php use App\Transcript; ?>

<style type="text/css">
table tr.selected{
    background-color: #3399CC !important; 
}
</style>

<section class="content-header">
    <h1>
        Admin
        <small>Transcript</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li><a href="schedule"><i class="active"></i>Create Transcript</a></li>
    </ol>
</section>
<section class="content">
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title">Transcript General Setting</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div><!-- /.box-header -->
<!-- form start -->
    <form id="upload_form" name="upload_form" enctype="multipart/form-data">
     {!! csrf_field() !!}
    <div class="box-body">  
        <div class="form-group col-lg-4">
            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
            <label for="scholastic">Scholastic</label>
            <select id="scholastic" name="scholastic" class="form-control">
                <option value="-1" selected>-- Select --</option>;
                <?php
                    $year = date("Y") + 2;
                    for($year;$year >=2010 ;$year--){
                        echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                    }
                ?>
                <option value="0">-- All --</option>;
            </select>
        </div>
        <div class="form-group col-lg-4">
            <label for="grade">Grade</label>
            <select id="grade" name="grade" class="form-control">
                <option value="-1" selected>-- Select --</option>;                                            
                <option>6</option>;
                <option>7</option>;
                <option>8</option>;
                <option>9</option>;
                <option value="0">-- All --</option>;
            </select>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
    </div>
    </div>
    </form>
</div><!-- /.box -->
</section>

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- page script -->
<script type="text/javascript">
$(document).ready(function()
{
    
});

</script> 

@endsection