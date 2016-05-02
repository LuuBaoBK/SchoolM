@extends('mytemplate.blankpage_ad')

@section('content')
<style type="text/css">
canvas{
        width: 100% !important;
        /*max-width: 300px;*/
        height: auto !important;
        /*max-height: 200px !important;*/
    }
</style>
<section class="content-header">
    <h1>
       	Admin
        <small>Statistic</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-home"></i>Admin</a></li>
        <li class="active"><a href="/admin/schedule">Statistic</a></li>
    </ol>
</section>

<section class="content">
  <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
  <div class="row">
    <div class="col-lg-6 col-md-6">
    	<div class="box box-primary">
    		<div class="box-header">
    			<h4 class="text-center"><b>Number Of Student</b></h4>
    		</div>
    		<div class="box-body">
    			<div class="chart">
    				<canvas id="number_of_student_chart"></canvas>
    			</div>
    		</div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6">
      <div class="box box-info">
        <div class="box-header">
          <h4 class="text-center"><b>The Proportion of Student / Grade</b></h4>
        </div>
        <div class="box-body">
            <canvas id="student_grade_chart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-6">
      <div class="box box-info">
        <div class="box-header">
          <h4 class="text-center"><b>The Proportion of Male & Female Student</b></h4>
        </div>
        <div class="box-body">
            <canvas id="male_female_chart"></canvas>
        </div>
      </div>
    </div>	
  </div>
</section>
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<script src="{{asset("/mylib/chartjs/dist/Chart.js")}}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#sidebar_list_8').addClass('active');
	$('#sidebar_list_8_1').addClass('active');

  function config_height(){
    var window_height = $(window).height();
    // $('#number_of_student_chart').parent().height(300);
  }
  config_height();
  function draw_chart(){
    var token = $('input[name="_token"]').val();
    $.ajax({
      url     :"<?= URL::to('/admin/statistic/numberofstudent/get_data') ?>",
      type    :"POST",
      async   :false,
      data    :{
        '_token' : token,
      },
      success:function(record){
        console.log(record);
        draw_line_chart(record.labels1,record.data1);
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  }

  draw_chart();

  function draw_line_chart(input_labels,input_data){
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
        //return 0;
    };
    var randomColorFactor = function() {
        return Math.round(Math.random() * 255);
    };
    var randomColor = function(opacity) {
        return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
    };
    var config = {
      type: 'line',
      data: {
          labels: input_labels,
          datasets: [{
              label: "Number of Student",
              data: input_data,
              fill: true,
              borderDash: [5, 5],
          }]
      },
          options: {
              responsive: true,
              hover: {
                  mode: 'dataset'
              },
              scales: {
                  xAxes: [{
                      display: true,
                      scaleLabel: {
                          show: false,
                          labelString: 'Month'
                      }
                  }],
                  yAxes: [{
                      display: true,
                      scaleLabel: {
                          show: true,
                          labelString: 'Value'
                      },
                      // ticks: {
                      //     suggestedMin: 0,
                      //     suggestedMax: 9,
                      // }
                  }]
              }
          }
    };
    $.each(config.data.datasets, function(i, dataset) {
        dataset.borderColor = randomColor(0.4);
        dataset.backgroundColor = randomColor(0.5);
        dataset.pointBorderColor = randomColor(0.7);
        dataset.pointBackgroundColor = randomColor(0.5);
        dataset.pointBorderWidth = 1;
    });
    var ctx = $("#number_of_student_chart").get(0).getContext("2d");
    var Line = new Chart(ctx, config);

    ctx = $('#male_female_chart').get(0).getContext("2d");
    var Line22 = new Chart(ctx,config);
  }
});
</script>
@endsection