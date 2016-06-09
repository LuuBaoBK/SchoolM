@extends('mytemplate.report_print')
@section('mycontent')
<style type="text/css">
  @media print {
    @page 
    {
        size: landscape;   /* auto is the current printer page size */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }

    body 
    {
        background-color:#FFFFFF; 
        /*border: solid 1px black ;*/
        margin: 0px;  /* the margin on the content before printing */
        padding: 0;
    }
    .no-print,
    .main-sidebar,
    .left-side,
    .main-header,
    .content-header {
      display: none !important;
    }
    .content-wrapper,
    .right-side,
    .main-footer {
      margin-left: 0 !important;
      min-height: 0 !important;
      -webkit-transform: translate(0, 0) !important;
      -ms-transform: translate(0, 0) !important;
      -o-transform: translate(0, 0) !important;
      transform: translate(0, 0) !important;
    }
    .fixed .content-wrapper,
    .fixed .right-side {
      padding-top: 0 !important;
    }
    .invoice {
      width: 100%;
      border: 0;
      margin: 0;
      padding: 0;
    }
    .invoice-col {
      float: left;
      width: 33.3333333%;
    }
    .table-responsive {
      overflow: auto;
    }
    .table-responsive > .table tr th,
    .table-responsive > .table tr td {
      white-space: normal !important;
    }
    table tbody tr {
      page-break-inside: avoid;
    }
  }
</style>
<div class="box box-primary no-print">
  <div class="box-header">
    <h4 class="text-center">Report Control</h4>
  </div>
  <div class="box-body">
    <div class="col-lg-6">
      <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
      <button id="btn_send_to_parent" class="btn btn-primary btn-block" style="width:85%; margin:auto">Send Report To Parent</button>
    </div>
    <div class="col-lg-6">
      <button id="btn_print" class="btn btn-primary btn-block" style="width:85%; margin:auto"><i class="glyphicon glyphicon-print pull-left"></i>Print</button>
    </div>
  </div>
</div>
<div class="box box-solid box-primary">
  <div class="box-header">
    <span>
      <?php 
        $year = date("Y");
        $year = (date("m") < 8 ) ? ($year - 1) : $year;
        $year_plus = $year+1;
      ?>
      Report Semester 2 : {{$year}} - {{$year_plus}}
    </span>
    <span class="pull-right">
      <?php $date = date("d-m-Y"); ?>
      {{$date}}
    </span>
    <h4 class="text-center">{{$class->classname}}</h4>
  </div>
  <div class="box-body">
    <table id="info_table" class="table table-responsive table-striped">
      <thead>
        <tr>
          <th style="display:none">Id</th>
          <th>Full name</th>
          @foreach($subject_list as $subject)
          <th>{{$subject->subject_name}}</th>
          @endforeach
          <th>GPA</th>
          <th>Rank</th>
          <th>Performance</th>
        </tr>
      </thead>
      <tbody>
        @foreach($student_list as $stu_key => $stu)
        <tr>
          <td style="display:none"><div>{{$stu['id']}}</div></td>
          <td><div>{{$stu['fullname']}}</div></td>
          @foreach($subject_list as $subject)
          <td><div>{{$stu['score_list'][0][$subject->id]}}</div></td>
          @endforeach
          <td><div>{{$stu['score_list'][0]['tb_hk1']}}</div></td>
          <td><div>{{($stu_key+1)}}</div></td>
          <td><div>{{$stu['performance']}}</div></td>
        </tr>
        @endforeach
      </tbody>  
    </table>
  </div>
  <div class="box-footer">
    <div class="pull-right hidden-xs">
      SchooM IT-Apartment
    </div>
  </div>
</div>
<!-- <div class="body">
  <div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i>This Scholastic Has No Class</h4>
  </div> -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#btn_print').on('click',function(){
    window.print();
  });
  $('#btn_send_to_parent').on('click',function(){
    var studentlist = [];
    var student = [];
    var header = [];
    var col;
    $('#info_table tbody tr').each(function(){
      student = [];
      col = $(this).find('td');
      col.each(function(i,j){
        student.push($(j).children().html());
      });
      studentlist.push(student);
    });
    $('#info_table thead tr th').each(function(){
      header.push($(this).html());
    });
    // call request
    var token           = $('input[name="_token"]').val();
    $.ajax({
        url     :"<?= URL::to('/teacher/manage-class/send_report') ?>",
        type    :"POST",
        async   :false,
        data    :{
                'studentlist'   :studentlist,
                'header'        :header,
                'type'          :"Report HK_2",
                '_token'        :token
                },
        success:function(record){
            console.log(record);
        },
        error:function(){
            alert("something went wrong, contact master admin to fix");
        }
    });
  });});
</script>
@endsection
