@extends('layouts.app')

@section('title', 'View Invoice')

@section('content')
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
    div, p, a, li, td { -webkit-text-size-adjust: none; }
    .ReadMsgBody { width: 100%; background-color: #ffffff; }
    .ExternalClass { width: 100%; background-color: #ffffff; }
    body { width: 100%; height: 100%; background-color: #e1e1e1; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
    html { width: 100%; }
    p { padding: 0 !important; margin-top: 0 !important; margin-right: 0 !important; margin-bottom: 0 !important; margin-left: 0 !important; }
    .visibleMobile { display: none; }
    .hiddenMobile { display: block; }
    table {margin: 0 0 0 !important;width: revert-layer !important;}
    @media only screen and (max-width: 600px) {

    table[class=fullTable] { width: 96% !important; clear: both; }
    table[class=fullPadding] { width: 85% !important; clear: both; }
    table[class=col] { width: 45% !important; }
    .erase { display: none; }
    }

    @media only screen and (max-width: 420px) {
    table[class=fullTable] { width: 100% !important; clear: both; }
    table[class=fullPadding] { width: 85% !important; clear: both; }
    table[class=col] { width: 100% !important; clear: both; }
    table[class=col] td { text-align: left !important; }
    .erase { display: none; font-size: 0; max-height: 0; line-height: 0; padding: 0; }
    .visibleMobile { display: block !important; }
    .hiddenMobile { display: none !important; }
    }
  </style>
    <div class="container">
        <div class="header">
        <h1>Tax Invoice</h1>
        <p><strong>Invoice No: </strong> {{ $invoice->id }}</p>
        <p><strong>Invoice Date: </strong> {{ $invoice->created_at }}</p>
        <p><strong>Due Date: </strong> {{ $invoice->created_at }}</p>
    </div>
        <div class="section">
            <h3>Karsh General Trading Co. LLC</h3>
            <p>Dubai, United Arab Emirates</p>
            <p>TRN: 100464359700003</p>
        </div>

        <div class="section">
            <h3>Bill To</h3>
            <p>{{ $invoice->booking->user->name }}</p>
            <p>{{ $invoice->user()->address }}</p>
            <p>TRN: {{ $invoice->customer_trn }}</p>
        </div>

        <table class="items-table">
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
                @foreach($invoice as $index => $item)
                <tr>

                    <td>{{ (int)$index + 1 }}</td>
                    <td>{{ $invoice->booking->goods_description}}</td>
                    <td>{{ $invoice->booking->quantity }}</td>
                    <td>{{ $invoice->total_cost }}</td>
                    <td>{{ $invoice->final_cost }}</td>
                    <td>{{ $invoice->vat }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="invoice-summary">

            <p><strong>Total Amount: </strong> {{ $invoice->total_cost }}</p>
            <p><strong>Total VAT (if applicable): </strong> {{ $invoice->vat }}</p>
            <p><strong>Final Total: </strong> {{ $invoice->final_cost }}</p>
        </div>
        <div class="footer">
        <p>Total In Words: <em>{{ $invoice->total_in_words }}</em></p>

        <p>Thanks for your business.</p>
    </div>
</div>
        <div style="background-color: #fff;width:60% !important;padding: 40px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">

                <tr>
                <td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                        <tr class="hiddenMobile">
                            <td height="40"></td>
                        </tr>
                        <tr class="visibleMobile">
                            <td height="30"></td>
                        </tr>

                        <tr>
                            <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="50%" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                        <tbody>
                                        <tr>
                                            <td align="left"> <img src="{{asset('images/invoice-logo.png')}}" alt="logo" border="0" /></td>
                                        </tr>
                                        <tr class="hiddenMobile">
                                            <td height="40"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;line-height: 16px;vertical-align: top;text-align: left;">
                                                Karsh General Trading Co. LLC<br>
                                                Dubai, United Arab Emirates<br>
                                                TRN: 100464359700003<br>
                                                www.karsh.ae
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="50%" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                        <tbody>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td height="5"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 21px; color: #000; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                                                PRO FORMA INVOICE<br>
                                                <small style="font-size: 13px;letter-spacing: normal;">ORDER #800000025</small><br />
                                                <small style="font-size: 13px;letter-spacing: normal;">MARCH 4TH 2016</small>
                                            </td>
                                        </tr>
                                        <tr>
                                        <tr class="hiddenMobile">
                                            <td height="50"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px; color: #000; line-height: 18px; vertical-align: top; text-align: right;">
                                            <small>Order Date :</small> {{ $invoice->created_at }}<br />
                                            <small>Terms : Due On Receipt</small>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                    </table>
                </td></tr>
                <tr><td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                        <tbody>
                        <tr>
                        <tr class="hiddenMobile">
                            <td height="60"></td>
                        </tr>
                        <tr class="visibleMobile">
                            <td height="40"></td>
                        </tr>
                        <tr>
                            <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                <tbody>
                                <tr>
                                    <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" width="52%" align="left">
                                        Item & Description
                                    </th>
                                    <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="left">
                                    <small>Qty</small>
                                    </th>
                                    <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="center">
                                        Rate
                                    </th>
                                    <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="right">
                                        Tax Amount
                                    </th>
                                    <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="right">
                                        Subtotal
                                    </th>
                                </tr>
                                <tr>
                                    <td height="1" style="background: #bebebe;" colspan="4"></td>
                                </tr>
                                <tr>
                                    <td height="10" colspan="4"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #ff0000;  line-height: 18px;  vertical-align: top; padding:10px 0;" class="article">
                                    Beats Studio Over-Ear Headphones
                                    </td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"><small>MH792AM/A</small></td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">1</td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="right">$299.95</td>
                                </tr>


                                </tbody>
                            </table>
                            <table class="items-table">
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
                                    @foreach($invoice as $index => $item)
                                    <tr>

                                        <td>{{ (int)$index + 1 }}</td>
                                        <td>{{ $invoice->booking->goods_description}}</td>
                                        <td>{{ $invoice->booking->quantity }}</td>
                                        <td>{{ $invoice->total_cost }}</td>
                                        <td>{{ $invoice->final_cost }}</td>
                                        <td>{{ $invoice->vat }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                        </tr>
                        </tbody>
                    </table>
                </td></tr>
                <tr><td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                        <tbody>
                        <tr>
                            <td>

                            <!-- Table Total -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                <tbody>
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    Subtotal
                                    </td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
                                    $329.90
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    Shipping &amp; Handling
                                    </td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    $15.00
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <strong>Grand Total (Incl.Tax)</strong>
                                    </td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <strong>$344.90</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; "><small>TAX</small></td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <small>$72.40</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- /Table Total -->

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td></tr>
                <tr><td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
                        <tbody>
                        <tr>
                        <tr class="hiddenMobile">
                            <td height="60"></td>
                        </tr>
                        <tr class="visibleMobile">
                            <td height="40"></td>
                        </tr>
                        <tr>
                            <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="65%" border="0" cellpadding="0" cellspacing="0" align="left" class="col">

                                        <tbody>
                                        <tr>
                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                            <strong>BILLING INFORMATION</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                            Philip Brooks<br> Public Wales, Somewhere<br> New York NY<br> 4468, United States<br> T: 202-555-0133
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


                                    <table width="35%" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                        <tbody>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                            <strong>PAYMENT METHOD</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                            Credit Card<br> Credit Card Type: Visa<br> Worldpay Transaction ID: <a href="#" style="color: #ff0000; text-decoration:underline;">4185939336</a><br>
                                            <a href="#" style="color:#b0b0b0;">Right of Withdrawal</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                <tbody>
                                <tr>
                                    <td>
                                    <table width="65%" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                        <tbody>
                                        <tr class="hiddenMobile">
                                            <td height="35"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                            <strong>SHIPPING INFORMATION</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                            Sup Inc<br> Another Place, Somewhere<br> New York NY<br> 4468, United States<br> T: 202-555-0171
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


                                    <table width="35%" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                                        <tbody>
                                        <tr class="hiddenMobile">
                                            <td height="35"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                            <strong>SHIPPING METHOD</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                            UPS: U.S. Shipping Services
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr class="hiddenMobile">
                            <td height="60"></td>
                        </tr>
                        <tr class="visibleMobile">
                            <td height="30"></td>
                        </tr>
                        </tbody>
                    </table>
                </td></tr>
                <tr><td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                        <tr>
                            <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                <tbody>
                                <tr>
                                    <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                    Have a nice day.
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr class="spacer">
                            <td height="50"></td>
                        </tr>

                    </table>
                </td>
                </tr>
            </table>


        </div>
        <!-- Add a button to download PDF -->
        <a href="{{ route('invoice.download', ['invoice' => $invoice->id]) }}" class="btn btn-primary">Download PDF</a>
    </div>





    @endsection
