@extends('app.app_layout')
@section('pageName')
    Invoices
@endsection
@section('title-section')
    <h1>Invoices</h1>
@endsection
@section('content')
    @php
        /* @var \App\Entities\SubscriptionCharge[] $invoices */
    @endphp
<div class="links-table-wrap">
    <div class="table-header">
        <h5>Your Invoices</h5>
    </div>
    <div class="table-body">
        @if(count($invoices))
            <table class="table table-data invoices-table" id="dataTable">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Invoice Date</th>
                    <th>Amount</th>
                    <th>Vat</th>
                    <th>Total</th>
                    <th>Get invoice</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->getId()}}</td>
                        <td>{{$invoice->getCreatedAt()->format('Y-m-d H:i:s')}}</td>
                        <td>{{$invoice->getAmount()}} USD</td>
                        <td>{{$invoice->getVat()}} USD</td>
                        <td>{{$invoice->getTotal()}} USD</td>
                        <td>
                            @if (!$invoice->getTotal())
                                No invoice for Zero orders
                            @elseif ($invoice->getStatus() === 'pending')
                                Pending
                            @else
                                <div class="btn-group btn-group-xs">
                                    <a target="_blank" class="open_modal btn btn-primary" href="/app/invoices/{{$invoice->getAccountingSystemId()}}">Download Invoice</a>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div style="margin: 15px auto;text-align:center">No orders and invoices yet.</div>
        @endif
    </div>
    @if($of)
        @include('app.page_nav')
    @endif
</div>
@endsection
