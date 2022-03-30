@extends('app.app_layout')
@section('pageName')
    Dashboard
@endsection
@section('content')
@if($success ?? false)
    <div class="alert alert-success" role="alert">
        <div class="icon">
            <img src="/assets-app//assets-app//assets-app/images/icon-check.svg" alt="icon-check">
        </div>
        <div>
            <h6>Thank you for choosing to use Traxr. You are now ready to capitalize on the value of link monitoring. You must start by adding a domain that you would like to monitor, and then add the links to the domain that you would like to monitor.</h6>
        </div>
        <button type="button" class="btn-close"></button>
    </div>
@endif

<div class="row cards">
    <div class="col col-12 col-lg-4">
        <div class="total-card total-card-blue">
            <div class="total-link">
                <div class="icon">
                    <img src="/assets-app/images/icon-total-blue.svg" alt="icon-total-blue">
                </div>
                <div>
                    <h5>Total backlinks</h5>
                    <span class="total-number">
                        87
                    </span>
                </div>
            </div>
            <div class="total-card-footer">
                <div class="card-item">
                    <span>Expired backlinks</span>
                    <a href="#" class="number">35</a>
                </div>
                <div class="card-item">
                    <span>Live backlinks</span>
                    <a href="#" class="number">12</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-12 col-lg-4">
        <div class="total-card total-card-red">
            <div class="total-link">
                <div class="icon">
                    <img src="/assets-app/images/icon-total-red.svg" alt="icon-total-red">
                </div>
                <div>
                    <h5>Your daily update</h5>
                    <span class="total-number">
                        43
                    </span>
                </div>
            </div>
            <div class="total-card-footer">
                <div class="card-item">
                    <span>Expired links</span>
                    <a href="#" class="number">35</a>
                </div>
                <div class="card-item">
                    <span>Live links</span>
                    <a href="#" class="number">12</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-12 col-lg-4">
        <div class="total-card total-card-green">
            <div class="total-link">
                <div class="icon">
                    <img src="/assets-app/images/icon-global.svg" alt="icon-global">
                </div>
                <div>
                    <h5>Total domains</h5>
                    <span class="total-number">
                        105
                    </span>
                </div>
            </div>
            <div class="total-card-footer">
                <div class="card-item">
                    <span>Expired backlinks</span>
                    <a href="#" class="number">35</a>
                </div>
                <div class="card-item">
                    <span>Live backlinks</span>
                    <a href="#" class="number">12</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row graphs">
    <div class="col col-12 col-xl-6">
        <div class="graph-box">
            <h3>Growth rate</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
            <div class="line-designation">
                <div class="line-item">
                    <span style="background-color: #F25F33;"></span>
                    Total growth of all backlinks
                </div>
                <div class="line-item">
                    <span style="background-color: #0BDD53;"></span>
                    Average growth of backlinks
                </div>
            </div>
            <div class="chart">
                <canvas id="chart1"></canvas>
            </div>
        </div>
    </div>
    <div class="col col-12 col-xl-6">
        <div class="graph-box">
            <h3>Spendings</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
            <div class="line-designation">
                <div class="line-item">
                    <span style="background-color: #2D2FF0;"></span>
                    Total spending
                </div>
                <div class="line-item">
                    <span style="background-color: #E8C300;"></span>
                    Active spending
                </div>
                <div class="line-item">
                    <span style="background-color: #E80054;"></span>
                    Lost spending
                </div>
            </div>
            <div class="chart">
                <canvas id="chart2"></canvas>
            </div>
        </div>
    </div>
    <div class="col col-12">
        <div class="graph-box full-width">
            <div>
                <h3>Links</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam, nulla sit viverra lacus viverra tellus mauris vitae.</p>
                <div class="line-designation">
                    <div class="line-item">
                        <span style="background-color: #00C0FF;"></span>
                        Total links
                    </div>
                    <div class="line-item">
                        <span style="background-color: #FFEB32;"></span>
                        Total lost links
                    </div>
                    <div class="line-item">
                        <span style="background-color: #D500E8;"></span>
                        Total live links
                    </div>
                </div>
            </div>
            <div class="chart">
                <canvas id="chart3"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    function startIntro(){
        var intro = introJs();
        intro.setOptions({
            steps: [
                {
                    intro: "Hello and welcome to the giuded tour!"
                },
                {
                    element: document.querySelector('#step1'),
                    intro: "If you have added prices to your links (you do that on the link page) we will show your average price pr. link as well as how much you spent and lost. You need at least 10 prices. The more the better"
                },
                {
                    element: document.querySelector('#step2'),
                    intro: "Here you can see your total links as well as links with errors or warning, including how many your lost.",
                    position: 'right'
                },
                {
                    element: '#step3',
                    intro: 'Here you can see how many links that are ok, as well as how many are HTML or Javascript generated content. Also how many of the links pointing to you that are not indexed',
                    position: 'left'
                },
                {
                    element: '#step4',
                    intro: 'Here you can see the overview Health of all your links. green is good',
                    position: 'right'
                },
                {
                    element: '#step5',
                    intro: 'Todo list. To get the most of the links you have, make sure this list is empty',
                    position: 'left'
                },
                {
                    element: '#notification',
                    intro: 'Here we will notify you of any changes to your links. You also get an email',
                    position: 'left'
                },
                {
                    element: '#final',
                    intro: '<b>Click Guided Tour in the menu at any time to get help on the page you need</b>',
                    position: 'left'
                }
            ]
        });

        intro.start();
    }


    // // Charts

    Chart.defaults.font.size = 8;
    Chart.defaults.color = 'rgba(44, 53, 66, 0.45)';
    Chart.defaults.elements.point.radius = 0;
    Chart.defaults.elements.arc.borderColor = 'rgba(65, 97, 128, 0.151934)';
    const ctx1 = document.getElementById('chart1');
    const ctx2 = document.getElementById('chart2');
    const ctx3 = document.getElementById('chart3');

    const chart1 = new Chart(ctx1, {
        type: 'line',
        options: {
            scales: {
                x: {
                    min: 0,
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 0
                    }
                },
                y: {
                    min: 0,
                    max: 50,
                    ticks: {
                        stepSize: 10,
                        padding: 9
                    },

                }
            },
            layout: {
                padding: 0,
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        },
        data: {
            labels: ['XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX'],
            datasets: [
                {
                    label: 'Total growth of all backlinks',
                    data: [25, 21, 24, 33, 25, 14, 26, 26.5, 20],
                    backgroundColor: '#F25F33',
                    borderColor: '#F25F33',
                    borderWidth: 2,
                    order: 1,
                    pointBorderWidth: 0
                },
                {
                    label: 'Average growth of backlinks',
                    data: [15, 15.5, 19, 20, 23, 24, 31, 32],
                    backgroundColor: '#0BDD53',
                    borderColor: '#0BDD53',
                    borderWidth: 2,
                    order: 2,
                    pointBorderWidth: 0
                }
            ]
        },

    });

    const chart2 = new Chart(ctx2, {
        type: 'line',
        options: {
            scales: {
                x: {
                    min: 0,
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 0
                    }
                },
                y: {
                    min: 0,
                    max: 50,
                    ticks: {
                        stepSize: 10,
                        padding: 9
                    },

                }
            },
            layout: {
                padding: 0,
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        },
        data: {
            labels: ['XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX'],
            datasets: [
                {
                    data: [13, 14, 12, 42, 21, 23, 22, 29, 32],
                    backgroundColor: '#2D2FF0',
                    borderColor: '#2D2FF0',
                    borderWidth: 2,
                    order: 3,
                    pointBorderWidth: 0
                },
                {
                    data: [23, 21, 23, 32, 28, 34, 18, 28, 26],
                    backgroundColor: '#E8C300',
                    borderColor: '#E8C300',
                    borderWidth: 2,
                    order: 2,
                    pointBorderWidth: 0
                },
                {
                    data: [8, 8.5, 9, 9, 13, 8, 20, 12, 13],
                    backgroundColor: '#E80054',
                    borderColor: '#E80054',
                    borderWidth: 2,
                    order: 1,
                    pointBorderWidth: 0
                }
            ]
        },

    });

    const chart3 = new Chart(ctx3, {
        type: 'line',
        options: {
            scales: {
                x: {
                    min: 0,
                    max: 8,
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 0,
                    },
                },
                y: {
                    min: 0,
                    max: 35,
                    ticks: {
                        stepSize: 10,
                        // callback: function(value, index, ticks) {
                        //     return 'YYYYY';
                        // },
                        padding: 9,
                    },
                }
            },
            layout: {
                padding: 0
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        },
        data: {
            labels: ['XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX', 'XXXXX'],
            datasets: [
                {
                    data: [5, 6, 8, 9, 12, 15, 9, 16, 10],
                    backgroundColor: '#00C0FF',
                    borderColor: '#00C0FF',
                    borderWidth: 2,
                    order: 3,
                    pointBorderWidth: 0
                },
                {
                    data: [14, 12, 14, 23, 15, 6, 19, 19, 16],
                    backgroundColor: '#FFEB32',
                    borderColor: '#FFEB32',
                    borderWidth: 2,
                    order: 2,
                    pointBorderWidth: 0
                },
                {
                    data: [22, 23, 24, 9, 31, 22, 33, 21, 17, 20.5],
                    backgroundColor: '',
                    borderColor: '#D500E8',
                    borderWidth: 2,
                    order: 1,
                    pointBorderWidth: 0
                }
            ]
        },

    });

</script>
@endsection
