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
          <h4 class="text-center"><b>The Number of Student Per Grade In The Last 2 Year</b></h4>
        </div>
        <div class="box-body">
            <canvas id="student_grade_chart_1"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6">
      <div class="box box-info">
        <div class="box-header">
          <h4 class="text-center"><b>The Proportion of Student This Scholastic</b></h4>
        </div>
        <div class="box-body">
            <canvas id="student_grade_chart_2"></canvas>
            <table class="table"> 
              <tr>
                <td class="text-center"><span style="background-color:#F7464A; color:#F7464A;">___</span> Grade 6</td>
                <td class="text-center"><span style="background-color:#46BFBD; color:#46BFBD;">___</span> Grade 7</td>
                <td class="text-center"><span style="background-color:#FDB45C; color:#FDB45C;">___</span> Grade 8</td>
                <td class="text-center"><span style="background-color:#949FB1; color:#949FB1;">___</span> Grade 9</td>
                <td class="text-center"><span style="background-color:blue; color:blue;">___</span> Male</td>
                <td class="text-center"><span style="background-color:pink; color:pink;">___</span> Female</td>
              </tr>
            </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6">
      <div class="box box-info">
        <div class="box-header">
          <h4 class="text-center"><b>The Proportion of New Male & Female Student</b></h4>
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
<script src="{{asset("/mylib/mychartjs/dist/Chart.js")}}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#sidebar_list_8').addClass('active');
	$('#sidebar_list_8_1').addClass('active');

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
        // console.log(record);
        draw_line_chart(record.chart1.labels,record.chart1.data);
        draw_bar_chart(record.chart2);
        draw_doughnut_chart(record.chart3);
        draw_pie_chart(record.student_male_count,record.student_female_count);
      },
      error:function(){
          alert("something went wrong, contact master admin to fix");
      }
    });
  }

  draw_chart();

  function draw_line_chart(input_labels,input_data){
    var setColor = function(red,green,blue,opacity){
      return 'rgba(' + red + ',' + green + ',' + blue + ',' + (opacity || '.3') + ')';
    }
    var config = {
      type: 'line',
      data: {
          labels: input_labels,
          datasets: [{
              label: "Number of Student",
              data: input_data,
              fill: true,
              borderDash: [5, 5],
              borderColor : "grey",
              backgroundColor : setColor(60,141,188,0.5),
              pointBorderColor : "red",
              pointBackgroundColor : 'black',
              pointBorderWidth : 1,
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
                          labelString: 'Year'
                      }
                  }],
                  yAxes: [{
                      display: true,
                      scaleLabel: {
                          show: true,
                          labelString: 'Value'
                      },
                      ticks: {
                          suggestedMin: 0,
                          // suggestedMax: 9,
                      }
                  }]
              }
          }
    };
    // $.each(config.data.datasets, function(i, dataset) {
    //     dataset.borderColor = randomColor(0.4);
    //     dataset.backgroundColor = randomColor(0.5);
    //     dataset.pointBorderColor = randomColor(0.7);
    //     dataset.pointBackgroundColor = randomColor(0.5);
    //     dataset.pointBorderWidth = 1;
    // });
    var ctx = $("#number_of_student_chart").get(0).getContext("2d");
    var Line = new Chart(ctx, config);
  }

  function draw_bar_chart(data){
    var setColor = function(red,green,blue,opacity){
      return 'rgba(' + red + ',' + green + ',' + blue + ',' + (opacity || '.3') + ')';
    }
    var config = {
          type: 'bar',
          data: {
            labels: ["6", "7", "8", "9"],
            datasets: [{
                label: data.label1,
                backgroundColor: "rgba(220,220,220,0.5)",
                data: [data.grade_6_1,data.grade_7_1,data.grade_8_1,data.grade_9_1]
            }, {
                label: data.label2,
                backgroundColor: "rgba(151,187,205,0.5)",
                data: [data.grade_6_2,data.grade_7_2,data.grade_8_2,data.grade_9_2]
            }]
          },
          options: {
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each bar to be 2px wide and green
            elements: {
                rectangle: {
                    borderWidth: 2,
                    borderColor: 'rgb(0, 255, 0)',
                    borderSkipped: 'bottom'
                }
            },
            responsive: true,
            legend: {
                position: 'top',
            },
            scales: {
                  xAxes: [{
                      display: true,
                      scaleLabel: {
                          show: false,
                          labelString: 'Year'
                      }
                  }],
                  yAxes: [{
                      display: true,
                      scaleLabel: {
                          show: true,
                          labelString: 'Value'
                      },
                      ticks: {
                          suggestedMin: 0,
                      }
                  }]
              }
          },
    };
    var ctx = $('#student_grade_chart_1').get(0).getContext("2d");
    var student_grade_chart_1 = new Chart(ctx,config);
  }

  function draw_doughnut_chart(data){
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    data.grade_6,
                    data.grade_7,
                    data.grade_8,
                    data.grade_9,
                    0,
                    0,
                    0,
                    0
                ],
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#FDB45C",
                    "#949FB1",
                ],
                label: 'Propotion Student / Grade'
            },
            {
                data: [
                    data.male_6,
                    data.female_6,
                    data.male_7,
                    data.female_7,
                    data.male_8,
                    data.female_8,
                    data.male_9,
                    data.female_9,
                ],
                backgroundColor: [
                    "blue",
                    "pink",
                    "blue",
                    "pink",
                    "blue",
                    "pink",
                    "blue",
                    "pink"
                ],
                label: 'Propotion Gender / Grade',
            }],
            labels: [
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                ""
            ]
        },
        options: {
            responsive: true,
            legend: {
                display: false,
                position: 'bottom',
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
        }
    };
      var ctx = $("#student_grade_chart_2").get(0).getContext("2d");
      var student_grade_chart_2 = new Chart(ctx, config);
  }

  function draw_pie_chart(data1,data2){
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    data1,
                    data2,
                ],
                backgroundColor: [
                    "blue",
                    "pink",
                ],
                label: 'Propotion Student / Grade'
            }],
            labels: [
                "Male",
                "Female"
            ]
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'bottom',
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            cutoutPercentage: 0
        }
    };
      var ctx = $("#male_female_chart").get(0).getContext("2d");
      var male_female_chart = new Chart(ctx, config);
  }
});
</script>
@endsection