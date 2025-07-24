<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="{{url('/')}}/assets/css/invoice.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('/')}}/assets/css/flatpickr.min.css">
    <link href="{{url('/')}}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{url('/')}}/assets/plugins/global/plugins.bundle.js"></script>


</head>

<body>
    <script src="{{ url('/') }}/assets/js/sweetalert2.min.js"></script>
    <!-- Bootstrap CSS -->



    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('
            success ') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('
            error ') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif
    @php

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

        <div class="status">
            <div class="{{ $statusClass }}">
                <button>
                    {{ $statusText }}
                </button>
            </div>
            <div class="status-btn-group">
                <button onclick="window.location.href='{{ route('invoice-download', $invoice->id) }}'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
                        <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1" />
                        <path d="M4.603 12.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.6 11.6 0 0 0-1.997.406 11.3 11.3 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.238c-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361q.016.032.026.044l.035-.012c.137-.056.355-.235.635-.572a8 8 0 0 0 .45-.606m1.64-1.33a13 13 0 0 1 1.01-.193 12 12 0 0 1-.51-.858 21 21 0 0 1-.5 1.05zm2.446.45q.226.244.435.41c.24.19.407.253.498.256a.1.1 0 0 0 .07-.015.3.3 0 0 0 .094-.125.44.44 0 0 0 .059-.2.1.1 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a4 4 0 0 0-.612-.053zM8.078 5.8a7 7 0 0 0 .2-.828q.046-.282.038-.465a.6.6 0 0 0-.032-.198.5.5 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822q.036.167.09.346z" />
                    </svg>
                    Download
                </button>
                <!-- <button>Pay Now</button> -->
            </div>
        </div>
        <div class="inv-main">

            <div class="py-1">
                <div class="px-14 py-1">
                    <table class="w-full border-collapse border-spacing-0">
                        <tbody>
                            <tr>
                                <td class="w-full align-top">
                                    <div>
                                        <img src="{{ asset('uploads/gplex_logo.png') }}" class="h-12" />
                                    </div>
                                </td>

                                <td class="align-top">
                                    <div class="text-sm">
                                        <table class="border-collapse border-spacing-0">
                                            <tbody>
                                                <tr>
                                                    <td class="border-r pr-4">
                                                        <div>
                                                            <p class="whitespace-nowrap text-slate-400 text-right">Date</p>
                                                            <p class="whitespace-nowrap font-bold text-main text-right">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('F j, Y') }}</p>
                                                        </div>
                                                    </td>
                                                    @if (!empty($invoice->due_date))
                                                    <td class="border-r pr-4">
                                                        <div>
                                                            <p class="whitespace-nowrap text-slate-400 text-right">Due Date</p>
                                                            <p class="whitespace-nowrap font-bold text-main text-right">{{ \Carbon\Carbon::parse($invoice->due_date)->format('F j, Y') }}</p>
                                                        </div>
                                                    </td>
                                                    @endif
                                                    @if (!empty($invoice->ref_no))
                                                    <td class="border-r pr-4">
                                                        <div>
                                                            <p class="whitespace-nowrap text-slate-400 text-right">Ref:</p>
                                                            <p class="whitespace-nowrap font-bold text-main text-right">{{$invoice->ref_no}}</p>
                                                        </div>
                                                    </td>
                                                    @endif
                                                    <td class="pl-4">
                                                        <div>
                                                            <p class="whitespace-nowrap text-slate-400 text-right">Invoice #</p>
                                                            <p class="whitespace-nowrap font-bold text-main text-right">{{$invoice->invoice_number}}</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-slate-100 px-14 py-1 text-sm">
                    <table class="w-full border-collapse border-spacing-0">
                        <tbody>
                            <tr>
                                <td class="w-1/2 align-top">
                                    <div class="text-sm text-neutral-600">
                                        <p class="font-bold">Supplier Address</p>
                                        <strong>Genuity Systems Ltd</strong>
                                        <p>Genusys Point</p>
                                        <p>Plot-8, Road 4, Block-A</p>
                                        <p>Section-11, Mirpur, Dhaka-1216</p>

                                    </div>
                                </td>
                                <td class="w-1/2 align-top text-right">
                                    <div class="text-sm text-neutral-600">
                                        <p class="font-bold">Beneficiary Address</p>
                                        <p>{{$invoice->address}}</p>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if(empty($invoice->invoice_custom_form_id))
                <div class="px-14 py-3 text-sm text-neutral-700">
                    <table class="w-full border-collapse border-spacing-0">
                        <thead>
                            <tr>
                                <td class="border-b-2 border-main pb-3 pl-3 text-center font-bold text-main">#</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Item</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Description</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Qty.</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Rate</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Tax</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Amount</td>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoiceItems as $item)
                            <tr>
                                <td class="border-b py-2 pl-3 text-center">{{$loop->iteration }}.</td>
                                <td class="border-b py-2 pl-2 text-center">{{$item['Item']}}</td>
                                <td class="border-b py-2 pl-2 text-center">{{$item['Description']}}</td>
                                <td class="border-b py-2 pl-2 text-center">{{$item['Qty']}}</td>
                                <td class="border-b py-2 pl-2 text-center">{{$item['Rate']}}</td>
                                <td class="border-b py-2 pl-2 text-center">{{$item['Tax']}}%</td>
                                <td class="border-b py-2 pl-2 text-right">{{$item['Amount']}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="7">
                                    <table class="w-full border-collapse border-spacing-0">
                                        <tbody>
                                            <tr>
                                                <td class="w-full"></td>
                                                <td>
                                                    <table class="w-full border-collapse border-spacing-0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="border-b p-3">
                                                                    <div class="whitespace-nowrap text-slate-400">Sub Total:</div>
                                                                </td>
                                                                <td class="border-b text-right">
                                                                    <div class="whitespace-nowrap font-bold text-main">TK{{$invoice->sub_total}}</div>
                                                                </td>
                                                            </tr>
                                                            @if(!empty($invoice->discount))
                                                            <tr>
                                                                <td class="p-3">
                                                                    <div class="whitespace-nowrap text-slate-400">Discount:</div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <div class="whitespace-nowrap font-bold text-main">TK-{{$invoice->discount}}</div>
                                                                </td>
                                                            </tr>
                                                            @endif

                                                            @if($invoice->total_tax>0)
                                                            <tr>
                                                                <td class="p-3">
                                                                    <div class="whitespace-nowrap text-slate-400">Tax Total:</div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <div class="whitespace-nowrap font-bold text-main">TK{{$invoice->total_tax}}</div>
                                                                </td>
                                                            </tr>
                                                            @endif

                                                            @if(!empty($invoice->adjustment))
                                                            <tr>
                                                                <td class="p-3">
                                                                    <div class="whitespace-nowrap text-slate-400">Adjustment:</div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <div class="whitespace-nowrap font-bold text-main">TK{{$invoice->adjustment}}</div>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td class="p-3">
                                                                    <div class="whitespace-nowrap">Total Amount:</div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <div class="whitespace-nowrap font-bold">TK{{$invoice->total_amount}}</div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="p-3">
                                                                    <div class="whitespace-nowrap">Total Due Amount:</div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <div class="whitespace-nowrap font-bold">TK{{$newDueAmount}}</div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-3">
                                                                    <div class="whitespace-nowrap">Total Received Amount:</div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <div class="whitespace-nowrap font-bold">TK{{$totalPayments}}</div>
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
                        </tbody>
                    </table>
                </div>
                @else
                @php
                $custom_invoice_total_field = count($customInvoiceData->field_details);
                @endphp
                <div class="px-14 py-10 text-sm text-neutral-700">
                    <table class="w-full border-collapse border-spacing-0">
                        <thead>
                            <tr>
                                <td class="border-b-2 border-main pb-3 pl-3 text-center font-bold text-main">SL No</td> <!-- Added Sl No Column -->
                                @foreach($customInvoiceData->field_details as $field)
                                <td class="border-b-2 border-main pb-3 pl-3 text-center font-bold text-main">
                                    {{ $field['field_name'] }}
                                </td>
                                @endforeach
                                <td class="border-b-2 border-main pb-3 pl-3 text-center font-bold text-main">
                                    Amount
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cal_total = [];
                            $slNo = 1;
                            @endphp
                            @foreach($invoiceItems as $item)
                            <tr>
                                <td class="border-b py-3 pl-3 text-center">{{ $slNo++ }}</td>
                                @foreach($customInvoiceData->field_details as $field)
                                <td class="border-b py-3 pl-3 text-center">
                                    <?php
                                    $fieldValue = $field['field_value'];
                                    $value = '';
                                    $totalValue = 0;
                                    foreach ($item as $data) {
                                        if (isset($data[$fieldValue])) {
                                            $value = $data[$fieldValue];
                                            if (isset($field['is_sum']) && $field['is_sum'] == 1) {
                                                // $totalValue = $totalValue + $value;
                                                $cal_total[$fieldValue][] = $value;
                                            }
                                            break;
                                        }
                                    }
                                    ?>
                                    {{ $value }}
                                </td>
                                @endforeach
                                <td class="border-b py-3 pl-3 text-right">
                                    {{ $item[count($item) -1]["amount"] }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="border-b py-3 pl-3 text-center">Total Net Value</td>
                                @php

                                foreach($cal_total as $total) {
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
                                //dd($sumSeconds);
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
                                echo "<td class='border-b py-2 pl-3 text-center'>". $field_sum_output."</td>";
                                }
                                @endphp
                                <td class="border-b py-2 pl-3 text-right" colspan="{{ $custom_invoice_total_field + 1 }}">{{ $invoice["sub_total"] }}</td>
                            </tr>
                            <tr>
                                <td class="border-b py-2 pl-3 text-center">VAT</td>
                                <td class="border-b py-2 pl-3 text-right" colspan="{{ $custom_invoice_total_field  }} ">{{ !empty($invoice["vat"]) ? $invoice["vat"] . '%' : '' }}</td>
                                <td class="border-b py-2 pl-3 text-right">{{ $invoice["total_tax"] }}</td>
                            </tr>
                            <tr>
                                <td class="border-b py-2 pl-3 text-center">Total Including VAT</td>
                                <td colspan="{{ $custom_invoice_total_field + 1}}" class="border-b py-3 pl-3 text-right">{{ $invoice["total_amount"] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif

                <div class="px-14 text-sm text-neutral-700 border-b py-2">
                    <p class="text-main font-bold">Total In Word</p>
                    <p>{{ \App\Helpers\Helper::convertNumberToWords($invoice->total_amount) }}</p>
                </div>

                <div class="px-14 text-sm text-neutral-700 border-b py-2">
                    <p class="text-main font-bold">Terms And Condition</p>
                    <p>{{$invoice->terms_conditions}}</p>

                </div>
                @if($newDueAmount > 0)


                <div class="px-14 text-sm text-neutral-700 border-b py-2">
                    <p class="text-main font-bold">Transactions</p>
                    @if (!empty($totalPayments) && $totalPayments > 0)
                    <p>{{$totalPayments}}TK found for this invoice</p>
                    @else
                    <p>No payments found for this invoice</p>
                    @endif

                </div>


                @if (!empty($invoice->invoice_custom_form_id))
                <div class="px-14 text-sm text-neutral-700 py-2">
                    <p class="text-main font-bold">Bank Information:</p>
                    {!! $customInvoiceData->bank_details !!}
                </div>
                @endif
                @if (!empty($existingPayments) && count($existingPayments) > 0)
                <div class="px-14 py-10 text-sm text-neutral-700">
                    @foreach ($existingPayments as $index => $payment)
                    @if(($payment['deposit_status'] ?? '') === 'Pending')
                    <div class="modal fade" id="depositModal-{{ $index }}" tabindex="-1" aria-labelledby="depositModalLabel-{{ $index }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-4">
                                <form action="{{ route('deposit-status-update', ['invoice' => $invoice->id, 'index' => $index]) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="depositModalLabel-{{ $index }}">Update Deposit Date</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bold">Deposit Date</label>
                                            <input type="text" name="deposit_date" class="form-control form-control-sm flatpickr" value="{{ old('deposit_date') }}">
                                            @error('deposit_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach

                    <table class="w-full border-collapse border-spacing-0">
                        <thead>
                            <tr>
                                <td class="border-b-2 border-main pb-3 pl-3 text-center font-bold text-main">#</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Payment Mode</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Amount</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Transfer Date</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Transfer Method</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Cheque Number</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Received Date</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Deposit Date</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Deposit Status</td>
                                <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($existingPayments as $payment)
                            <tr>
                                <td class="border-b py-2 pl-3 text-center">{{ $loop->iteration }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['payment_mode'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['payment'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['transfer_date'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['transfer_mode'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['cheque_number'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['received_date'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['deposit_date'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">{{ $payment['deposit_status'] ?? '-' }}</td>
                                <td class="border-b py-2 pl-2 text-center">
                                    @if(($payment['deposit_status'] ?? '') === 'Pending')
                                    <button type="button"
                                        class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1"
                                        title="Deposit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#depositModal-{{ $loop->index }}">
                                        <span class="svg-icon svg-icon-2x">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M12 22C17.5229 22 22 17.5229 22 12C22 6.47715 17.5229 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5229 6.47715 22 12 22Z" fill="black" />
                                                <path d="M10.0004 14.0002L7.50037 11.5002L6.08594 12.9146L10.0004 16.829L18.0004 8.82898L16.586 7.41455L10.0004 14.0002Z" fill="black" />
                                            </svg>
                                        </span>
                                    </button>
                                    @else
                                    <span class="badge bg-success">Deposit</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-2 pl-3 text-center text-sm text-gray-500">No existing payments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                @else
                @endif

                <!-- Payment Form -->
                <form action="{{ route('invoice-payment', $invoice->id) }}" method="POST" id="payment-form">
                    @csrf
                    <div class="px-14 py-1 text-sm text-neutral-700">
                        <label for="payment-amount" class="text-main font-bold">Amount
                            <span>
                                <input type="text" name="payment_amount" id="payment-amount" class="form-control" value="{{ old('payment_amount') }}" required>
                                <span class="font-bold" style="padding: 0.33rem 1rem;">TK</span>
                            </span>
                        </label>
                        @if ($errors->has('payment_amount'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('payment_amount') }}</span>
                        @endif
                    </div>

                    <div class="px-14 py-1 text-sm text-neutral-700">
                        <label for="payment_mode" class="text-main font-bold">Payment Mode:</label>

                        <select class="form-select form-select-sm w-auto" name="payment_mode" id="payment-mode" required>
                            <option value="">Select Payment Mode</option>
                            <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="Bank Transfer" {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>

                        @if ($errors->has('payment_mode'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('payment_mode') }}</span>
                        @endif
                    </div>

                    <div id="cheque-fields" class="px-14 py-1 text-sm text-neutral-700" style="display:none">
                        <label for="cheque-number" class="text-main font-bold">Cheque Number:
                            <span>
                                <input type="text" name="cheque_number" id="cheque-number" class="form-control form-control-sm" value="{{ old('cheque_number') }}">

                            </span>
                        </label>
                        @if ($errors->has('cheque_number'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('cheque_number') }}</span>
                        @endif
                        <label for="received-date" class="text-main font-bold">Received Date:
                            <span>
                                <input type="text" name="received_date" id="received-date" class="form-control form-control-sm flatpickr" value="{{ old('received_date') }}">

                            </span>
                        </label>
                        @if ($errors->has('received_date'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('received_date') }}</span>
                        @endif
                    </div>

                    <div id="bank-fields" class="px-14 py-1  text-sm text-neutral-700" style="display:none">
                        <label class="text-main font-bold" for="transfer-date">Transfer Date:
                            <span>
                                <input type="text" name="transfer_date" id="transfer-date" class="form-control form-control-sm form-control-solid flatpickr" value="{{ old('transfer_date') }}">

                            </span>
                        </label>
                        @if ($errors->has('transfer_date'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('transfer_date') }}</span>
                        @endif<br><br>


                        <label class="text-main font-bold" for="transfer-mode">Transfer Mode:</label>

                        <select name="transfer_mode" id="transfer-mode" class="form-select form-select-sm w-auto">
                            <option value="">Select Transfer Mode</option>
                            <option value="BEFTN" {{ old('transfer_mode') == 'BEFTN' ? 'selected' : '' }}>BEFTN</option>
                            <option value="NPSB" {{ old('transfer_mode') == 'NPSB' ? 'selected' : '' }}>NPSB</option>
                        </select>

                        @if ($errors->has('transfer_mode'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('transfer_mode') }}</span>
                        @endif

                    </div>

                    <div class="px-14 py-1 text-sm text-neutral-700">
                        <label class="text-main font-bold" for="deposit-date">Deposit Status:</label>

                        <select name="deposit_status" id="deposit-status" class="form-select form-select-sm w-auto">
                            <option value="">Select Deposit Status</option>
                            <option value="Pending" {{ old('deposit_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Success" {{ old('deposit_status') == 'Success' ? 'selected' : '' }}>Success</option>
                            <option value="Failed" {{ old('deposit_status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                        </select>

                        @if ($errors->has('deposit_status'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('deposit_status') }}</span>
                        @endif


                    </div>

                    <div id="deposit-date-wrapper" class="px-14 py-1 text-sm text-neutral-700">
                        <label class="text-main font-bold" for="deposit-date">Deposit Date:
                            <span>
                                <input type="text" name="deposit_date" class="form-control form-control-sm flatpickr" id="deposit-date" value="{{ old('deposit_date') }}">
                            </span>
                        </label><br>
                        @if ($errors->has('deposit_date'))
                        <span class="text-danger" style="color:#F1416C">{{ $errors->first('deposit_date') }}</span>
                        @endif
                    </div>


                    <div class="px-14 text-sm text-neutral-700">
                        <button type="submit" class="pay-now">Pay Now</button>
                    </div>
                </form>
                @else
                <!-- Message if no payment is due -->
                <div class="px-14 py-1 text-sm text-neutral-700">
                    <p class="text-success">The invoice is fully paid. No further payments are needed.</p>
                </div>
                @endif



            </div>
        </div>

        <script>
            document.getElementById('payment-mode').addEventListener('change', function() {
                const paymentMode = document.getElementById('payment-mode').value;
                const chequeFields = document.getElementById('cheque-fields');
                const bankFields = document.getElementById('bank-fields');

                chequeFields.style.display = 'none';
                bankFields.style.display = 'none';

                if (this.value === 'Cheque') {
                    chequeFields.style.display = 'block';
                } else if (this.value === 'Bank Transfer') {
                    bankFields.style.display = 'block';
                }
            });
        </script>

        <script src="{{url('/')}}/assets/js/flatpickr.js"></script>

        <script>
            flatpickr(".flatpickr", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
        </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const depositStatus = document.getElementById('deposit-status');
            const depositDateDiv = document.getElementById('deposit-date-wrapper');

            function toggleDepositDate() {
                if (depositStatus.value === 'Success') {
                    depositDateDiv.style.display = 'block';
                } else {
                    depositDateDiv.style.display = 'none';
                }
            }

            depositStatus.addEventListener('change', toggleDepositDate);
            toggleDepositDate(); // initial call
        });
    </script>


</body>




</html>