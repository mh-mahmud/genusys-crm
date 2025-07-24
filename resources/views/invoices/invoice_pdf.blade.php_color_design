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
        padding: 5px;
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
      @media print {
        body {
          margin: 0;
          padding: 20px;
        }
      }
    </style>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.4; margin: 40px auto; max-width: 800px; padding: 20px; font-size: 13px;">
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


    <div style="margin-left:8px" class="{{ $statusClass }}">
        <button>
            {{ $statusText }}
        </button>
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
                    <td class="text-main font-bold">Beneficiary Address</td>
                    <td>{{ $invoice->address }}</td>
                </tr>
                <tr>
                    <td class="text-main font-bold">Supplier Address</td>
                    <td>Genuity Systems Ltd,Genusys Point,Plot-8, Road 4, Block-A,Section-11, Mirpur, Dhaka-1216</td>
                </tr>
            </table>
        </div>

        <div>
            <h1 style="text-align: center; margin-bottom: 2px; margin-top:20px; margin-left:auto; margin-right:auto; font-size: 24px; text-decoration: underline;">Invoice</h1>
        </div>

        @if (!isset($invoice->invoice_custom_form_id))
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
                <table  style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #424242; padding: 5px; text-align: center; background-color: #002060; color: #ffffff" colspan="{{ $custom_invoice_total_field + 2 }}">
                                {{  \Carbon\Carbon::parse($customInvoiceData->created_at)->format('F, Y') }}
                            </th>
                        </tr>
                        <tr style="border: 1px solid #424242; padding: 5px; text-align: left; background-color: #c65911;
    color: #ffffff;">
                       <th>SL No</th>
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
                                <td>
                                    {{ $item[count($item) - 1]['amount'] }}
                                </td>
                            </tr>
                        @endforeach
                        <tr style="border: 1px solid #424242; padding: 5px; text-align: left; background-color: #002060; color: #ffffff;">
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
                            <td>VAT</td>
                            <td colspan="{{ $custom_invoice_total_field}}" class="text-right" >
                                {{ !empty($invoice['vat']) ? $invoice['vat'] . '%' : '' }}</td>
                            <td class="text-right">{{ $invoice['total_tax'] }}</td>
                        </tr>
                        <tr>
                            <td>Total Including VAT</td>
                            <td colspan= "{{ $custom_invoice_total_field + 1  }}" class="text-right">
                                {{ $invoice['total_amount'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
        @if (empty($invoice->invoice_custom_form_id))
            <div class="text-right font-bold">Sub Total: TK{{ $invoice->sub_total }}</div>
            @if (!empty($invoice->discount))
                <div class="text-right font-bold">Discount: TK{{ $invoice->discount }}</div>
            @endif
            @if ($invoice->total_tax > 0)
                <div class="text-right font-bold">Tax Total: TK{{ $invoice->total_tax }}</div>
            @endif
            @if (!empty($invoice->adjustment))
                <div class="text-right font-bold">Adjustment: TK{{ $invoice->adjustment }}</div>
            @endif
            <div class="text-right font-bold">Total Amount: TK{{ $invoice->total_amount }}</div>
            <div class="text-right font-bold">Total Due Amount: TK{{ $newDueAmount }}</div>
        @endif
        <div style="border: 2px solid #000000; display: flex; justify-content: space-between; padding: 10px 5px; border-collapse: collapse; margin: 40px 8px;">
            <strong>Total In word:</strong>
            <strong>
                {{ \App\Helpers\Helper::convertNumberToWords($invoice->total_amount) }}
            </strong>
        </div>
        @if (!empty($invoice->invoice_custom_form_id))
        <div style="position: relative; width: 100%; height: auto; margin: 40px 8px">

            <!-- Left Side: Bank Information Details -->
            <div style="position: absolute; left: 0; top: 0; width: 48%; text-align: left;">
                <strong>Bank Information Details:</strong></br>
                {!! $customInvoiceData->bank_details !!}
            </div>
        
            <!-- Right Side: Issued by -->
            <div style="position: absolute; right: 15px; top: 0; width: 48%; text-align: right;">
                <strong>Issued by:</strong></br></br>
                _____________________</br>
                <strong>{!! $customInvoiceData->issued_by !!}</strong>
            </div>
        
        </div>
        @else                     
        <div style="margin-top: 100px">
            <h3>Terms & Conditions</h3>
            <p>{{ $invoice->terms_conditions }}</p>
        </div>
        

        <div style="margin-top: 100px">
            <h3>Transactions</h3>
            <p>No payments found for this invoice</p>
        </div>
        @endif
    </div>

</body>

</html>
