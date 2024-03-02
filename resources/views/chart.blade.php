<!DOCTYPE html>
<html>
<head>
    <title>Laravel Highcharts</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>

<div id="chartContainer" style="height: 300px; margin: 0 auto"></div>

<script>
    // Function to fetch data and update the chart
    function updateChart() {
        $.ajax({
            url: '{{ route("get-flat-voucher-chart") }}',
            method: 'GET',
            dataType: 'json',
            success: function (chartData) {
                // Create Highcharts chart
                Highcharts.chart('chartContainer', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Flat Voucher Chart'
                    },
                    xAxis: {
                        categories: chartData.categories
                    },
                    yAxis: {
                        title: {
                            text: 'Amount'
                        }
                    },
                    series: [{
                        name: 'Amount',
                        data: chartData.data
                    }]
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching chart data:', error);
            }
        });
    }

    // Call the function on page load or whenever you want to update the chart
    $(document).ready(function () {
        updateChart();
    });
</script>

</body>
</html>
