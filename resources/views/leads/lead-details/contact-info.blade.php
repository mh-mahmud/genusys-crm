<div class="tab-pane fade show @if(session('success') || session('error')) @else active @endif"
                         id="g_lead_details" role="tabpanel" aria-labelledby="g_lead_details_tab">
   <div class="card" style="margin-top:0px;padding:20px;">
        <div class="card-header bg-light bd-cyan align-items-center">
            <div class="card-title">
                <h4>Client Contact Information</h4>
            </div>
            <a href="{{ route('lead-edit', $lead_data_id) }}" class="btn btn-sm btn-success"
                id="kt_toolbar_primary_button">
                <span class="svg-icon svg-icon-3 me-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path opacity="0.3"
                                        d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                        fill="black"></path>
                                <path
                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                    fill="black"></path>
                        </svg>
                    </span>
            </a>
        </div>
            <!--begin::Body-->
        <div class="card-body py-2">
            <div class="g-lead-details-area mb-5">
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">FORM NAME
                    </span>
                    <span style="font-weight:bold">{{ $lead->leadsForm?->form_name ?? '' }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">First Name</span>
                    <span>{{ $lead->first_name }}</span>
                </div>

                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Middle Name</span>
                    <span>{{ $lead->middlename }}</span>
                </div>

                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Last Name</span>
                    <span>{{ $lead->last_name }}</span>
                </div>

                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Email</span>
                    <span>{{ $lead->email }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Cell Phone</span>
                    <span>{{ $lead->phone }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Home Phone</span>
                    <span>{{ $lead->home_phone }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Work Phone</span>
                    <span>{{ $lead->work_phone }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                    class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Address
                    </span>
                    <span>{{ $lead->address }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Status</span>
                        @if ($lead->lead_status == "Warm")
                          <span class="badge badge-light-primary">Warm</span>
                        @elseif ($lead->lead_status == "Qualified")
                          <span class="badge badge-light-primary">Qualified</span>
                        @elseif ($lead->lead_status == "Hot")
                          <span class="badge badge-light-warning">Hot</span>
                        @elseif ($lead->lead_status == "Won")
                          <span class="badge badge-light-success">Won</span>
                        @elseif ($lead->lead_status == "Dead")
                          <span class="badge badge-light-danger">Dead</span>
                        @endif
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Source</span>
                        <span>
                        @if(in_array($lead->lead_source, config('constants.lead_source')))
                                {{ $lead->lead_source }}
                            @else

                            @endif
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                    class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">City
                    </span>
                    <span>{{ $lead->city }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                    class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Zip</span>
                    <span>{{ $lead->zip }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                    class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">State</span>
                    <span>{{ $lead->state }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                    class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Country</span>
                    <span>{{ $lead->country }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                    <span
                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Notes
                    </span>
                    <span>{{ $lead->lead_notes }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
