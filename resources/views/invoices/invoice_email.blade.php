@extends('layouts.email')

@section('content')
    <div class="invoice-container">
        <h1>Tax Invoice</h1>
        <p><strong>Invoice No: </strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Invoice Date: </strong> {{ $invoice->invoice_date }}</p>
        <p><strong>Due Date: </strong> {{ $invoice->due_date }}</p>

        <div class="company-details">
            <h3>Karsh General Trading Co. LLC</h3>
            <p>Dubai, United Arab Emirates</p>
            <p>TRN: 100464359700003</p>
        </div>

        <div class="customer-details">
            <h3>Bill To</h3>
            <p>{{ $invoice->customer_name }}</p>
            <p>{{ $invoice->customer_address }}</p>
            <p>TRN: {{ $invoice->customer_trn }}</p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item & Description</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Taxable Amount</th>
                    <th>Tax Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->rate }}</td>
                    <td>{{ $item->taxable_amount }}</td>
                    <td>{{ $item->tax_amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="invoice-summary">
            <p><strong>Sub Total: </strong> {{ $invoice->subtotal }}</p>
            <p><strong>Total Amount: </strong> {{ $invoice->total }}</p>
            <p><strong>Total VAT (if applicable): </strong> {{ $invoice->vat }}</p>
            <p><strong>Final Total: </strong> {{ $invoice->final_total }}</p>
        </div>

        <p>Total In Words: <em>{{ $invoice->total_in_words }}</em></p>

        <p>Thanks for your business.</p>
    </div>
@endsection
