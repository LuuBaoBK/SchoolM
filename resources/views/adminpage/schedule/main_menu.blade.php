@extends('adminpage.schedule.schedule_template')
@section('schedule_content')
<div class="box box-primary">
    <div class="box-header">
        <p class="text-center" style="font-size:25px">General Info</p>
    </div>
    <div class="box-body">
        <ul style="width:50%;margin:auto" class="list-group list-group-unbordered">
            @foreach($subject_list as $subject)
            <li class="list-group-item" style="color:{{$subject->style_on_view}}">
                <b>{{$subject->subject_name}}</b>
                <a class="pull-right" style="color:{{$subject->style_on_view}}">{{$subject->teacher_available}}/{{$subject->teacher_need}}</a>
            </li>
            @endforeach
            <li class="list-group-item" style="color:{{$total_period['color']}}">
                <b>Total Period Per Week</b>
                <a class="pull-right" style="color:{{$total_period['color']}}">{{$total_period['class']}}/{{$total_period['max']}}</a>
            </li>
        </ul>
    </div>
</div>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#btn_home').addClass('active');
    });
</script>
@endsection