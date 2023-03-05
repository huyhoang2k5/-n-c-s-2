@extends('default')
@section('content')

    <form action="{{ route('nhap-kho.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Excel file:</label>
            <input type="text" name="ma_phieu_nhap">
            <input type="file" name="excel_file" id="file">
        </div>
        <button type="submit" class="btn btn-primary">Import</button>

    </form>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

{{-- @section('script')
<script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
<script>
    const quill = new Quill('#quill_editor', {
        theme: 'snow'
    });

    const form = document.querySelector('#form-create');
    form.onsubmit = function(e) {
        const mo_ta = document.querySelector('input[name=mo_ta]');
        mo_ta.value = JSON.stringify(quill.getContents());

        return true;
    };
</script>
@endsection --}}
