@extends('adminpage.schedule.schedule_template')
@section('schedule_content')
<div class="box box-primary">
    <div class="box-header">
        <p class="text-center" style="font-size:25px">Please Fix These Error Before Create New Scheule</p>
    </div>
    <div class="box-body">
        <ul style="width:45%; margin:auto" class="list-group list-group-bordered pull-left">
            <!-- @foreach($subject_list as $subject)
            <li class="list-group-item" style="color:{{$subject->style_on_view}}">
                <b>{{$subject->subject_name}}</b>
                <a class="pull-right" style="color:{{$subject->style_on_view}}">{{$subject->total_used_teachers}}/{{$subject->teacher_need}}</a>
            </li>
            @endforeach
            <li class="list-group-item" style="color:{{$total_period['color']}}">
                <b>Total Period Per Week</b>
                <a class="pull-right" style="color:{{$total_period['color']}}">{{$total_period['class']}}/{{$total_period['max']}}</a>
            </li> -->
            <li class="list-group-item text-center" style="color:{{$subject->style_on_view}}">
                <b class="">List Teacher Overwork</b>
            </li>
            @foreach($teacher_error_list as $teacher)
            <li class="list-group-item" style="color:{{$subject->style_on_view}}">
                <b>{{$teacher->id}} - {{$teacher->fullname}} ({{$teacher->subject}})</b>
                <a class="pull-right" style="color:{{$subject->style_on_view}}">{{$teacher->total_period}}</a>
            </li>
            @endforeach
        </ul>
        <ul style="width:50%; margin:auto" class="list-group list-group-bordered pull-right">
            <li class="list-group-item list-group-item-danger">Duplicated Subject</li>
            <li class="list-group-item"></li>
            @foreach($duplicated_list as $row)
            <li class="list-group-item">{{$row}}</li>
            @endforeach
            <li class="list-group-item list-group-item-warning">No Assigment</li>
            <li class="list-group-item"></li>
            @foreach($no_assigment_list as $row)
            <li class="list-group-item">{{$row}}</li>
            @endforeach
        </ul>
    </div>
</div>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#btn_new_schedule').addClass('active');
    });
</script>
@endsection