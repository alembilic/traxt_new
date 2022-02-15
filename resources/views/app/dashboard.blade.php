@extends('app.layout')
@section('pageName')
    Dashboard
@endsection
@section('content')
@if($success ?? false)
    <div class="row">
        <div class="col-md-12">
            <div class="panel white-bg" style="width: 100%;">
                <div class="panel-body">
                    <div class="text-center">
                        <h1>Welcome to Traxr</h1>
                        <p style="font-size: 16px;">Thank you for choosing to use Traxr. You are now ready to capitalize on the value of link monitoring. You must start by adding a domain that you would like to monitor, and then add the links to the domain that you would like to monitor.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row" id="step1">
    <div class="col-sm-6 col-md-4">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-blue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="dashboard-header">
                    @if($res_num_prices >= $required_num)
                    <span title="The average cost pr. link. Add more prices to your links to get more accurate amounts"><b>{{ $fmt->formatCurrency(round($avg_price),$currency_code) }} {{ $currency_code }}</b> Avg. cost per link</span>
                    @else
                        Add minimum {{$required_num}} prices to your links to get economic data
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-brightred">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">
                        @if($res_num_prices >= $required_num)
                        <span title="Lost link value due to lost links, link not indexed or with no follow tags."><b>{{$fmt->formatCurrency(($res_vanished_count + $res_header_nofollow_count + $res_rel_nofollow_count + $res_no_index) * round($avg_price),$currency_code)}} {{$currency_code}}</b> Lost link value</span>
                        @else
                                Add minimum {{$required_num}} prices to your links to get economic data
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-orange">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">
                        @if($res_num_prices >= $required_num)
                        <span title="The total amount you have spent on links"><b>{{$fmt->formatCurrency($res_all_links * round($avg_price),$currency_code). " " . $currency_code}}</b> Total link value</span>
                        @else
                            Add minimum {{$required_num}} prices to your links to get economic data
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row" id="step2">
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-blue">
                    <a href="/app/links.php"><i class="fas fa-link"></i></a>
                </div>
                <div class="dashboard-header">
                    <a href="/app/links.php">
                        {{$res_all_links}} Links
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-brightred">
                    <a href="/app/links.php?id_domain=&vanished=1&submut=Adjust+Filters"><i class="fas fa-times"></i></a>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">
                        <a href="/app/links.php?id_domain=&vanished=1&submut=Adjust+Filters">
                            {{$res_vanished_count}} Vanished
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-orange">
                    <a href="/app/links.php?id_domain=&head_nofollow=1&submut=Adjust+Filters"><i class="fas fa-check"></i></a>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">
                        <a href="/app/links.php?id_domain=&head_nofollow=1&submut=Adjust+Filters">
                            {{$res_header_nofollow_count}} Headers with nofollow/noindex
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-darkorange">
                    <a href="/app/links.php?id_domain=&nofollow=1&submut=Adjust+Filters"><i class="fas fa-check"></i></a>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">
                        <a href="/app/links.php?id_domain=&nofollow=1&submut=Adjust+Filters">
                            {{$res_rel_nofollow_count}} Links with Rel="nofollow"
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Row -->
<div class="row" id="step3">
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-green">
                    <i class="fas fa-check"></i>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">{{$res_all_ok}} OK</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-green">
                    <i class="fas fa-server"></i>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">{{$res_html_links}} HTML Links</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-gray">
                    <a href="/app/links.php?id_domain=&js_render=1&submut=Adjust+Filters"><i class="fas fa-desktop"></i></a>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">
                        <a href="/app/links.php?id_domain=&js_render=1&submut=Adjust+Filters">
                            {{$res_js_links}} Clientside Links
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel white-bg" style="min-height:100px">
            <div class="panel-body">
                <div class="round-icon-bg icon-red">
                    <a href="/app/links.php?id_domain=&index_state=1&submut=Adjust+Filters"><i class="fas fa-unlink"></i></a>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">
                        <a href="/app/links.php?id_domain=&index_state=1&submut=Adjust+Filters">
                            {{$res_no_index}} Not indexed
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-12 col-lg-6" id="step4">
        <div class="panel white-bg" style="min-height:520px;height:520px;">
            <div class="panel-body">
                <div class="round-icon-bg icon-green">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">Overall Health</div>
                    <canvas id="myChart" class="Chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-6" id="step5">
        <div class="panel white-bg" style="min-height:520px;max-height:520px;">
            <div class="panel-body">
                <div class="round-icon-bg icon-blue">
                    <i class="fas fa-list"></i>
                </div>
                <div class="text-center">
                    <div class="dashboard-header">TODO List</div>
                </div>
                <div class="text-left-dashboard" style="overflow-y: scroll;max-height:420px;">
                    <h4>Vasnished</h4>
                    <table>
                        @if($res_vanished_count)
                            @foreach ($res_vanished_todo as $res)
                                <tr>
                                    <td><div class="round-icon-small-bg icon-red"><i class="fas fa-times"></i></div></td>
                                    <td><a href="{{$res['url']}}" target="_BLANK">{{$res['url']}}</a><br /></td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td><div class="round-icon-small-bg icon-green"><i class="fas fa-check"></i></div></td>
                            <td>No Errors found<br /></td>
                        </tr>
                        @endif
                    </table>
                    <h4>Not indexed</h4>
                    <table>
                        @if($res_no_index)
                            @foreach ($res_noindex_todo as $res)
                            <tr>
                                <td><div class="round-icon-small-bg icon-red"><i class="fas fa-unlink"></i></div></td>
                                <td><a href="{{$res['url']}}" target="_BLANK">{{$res['url']}}</a><br /></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td><div class="round-icon-small-bg icon-green"><i class="fas fa-check"></i></div></td>
                                <td>No Errors found<br /></td>
                            </tr>
                        @endif
                    </table>
                    <h4>Nofollow - Headers</h4>
                    @if($res_header_nofollow_count)
                        @foreach ($res_noheader_todo as $res)
                        <tr>
                            <td><div class="round-icon-small-bg icon-orange"><i class="fas fa-check"></i></div></td>
                            <td><a href="{{$res['url']}}" target="_BLANK">{{$res['url']}}</a><br /></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td><div class="round-icon-small-bg icon-green"><i class="fas fa-check"></i></div></td>
                            <td>No Errors found<br /></td>
                        </tr>
                    @endif
                    <h4>Nofollow - Rel</h4>
                    <table>
                        @if($res_rel_nofollow_count)
                            @foreach ($res_nofollow_todo as $res)
                            <tr>
                                <td><div class="round-icon-small-bg icon-darkorange"><i class="fas fa-check"></i></div></td>
                                <td><a href="{{$res['url']}}" target="_BLANK">{{$res['url']}}</a><br /></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td><div class="round-icon-small-bg icon-green"><i class="fas fa-check"></i></div></td>
                                <td>No Errors found<br /></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div><!-- END Column -->


</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ok','Vasnished','Clientside','Header No follow','No follfow','Not Indexed'],
            datasets: [{
                data: [{{$res_all_ok}}, {{$res_vanished_count}}, {{$res_js_links}}, {{$res_header_nofollow_count}}, {{$res_rel_nofollow_count}}, {{$res_no_index}}],
                backgroundColor: [
                    'rgba(138, 233, 140, 1)',
                    'rgba(243, 22, 58, 1)',
                    'rgba(198, 170, 170, 1)',
                    'rgba(233, 209, 138, 1)',
                    'rgba(255, 178, 102, 1)',
                    'rgba(245, 122, 142, 1)',
                    'rgba(245, 122, 142, 1)',
                ]

            }]
        },
        options: {
            responsive: false,

            legend: {
                display: false
            },
        }
    });

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
</script>
@endsection
