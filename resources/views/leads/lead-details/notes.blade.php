<div class="tab-pane fade" id="g_RAKIB_lead_table2" role="tabpanel" aria-labelledby="g_RAKIB_lead_table_tab2">
    <div class="card">
        <div class="card-body">

            <div class="row mb-1">
                <div class="col-md-5" style="border:1px solid #ddd;">
                    <div class="row">
                        <h5 class="mb-2"
                            style="border:1px solid #DDD;padding:7px;background-color:#54B4D3;color:#f7f7f7">Note
                            Section</h5>
                        <form class="g-form w-100" action="{{ route('save-lead-note') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                            <div class="col-md-12">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Write a Note</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea min="10" class="form-control form-control-sm form-control-solid" name="lead_notes" rows="3">{{ old('lead_notes') }}</textarea>
                                    <!--end::Input-->
                                    @if ($errors->has('lead_notes'))
                                        <span class="text-danger">{{ $errors->first('lead_notes') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Result Code</label>
                                    <select class="form-control form-control-sm form-control-solid"
                                        name="result_codes_id">
                                        <option value="" disabled
                                            {{ old('result_codes_id') == '' ? 'selected' : '' }}>Select Code</option>
                                        @foreach ($lead_result_codes as $result_code)
                                            <option value="{{ $result_code->id }}"
                                                {{ old('result_codes_id') == $result_code->id ? 'selected' : '' }}>
                                                {{ $result_code->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('result_codes_id'))
                                        <span class="text-danger">{{ $errors->first('result_codes_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary" id="">Submit</button>
                            </div>
                        </form>

                    </div>


                </div>

                <div class="col-md-7">
                    <div class="mb-10 bg-light p-5 rounded-3">
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <strong class="fs-5">Note Logs</strong>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <thead>
                                    <tr class="fw-bolder text-muted bg-light bd-cyan">
                                        <th class="ps-4 min-w-50px">SL</th>
                                        <th class="ps-4 min-w-150px">Result Code</th>
                                        <th class="ps-4 min-w-150px">Notes</th>
                                        <th class="ps-4 min-w-150px">Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($notelogs))
                                        @foreach ($notelogs as $index => $row)
                                            <tr>
                                                <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                                <td class="ps-4 text-dark fs-6">{{ $row->lead_res_code->title }}</td>
                                                <td class="ps-4 text-dark fs-6">{{ $row->lead_notes }}</td>
                                                <td class="ps-4 text-dark fs-6">{{ $row->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%" class="text-center">No data available
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- action information -->
                    <div class="mb-10 bg-light p-5 rounded-3">

                        <h5 class="mb-3"
                            style="border:1px solid #DDD;padding:7px;background-color:#54B4D3;color:#f7f7f7">Action
                            Information</h5>

                        {{-- <div class="mb-5">
    <h5 class="custom-bottom-border">Dates</h5>
    <table class="custom-table">
            <tr>
                <td>Created</td>
                <td>{{ date("Y-m-d") }}</td>
            </tr>
            <tr>
                <td>Last modified</td>
                <td>Not yet quoted</td>
            </tr>
    </table>
    </div> --}}

                        <div class="mb-9">
                            <h5 class="custom-bottom-border">Producer Info</h5>
                            <form class="g-form w-100" action="{{ route('save-assign-lead') }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                <table class="custom-table">
                                    <tr>
                                        <td>Assigned To</td>
                                        <td>
                                            <select class="form-control form-control-sm form-control-solid"
                                                name="assigned_to">
                                                <option value=""
                                                    {{ old('assigned_to') == '' ? 'selected' : '' }}>-- Select Lead --
                                                </option>
                                                @foreach ($users as $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $lead->assigned_to == $value->id ? 'selected' : '' }}>
                                                        {{ $value->first_name . ' ' . $value->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('assigned_to'))
                                                <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Created by</td>
                                        <td>{{ @$lead->created_name->username }}</td>
                                    </tr>
                                    <tr>
                                        <td>Last modified</td>
                                        <td>{{ @$lead->updated_name->username }}</td>
                                    </tr>
                                    <tr>
                                        <td>Created at</td>
                                        <td>{{ $lead->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Updated at</td>
                                        <td>{{ $lead->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Language</td>
                                        <td>{{ $lead->language }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bound</td>
                                        <td></td>
                                    </tr>
                                    <td>Region</td>
                                    <td>None</td>
                                    </tr>
                                </table>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary" id="">Submit</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>


            </div>


        </div>
    </div>
</div>
