@extends('app.app_layout')
@section('pageName')
    My Plan
@endsection
@section('title-section')
<h1>My Plan</h1>



                    @endsection
                    @section('content')
                        @php
                            /* @var \App\Entities\Product|null $plan */
                            /* @var \App\Entities\Product $availablePlan */
                            /* @var \App\Entities\User $user */
                            /* @var \App\Entities\Subscription|null $subscription */
                        @endphp
                        <div class="page-wrap">

                            <main class="main-content">

                                <div class="content-wrap">

                                    <div class="container-fluid">
                                        <div class="plan-top">
                                            <h3 class="active-plan"><span>Use</span> a referal code <span>and get</span> two months free.
                                            </h3>
                                            <h3>Use a referal code, and get the <span>first month for free</span>.</h3>
                                        </div>
                                        <div class="plan-tab-main">
                                            <ul class="nav nav-pills justify-content-center" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly"
                                                            type="button" role="tab" aria-controls="monthly" aria-selected="true">Billed
                                                        Monthly</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="annually-tab" data-bs-toggle="tab"
                                                            data-bs-target="#annually" type="button" role="tab" aria-controls="annually"
                                                            aria-selected="false">Billed Annually</button>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="tab-content" id="myTabContent">
                        <!-- monthly -->
                        <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">

                            <div class="row">

                                @foreach ($plans as $availablePlan)

                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                                        <div class="plan-cards">
                                            <div class="card border-0 rounded-0">
                                                <div class="card-header border-0">
                                        {{ $availablePlan->getProductName() }}
                                    </div>
                                    <div class="card-domain-link">
                                        <p><span>{{$availablePlan -> getDomains()}}</span>Domain</p>
                                        <p><span>{{ $availablePlan -> getLinks() }}</span>Links</p>
                                    </div>
                                    <div class="domain-price">
                                        <h2>{{ $availablePlan ->getPricePerMonth() > 0 ? "$" . number_format($availablePlan->getPricePerMonth() / 100, 0, '.', '') : 'Free'}}<sub>/year</sub></h2>
                                    </div>
                                    @if($plan ->getProductName() == $availablePlan ->getProductName())
                                        <div class="pich-the-plan">
                                            <a href="#" class="btn btn-primary disabled"
                                               data-bs-toggle="tooltip" data-bs-placement="bottom"
                                               title="Current Plan">Current Plan</a>
                                        </div>
                                    @else
                                        <div class="pich-the-plan">
                                            <form>
                                                <div class="plan-form">
                                                    <label class="form-label">Enter referral code and get
                                                        <span>2 months free</span></label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Enter your code here">
                                                </div>
                                            </form>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="tooltip"
                                               data-bs-placement="bottom" title="Pick the Plan">Pick the
                                                Plan</a>
                                        </div>
                                    @endif
                                    <div class="pich-list">
                                        <ul>
                                            <li><span data-bs-toggle="tooltip"
                                                      data-bs-placement="bottom" title=""
                                                      data-bs-original-title="close-plan-icon"><img
                                                        src="/assets-app/images/close-plan-icon.svg"
                                                        alt="close-plan-icon"></span>Index Check</li>
                                            <li><span data-bs-toggle="tooltip"
                                                      data-bs-placement="bottom" title=""
                                                      data-bs-original-title="close-plan-icon"><img
                                                        src="/assets-app/images/close-plan-icon.svg"
                                                        alt="close-plan-icon"></span>Response Codes</li>
                                            <li><span data-bs-toggle="tooltip"
                                                      data-bs-placement="bottom" title=""
                                                      data-bs-original-title="close-plan-icon"><img
                                                        src="/assets-app/images/close-plan-icon.svg"
                                                        alt="close-plan-icon"></span>Manuel update</li>
                                            <li><span data-bs-toggle="tooltip"
                                                      data-bs-placement="bottom" title=""
                                                      data-bs-original-title="close-plan-icon"><img
                                                        src="/assets-app/images/close-plan-icon.svg"
                                                        alt="close-plan-icon"></span>Response Codes</li>
                                        </ul>
                                    </div>
                                        </div>
                                    @if($plan ->getProductName() == $availablePlan ->getProductName())
                                        <div class="card-footer">
                                            <p>Next renewal: 2099-05-01</p>
                                        </div>
                                    @endif
                                        </div>
                                    </div>


                            @endforeach


                                    <!-- Enterprise plan monthly end  -->
                            </div>

                        </div>

                        <!-- annually -->
                        <div class="tab-pane fade show active" id="annually" role="tabpanel"
                             aria-labelledby="annually-tab">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-4 col-sm-12">
                                    <div class="plan-cards">
                                        <div class="card border-0 rounded-0">
                                            <div class="card-header border-0">
                                                Free
                                            </div>
                                            <div class="card-body">
                                                <div class="card-domain-link">
                                                    <p><span>1</span>Domain</p>
                                                    <p><span>25</span>Links</p>
                                                </div>
                                                <div class="domain-price">
                                                    <h2>$0<sub>/year</sub></h2>
                                                </div>
                                                <div class="pich-the-plan">
                                                    <a href="#" class="btn btn-primary disabled"
                                                       data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                       data-bs-original-title="Tooltip on bottom">Current Plan</a>
                                                </div>
                                                <div class="pich-list">
                                                    <ul>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Index Check</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Response Codes</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Manuel update</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Response Codes</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <p>Next renewal: 2099-05-01</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-4 col-sm-12">
                                    <div class="plan-cards">
                                        <div class="card border-0 rounded-0">
                                            <div class="card-header border-0">
                                                Starter
                                            </div>
                                            <div class="card-body">
                                                <div class="card-domain-link">
                                                    <p><span>1</span>Domain</p>
                                                    <p><span>100</span>Links</p>
                                                </div>
                                                <div class="domain-price">
                                                    <h2>$19<sub>/month</sub></h2>
                                                </div>
                                                <div class="pich-the-plan">
                                                    <form>
                                                        <div class="plan-form">
                                                            <label class="form-label">Enter refferal code and get
                                                                <span>2 months free</span></label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Enter your code here">
                                                        </div>
                                                    </form>
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom" title=""
                                                       data-bs-original-title="Pick the Plan">Pick the Plan</a>
                                                </div>
                                                <div class="pich-list">
                                                    <ul>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Index Check</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Response Codes</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Manuel update</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="close-plan-icon"><img
                                                                    src="/assets-app/images/close-plan-icon.svg"
                                                                    alt="close-plan-icon"></span>Response Codes</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-4 col-sm-12">
                                    <div class="plan-cards">
                                        <div class="card border-0 rounded-0">
                                            <div class="card-header border-0">
                                                Business
                                            </div>
                                            <div class="card-body">
                                                <div class="card-domain-link">
                                                    <p><span>15</span>Domain</p>
                                                    <p><span>1000</span>Links</p>
                                                </div>
                                                <div class="domain-price">
                                                    <h2>$29<sub>/month</sub></h2>
                                                </div>
                                                <div class="pich-the-plan">
                                                    <form>
                                                        <div class="plan-form">
                                                            <label class="form-label">Enter refferal code and get
                                                                <span>2 months free</span></label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Enter your code here">
                                                        </div>
                                                    </form>
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom" title=""
                                                       data-bs-original-title="Pick the Plan">Pick the Plan</a>
                                                </div>
                                                <div class="pich-list">
                                                    <ul>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Index Check</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Response Codes
                                                        </li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Manuel update</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Response Codes
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-4 col-sm-12">
                                    <div class="plan-cards">
                                        <div class="card border-0 rounded-0">
                                            <div class="card-header border-0">
                                                Enterprise
                                            </div>
                                            <div class="card-body">
                                                <div class="card-domain-link">
                                                    <p><span>100</span>Domain</p>
                                                    <p><span>10000</span>Links</p>
                                                </div>
                                                <div class="domain-price">
                                                    <h2>$39<sub>/month</sub></h2>
                                                </div>
                                                <div class="pich-the-plan">
                                                    <form>
                                                        <div class="plan-form">
                                                            <label class="form-label">Enter refferal code and get
                                                                <span>2 months free</span></label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Enter your code here">
                                                        </div>
                                                    </form>
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom" title=""
                                                       data-bs-original-title="Contact Sales">Contact Sales</a>
                                                </div>
                                                <div class="pich-list">
                                                    <ul>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Index Check</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Response Codes
                                                        </li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Manuel update</li>
                                                        <li><span data-bs-toggle="tooltip"
                                                                  data-bs-placement="bottom" title=""
                                                                  data-bs-original-title="active-plan-icon"><img
                                                                    src="/assets-app/images/active-plan-icon.svg"
                                                                    alt="active-plan-icon"></span>Response Codes
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </div>
    </main>
@endsection

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- Charts JS -->
<script src="js/chart.min.js"></script>
<!-- Main JS -->
<script src="js/main.js"></script>
</body>

</html>
