<div class="tab-pane fade show @if (session('success') || session('error')) active @endif" id="g_lead_table" role="tabpanel"
    aria-labelledby="g_lead_table_tab">
    <div class="card">
        <div class="card-body">
            <div class="row mb-1">
                @foreach ($tableData as $tableName => $data)
                    <!-- @if (!empty($data))-->
                    @php
                        $field = $fields->firstWhere('table_name', $tableName);
                        $viewType = $field->view_type ?? 'table_view'; // Default to table_view if view_type is not set

                        //Initialize arrays to store column sizes and form data
                        //Iterate over all rows to collect column information
                        $columnSizes = [];
                        $formData = [];

                    @endphp
                    @if ($viewType === 'form_view')
                        @foreach ($data as $row)
                            @foreach ($row as $key => $value)
                                @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_at', 'updated_at']))
                                    @php
                                        $field = $fields->where('field_name', $key)->first();
                                        $formSize = $field->form_size ?? 'col-md-6';
                                        $isFile = $field && $field->field_value === 'file';

                                        //Map the column size to the corresponding mb- class
                                        $columnSize = '';
                                        switch ($formSize) {
                                            case 'col-md-3':
                                                $columnSize = '1';
                                                break;
                                            case 'col-md-6':
                                                $columnSize = '2';
                                                break;
                                            case 'col-md-9':
                                                $columnSize = '3';
                                                break;
                                            case 'col-md-12':
                                            default:
                                                $columnSize = '4';
                                                break;
                                        }

                                        // Store column sizes and form data
                                        if (!isset($columnSizes[$formSize])) {
                                            $columnSizes[$formSize] = $formSize;
                                        }

                                        if (!isset($formData[$formSize])) {
                                            $formData[$formSize] = [];
                                        }

                                        $formData[$formSize][] = [
                                            'key' => $key,
                                            'value' => $value,
                                            'isFile' => $isFile,
                                        ];
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach
                        @foreach ($columnSizes as $formSize)
                            <div class="{{ $formSize }}">
                                <div class="fs-3 {{ $formSize }}"
                                    style="width:100%;border:1px solid #DDD;padding:7px;margin-bottom:10px;margin-top:30px;background-color:#54B4D3;">
                                    {{ ucwords(str_replace('_', ' ', $tableName)) }}

                                    <a href="{{ route('lead-edit-tabledata', ['tableName' => $tableName, 'leadId' => $row->id]) }}"
                                        class="btn btn-icon btn-sm btn-success">
                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3"
                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                    fill="black" />
                                                <path
                                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </div>
                                <div class="g-lead-details mb-5" style="columns: {{ $columnSize }}">
                                    @foreach ($formData[$formSize] as $dataItem)
                                        <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                            <span
                                                class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">{{ ucwords(str_replace('_', ' ', $dataItem['key'])) }}</span>
                                            @if ($dataItem['isFile'])
                                                @if (!empty($dataItem['value']))
                                                    <span><a href="{{ url('uploads/files/' . $dataItem['value']) }}"
                                                            download>Download</a></span>
                                                @else
                                                    <span></span>
                                                @endif
                                            @else
                                                <span>{{ $dataItem['value'] }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endif
                @endforeach
            </div>

            {{-- Display table_view after form_view --}}
            @foreach ($tableData as $tableName => $data)
                @if (!empty($data) && !in_array($tableName, $notShowTable))
                    @php
                        $field = $fields->firstWhere('table_name', $tableName);
                        $viewType = $field->view_type ?? 'table_view'; // Default to table_view if view_type is not set
                    @endphp

                    @if ($viewType === 'table_view')
                        <div class="mb-10 bg-light p-5 rounded-3">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <strong class="fs-5">{{ ucwords(str_replace('_', ' ', $tableName)) }}</strong>
                                <button type="button" class="btn btn-success btn-sm"
                                    onclick="window.location='{{ route('leads-add', ['tableName' => $tableName, 'leadId' => $lead->id]) }}'">
                                    <i class="bi bi-plus-lg"></i>
                                    Add New
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table
                                    class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                            @if ($data->isNotEmpty() && $data->first() !== null)
                                                <th class="ps-4 min-w-50px">SL</th>
                                                <!-- @foreach ($data->first() as $key => $value)
                                                    @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_by', 'created_at', 'updated_at']))
                                                    <th c   lass="ps-4 min-w-150px">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                    @endif
                                                @endforeach -->
                                                @php $count = 0; @endphp
                                                @foreach ($data->first() as $key => $value)
                                                    @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_by', 'created_at', 'updated_at']))
                                                        @php $count++; @endphp
                                                        @if ($count > 5)
                                                            @break
                                                        @endif
                                                        <th class="ps-4 min-w-150px">
                                                            {{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                    @endif
                                                @endforeach

                                                <th class="ps-4 min-w-150px">Created By</th>
                                                <th class="min-w-50px text-end pe-4">Action</th>
                                            @else
                                                <th class="ps-4 min-w-150px">&nbsp;</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data->isNotEmpty())
                                            @foreach ($data as $index => $row)
                                                @php
                                                    $i = 1;
                                                @endphp
                                                <tr>
                                                    <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                                    @php $i = 0; @endphp
                                                    @foreach ($row as $key => $value)
                                                        @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_by', 'created_at', 'updated_at']))
                                                            @php
                                                                //if($i==70) {
                                                                //continue;
                                                                //}
                                                                $i++;
                                                                if ($i > 5) {
                                                                    break;
                                                                }
                                                                $field = $fields->where('field_name', $key)->first();
                                                                $isFile = $field && $field->field_value === 'file';
                                                                $isDate = $field && $field->field_value === 'date';
                                                                //$i++;
                                                            @endphp

                                                            @if ($isFile)
                                                                <td class="ps-5 text-dark fs-6">
                                                                    @if (!empty($value))
                                                                        <a href="{{ url('uploads/files/' . $value) }}"
                                                                            download>Download</a>
                                                                    @else
                                                                        <span></span>
                                                                    @endif
                                                                </td>
                                                            @elseif ($isDate)
                                                                <td class="ps-5 text-dark fs-6">
                                                                    {{ !empty($value) ? $value : ' ' }}
                                                                </td>
                                                            @else
                                                                <td class="ps-5 text-dark fs-6">{{ $value }}
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    <td class="ps-5 text-dark fs-6">{{ $row->created_by }}</td>
                                                    <td class="d-flex align-items-center justify-content-end gap-1">

                                                        <a href="{{ route('lead-show-table-details', ['tableName' => $tableName, 'leadId' => $row->id]) }}"
                                                            class="btn btn-icon btn-sm btn-success btn-show-details">

                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24"
                                                                            height="24" />
                                                                        <path
                                                                            d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                            fill="black" fill-rule="nonzero"
                                                                            opacity="0.7" />
                                                                        <path
                                                                            d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                            fill="black" opacity="0.7" />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </a>
                                                        <a href="{{ route('lead-edit-tabledata', ['tableName' => $tableName, 'leadId' => $row->id]) }}"
                                                            class="btn btn-icon btn-sm btn-success">
                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3"
                                                                        d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                        fill="black" />
                                                                    <path
                                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </a>
                                                        <form
                                                            action="{{ route('delete-tabledata', ['tableName' => $tableName, 'id' => $row->id, 'leadId' => $lead->id]) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-icon btn-sm px-3 py-2">
                                                                <i class="bi bi-x p-0"></i>
                                                            </button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%" class="text-center">No data
                                                    available
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                @endif
            @endforeach

            <!-- add api data -->
            <div class="mb-10 bg-light p-5 rounded-3">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <strong class="fs-5">Rate Analysis Data</strong>
                </div>
                <div class="table-responsive">
                    <table
                        class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                        <thead>
                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                <th class="ps-4 min-w-50px">SL</th>
                                <th class="ps-4 min-w-150px">Company Name</th>
                                <th class="ps-4 min-w-150px">Term</th>
                                <th class="ps-4 min-w-150px">Down Payment</th>
                                <th class="ps-4 min-w-150px">Payment Amount</th>
                                <th class="ps-4 min-w-150px">Total Premium</th>
                                <th class="ps-4 min-w-150px">Purchased</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($rate_api_data))
                                @foreach ($rate_api_data as $index => $row)
                                    <tr>
                                        <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                        <td class="ps-4 text-dark fs-6">{{ $row->CompanyName }}</td>
                                        <td class="ps-4 text-dark fs-6">{{ $row->Term }}</td>
                                        <td class="ps-4 text-dark fs-6">{{ $row->DownPayment }}</td>
                                        <td class="ps-4 text-dark fs-6">{{ $row->PaymentAmount }}</td>
                                        <td class="ps-4 text-dark fs-6">{{ $row->TotalPremium }}</td>
                                        <td class="ps-4 text-dark fs-6">{{ $row->Purchased == true ? 'Yes' : 'No' }}
                                        </td>
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
        </div>
    </div>
</div>
