@extends('app.layout')
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
@endsection
