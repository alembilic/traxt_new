@extends('app.layout')
@section('pageName')
    My Plan
@endsection
@section('content')
    @php
        /* @var \App\Entities\Product|null $plan */
        /* @var \App\Entities\Product $availablePlan */
        /* @var \App\Entities\User $user */
        /* @var \App\Entities\OrderSubscription|null $subscription */
    @endphp
    <script>
        $(function() {
            $("#cancel_sub").confirm({
                title: 'Are you sure?',
                content: 'This will cancel your subscription',
                buttons: {
                    info: {
                        text: 'Cancel Subscription',
                        btnClass: 'btn-red',
                        action: function(){
                            location.href = this.$target.attr('href');
                        }
                    },
                    cancel: function () {
                        return true;
                    },
                }
            });
        });
    </script>
    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-options pull-right">
                </div>
                <i class="fas fa-file-import"></i><h3 class="panel-title">See your plan</h3>
            </div>
            @foreach($validationErrors ?? [] as $error)
                <p>{{ $error }}</p>
            @endforeach
            <div class="panel-body">
                <h1 style="text-align: center; margin: 20px;">You current plan</h1>
                <div class="all_plans">
                    <div class="plan" style="margin: 0 auto;">
                        @if (!$user->isActivePlan() || !$plan || !$plan->getDomains())
                            No active plan
                        @else
                            <div class="name">
                                {{$plan->getProductName()}}
                            </div>
                            <div class="Features">
                                <div class="domains">
                                    No Domains: {{$plan->getDomains()}}
                                </div>
                                <div class="links">
                                    No Links: {{$plan->getLinks()}}
                                </div>
                                <div class="links">
                                    Index Check:
                                    @if($plan->getIndexService())
                                        <i class="fa fa-check-square green tooltips" title="" data-original-title="Index service include. We track if google index your links"></i>
                                    @else
                                        <i class="fa fa-stop-circle red tooltips" title="" data-original-title="Index service Not include. We Dont track if google index your links"></i>
                                    @endif
                                </div>
                                <div class="links">
                                    Response Codes:
                                    @if($plan->getResponseCode())
                                        <i class="fa fa-check-square green tooltips" title="" data-original-title="We track response code of links, and check if they redirect"></i>
                                    @else
                                        <i class="fa fa-stop-circle red tooltips" title="" data-original-title="We Dont track response code of links, and dont check if they redirect"></i>
                                    @endif
                                </div>
                                <div class="links">
                                    Manuel update:
                                    @if($plan->getManualUpdate())
                                        <i class="fa fa-check-square green tooltips" title="" data-original-title="You can force an update to check your links"></i>
                                    @else
                                        <i class="fa fa-stop-circle red tooltips" title="" data-original-title="You cant force an update to check your links"></i>
                                    @endif
                                </div>
                                <div class="links">
                                    JS render service:
                                    @if($plan->getRenderService())
                                        <i class="fa fa-check-square green tooltips" title="We check the JavaScript rendered version of you links origin" ></i>
                                    @else
                                        <i class="fa fa-stop-circle red tooltips" title="" data-original-title="We dont check the JavaScript rendered version of you links origin"></i>
                                    @endif
                                </div>
                            </div>
                            <hr />
                            @if($user->getSubscription())
                                Price: {{ number_format($subscription->getTotal(), 2, '.', '') }} USD
                                <br />
                                Every {{ $subscription->getPeriod() }} Month{{ $subscription->getPeriod() > 1 ? 's' : '' }}
                                <br />Next renewal:
                                @if ($plan->getRenew() === 1)
                                    {{ $user->getNextDueDate()->format('Y-m-d') }}
                                    <div style="margin-top: 20px;"><a href="/app/myplan/cancel" id="cancel_sub" class="btn btn-danger">Cancel subscription</a></div>
                                @else
                                    Not set to renew
                                    <div style="margin-top: 20px;">Subscription will end on {{ $user->getNextDueDate()->format('Y-m-d') }}</div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>

                <h1 style="text-align: center; margin: 20px;">Pick a new plan, choice below</h1>
                <div class="all_plans">
                    @if ($isPaymentCanceled ?? false)
                        <div style="color: red;font-weight:bold;">You canceled the Payment, pick a plan to continue</div>
                    @endif
                    @foreach ($plans as $availablePlan)
                    <div class="plan">
                        <div class="name">
                            {{ $availablePlan->getProductName() }}
                        </div>
                        <div class="Features">
                            <div class="domains">
                                Number of Domains: {{ $availablePlan->getDomains() }}
                            </div>
                            <div class="links">
                                Number of Links: {{ $availablePlan->getLinks() }}
                            </div>
                            <div class="links">
                                Index Check:
                                @if($availablePlan->getIndexService())
                                    <i class="fa fa-check-square green tooltips" title="" data-original-title="Index service include. We track if google index your links"></i>
                                @else
                                    <i class="fa fa-stop-circle red tooltips" title="" data-original-title="Index service Not include. We Dont track if google index your links"></i>
                                @endif
                            </div>
                            <div class="links">
                                Response Codes:
                                @if($availablePlan->getResponseCode())
                                    <i class="fa fa-check-square green tooltips" title="" data-original-title="We track response code of links, and check if they redirect"></i>
                                @else
                                    <i class="fa fa-stop-circle red tooltips" title="" data-original-title="We Dont track response code of links, and dont check if they redirect"></i>
                                @endif
                            </div>
                            <div class="links">
                                Manuel update:
                                @if($availablePlan->getManualUpdate())
                                    <i class="fa fa-check-square green tooltips" title="" data-original-title="You can force an update to check your links"></i>
                                @else
                                    <i class="fa fa-stop-circle red tooltips" title="" data-original-title="You cant force an update to check your links"></i>
                                @endif
                            </div>
                            <div class="links">
                                JS render service:
                                @if($availablePlan->getRenderService())
                                    <i class="fa fa-check-square green tooltips" title="We check the JavaScript rendered version of you links origin" ></i>
                                @else
                                    <i class="fa fa-stop-circle red tooltips" title="" data-original-title="We dont check the JavaScript rendered version of you links origin"></i>
                                @endif
                            </div>
                        </div>
                        <div class="pricewrapper">
                            <div class="price">
                                {{ number_format($availablePlan->getPricePerMonth() / 100, 2, '.', '') }} USD
                                @if ($user->getVatValid() === 'DK')
                                    <br /><span style="color: grey; font-size: 12px;">+{{ number_format($availablePlan->getPricePerMonth() / 100 * 0.25, 2, '.', '') }} USD VAT</span>
                                @endif
                                <br />For {{ $availablePlan->getRenew() }} Month{{ $availablePlan->getRenew() > 1 ? 's' : '' }}
                                <a href="/app/plans/{{ $availablePlan->getMixId() }}/once">Pick this plan</a>
                            </div>
                            <div class="price">
                                {{ number_format($availablePlan->getPriceSubscription() / 100, 2, '.', '') }} USD
                                @if ($user->getVatValid() === 'DK')
                                    <br /><span style="color: grey; font-size: 12px;">+{{ number_format($availablePlan->getPriceSubscription() / 100 * 0.25, 2, '.', '') }} USD VAT</span>
                                @endif
                                <br />For {{ $availablePlan->getRenewSubscribe() }} Month{{ $availablePlan->getRenewSubscribe() > 1 ? 's' : '' }}
                                <a href="/app/plans/{{ $availablePlan->getMixId() }}/subscribe">Pick this plan</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- END Row -->
@endsection
