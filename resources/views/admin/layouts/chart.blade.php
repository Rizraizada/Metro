

    <style>
        /* Additional styles can be added here */
        #combine-chart {
            max-width: 800px;
            margin: 20px auto;
        }

        .panel-heading {
            background-color: #5bc0de;
            color: #fff;
            padding: 10px;
        }

        .tools {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Combined Chart
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div id="combine-chart">
                            <div id="legendcontainer26" class="legend-block">
                                <!-- Legend content can be added here if needed -->
                            </div>
                            <div id="combine-chartContainer" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

  <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('/get-chart-data')
                .then(response => response.json())
                .then(data => {
                    var chartData = {
                        labels: data.map(item => `Delay: ${item.delay_charge}, Utility: ${item.utility_charge}, Special Discount: ${item.special_discount}, Car Money: ${item.car_money}, Tiles Work: ${item.tiles_work}, Refund Money: ${item.refund_money}, Miscellaneous Cost: ${item.miscellaneous_cost}`),
                        datasets: [{
                            label: 'Amount',
                            backgroundColor: data.map(item => (item.special_discount < 0 || item.refund_money < 0) ? 'rgba(255, 0, 0, 0.5)' : 'rgba(75, 192, 192, 0.2)'),
                            borderColor: data.map(item => (item.special_discount < 0 || item.refund_money < 0) ? 'rgba(255, 0, 0, 1)' : 'rgba(75, 192, 192, 1)'),
                            borderWidth: 1,
                            data: data.map(item => item.amount)
                        }]
                    };

                    var ctx = document.getElementById('combine-chartContainer').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Expense Categories'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Amount'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top' // Adjust legend position
                                },
                                title: {
                                    display: true,
                                    text: 'Profit Loss Chart'
                                }
                            }
                        }
                    });
                });
        });
    </script>

</body>

</html>
