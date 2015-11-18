@extends('mytemplate.newblankpage')
@section('content')
<section class="content-header">
    <h1>
        Admin
        <small>Edit Class Info</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active">Edit_Class_Info</li>
    </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
        <div class="box box-solid box-primary">
            <div class="box-header">
               <h3 class="box-title">Edit Class Info</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>   
            </div>
            <form id="class_form_submit" method="POST" role="form">
                {!! csrf_field() !!}
                <div class="box-body">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                      @if(Session::has('alert-' . $msg))
                      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                      @endif
                    @endforeach
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
                                            $year = date("Y") + 2;
                                            for($year;$year >=2010 ;$year--){
                                                if($year == ("20".$record['scholastic']))
                                                {
                                                    echo ("<option value='".substr($year,2)."' selected >".$year." - ".($year+1)."</option>");
                                                }
                                                else
                                                {
                                                    echo ("<option value='".substr($year,2)."'>".$year." - ".($year+1)."</option>");
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3 col-xs-7">
                                    <label for="grade">Grade</label>
                                    <select id="grade" name="grade" class="form-control">
                                        <?php
                                            for($grade = 6; $grade < 10 ; $grade++){
                                                if($grade == ($record['grade']))
                                                {
                                                    echo ("<option value='".$grade."' selected >".$grade."</option>");
                                                }
                                                else
                                                {
                                                    echo ("<option value='".$grade."'>".$grade."</option>");
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3 col-xs-7">
                                    <label for="group">Group</label>
                                    <select id="group" name="group" class="form-control">
                                        <?php
                                        	$grouptype=['A','B','C','D','MT'];
                                            for($group = 0; $group < 5 ; $group++){
                                                if($grouptype[$group] == ($record['group']))
                                                {
                                                    echo ("<option value='".$grouptype[$group]."' selected >".$grouptype[$group]."</option>");
                                                }
                                                else
                                                {
                                                    echo ("<option value='".$grouptype[$group]."'>".$grouptype[$group]."</option>");
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>                                                   
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-3 col-xs-7">
                                    <label for="classname">Class Name</label>
                                    <input type="text" id="classname" name="classname" class="form-control" value={{$record['classname']}}>
                                    @if (count($errors) > 0)
									    <div class="alert alert-warning">
									        <ul>
									            @foreach ($errors->all() as $error)
									               {{ $error }}
									            @endforeach 
									        </ul>
									    </div>
									@endif   
                                </div>
                                <div class="form-group col-lg-3 col-xs-7">
                                    <label for="homeroom_teacher">Current HomeRoom Teacher</label>
                                    <input type="text" id="homeroom_teacher" name="homeroom_teacher" class="form-control" value="{{$record['homeroom_teacher']}}" disabled>
                                </div>
                                <div class="form-group col-lg-3 col-xs-7">
                                    <label for="homeroomteacher">Change Homeroom Teacher</label>
                                    <select id="homeroomteacher" name="homeroomteacher" class="form-control">
                                    	<option value="" slected>Select to change</option>
                                        <?php
                                            foreach($record['teacherlist'] as $key => $value){
                                                echo ("<option value='".$value->id."'>".$value->id." | ".$value->user->firstname." ".$value->user->middlename." ".$value->user->lastname."</option>");
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div> <!-- Student box body -->
                    </div> <!-- Student box -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button id ="class_form_submit" type="submit" class="btn btn-primary">Change Class Info</button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
<!-- page script -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
 $(function () {
	setTimeout(function() {
		    $('.alert').slideUp('slow');
		}, 2500); // <-- time in milliseconds
});

</script>

@endsection