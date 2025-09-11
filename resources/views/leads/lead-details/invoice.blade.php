

<div class="tab-pane fade {{ session('active_tab') === 'g_lead_invoice_tab' ? 'active show' : '' }}"
        id="g_lead_invoice" role="tabpanel" aria-labelledby="g_lead_invoice_tab">

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="fs-3">Invoices</strong>
                <a class="btn btn-success btn-sm" target="_blank"
                    href="{{ route('invoice-create', $lead->id) }}">
                    <i class="bi bi-plus-lg"></i>
                    Create Invoice
                </a>
            </div>

            <div class="table-responsive">
                @if($invoices->isNotEmpty())
                    <!--begin::Table-->
                    <table
                        class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                            <th class="ps-4 min-w-50px">SL</th>
                            <th class="min-w-150px">Invoice No</th>
                            <th class="min-w-140px">Amount</th>
                            <th class="min-w-140px">Total Tax</th>
                            <th class="min-w-140px">Discount</th>
                            <th class="min-w-140px">Date</th>
                            <th class="min-w-120px">Customer</th>
                            <th class="min-w-120px">Due Date</th>
                            <th class="min-w-120px">Status</th>
                            <th class="min-w-140px text-center">Payment</th>
                            <th class="min-w-140px text-center">Due</th>
                            <th class="min-w-100px text-end text-end-new">Actions</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($invoices as $invoice)

                            <tr>

                                <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                <td class="text-dark fs-6">{{$invoice->invoice_number}}</td>
                                <td class="text-dark fs-6 w-100px">{{$invoice->total_amount}}</td>
                                <td class="text-dark fs-6 w-200px">{{$invoice->total_tax }}</td>
                                <td class="text-dark fs-6 w-200px">{{ $invoice->discount ?? '0.00' }}</td>
                                <td class="text-dark fs-6 w-200px">
                                    @if($invoice->invoice_date)
                                        {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}
                                    @endif
                                </td>
                                <td class="text-dark fs-6 w-200px">{{$invoice->first_name}} {{$invoice->last_name}}</td>
                                <td class="text-dark fs-6 w-200px">
                                    @if($invoice->due_date)
                                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}
                                    @endif
                                </td>

                                @php

                                    $paymentDetails = collect($invoice->payment_details);
                                    $totalPayments = $paymentDetails->sum('payment');

                                    $lastPayment = $paymentDetails->last();
                                    $paymentAmount = $lastPayment['payment'] ?? '0.00';
                                    $dueAmount = $lastPayment['due'] ?? $invoice->total_amount;

                                    if ($totalPayments == $invoice->total_amount) {
                                    $status = 'Paid';
                                    $statusClass = 'badge-light-success';
                                    } elseif ($totalPayments == 0) {
                                    $status = 'Unpaid';
                                    $statusClass = 'badge-light-danger';
                                    } elseif ($totalPayments > 0 && $totalPayments < $invoice->total_amount) {
                                    $status = 'Partial Paid';
                                    $statusClass = 'badge-light-warning';
                                    }
                                @endphp


                                <td>
                                    <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                </td>

                                <!-- Display Payment and Due from payment_details -->


                                <td class="text-dark fs-6 w-200px text-center">{{ $totalPayments}}</td>
                                <td class="text-dark fs-6 w-200px text-center">{{ $dueAmount }}</td>
                                <td>
                                    <div
                                        class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                        <a href="{{ route('invoice-show', $invoice->id) }}"
                                            target="_blank"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                            <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24px" height="24px" viewBox="0 0 24 24">
                                            <g stroke="none" stroke-width="1"
                                                fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24"
                                                        height="24"/>
                                                <path
                                                    d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                    fill="black" fill-rule="nonzero"
                                                    opacity="0.7"/>
                                                <path
                                                    d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                    fill="black" opacity="0.7"/>
                                            </g>
                                        </svg>
                                    </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a target="_blank"
                                            href="{{ route('invoice-edit', $invoice->id) }}"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                    fill="black"/>
                                            <path
                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                fill="black"/>
                                        </svg>
                                    </span>
                                            <!--end::Svg Icon-->
                                        </a>

                                        {{--
                                        <form action="{{ route('invoice-destroy', $invoice->id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                onclick="return confirmDelete()">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                            fill="black" />
                                                        <path opacity="0.5"
                                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                            fill="black" />
                                                        <path opacity="0.5"
                                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </form>
                                        --}}

                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach

                        </tbody>
                        <!--end::Table body-->
                    </table>
                @else
                    <p>No results found.</p>
                @endif
                <!--end::Table-->
            </div>

        </div>
    </div>

</div>