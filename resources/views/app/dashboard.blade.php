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
                <h6>Thank you for choosing to use Traxr. You are now ready to capitalize on the value of link
                    monitoring. You must start by adding a domain that you would like to monitor, and then add the links
                    to the domain that you would like to monitor.</h6>
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
                        ${{ (int)$totalSpending[0]["totalSpending"] / 100 }}
                    </span>
                        </div>
                    </div>
                    <div class="total-card-footer">
                        <div class="card-item">
                            <span><i class="fas fa-info-circle" id="info-tooltip-1" style="font-size: 0.9rem;"></i>  + Active backlink value</span>
                            <a href="#" class="number" style="color: #0BDD53">${{ (int)$totalSpending[2] / 100}}</a>
                        </div>

                        <div class="card-item">
                            <span><i class="fas fa-info-circle" id="info-tooltip-2" style="font-size: 0.9rem;"></i>  - Lost backlink value</span>
                            <a href="#" class="number">${{ (int)$totalSpending[1]["lostSpending"] / 100 }}</a>
                        </div>
                    </div>
                @else
                    <div>
                        <div style="text-align: center;">
                            <a href={!! route('links') !!}><img src="/assets-app/images/financial-icon.svg"
                                                                style="cursor: pointer"/></a>
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
                <div style="display: flex; flex-direction: row; justify-content: space-between">
                    <h3>Page rank growth</h3>
                    <div style="justify-content: center">
                        <button class="btn rank" style="text-decoration: none;" onclick="updateChart1('all', this)">All
                            time
                        </button>
                        <button id="week-button" class="btn rank" style="text-decoration: none;"
                                onclick="updateChart1('week', this)">Week
                        </button>
                        <button class="btn rank" style="text-decoration: none;" onclick="updateChart1('month', this)">
                            Month
                        </button>
                        <button class="btn rank" style="text-decoration: none;" onclick="updateChart1('year', this)">
                            Year
                        </button>
                    </div>
                </div>
                <hr style="width: 100%; height: 0.01rem;"/>
                <p>PageRank is one of the most vital indicators for determining the success of your backlinks</p>
                <div class="line-designation">
                    <div class="line-item">
                        <span style="background-color: #F25F33;"></span>
                        Total growth of all backlinks
                    </div>
                </div>

                <div class="chart">
                    <canvas id="chart1"></canvas>
                </div>
            </div>
        </div>
        <div class="col col-12 col-xl-6">
            <div class="graph-box">
                <div style="display: flex; flex-direction: row; justify-content: space-between">
                    <h3>Spending</h3>
                    <div style="justify-content: center">
                        <button class="btn spending" style="text-decoration: none;" onclick="updateChart2('all', this)">
                            All
                            time
                        </button>
                        <button id="week-button2" class="btn spending" style="text-decoration: none;"
                                onclick="updateChart2('week', this)">Week
                        </button>
                        <button class="btn spending" style="text-decoration: none;"
                                onclick="updateChart2('month', this)">Month
                        </button>
                        <button class="btn spending" style="text-decoration: none;"
                                onclick="updateChart2('year', this)">Year
                        </button>
                    </div>
                </div>
                <hr style="width: 100%; height: 0.01rem;"/>
                <p>Spending indicate how much money you have spent on your backlinks, including active and lost
                    spending.</p>
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
            <div class="graph-box">
                <div style="display: flex; flex-direction: row; justify-content: space-between">
                    <h3>Links</h3>
                    <div style="justify-content: center">
                        <button class="btn links" style="text-decoration: none;"
                                onclick="updateChart3('all', this)">All time
                        </button>
                        <button id="week-button3" class="btn links" style="text-decoration: none;"
                                onclick="updateChart3('week', this)">Week
                        </button>
                        <button class="btn links" style="text-decoration: none;"
                                onclick="updateChart3('month', this)">Month
                        </button>
                        <button class="btn links" style="text-decoration: none;"
                                onclick="updateChart3('year', this)">Year
                        </button>
                    </div>
                </div>
                <hr style="width: 100%; height: 0.01rem;"/>
                <p>Links indicate how many links you have in Traxr, including active backlinks and non-active
                    backlinks.</p>
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
                <div class="chart">
                    <canvas id="chart3"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
      tippy('#info-tooltip-1', {
        content: 'Active backlink value is the amount of money you have spent on backlinks that are currently active.',
        placement: 'top'
      })

      tippy('#info-tooltip-2', {
        content: 'Lost backlink value, is the amount of money you have spent on backlinks that are inactive/lost.',
        placement: 'bottom'
      })

      function startIntro() {
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

      let chart1;
      let chart2;
      let chart3;
      $(function () {
        Chart.defaults.font.size = 8;
        Chart.defaults.color = 'rgba(44, 53, 66, 0.45)';
        Chart.defaults.elements.point.radius = 0;
        Chart.defaults.elements.arc.borderColor = 'rgba(65, 97, 128, 0.151934)';
        const ctx1 = document.getElementById('chart1');
        const ctx2 = document.getElementById('chart2');
        const ctx3 = document.getElementById('chart3');

        chart1 = new Chart(ctx1, {
          type: 'line',
          responsive: true,
          options: {
            scales: {
              x: {
                type: "time",
                distribution: 'series',
                time: {
                  tooltipFormat: 'll',
                  unit: 'day'
                }
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
            datasets: [{
              label: 'Total growth of all backlinks',
              data: [],
              backgroundColor: '#F25F33',
              borderColor: '#F25F33',
              borderWidth: 2,
              order: 1,
              pointBorderWidth: 0
            }]
          },
        });
        chart2 = new Chart(ctx2, {
          type: 'line',
          responsive: true,
          options: {
            scales: {
              x: {
                type: "time",
                distribution: 'series',
                time: {
                  tooltipFormat: 'll',
                  unit: 'day'
                }
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
            datasets: [
              {
                data: [],
                backgroundColor: '#2D2FF0',
                borderColor: '#2D2FF0',
                borderWidth: 2,
                order: 3,
                pointBorderWidth: 0,
                parsing: {
                  yAxisKey: 'total'
                }
              },
              {
                data: [],
                backgroundColor: '#E8C300',
                borderColor: '#E8C300',
                borderWidth: 2,
                order: 2,
                pointBorderWidth: 0,
                parsing: {
                  yAxisKey: 'active'
                }
              },
              {
                data: [],
                backgroundColor: '#E80054',
                borderColor: '#E80054',
                borderWidth: 2,
                order: 1,
                pointBorderWidth: 0,
                parsing: {
                  yAxisKey: 'lost'
                }
              }
            ]
          },
        });
        chart3 = new Chart(ctx3, {
          type: 'line',
          responsive: true,
          options: {
            scales: {
              x: {
                type: "time",
                distribution: 'series',
                time: {
                  tooltipFormat: 'll',
                  unit: 'day'
                }
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
            datasets: [
              {
                data: [],
                backgroundColor: '#00C0FF',
                borderColor: '#00C0FF',
                borderWidth: 2,
                order: 3,
                pointBorderWidth: 0,
                parsing: {
                  yAxisKey: 'total'
                }
              },
              {
                data: [],
                backgroundColor: '#FFEB32',
                borderColor: '#FFEB32',
                borderWidth: 2,
                order: 2,
                pointBorderWidth: 0,
                parsing: {
                  yAxisKey: 'lost'
                }
              },
              {
                data: [],
                backgroundColor: '#D500E8',
                borderColor: '#D500E8',
                borderWidth: 2,
                order: 1,
                pointBorderWidth: 0,
                parsing: {
                  yAxisKey: 'active'
                }
              }
            ]
          },
        });
        //init the charts
        $('#week-button').trigger("click");
        $('#week-button2').trigger("click");
        $('#week-button3').trigger("click");
      });

      function updateChart1(type, el) {
        $(".btn-link.rank").removeClass('btn-link')
        $(el).addClass("btn-link")
        Api.makeRequest('getPageRankGraphData', {
          complete: function (data) {
            chart1.data.datasets[0].data = data.responseJSON;
            chart1.update();
          }
        }, {
          type: type
        });
      }

      function updateChart2(type, el) {
        $(".btn-link.spending").removeClass('btn-link')
        $(el).addClass("btn-link")

        Api.makeRequest('getBacklinkSpendingGraphData', {
          complete: function (data) {
            chart2.data.datasets[0].data = data.responseJSON;
            chart2.data.datasets[1].data = data.responseJSON;
            chart2.data.datasets[2].data = data.responseJSON;
            chart2.update();
          }
        }, {
          type: type
        });
      }

      function updateChart3(type, el) {
        $(".btn-link.links").removeClass('btn-link')
        $(el).addClass("btn-link")

        Api.makeRequest('getBacklinkAmountGraphData', {
          complete: function (data) {
            chart3.data.datasets[0].data = data.responseJSON;
            chart3.data.datasets[1].data = data.responseJSON;
            chart3.data.datasets[2].data = data.responseJSON;
            chart3.update();
          }
        }, {
          type: type
        });
      }
    </script>
@endsection
