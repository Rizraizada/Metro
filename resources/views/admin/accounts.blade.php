@include('admin.layouts.Header')
<!-- Include Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@include('admin.layouts.sidebar')
<style>
     .amount-display {
        font-size: 24px;
        margin-top: 10px;
    }

         #chart-container {
            max-width: 800px;
            margin: 20px auto;
        }
 </style>
<body>

    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-4">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <div class="gauge-canvas">
                                    <h4 class="widget-h">Recent Projects</h4>
                                    <div id="recentProjectsCarousel" class="slick-carousel">
                                        @isset($recentProjects)
                                            @foreach($recentProjects as $project)
                                                <div>{{ $project->name }}</div>
                                            @endforeach
                                        @else
                                            <div>No recent projects available.</div>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <div class="gauge-canvas">
                                    <h4 class="widget-h">Profit within Date Range</h4>
                                    <div class="input-group">
                                        <input type="text" id="dateRangePicker" class="form-control" placeholder="Select Date Range">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="filterByDateRange()">Go</button>
                                        </span>
                                    </div>
                                    <div id="recentProjectsCarousel" class="slick-carousel">
                                        <p id="profitValue" class="amount-display">{{ number_format($todayProfitLoss, 2) }} Tk</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <div class="daily-visit">
                                    <h4 class="widget-h">Recent Items</h4>
                                    <div id="dailyVisitorsCarousel" class="slick-carousel">
                                        @isset($dailyVisitorsItems)
                                            @foreach($dailyVisitorsItems as $item)
                                                <div>{{ $item->name }}</div>
                                            @endforeach
                                        @else
                                            <div>No daily visitors items available.</div>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Flat Voucher Chart
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <!-- Render the chart -->
                            <div>
                                <canvas id="combine-chartContainer" style="width: 100%; height: 300px; text-align: center; margin: 0 auto;"></canvas>
                            </div>
                        </div>
                    </section>
                </div>
            </div>



        </section>
    </section>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize date picker
        $('#dateRangePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    });

    function filterByDateRange() {
        var startDate = $('#dateRangePicker').datepicker('getDate');
        var endDate = new Date();


        $.ajax({
            url: '/calculate-profit',
            type: 'GET',
            data: {
                start_date: startDate.toISOString().slice(0, 10),
                end_date: endDate.toISOString().slice(0, 10),
            },
            success: function (response) {
                $('#profitValue').text(response.profit);
            },
            error: function (error) {
                console.error('Error:', error);
            },
        });
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    fetch('/get-chart-data')
        .then(response => response.json())
        .then(data => {
            var expenseCategories = Object.keys(data[0]).filter(key => key !== 'amount');

            var chartData = {
                labels: data.map(item => `Expense ${data.indexOf(item) + 1}`),
                datasets: expenseCategories.map(category => {
                    return {
                        label: category,
                        backgroundColor: getRandomColor(), // A function to generate random colors
                        data: data.map(item => item[category])
                    };
                })
            };

            var ctx = document.getElementById('combine-chartContainer').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    scales: {
                        xAxes: [{
                            stacked: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Income'
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Amount'
                            },
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Income and Expenses Chart'
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
});

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

</script>





    @include('admin.layouts.footer')

    <!-- Include jQuery and Slick slider scripts -->

</body>
</html>
