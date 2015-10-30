@extends('class.template')
@section('content')
 
<!-- Main content -->
<p style="color:red" ><?php echo Session::get('message'); ?></p>
<a href="<?php echo 'form' ?>">Add New Class</a>
<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Semester</th>
            <th>Class name</th>
            <th>Homeroom teacher</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($data as $row) {
        ?>
            <tr>
                <td><?php echo $row->id ?></td>
                <td><?php echo $row->semester ?></td>
                <td><?php echo $row->classname ?></td>
                <td><?php echo $row->homeroom_teacher ?></td>
                <td>
                    <a href="<?php echo 'edit/'.$row->id ?>">Edit</a> | 
                    <a href="<?php echo 'delete/'.$row->id ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Semester</th>
            <th>Class name</th>
            <th>Homeroom teacher</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>
           
@endsection