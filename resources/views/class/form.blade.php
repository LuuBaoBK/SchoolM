@extends('class.template')
@section('content')
<html>
<head>
<title>Add Class</title>
</head>
<p style="color:red">{{ $errors->first('id')}}</p>
<p style="color:red">{{ $errors->first('semester')}}</p>
<p style="color:red">{{ $errors->first('classname')}}</p>
<p style="color:red">{{ $errors->first('homeroom_teacher')}}</p>
<body>
	<form action="{{action('Class\ClassController@save')}}" method="post">
		<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
		Id
		<input type="text" name="id" class="form-control">
		Semester
		<input type="text" name="semester" class="form-control">
		Class Name
		<input type="text" name="classname" class="form-control">
		Homeroom Teacher
		<input type="text" name="homeroom_teacher" class="form-control">
		<br>
		<input type="submit" value="Save Record" class="btn btn-primary">
	</form>
</body>
</html>
@endsection