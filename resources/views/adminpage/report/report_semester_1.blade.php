@extends('mytemplate.report_print')
@section('mycontent')
<style type="text/css" media="print">
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
  @media print {
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
}

</style>
@if($total_class > 0)
  @foreach($class_list as $key => $class)
  <body class="layout-boxed">
    <section class="content">
      <div class="wrapper">
        <div class="box box-primary box-solid">
          <div class="box-header">
            <span>
              <?php 
                $year = date("Y");
                $year = (date("m") < 8 ) ? ($year - 1) : $year;
                $year_plus = $year+1;
              ?>
              Report Semester 1 : {{$year}} - {{$year_plus}}
            </span>
            <h4 class="text-center">{{$class->classname}}</h4>
          </div>
          <div class="box-body">
            <table id="info_table" class="table table-responsive table-striped">
              <thead>
                <tr>
                  <th>Full name</th>
                  @foreach($subject_list as $subject)
                  <th>{{$subject->subject_name}}</th>
                  @endforeach
                  <th>GPA</th>
                </tr>
              </thead>
              <tbody>
                @foreach($class['student_list'] as $stu_key => $stu)
                <tr>
                  <td><div>{{$stu->fullname}}</div></td>
                  @foreach($subject_list as $subject)
                  <td><div>{{$stu['score_list'][$subject->id]}}</div></td>
                  @endforeach
                  <td><div>{{$stu['score_list']['gpa']}}</div></td>
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
      </div>
  @if($key<($total_class-1))
    <div class="pagebreak"></div>
  @endif
  </section>
  </body>
  @endforeach
@else
  <div class="body">
  <div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i>This Scholastic Has No Class</h4>
  </div>
</div>
@endif

<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
  // $(".tab td, .tab th").each(function(){ $(this).css("width",  $(this).width() + "px")  });
  // $(".tab tr").wrap("<div class='avoidBreak'></div>");
  setTimeout(function(){ window.print(); }, 3000);
});
</script>
@endsection
