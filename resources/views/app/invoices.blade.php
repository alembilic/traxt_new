@extends('app.app_layout')
@section('pageName')
    Invoices
@endsection
@section('title-section')
    <h1>Invoices</h1>
@endsection
@section('content')
<div class="links-table-wrap">
    <div class="table-header">
        <div class="panel-body">
            <h5>Invoices</h5>
            <p></p>
            @php
                /* @var \App\Entities\SubscriptionCharge[] $invoices */
            @endphp
            <div class="table-body" style="width: 100%">
                @if (count($invoices))
                    <table class="table" style="width: 100%">
                        <thead>
                            <tr class="table-title">
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
                            <tr class="table-item">
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
                                        <a target="_blank" class="open_modal btn btn-default" href="/app/invoices/{{$invoice->getAccountingSystemId()}}">Download Invoice</a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    No orders and invoices yet.
                @endif
            </div>
        </div>
    </div>
</div>
    <!-- END Row -->
@endsection
