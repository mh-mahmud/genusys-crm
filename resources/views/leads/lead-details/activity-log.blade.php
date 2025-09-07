<div
    class="tab-pane fade {{ session('active_tab') === 'g_lead_activity_log_tab' ? 'active show' : '' }}"
    id="g_lead_activity_log" role="tabpanel" aria-labelledby="g_lead_activity_log_tab">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="fs-3">Log History</strong>
            </div>

            <div class="table-responsive">
                @if (isset($logs) && $logs->isNotEmpty())
                    <!--begin::Table-->
                    <table
                        class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                            <th class="ps-4 rounded-start min-w-40px">SL</th>
                            <th class="min-w-150px">Module</th>
                            <th class="min-w-140px">Sub Module</th>
                            <th class="min-w-140px">Log Message</th>
                            <th class="min-w-140px">Lead</th>
                            <th class="min-w-140px">Created By</th>
                            <th class="min-w-120px">Created At</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($logs as $log)
                            <tr>
                                <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                <td class="text-dark fs-6">{{ $log->module }}</td>
                                <td class="text-dark fs-6">{{ $log->sub_module }}</td>
                                <td class="text-dark fs-6">{{ $log->log_message }}</td>
                                <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                <td class="text-dark fs-6">{{ $log->first_name }} {{ $log->last_name }}</td>
                                <td>
                                    {{ $log->created_at->format('d-m-Y h:i:s A') }}
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