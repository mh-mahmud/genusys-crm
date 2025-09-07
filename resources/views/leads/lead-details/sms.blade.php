<div class="tab-pane fade {{ session('active_tab') === 'g_lead_sms_tab' ? 'active show' : '' }}"
        id="g_lead_sms" role="tabpanel" aria-labelledby="g_lead_sms_tab">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="fs-3">SMS List</strong>
                <a class="btn btn-success btn-sm" id="kt_activities_toggle_2"><i
                        class="bi bi-plus-lg"></i>Send SMS</a>
            </div>


            <div class="table-responsive">
                @if(count($sms) > 0)
                    <!--begin::Table-->
                    <table
                        class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                            <th class="ps-4">SL</th>
                            <th class="min-w-150px">To</th>
                            <th class="min-w-150px">Lead</th>
                            <th class="min-w-150px">SMS Body</th>
                            <th class="min-w-140px">Send Time</th>
                            <th class=" min-w-120px">Status</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($sms as $value)
                            <tr>
                                <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                <td class="text-dark fs-6">{{ $value->sms_to }}</td>
                                <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                <td class="text-dark fs-6">{{ $value->sms_text }}</td>
                                <td class="text-dark fs-6">{{ Carbon::parse($value->log_time)->format('d-m-Y h:i A') }}</td>
                                <td>
                                    @if ($value->send_status == 1)
                                        <span class="badge badge-light-success">Success</span>
                                    @elseif ($value->status == 0)
                                        <span class="badge badge-light-danger">Fail</span>
                                    @endif
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


            <!-- </div> -->
            <!--end::Body-->

        </div>
    </div>
</div>