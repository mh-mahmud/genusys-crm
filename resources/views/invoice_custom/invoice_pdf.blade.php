<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .status button {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            cursor: pointer;
        }

        .inv-main {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .text-main {
            color: #333;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .terms_conditions {
            margin-top: 30px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        .terms_conditions h3 {
            margin-bottom: 10px;
        }

        .terms_conditions p {
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="status">
        <button>Unpaid</button>
    </div>

    <div class="inv-main">
        <div>

            <!-- <img src="{{ getcwd() . '/uploads/logo.svg' }}" class="h-12" alt="Logo" /> -->


        </div>

        <div class="py-4">
            <table>
                <tr>
                    <td class="text-main font-bold">Date</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <td class="text-main font-bold">Due Date</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <td class="text-main font-bold">Invoice #</td>
                    <td>{{ $invoice->invoice_number }}</td>
                </tr>

                <tr>
                    <td class="text-main font-bold">Bill To</td>
                    <td>{{$invoice->customer?->customer_group}}<br>{{ $invoice->address }}</td>
                </tr>
                <tr>
                    <td class="text-main font-bold">Sale Agent</td>
                    <td>{{$invoice->saleAgent?->first_name}} {{$invoice->saleAgent?->last_name}}</td>
                </tr>
            </table>
        </div>

        <div class="py-4">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Tax</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceItems as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item['Item']}}</td>
                        <td>{{$item['Description']}}</td>
                        <td>{{$item['Qty']}}</td>
                        <td>{{$item['Rate']}}</td>
                        <td>{{$item['Tax']}}%</td>
                        <td>{{$item['Amount']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right font-bold">Sub Total: TK{{ $invoice->sub_total }}</div>
        @if(!empty($invoice->discount))
        <div class="text-right font-bold">Discount: TK{{ $invoice->discount }}</div>
        @endif
        @if($invoice->total_tax>0)
        <div class="text-right font-bold">Tax Total: TK{{ $invoice->total_tax }}</div>
        @endif
        @if(!empty($invoice->adjustment))
        <div class="text-right font-bold">Adjustment: TK{{ $invoice->adjustment }}</div>
        @endif
        <div class="text-right font-bold">Total Amount: TK{{ $invoice->total_amount }}</div>
        <div class="terms_conditions">
            <h3>Terms & Conditions</h3>
            <p>{{ $invoice->terms_conditions }}</p>
        </div>
        <div class="terms_conditions">
            <h3>Transactions</h3>
            <p>No payments found for this invoice</p>
        </div>
    </div>

</body>

</html>