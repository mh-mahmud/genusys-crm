@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Add New Record to {{ ucwords(str_replace('_', ' ', $tableName)) }}</h2>
    <form action="{{ route('store-tabledata') }}" method="POST">
        @csrf
        <input type="hidden" name="tableName" value="{{ $tableName }}">
        <input type="hidden" name="form_id" value="{{ $leads->form_id }}">
        <input type="hidden" name="lead_id" value="{{ $leads->id }}">
        
        @foreach ($filteredColumns as $column)
            @if (!in_array($column, ['lead_id', 'form_id']))
                <div class="form-group">
                    <label for="{{ $column }}">{{ ucwords(str_replace('_', ' ', $column)) }}</label>
                    @php
                        $inputType = 'text'; // Default input type
                        if (isset($columnTypes[$column])) {
                            $type = strtolower($columnTypes[$column]);
                            if (strpos($type, 'int') !== false || strpos($type, 'numeric') !== false) {
                                $inputType = 'number';
                            } elseif (strpos($type, 'date') !== false) {
                                $inputType = 'date';
                            } elseif (strpos($type, 'email') !== false) {
                                $inputType = 'email';
                            } elseif (strpos($type, 'text') !== false || strpos($type, 'blob') !== false) {
                                $inputType = 'textarea';
                            } // Add more conditions based on your column types
                        }
                    @endphp
                    @if ($inputType === 'textarea')
                        <textarea class="form-control" id="{{ $column }}" name="{{ $column }}"></textarea>
                    @elseif($inputType === 'date')
                        <input type="{{ $inputType }}" class="form-control form-control-sm form-control-solid" id="common_dob" name="{{ $column }}">
                    @else
                        <input type="{{ $inputType }}" class="form-control" id="{{ $column }}" name="{{ $column }}">
                    @endif
                </div>
            @endif
        @endforeach
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
@endsection

