<div class="tab-pane fade {{ session('active_tab') === 'g_lead_email_tab' ? 'active show' : '' }}"
        id="g_lead_email" role="tabpanel" aria-labelledby="g_lead_email_tab">
    <div class="card">
        <div class="card-body">

            <!--begin::Body-->
            <div class="card-body p-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="fs-3">Emails</strong>
                    <a class="btn btn-success btn-sm" id="kt_activities_toggle">
                        <i class="bi bi-plus-lg"></i>
                        Send Email
                    </a>
                </div>
                <div class="table-responsive">
                    
                    @if(count($emails) > 0)
                        <table
                            class="table table-sm table-condensed table-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                <th class="ps-4 rounded-start min-w-50px">SL</th>
                                <th class="min-w-150px">To</th>
                                <th class="min-w-150px">Lead</th>
                                <th class="min-w-150px">Email Subject</th>
                                <th class="min-w-140px">Time</th>
                                <th class="rounded-end min-w-50px">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($emails as $email)
                                <tr>
                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                    <td class="text-dark fs-6">{{ implode(', ', $email->email_to) }}</td>
                                    <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                    <td class="text-dark fs-6">{{ $email->email_subject }}</td>
                                    <td class="text-dark fs-6">{{ Carbon::parse($email->log_time)->format('d-m-Y h:i A') }}</td>
                                    <td class="text-dark fs-6">
                                        @if ($email->send_status == config('constants.campaign_status')["Success"])
                                            <span class="badge badge-light-success">Success</span>
                                        @elseif ($email->status == 0)
                                            <span class="badge badge-light-danger">Fail</span>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach

                            </tbody>
                        </table>
                    @else
                        <p>No results found.</p>
                    @endif
                </div>
            </div>
            <!--end::Body-->

        </div>
    </div>
</div>