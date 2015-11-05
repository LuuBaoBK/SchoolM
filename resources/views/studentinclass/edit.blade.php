@extends('class.template')
@section('content')
<html>
<head>
<title>Edit Class</title>
</head>
<p style="color:red">{{ $errors->first('class_id')}}</p>
<p style="color:red">{{ $errors->first('student_id')}}</p>
<body>
    <form action="{{action('StudentInClass\StudentInClassController@update')}}" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
        Id
        <input type="text" name="class_id"  value="<?= $row->class_id ?>" class="form-control">
        Semester
        <input type="text" name="student_id" value="<?= $row->student_id ?>" class="form-control">
        <br>
        <input type="submit" value="Edit Record" class="btn btn-primary">
    </form>
</body>
</html>
@endsection