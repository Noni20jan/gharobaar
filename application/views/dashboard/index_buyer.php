<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/utils.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/analyser.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>



<style type="text.css">

  .highcharts-figure, .highcharts-data-table table {
  min-width: 310px; 
  max-width: 800px;
  margin: 1em auto;
}


#container {
  height: 400px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>


<!-- custom analytics  -->





<script>
  var dataMap;
  // Create the chart
  $(document).ready(function() {
    var data = {
      "test": "test"
    }


    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Bar_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {

        // console.log(data);
        dataMap = data;
      }
    });
    // console.log(dataMap);
  });


  Highcharts.chart('column', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'New Customers in Last Week'
    },

    xAxis: {
      categories: <?php echo json_encode($days_newCustomer); ?>,
      plotBands: [{ // visualize the weekend
        from: 4.5,
        to: 6.5,
        color: 'white'
      }]
    },
    yAxis: {
      title: {
        text: 'Number of Customers'
      }
    },
    tooltip: {
      shared: true,
      valueSuffix: ' customers'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      line: {
        fillOpacity: 0.5
      }
    },
    series: [{
      name: 'Last Week',
      data: <?php echo json_encode($test); ?>
    }, ]
  });



  $(document).ready(function() {

    var data = {
      "test1": "test1"
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Line_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {
        // console.log(data);
        dataMap = data;
      }
    });
    console.log(dataMap);
  });

  Highcharts.chart('column1', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'No. of transactions in the last one week'
    },
    xAxis: {
      categories: [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
      ],
      plotBands: [{ // visualize the weekend
        from: 4.5,
        to: 6.5,
        color: 'white'
      }]
    },
    yAxis: {
      title: {
        text: 'Number of transactions'
      }
    },
    tooltip: {
      shared: true,
      valueSuffix: ' transaction'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      line: {
        fillOpacity: 0.5
      }
    },
    series: [{
      name: 'Last Week',
      data: <?php echo json_encode($test1); ?>
    }, ]
  });
  $(document).ready(function() {

    var data = {
      "test2": "test2"
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Line_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {
        // console.log(data);
        dataMap = data;
      }
    });
    console.log(dataMap);
  });

  Highcharts.chart('column2', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Average value of transactions'
    },
    xAxis: {
      categories: [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
      ],
      plotBands: [{ // visualize the weekend
        from: 4.5,
        to: 6.5,
        color: 'white'
      }]
    },
    yAxis: {
      title: {
        text: 'Number of transactions'
      }
    },
    tooltip: {
      shared: true,
      valueSuffix: ' transaction'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      line: {
        fillOpacity: 0.5
      }
    },
    series: [{
      name: 'Last Week',
      data: <?php echo json_encode($test2); ?>
    }, ]
  });
  // 

  $(document).ready(function() {

    var data = {
      "test3": "test3"
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Line_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {
        // console.log(data);
        dataMap = data;
      }
    });
    console.log(dataMap);
  });

  Highcharts.chart('column3', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'New markets covered till now'
    },

    xAxis: {
      categories: [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
      ],
      plotBands: [{ // visualize the weekend
        from: 4.5,
        to: 6.5,
        color: 'white'
      }]
    },
    yAxis: {
      title: {
        text: 'Number of transactions'
      }
    },
    tooltip: {
      shared: true,
      valueSuffix: ' transaction'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      line: {
        fillOpacity: 0.5
      }
    },
    series: [{
      name: 'Last Week',
      data: <?php echo json_encode($test3); ?>
    }, ]
  });


  $(document).ready(function() {

    var data = {
      "test4": "test4"
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Line_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {
        // console.log(data);
        dataMap = data;
      }
    });
    console.log(dataMap);
  });

  Highcharts.chart('column4', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'New markets delivered to in the last one week'
    },
    xAxis: {
      categories: [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
      ],
      plotBands: [{ // visualize the weekend
        from: 4.5,
        to: 6.5,
        color: 'white'
      }]
    },
    yAxis: {
      title: {
        text: 'Number of transactions'
      }
    },
    tooltip: {
      shared: true,
      valueSuffix: ' transaction'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      line: {
        fillOpacity: 0.5
      }
    },
    series: [{
      name: 'Last Week',
      data: <?php echo json_encode($test4); ?>
    }, ]
  });




  $(document).ready(function() {

    var data = {
      "test5": "test5"
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Line_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {
        // console.log(data);
        dataMap = data;
      }
    });
    console.log(dataMap);
  });

  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'GROWTH OVER LAST WEEK'
    },
    credits: {
      enabled: false
    },
    accessibility: {
      announceNewData: {
        enabled: true
      }
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      title: {
        text: 'Total growth percent'
      }

    },
    legend: {
      enabled: false
    },
    plotOptions: {
      series: {
        borderWidth: 0,
        dataLabels: {
          enabled: true,
          format: '{point.y:.1f}%'
        }
      }
    },

    tooltip: {
      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{
      name: "Days",
      colorByPoint: true,
      data: <?php echo json_encode($test5); ?>
    }],
    drilldown: {
      series: [{
          name: "SUNDAY",
          id: "SUNDAY",
          data: <?php echo json_encode($dd1); ?>
        },
        {
          name: "MONDAY",
          id: "MONDAY",
          data: <?php echo json_encode($dd1); ?>
        },
        {
          name: "TUESDAY",
          id: "TUESDAY",
          data: <?php echo json_encode($dd1); ?>
        },
        {
          name: "WEDNESDAY",
          id: "WEDNESDAY",
          data: <?php echo json_encode($dd1); ?>
        },
        {
          name: "THRUSDAY",
          id: "THRUSDAY",
          data: <?php echo json_encode($dd1); ?>
        },
        {
          name: "FRIDAY",
          id: "FRIDAY",
          data: <?php echo json_encode($dd1); ?>
        },
        {
          name: "SATURDAY",
          id: "SATURDAY",
          data: <?php echo json_encode($dd1); ?>
        },

      ]
    }
  });


  // Create the chart
  $(document).ready(function() {

    var data = {
      "test6": "test6"
    }

    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Bar_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {

        // console.log(data);
        dataMap = data;
      }
    });
  });
  Highcharts.chart('container-fluid', {
    chart: {
      type: 'column'
    },

    title: {
      text: 'GROWTH OVER LAST WEEK'
    },
    credits: {
      enabled: false
    },
    accessibility: {
      announceNewData: {
        enabled: true
      }
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      title: {
        text: 'Total transaction percent'
      }

    },
    legend: {
      enabled: false
    },
    plotOptions: {
      series: {
        borderWidth: 0,
        dataLabels: {
          enabled: true,
          format: '{point.y:.1f}%'
        }
      }
    },

    tooltip: {
      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{
      name: "Days",
      colorByPoint: true,
      data: <?php echo json_encode($test6); ?>
    }],
    drilldown: {
      series: [{
          name: "SUNDAY",
          id: "SUNDAY",
          data: <?php echo json_encode($dd2); ?>
        },
        {
          name: "MONDAY",
          id: "MONDAY",
          data: <?php echo json_encode($dd2); ?>


        },
        {
          name: "TUESDAY",
          id: "TUESDAY",
          data: <?php echo json_encode($dd2); ?>
        },
        {
          name: "WEDNESDAY",
          id: "WEDNESDAY",
          data: <?php echo json_encode($dd2); ?>
        },
        {
          name: "THRUSDAY",
          id: "THRUSDAY",
          data: <?php echo json_encode($dd2); ?>
        },
        {
          name: "FRIDAY",
          id: "FRIDAY",
          data: <?php echo json_encode($dd2); ?>
        },
        {
          name: "SATURDAY",
          id: "SATURDAY",
          data: <?php echo json_encode($dd2); ?>
        },

      ]
    }
  });

  $(document).ready(function() {
    var data = {
      "test7": "test7"
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Pie_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {

        // console.log(data);
        dataMap = data;
      }
    });
  });

  Highcharts.chart(container1, {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
    },

    title: {
      text: 'Active Customer placed order in 3 months'
    },
    credits: {
      enabled: false
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Customers',
      colorByPoint: true,
      data: <?php echo json_encode($test7); ?>
    }],
    drilldown: {
      series: [{
          name: "Deepansh",
          id: "Deepansh",
          data: <?php echo json_encode($dy1); ?>
        }, {
          name: "Navin",
          id: "Navin",
          data: <?php echo json_encode($dy2); ?>
        },
        {
          name: "Rajesh",
          id: "Rajesh",
          data: <?php echo json_encode($dy3); ?>
        },
        {
          name: "knight",
          id: "knight",
          data: <?php echo json_encode($dy4); ?>
        },
        {
          name: "Joker",
          id: "Joker",
          data: <?php echo json_encode($dy5); ?>
        },
        {
          name: "Arrow",
          id: "Arrow",
          data: <?php echo json_encode($dy6); ?>
        }
      ],
    }
  });

  $(document).ready(function() {
    var data = {
      "test8": "test8"
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
      type: 'post',
      url: 'http://localhost/gharobar/Pie_controller/json_data',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {

        // console.log(data);
        dataMap = data;
      }
    });
  });
  Highcharts.chart(container2, {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
    },

    title: {
      text: 'Active Customer  not placed order in 3 months'
    },
    credits: {
      enabled: false
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',

        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Customers',
      colorByPoint: true,
      data: <?php echo json_encode($test8); ?>
    }],
    drilldown: {
      series: [{
          name: "Deepansh",
          id: "Deepansh",
          data: <?php echo json_encode($dy1); ?>
        }, {
          name: "Navin",
          id: "Navin",
          data: <?php echo json_encode($dy2); ?>
        },
        {
          name: "Rajesh",
          id: "Rajesh",
          data: <?php echo json_encode($dy3); ?>
        },
        {
          name: "knight",
          id: "knight",
          data: <?php echo json_encode($dy4); ?>
        },
        {
          name: "Joker",
          id: "Joker",
          data: <?php echo json_encode($dy5); ?>
        },
        {
          name: "Arrow",
          id: "Arrow",
          data: <?php echo json_encode($dy6); ?>
        }
      ],
    }

  });
</script>