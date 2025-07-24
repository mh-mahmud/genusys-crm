<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000000;
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
            padding: 4px;
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

        .header {
            margin-bottom: 20px;
            text-align: right;
        }

        .ref {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .info-table td {
            padding: 5px;
            border: 1px solid #424242;
        }

        .info-table .label {
            font-weight: bold;
            width: 150px;
            background-color: #f8f8f8;
        }

        .info-table .separator {
            width: 30px;
            background: none;
        }

        .invoice-title {
            text-align: center;
            margin: 30px 0;
            font-size: 24px;
            text-decoration: underline;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #424242;
            padding: 4px;
            text-align: left;
        }

        .data-table th:not(:first-child),
        .data-table td:not(:first-child) {
            text-align: right;
        }

        .data-table th {
            background-color: #002060;
            color: #ffffff;
        }

        .data-table tr:not(:first-child) th {
            background-color: #c65911;
            color: #ffffff;
        }

        .g-custom-border {
            border: 2px solid #000000;
            display: flex;
            justify-content: space-between;
            padding: 10px 5px;
        }

        .total-row {
            font-weight: bold;
            color: #000000;
        }

        .footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 40px;
        }

        .inv-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .footer {
            position: fixed;
            bottom: -80px;
            width: 100%;
            height: 60px;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        /* Add print-specific styles */
        @media print {
            body {
                margin: 0;
                padding: 10px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .footer {
                position: fixed;
                bottom: 0;
            }

            .page-break {
            page-break-after: always;
        }
        }
    </style>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1; margin: 0 20px auto; max-width: 800px; padding: 5px; font-size: 12px;">

@php
    // Determine the payment status based on $newDueAmount
    if ($newDueAmount == 0) {
        $statusClass = 'g-paid';
        $statusText = 'Paid';
    } elseif ($newDueAmount > 0 && $newDueAmount < $invoice->total_amount) {
        $statusClass = 'g-partial-paid';
        $statusText = 'Partial Paid';
    } elseif ($newDueAmount == $invoice->total_amount) {
        $statusClass = 'g-unpaid';
        $statusText = 'Unpaid';
    }
@endphp

@foreach(['Office Copy', 'Client Copy'] as $copyType)

<div style="margin-left:8px" class="{{ $statusClass }}">
    <!-- <button>
            {{ $statusText }}
    </button> -->
</div>

<div class="inv-header-top">
    <table style="border-collapse: collapse; border: none;" role="presentation" aria-label="Invoice Header">
        <tr>
            <td style="border: none; padding-bottom: 10px; ">
            <!-- <img src="http://192.168.11.123/gplexCRM/uploads/invoice/genuity.png" width="200" alt="Logo"> -->
            <img src="{{ asset('uploads/invoice/genuity.png') }}" width="200" alt="Logo">
            </td>
            <td style="border: none; padding-bottom: 10px; text-align: right">
            <!-- <img src="http://192.168.11.123/gplexCRM/uploads/invoice/gplex.png" width="200" alt="Logo"> -->
            <img src="{{ asset('uploads/invoice/gplex.png') }}" width="200" alt="Logo">
            </td>
        </tr>
    </table>
</div>

<div class="inv-form-name">
    <table style="border-collapse: collapse; border: none;" role="presentation" aria-label="Invoice Header">
        <tr>
            <td style="border: none; text-align:right">
                <strong style="border:1px solid #000000; padding:5px">{{$copyType}}</strong>
            </td>
        </tr>
    </table>
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
            <!-- @if (!empty($invoice->due_date))
                <tr>
                    <td class="text-main font-bold">Due Date</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('F j, Y') }}</td>
                </tr>



            @endif -->

            @if (!empty($invoice->ref_no))
                <tr>
                    <td class="text-main font-bold">Ref</td>
                    <td>{{ $invoice->ref_no }}</td>
                </tr>

            @endif
            <!-- <tr>
                <td class="text-main font-bold">Invoice #</td>
                <td>{{ $invoice->invoice_number }}</td>
            </tr> -->

            <tr>
                <td class="text-main font-bold " style="white-space: nowrap">Beneficiary Address</td>
                <td>{{ $invoice->address }}</td>
            </tr>
            <tr>
                <td class="text-main font-bold">Supplier Address</td>
                <td>Genuity Systems Ltd,Genusys Point,Plot-8, Road 4, Block-A,Section-11, Mirpur, Dhaka-1216</td>
            </tr>
        </table>
    </div>

    <div style="text-align: center;margin-top: 20px">
        <strong
            style="text-align: center; margin-left:auto; margin-right:auto; font-size: 22px; line-height: 1; text-decoration: underline;">
            Invoice</strong>
    </div>

    @if (!isset($invoice->invoice_custom_form_id))
        <div>
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
                @foreach ($invoiceItems as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['Item'] }}</td>
                        <td>{{ $item['Description'] }}</td>
                        <td>{{ $item['Qty'] }}</td>
                        <td>{{ $item['Rate'] }}</td>
                        <td>{{ $item['Tax'] }}%</td>
                        <td>{{ $item['Amount'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="py-4">
            @php
                $custom_invoice_total_field = count($customInvoiceData->field_details);
            @endphp
            <table style="width: 100%; border-collapse: collapse; margin: 5px 0;">
                <thead>
                <tr>
                    <th style="padding: 5px; text-align: center; color: #000000"
                        colspan="{{ $custom_invoice_total_field + 2 }}">
                        {{  \Carbon\Carbon::parse($customInvoiceData->created_at)->format('F, Y') }}
                    </th>
                </tr>
                <tr style="border: 1px solid #424242; padding: 5px; text-align: left;
    color: #000000;">
                    <th align="left">SL No</th>
                    @foreach ($customInvoiceData->field_details as $field)
                        <th>
                            {{ $field['field_name'] }}
                        </th>
                    @endforeach
                    <th>
                        Amount
                    </th>
                </tr>
                </thead>
                <tbody>
                @php
                    $cal_total = [];
                    $slNo = 1;
                @endphp
                @foreach ($invoiceItems as $item)
                    <tr>
                        <td>{{ $slNo++ }}</td>
                        @foreach ($customInvoiceData->field_details as $field)
                            <td>
                                    <?php
                                    $fieldValue = $field['field_value'];
                                    $value = '';
                                    $totalValue = 0;
                                    foreach ($item as $data) {
                                        if (isset($data[$fieldValue])) {
                                            $value = $data[$fieldValue];
                                            if (isset($field['is_sum']) && $field['is_sum'] == 1) {
                                                $cal_total[$fieldValue][] = $value;
                                            }
                                            break;
                                        }
                                    }
                                    ?>
                                {{ $value }}
                            </td>
                        @endforeach
                        <td style="text-align: right">
                            {{ $item[count($item) - 1]['amount'] }}
                        </td>
                    </tr>
                @endforeach
                <tr style="border: 1px solid #424242; padding: 5px; text-align: left;color: #000000;">
                    <td>Total Net Value</td>
                    @php
                        $total_sum_fields = (is_array($cal_total) && !empty($cal_total)) ? count($cal_total)  : 0;
                        $net_value_col_span = $custom_invoice_total_field - $total_sum_fields;
                        foreach ($cal_total as $total) {
                            $sumSeconds = 0;
                            $numericSum = 0;
                            foreach($total as $value) {
                                if (strpos($value, ':') !== false) {
                                    $timeParts = explode(':', $value); // Split time into parts
                                    if (count($timeParts) == 3) { // Ensure it's in the form of H:M:S
                                        $hours = (int)$timeParts[0];
                                        $minutes = (int)$timeParts[1];
                                        $seconds = (int)$timeParts[2];
                                        $sumSeconds += ($hours * 3600) + ($minutes * 60) + $seconds;
                                    }
                                } elseif (is_numeric($value)) { // Only process numeric values
                                    $numericSum += $value;
                                }
                            }
                            $sumTime = null;
                            if ($sumSeconds > 0) {
                                $hours = floor($sumSeconds / 3600); // Calculate total hours
                                $minutes = floor(($sumSeconds % 3600) / 60); // Calculate remaining minutes
                                $seconds = $sumSeconds % 60; // Calculate remaining seconds

                                $sumTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Format as H:i:s
                            }

                            // Combine the results for output
                            $field_sum_output = '';

                            if ($sumTime) {
                                $field_sum_output = $sumTime ;
                            } else if ($numericSum > 0) {
                                $field_sum_output = $numericSum;
                            }
                            echo "<td class='border-b py-3 pl-3 text-center'>" . $field_sum_output . '</td>';
                        }
                    @endphp
                    <td colspan="{{ $net_value_col_span + 1}}" class="text-right">
                        {{ $invoice['sub_total'] }}
                    </td>
                </tr>
                <tr>
                    <td>VAT {{ !empty($invoice['vat']) ? $invoice['vat'] . '%' : '' }}</td>
                    <td colspan="{{ $custom_invoice_total_field}}" class="text-right">
                        <!-- {{ !empty($invoice['vat']) ? $invoice['vat'] . '%' : '' }} -->
                    </td>
                    <td class="text-right">{{ $invoice['total_tax'] }}</td>
                </tr>
                <tr>
                    <td>Total Including VAT</td>
                    <td colspan="{{ $custom_invoice_total_field + 1  }}" class="text-right">
                        {{ $invoice['total_amount'] }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
    @if (empty($invoice->invoice_custom_form_id))
        <div class="text-right font-bold">Sub Total: TK {{ $invoice->sub_total }}</div>
        <div class="text-right font-bold">Total Amount: TK {{ $invoice->total_amount }}</div>
        <div class="text-right font-bold">Total Due Amount: TK {{ $newDueAmount }}</div>
        <div class="text-right font-bold">Total Received Amount: TK {{ $totalPayments }}</div>
    @endif
    <div
        style="border: 2px solid #000000; display: flex; justify-content: space-between; padding: 10px 5px; border-collapse: collapse; margin: 40px 8px;">
        <strong>Total In word:</strong>
        <strong>
            {{ \App\Helpers\Helper::convertNumberToWords($invoice->total_amount) }}
        </strong>
    </div>
    @if (!empty($invoice->invoice_custom_form_id))
        <div style="position: relative; width: 100%; height: auto; margin: 40px 5px">

            <table style="border-collapse: collapse;" style="border: none;">
                <tr>
                    <td style="border: none; padding: 10px;">
                        <div>
                            <div style="display: flex;flex-direction: column;gap:0; font-size: 13px; line-height: 1">
                                <strong>Bank Information Details:</strong>
                                {!! $customInvoiceData->bank_details !!}
                            </div>
                        </div>
                    </td>
                    <td style="border: none; padding: 10px;text-align: right">
                        <div>
                            <strong>Issued by:</strong></br></br>
                            _____________________
                            <div
                                style="display: flex; flex-direction: column; gap:0; font-weight: bold; font-size: 13px; line-height: 1">
                                {!! $customInvoiceData->issued_by !!}
                            </div>

                        </div>
                    </td>

                </tr>
            </table>


            <div class="footer" style="text-align: center; border-top:1px solid #000; padding-top: 10px">
                <small style=" text-align: center; font-size: 9px; padding-top: 5px; width: 100%; line-height: 1.1">
                    Genusys Point,Plot-8,Road-4,Block-A,Section-11,Mirpur,Dhaka-1216,Bangladesh,Tel:+88 0961 188
                    8444,02-903 0244/55,Email:info@genuitysystems.com
                </small>
            </div>

        </div>
    @else
        <div style="position: relative; width: 100%; height: auto; margin: 40px 8px">
            <table style="border-collapse: collapse;" style="border: none;">
                <tr>
                    <td style="border: none; padding: 10px;">
                        <div>
                            <div style="font-size: 13px; line-height: 1.4;">
                                <div><strong>Bank Information Details:</strong></div>
                                <div><strong>Genuity System Ltd</strong></div>
                                <div><small>Eastern Bank Ltd</small></div>
                                <div><small>AC no-1071060004253</small></div>
                                <div><small>Routing no-095262987</small></div>
                            </div>
                        </div>
                    </td>
                    <td style="border: none; padding: 10px;">
                        <div>
                            <strong>Issued by:</strong></br></br>
                            _____________________
                            <div
                                style="display: flex; flex-direction: column; gap:0; font-weight: bold; font-size: 13px; line-height: 1">
                                <p>Genuity Systems Limited</p>
                               
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="footer" style="text-align: center; border-top:1px solid #000; padding-top: 10px">
                <small style=" text-align: center; font-size: 9px; padding-top: 5px; width: 100%; line-height: 1.1">
                    Genusys Point,Plot-8,Road-4,Block-A,Section-11,Mirpur,Dhaka-1216,Bangladesh,Tel:+88 0961 188
                    8444,02-903 0244/55,Email:info@genuitysystems.com
                </small>
            </div>
        </div>
    @endif
</div>


@if(!$loop->last)
<div class="page-break"></div>
@endif
</div>
@endforeach
</body>

</html>
