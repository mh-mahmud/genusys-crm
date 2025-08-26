  <div class="modal-content">

                    {{-- Loop through tables --}}
                    @foreach($tableData as $tbl => $data)
                        <div class="card card-xxl-stretch mt-4">
                            <div class="card-header bg-light bd-cyan">
                                <div class="card-title m-0">
                                    <h3 class="fw-bolder m-0">{{ ucwords(str_replace('_', ' ', $tbl)) }}</h3>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="g-lead-details-area mb-5">
                                    @foreach($data['columns'] as $column)
                                        @if(!in_array($column, ['lead_id', 'form_id', 'created_at', 'updated_at']))
                                            @php
                                                $value = $data['existingData']->$column ?? '';
                                            @endphp

                                            <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                                <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">
                                                    {{ ucwords(str_replace('_', ' ', $column)) }}
                                                </span>
                                                <span>
                                                    @if($value === '' || $value === null)
                                                        <em class="text-muted"></em>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

            <!-- Modal Footer -->
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->

        </div>