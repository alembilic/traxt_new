@extends('app.layout')
@section('pageName')
Guide
@endsection
@section('content')
    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-options pull-right">
                </div>
                <i class="fas fa-file-import"></i><h3 class="panel-title">A quick setup guide</h3>
            </div>
            <div class="panel-body">
                <h1>A quick setup guide</h1>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/cPSlEiaoHuM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection
