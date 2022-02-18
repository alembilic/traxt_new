@extends('app.layout')
@section('pageName')
    Invoices
@endsection
@section('content')
    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-options pull-right">
                </div>
                <i class="fas fa-list"></i>
                <h3 class="panel-title">Invoices</h3>
            </div>
            @php
                /* @var \App\Entities\Order[] $invoices */
            @endphp
            <div class="panel-body table-responsive">
                @if (count($invoices))
                    <table class="table table-hover table-striped">
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
                                    @elseif ($invoice->getDineroGuid() && $invoice->getTransferState() !== 5)
                                    Pending
                                    @else
                                    <div class="btn-group btn-group-xs">
                                        <a target="_blank" class="open_modal btn btn-default" href="/app/invoices/{{$invoice->getDineroGuid()}}">Download Invoice</a>
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
    <!-- END Row -->
@endsection
