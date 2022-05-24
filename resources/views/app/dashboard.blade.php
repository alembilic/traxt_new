@extends('app.app_layout')
@section('pageName')
    Dashboard
@endsection
@section('title-section')
    <h1>Dashboard</h1>
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
@php
/**
 * @var \App\Entities\User $user
 * @var \App\Contracts\Statistics\IStatisticsObject $backLinksTotal
 * @var \App\Contracts\Statistics\IStatisticsObject $backLinksDaily
 * @var \App\Contracts\Statistics\IStatisticsObject $backLinksDailyGraph
 * @var \App\Contracts\Statistics\IStatisticsObject $domains
 * @var \App\Contracts\Statistics\IStatisticsItem $item
 */
@endphp
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
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
                        {{ $backLinksTotal->getTotalCount() }}
                    </span>
                </div>
            </div>
            <div class="total-card-footer">
                @foreach ($backLinksTotal->toArray() as $item)
                <div class="card-item">
                    <span>{{ $item->getTitle() }}</span>
                    <a href="#" class="number">{{ $item->getCount() }}</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col col-12 col-lg-4">
        <div class="total-card total-card-red">
            @if($hasFinancialData)
            <div class="total-link">
                <div class="icon">
                    <img src="/assets-app/images/dollar-icon.svg" alt="icon-total-red">
                </div>
                <div>
                    <h5>Total Spending</h5>
                    <span class="total-number">
                        ${{ $totalSpending[0]["totalSpending"] }}

                    </span>
                </div>
            </div>
            <div class="total-card-footer">
                <div class="card-item">
                 <span><i class="fas fa-info-circle" id="info-tooltip-1" style="font-size: 0.9rem;"></i>  + Active backlink value</span>
                    <a href="#" class="number">${{$totalSpending[2]}}</a>
                </div>

                <div class="card-item">
                    <span><i class="fas fa-info-circle" id="info-tooltip-2" style="font-size: 0.9rem;"></i>  - Lost backlink value</span>
                    <a href="#" class="number">${{ $totalSpending[1]["lostSpending"] }}</a>
                </div>
            </div>
            @else
                <div>
          <div style="text-align: center;">
              <a href={!! route('links') !!}><img src="/assets-app/images/financial-icon.svg" style="cursor: pointer" /></a>
          </div>
                    <div style="text-align: center; padding: 10px">
                        <a href={!! route('links') !!}>Add prices</a> to your links to see financial data.
                    </div>
                </div>
            @endif
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
                        {{ $domains->getTotalCount() }}
                    </span>
                </div>
            </div>
            <div class="total-card-footer">
                <div class="card-item">&nbsp;</div>
                <div class="card-item">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
<div class="row graphs">
    <div class="col col-12 col-xl-6">
        <div class="graph-box">
            <h3>Page rank growth</h3>
            <p>PageRank is one of the most vital indicators for determining the success of your backlinks</p>
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
            <h3>Spending</h3>
            <p>Spending indicate how much money you have spent on your backlinks, including active and lost spending.</p>
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
                <p>Links indicate how many links you have in Traxr, including active backlinks and non-active backlinks.</p>
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
@php
$days = [];
for ($i = 7; $i >= 0; $i--) {
    $days[] = '"' . date('Y-m-d', strtotime('-' . $i . 'days')) . '"';
}
@endphp
<script>

      tippy('#info-tooltip-1', {
          content: 'hover like glover',
          placement: 'top'
      })

      tippy('#info-tooltip-2', {
          content: 'hover like glover',
          placement: 'bottom'
      })

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

    $(function () {
        const daysLabels = [{!! implode(', ', $days) !!}];
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
                labels: daysLabels,
                datasets: [
                    {
                        label: 'Total growth of all backlinks',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#F25F33',
                        borderColor: '#F25F33',
                        borderWidth: 2,
                        order: 1,
                        pointBorderWidth: 0
                    },
                    {
                        label: 'Average growth of backlinks',
                        data: [0, 0, 0, 0, 0, 0, 0],
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
                labels: daysLabels,
                datasets: [
                    {
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#2D2FF0',
                        borderColor: '#2D2FF0',
                        borderWidth: 2,
                        order: 3,
                        pointBorderWidth: 0
                    },
                    {
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#E8C300',
                        borderColor: '#E8C300',
                        borderWidth: 2,
                        order: 2,
                        pointBorderWidth: 0
                    },
                    {
                        data: [0, 0, 0, 0, 0, 0, 0],
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
                labels: daysLabels,
                datasets: [
                    {
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#00C0FF',
                        borderColor: '#00C0FF',
                        borderWidth: 2,
                        order: 3,
                        pointBorderWidth: 0
                    },
                    {
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#FFEB32',
                        borderColor: '#FFEB32',
                        borderWidth: 2,
                        order: 2,
                        pointBorderWidth: 0
                    },
                    {
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '',
                        borderColor: '#D500E8',
                        borderWidth: 2,
                        order: 1,
                        pointBorderWidth: 0
                    }
                ]
            },

        });
    });
</script>
@endsection
