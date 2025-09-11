
<div class="tab-pane fade {{ session('active_tab') === 'g_lead_meeting_tab' ? 'active show' : '' }}"
        id="g_lead_meeting" role="tabpanel" aria-labelledby="g_lead_meeting_tab">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="fs-3">Meetings</strong>
                <a class="btn btn-success btn-sm" id="kt_activities_toggle_3"><i
                        class="bi bi-plus-lg"></i>Meeting Request</a>
            </div>
            <div class="table-responsive">
                @if(count($meetings) > 0)
                    <!--begin::Table-->
                    <table
                        class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                            <th class=" ps-4">SL</th>
                            <!-- <th class="min-w-150px">Form ID</th> -->
                            <th class="min-w-150px">Meeting Subject</th>
                            <!-- <th class="min-w-150px">Promotion</th> -->
                            <th class="min-w-140px">Meeting Date</th>
                            <th class="min-w-140px">Duration</th>
                            <th class="min-w-140px">Created By</th>
                            <th class="min-w-120px">Status</th>
                            <th class="min-w-120px">Rating</th>
                            <th class="min-w-100px text-center text-center-new">Actions</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($meetings as $meeting)
                            <tr>
                                <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                <td class="text-dark fs-6 w-250px">{{$meeting->meeting_subject }}</td>
                                <td class="text-dark fs-6">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('Y-m-d h:i A') }}</td>
                                <td class="text-dark fs-6">{{$meeting->duration }}</td>
                                <td class="text-dark fs-6">{{$meeting->user->username ?? 'N/A'}}</td>

                                <td>
                                    @if ($meeting->status == 1)
                                        <span class="badge badge-light-success">Active</span>
                                    @elseif ($meeting->status == 0)
                                        <span class="badge badge-light-danger">Inactive</span>
                                    @endif
                                </td>

                                <td class="text-dark fs-6">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <=$meeting->rating)
                                            <i class="fa fa-star text-warning"></i>
                                            <!-- Yellow star for ratings -->
                                        @else
                                            <i class="fa fa-star text-muted"></i>
                                            <!-- Grey star for remaining -->
                                        @endif
                                    @endfor
                                </td>


                                <td>
                                    <div
                                        class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                        <a href="#"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#add_feedback_modal"
                                                    data-id="{{ $meeting->id }}">
                                                    <!-- Pass meeting ID here -->
                                                    <!-- Svg Icon -->
                                            <span class="svg-icon svg-icon-3">
                                                <svg fill="#000000" width="800px" height="800px"
                                                        viewBox="0 0 1920 1920"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M84 0v1423.143h437.875V1920l621.235-496.857h692.39V0H84Zm109.469 109.464H1726.03V1313.57h-621.235l-473.452 378.746V1313.57H193.469V109.464Z"
                                                        fill-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </a>

                                        <a target="_blank"
                                                href="#"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                id="show_meeting_{{ $meeting->id }}">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                            height="24px" viewBox="0 0 24 24">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path
                                                                d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                fill="black" fill-rule="nonzero" opacity="0.7"/>
                                                            <path
                                                                d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                fill="black" opacity="0.7"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                        </a>
                                        <!-- <a target="_blank"
                                            href="{{ route('meeting-edit', $meeting->id) }}"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">

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

                                        </a> -->

                                    <a
                                            href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            id="update_meeting_{{ $meeting->id }}">

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

                                </a>


                                <!--begin::Meeting activities drawer-->
                                <div id="kt_activities_3_{{ $meeting->id }}" class="bg-body"
                                        data-kt-drawer="true" data-kt-drawer-name="activities"
                                        data-kt-drawer-activate="true"
                                        data-kt-drawer-overlay="true"
                                        data-kt-drawer-width="{default:'300px', 'lg': '50%'}"
                                        data-kt-drawer-direction="end"
                                        data-kt-drawer-toggle="#update_meeting_{{ $meeting->id }}"
                                        data-kt-drawer-close="#kt_activities_close">
                                    <div class="card shadow-none rounded-0 w-100">
                                        <!--begin::Header-->
                                        <div class="card-header" id="kt_activities_header">
                                            <h3 class="card-title fw-bolder text-dark">Edit
                                                Meeting</h3>
                                            <div class="card-toolbar">
                                                <button type="button"
                                                        class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                                                        id="kt_activities_close">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                    height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)"
                                                    fill="black"/>
                                            <rect x="7.41422" y="6" width="16" height="2"
                                                    rx="1" transform="rotate(45 7.41422 6)"
                                                    fill="black"/>
                                        </svg>
                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body position-relative"
                                                id="kt_activities_body">
                                            <!--begin::Content-->
                                            <div id="kt_activities_scroll"
                                                    class="position-relative scroll-y me-n5 pe-5"
                                                    data-kt-scroll="false"
                                                    data-kt-scroll-height="auto"
                                                    data-kt-scroll-wrappers="#kt_activities_body"
                                                    data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                                                    data-kt-scroll-offset="5px">
                                                <!--begin::Timeline items-->
                                                <!-- <div class="timeline"> -->

                                                <!--begin::Tables Widget 9-->
                                                <div class="card mb-5 mb-xl-8">
                                                    <!--begin::Header-->

                                                    <!--end::Header-->
                                                    <div
                                                        style="border:1px solid #ddd;padding:20px">
                                                        <div class="row">
                                                            <div class="col-md-12 mx-auto">

                                                                <form
                                                                    action="{{ route('meeting-update', $meeting->id) }}"
                                                                    method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden"
                                                                            name="lead_id"
                                                                            value="{{ $lead->id }}">
                                                                    <input type="hidden"
                                                                            name="form_lead_panel"
                                                                            value="1">
                                                                    <div class="row">

                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="fv-row mb-3">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark">Select
                                                                                    Lead</label>
                                                                                <select
                                                                                    class=" form-control form-control-sm form-control-solid"
                                                                                    name="recipients"
                                                                                    aria-label="Default select example">
                                                                                    <option
                                                                                        value="{{$lead->id}}">
                                                                                        @if($lead->first_name || $lead->last_name || $lead->email)
                                                                                            {{ trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? '') .
                                                                                            ($lead->email ? ' <' . $lead->email . '>' : '')) }}
                                                                                        @endif
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="fv-row mb-3">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark">Meeting
                                                                                    Subject</label>
                                                                                <input
                                                                                    class="form-control form-control-sm form-control-solid"
                                                                                    required
                                                                                    type="text"
                                                                                    name="meeting_subject"
                                                                                    value="{{ old('meeting_subject', $meeting->meeting_subject ?? '') }}"
                                                                                    autocomplete="off"/>
                                                                                @if ($errors->has('meeting_subject'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('meeting_subject') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>


                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="fv-row mb-3">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark">Meeting
                                                                                    Date</label>
                                                                                <input
                                                                                    type="text"
                                                                                    class="form-control form-control-sm form-control-solid flatpickr"
                                                                                    name="meeting_date"
                                                                                    value="{{ old('meeting_date', $meeting->meeting_date ?? '') }}"
                                                                                    required/>
                                                                                @if ($errors->has('meeting_date'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('meeting_date') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>


                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="form-group">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark"
                                                                                    for="textarea">Meeting
                                                                                    Description</label>
                                                                                <textarea
                                                                                    class="form-control form-control-sm form-control-solid"
                                                                                    name="meeting_description"
                                                                                    rows="2">{{ old('meeting_description', $meeting->meeting_description ?? '') }}</textarea>
                                                                                @if ($errors->has('meeting_description'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('meeting_description') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>


                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="fv-row mb-3">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark">Meeting
                                                                                    Link</label>
                                                                                <input
                                                                                    class="form-control form-control-sm form-control-solid"
                                                                                    type="url"
                                                                                    name="meeting_link"
                                                                                    value="{{ old('meeting_link', $meeting->meeting_link ?? '') }}"
                                                                                    autocomplete="off"/>
                                                                                @if ($errors->has('meeting_link'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('meeting_link') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>


                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="fv-row mb-3">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark">Duration</label>
                                                                                <input
                                                                                    class="form-control form-control-sm form-control-solid"
                                                                                    type="text"
                                                                                    name="duration"
                                                                                    value="{{ old('duration', $meeting->duration ?? '') }}"
                                                                                    autocomplete="off"/>
                                                                                @if ($errors->has('duration'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('duration') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>


                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="fv-row mb-3">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark">Attachments</label>
                                                                                <input
                                                                                    type="file"
                                                                                    class="form-control form-control-sm form-control-solid"
                                                                                    name="attachments"/>
                                                                                @if ($meeting->attachments)
                                                                                    <div
                                                                                        class="mt-3"
                                                                                        id="attachments-file-container">
                                                                                        @php

                                                                                            $fileExtension = pathinfo($meeting->attachments, PATHINFO_EXTENSION);
                                                                                        @endphp

                                                                                            <!-- Show a link for non-image attachments -->
                                                                                        <a href="{{ asset('uploads/meetings/' . $meeting->attachments) }}"
                                                                                            target="_blank">
                                                                                            View {{ strtoupper($fileExtension) }}
                                                                                            Attachment
                                                                                        </a>


                                                                                        <!-- Replace the trash icon with a new "remove" icon -->
                                                                                        <button
                                                                                            type="button"
                                                                                            class="btn btn-danger btn-sm p-1"
                                                                                            id="delete-attachments-file">
                                                                                            <i class="fas fa-times-circle pe-0"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                                @if ($errors->has('attachments'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('attachments') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>


                                                                        <div
                                                                            class="col-md-6">
                                                                            <div
                                                                                class="fv-row mb-3">
                                                                                <label
                                                                                    class="form-label fw-bolder text-dark">Status</label>
                                                                                <select
                                                                                    class=" form-control form-control-sm form-control-solid"
                                                                                    name="status"
                                                                                    aria-label="Default select example">
                                                                                    <option
                                                                                        value="1" {{ old('status', $meeting->status ?? '1') == '1' ? 'selected' : '' }}>
                                                                                        Active
                                                                                    </option>
                                                                                    <option
                                                                                        value="0" {{ old('status', $meeting->status ?? '') == '0' ? 'selected' : '' }}>
                                                                                        Inactive
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                        <div
                                                                            class="col-md-2">
                                                                            <div
                                                                                class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                                                <input
                                                                                    class="form-check-input form-check-sm"
                                                                                    type="checkbox"
                                                                                    name="send_email"
                                                                                    id="sendEmail"
                                                                                    value="1" {{ old('send_email', $meeting->send_email) ? 'checked' : '' }}>
                                                                                <label
                                                                                    class="form-check-label fw-bolder text-dark"
                                                                                    for="sendEmail">
                                                                                    Send
                                                                                    Email
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="col-md-2">
                                                                            <div
                                                                                class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                                                <input
                                                                                    class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="send_sms"
                                                                                    id="sendSMS"
                                                                                    value="1" {{ old('send_sms', $meeting->send_sms) ? 'checked' : '' }}>
                                                                                <label
                                                                                    class="form-check-label fw-bolder text-dark"
                                                                                    for="sendSMS">
                                                                                    Send SMS
                                                                                </label>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                    <!--End Row-->
                                                                    <div
                                                                        class="card-footer d-flex justify-content-end py-6 px-9">
                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-primary"
                                                                            id="">
                                                                            Save Changes
                                                                        </button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end::Tables Widget 9-->

                                                <!-- </div> -->
                                                <!--end::Timeline items-->
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Body-->
                                        <!--begin::Footer-->

                                        <!--end::Footer-->
                                    </div>
                                </div>

                                <!--begin::Meeting activities drawer-->
                                <div id="kt_activities_3_{{ $meeting->id }}" class="bg-body"
                                        data-kt-drawer="true" data-kt-drawer-name="activities"
                                        data-kt-drawer-activate="true"
                                        data-kt-drawer-overlay="true"
                                        data-kt-drawer-width="{default:'300px', 'lg': '50%'}"
                                        data-kt-drawer-direction="end"
                                        data-kt-drawer-toggle="#show_meeting_{{ $meeting->id }}"
                                        data-kt-drawer-close="#kt_activities_close">
                                    <div class="card shadow-none rounded-0 w-100">
                                        <!--begin::Header-->
                                        <div class="card-header" id="kt_activities_header">
                                            <h3 class="card-title fw-bolder text-dark">
                                                Meeting Details</h3>
                                            <div class="card-toolbar">
                                                <button type="button"
                                                        class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                                                        id="kt_activities_close">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                    height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)"
                                                    fill="black"/>
                                            <rect x="7.41422" y="6" width="16" height="2"
                                                    rx="1" transform="rotate(45 7.41422 6)"
                                                    fill="black"/>
                                        </svg>
                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body position-relative"
                                                id="kt_activities_body">
                                            <!--begin::Content-->
                                            <div id="kt_activities_scroll"
                                                    class="position-relative scroll-y me-n5 pe-5"
                                                    data-kt-scroll="false"
                                                    data-kt-scroll-height="auto"
                                                    data-kt-scroll-wrappers="#kt_activities_body"
                                                    data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                                                    data-kt-scroll-offset="5px">
                                                <!--begin::Timeline items-->
                                                <!-- <div class="timeline"> -->

                                                <!--begin::Tables Widget 9-->
                                                <div class="card mb-5 mb-xl-8">
                                                    <!--begin::Header-->

                                                    <!--end::Header-->
                                                    <div
                                                        style="border:1px solid #ddd;padding:20px">
                                                        <div class="row">
                                                            <div class="col-md-12 mx-auto">

                                                                <div class="card-body p-1">

                                                                    <!-- Show Lead Information if lead_id exists -->
                                                                    @if($lead)
                                                                        <div
                                                                            class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                            <span
                                                                                class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead</span>
                                                                            <span>{{ $lead->first_name . ' ' . $lead->last_name . ' <' . $lead->email . '>' }}</span>
                                                                        </div>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <span
                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Subject</span>
                                                                        <span>{{ $meeting->meeting_subject }}</span>
                                                                    </div>

                                                                    @php
                                                                        date_default_timezone_set('Asia/Dhaka');
                                                                        //assuming the $meeting->meeting_date is a datetime string
                                                                        $meetingDate = Carbon::parse($meeting->meeting_date); // Parse date with Carbon
                                                                        // Format pieces of the date and time
                                                                        $dayOfWeek = $meetingDate->format('l'); // full day name (example., Thursday)
                                                                        $day = $meetingDate->format('d'); // numeric day (example., 12)
                                                                        $monthYear = $meetingDate->format('F Y'); // full month and year (example., September 2024)
                                                                        $time = $meetingDate->format('g:i A'); // time with AM/PM (example., 2:00 PM)
                                                                        $timezone = $meetingDate->timezoneName; // timezone (example., Asia/Dhaka)
                                                                    @endphp

                                                                    <div
                                                                        class="position-relative d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <!-- <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Date</span> -->
                                                                        <span>
                                                        <div
                                                            class="calendar-block position-relative">
                                                            <div class="calendar-left">
                                                                <!-- Display the day of the week -->
                                                                <div
                                                                    class="calendar-header">{{ $dayOfWeek }}</div>
                                                                <!-- Display the numeric day -->
                                                                <div
                                                                    class="calendar-date">{{ $day }}</div>
                                                                <!-- Display the month and year -->
                                                                <div
                                                                    class="calendar-footer">
                                                                    <div
                                                                        class="calendar-month-year">{{ $monthYear }}</div>
                                                                    <div
                                                                        class="calendar-time-block">
                                                                        <!-- Display the time -->
                                                                        <div
                                                                            class="calendar-time">{{ $time }}</div>
                                                                        <!-- Display the timezone dynamically -->
                                                                        <div
                                                                            class="calendar-timezone">({{ $timezone }})</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>

                                                                        <!-- Event details placed behind the calendar using z-index -->
                                                                        <span
                                                                            class="event-details-block">
                                                        <div class="event-details">
                                                            <h3>Details of the event</h3>
                                                            <ul>
                                                                <li><strong>Description:</strong>{{ $meeting->meeting_description }}</li>
                                                                <li>
                                                                    Please attend the meeting on time.<br><strong>How to Join:</strong> <a
                                                                        href="{{ $meeting->meeting_link }}">{{ $meeting->meeting_link }}</a></li>
                                                                <li><strong>Duration:</strong> {{ $meeting->duration }}</li>
                                                            </ul>
                                                        </div>
                                                    </span>
                                                                    </div>


                                                                    @if($meeting->attachments)
                                                                        <div
                                                                            class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                            <span
                                                                                class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Attachments</span>
                                                                            <span> <a
                                                                                    href="{{ asset('uploads/meetings/' . $meeting->attachments) }}"
                                                                                    target="_blank">
                                                            <i class="fas fa-paperclip me-1"></i>Attachment
                                                        </a></span>
                                                                        </div>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <span
                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Status</span>
                                                                        @if ($meeting->status === 1)
                                                                            <span>Active</span>
                                                                        @elseif ($meeting->status === 0)
                                                                            <span>Inactive</span>
                                                                        @endif
                                                                    </div>

                                                                    <div
                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <span
                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Created By</span>
                                                                        <span>{{ $meeting->user->username ?? 'N/A' }}</span>
                                                                    </div>

                                                                    <div
                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <span
                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Rating</span>
                                                                        <span>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                @if($i <=$meeting->rating)
                                                                                    <i class="fa fa-star text-warning"></i>
                                                                                    <!-- yellow star ratings -->
                                                                                @else
                                                                                    <i class="fa fa-star text-muted"></i>
                                                                                    <!-- grey star remaining -->
                                                                                @endif
                                                                            @endfor
                                                    </span>
                                                                    </div>

                                                                    <div
                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <span
                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Feedback</span>
                                                                        <span>{{ $meeting->meeting_feedback }}</span>
                                                                    </div>

                                                                    <div
                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <span
                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send Email</span>
                                                                        @if ($meeting->send_email === 1)
                                                                            <span>Yes</span>
                                                                        @elseif ($meeting->send_email === 0 || $meeting->send_email === null)
                                                                            <span>No</span>
                                                                        @endif
                                                                    </div>

                                                                    <div
                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                        <span
                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send SMS</span>
                                                                        @if ($meeting->send_sms === 1)
                                                                            <span>Yes</span>
                                                                        @elseif ($meeting->send_sms === 0 || $meeting->send_sms === null)
                                                                            <span>No</span>
                                                                        @endif
                                                                    </div>


                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end::Tables Widget 9-->

                                                <!-- </div> -->
                                                <!--end::Timeline items-->
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Body-->
                                        <!--begin::Footer-->

                                        <!--end::Footer-->
                                    </div>
                                </div>

                                        {{--
                                        <form action="{{ route('meeting-destroy', $meeting->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="return confirmDelete()">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
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