<?php

$type = $staff->type($DBH, $username);

?>
<script src="/assets/js/custom/commonScripts.js"></script>
<div id="cat" class="graphDefault"></div>
<script type="text/javascript">
	$(function () {
    $('#cat').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Calls for <?php echo $username; ?> by type.'
        },
        subtitle: {
            text: 'Source: Nightline Server'
        },
        xAxis: {
            categories: [<?php echo $type['cat']; ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Calls'
            }
        },
        tooltip: {
            /*headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',*/
            shared: true,
            // useHTML: true,
            formatter:function(){
                    console.log(this);
                    return 'Call Type: ' + this.x + ' - Total Calls: ' + this.y;
                }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Categories',
            data: [<?php echo $type['count']; ?>]

        }]
    });
});

</script>