<?php
if(isset($post)) {
  foreach ($post as $key => $value) {
    	if($key == "submit") continue;
    	$username = $value;
  }
}

$bookings = $staff->bookings($DBH, $username);


?>
<script src="/assets/js/custom/commonScripts.js"></script>
<div id="bar" class="graphDefault"></div>
<script type="text/javascript">
$(function() {
var bookFilled = new Highcharts.Chart({
    chart: { 
      renderTo : 'bar',
      type: 'bar',
      backgroundColor: 'rgba(0,0,0,0)'
    },
    title: {
      text: 'Booking Quantity and Filled for the Year',
      style: {
        color: 'white'
      },
      x: -20 //center
    },
    subtitle: {
      text: 'Source: Nightline Server',
      style: {
        color: 'white'
      },
      x: -20
    },
    legend: {
      itemStyle: {
        color: 'white'
      },
    },
    xAxis: {
      categories: ['Bookings'], /*As the php array contains strings add a single speech mark to the beginning and end */
      labels: {
        style: {
          color: 'white'
        }
      }
    },
    yAxis: {
      min: 0,
      labels: {
        style: {
          color: 'rgba(255,255,255,1)'
        }
      },
      title: {
        text: 'Total Calls',
        style: {
          color: 'rgba(255,255,255,1)'
        }
      },
      plotOptions: {
        bar: {
          dataLabels: {
            enabled: true
          }
        }
      }
    },
    credits: {
      enabled: false
    },
    series: [{
      name: 'Booked',
      data: [<?php echo $bookings['booked']; ?>]
    }, {
    name: 'Filled',
    data: [<?php echo $bookings['filled']; ?>]
  }]
}); 
});
</script>