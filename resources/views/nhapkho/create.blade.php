@extends('default')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Nhập kho</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('nhap-kho.index') }}">Quản lý nhập
                                                kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Nhập kho</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <form action="#" method="POST" id="form-create">
                            @csrf
                            <div class="row g-gs">
                                <div class="col-xxl-12">
                                    <div class="gap gy-4">
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <div class="card-body">
                                                    <div class="row g-gs">
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label for="ma_phieu_nhap"
                                                                    class="form-label">Mã phiếu nhập</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" minlength="1" maxlength="255"
                                                                        class="form-control" id="ma_phieu_nhap"
                                                                        value="#{{ $ma_phieu_nhap }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"> <label for="ngay_nhap"
                                                                    class="form-label">Ngày nhập kho</label>
                                                                <div class="form-control-wrap"> <input
                                                                        placeholder="yyyy/mm/dd" type="date"
                                                                        class="form-control" name="ngay_nhap"
                                                                        value="{{ old('ngay_nhap') }}" id="ngay_nhap"
                                                                        required> </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" id="quill_editor"
                                                                        value="{!! old('mo_ta') !!}"
                                                                        data-toolbar="minimal"
                                                                        data-placeholder="Viết chi tiết sản phẩm vào đây...">
                                                                    </div>
                                                                    <input type="hidden" name="mo_ta">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <table id="item-table" class="table" data-nk-container="table-responsive">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="tb-col"><span class="overline-title">Mã hàng
                                                                    hóa</span></th>
                                                            <th class="tb-col"><span class="overline-title">Mã nhà cung
                                                                    cấp</span></th>
                                                            <th class="tb-col"><span class="overline-title">Số lượng</span>
                                                            </th>
                                                            <th class="tb-col"><span class="overline-title">Giá
                                                                    nhập(vnđ)</span></th>
                                                            <th class="tb-col"><span class="overline-title">Ngày sản
                                                                    xuất</span></th>
                                                            <th class="tb-col"><span class="overline-title">Bảo
                                                                    quản(tháng)</span></th>
                                                            <th class="tb-col tb-col-end"><span
                                                                    class="overline-title">Action</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb-container">
                                                        <tr class="item-row">
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap">
                                                                    {{-- <input type="text" minlength="1" maxlength="255"
                                                                        class="form-control" name="ma_hang_hoa[]"
                                                                        required /> --}}
                                                                    <input list="ma_hang_hoa" name="ma_hang_hoa[]"
                                                                        class="form-control">
                                                                    <datalist id="ma_hang_hoa">
                                                                        @foreach ($hang_hoa as $hang)
                                                                            <option value="{{ $hang->ma_hang_hoa }}"></option>
                                                                        @endforeach
                                                                    </datalist>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input type="text"
                                                                        minlength="1" maxlength="255" class="form-control"
                                                                        name="ma_ncc[]" required />
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input type="number"
                                                                        min="1" max="1000000000"
                                                                        class="form-control" name="so_luong[]" required />
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input type="number"
                                                                        min="1" max="1000000000"
                                                                        class="form-control" name="gia_nhap[]" required />
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input
                                                                        placeholder="dd/mm/yyyy" type="date"
                                                                        class="form-control" name="ngay_san_xuat[]"
                                                                        value="{{ old('ngay_san_xuat[]') }}" required>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input type="number"
                                                                        min="1" max="1000000000"
                                                                        class="form-control" name="tg_bao_quan[]"
                                                                        required /></div>
                                                            </td>
                                                            <td class="tb-col tb-col-end"><button type="button"
                                                                    class="btn btn-danger btn-sm remove-item">Remove</button>
                                                            </td>
                                                        </tr>
                                                        <template id="hang-hoa-template">
                                                            <tr class="item-row">
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input type="text"
                                                                            minlength="1" maxlength="255"
                                                                            class="form-control" name="ma_hang_hoa[]"
                                                                            required /></div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input type="text"
                                                                            minlength="1" maxlength="255"
                                                                            class="form-control" name="ma_ncc[]"
                                                                            required />
                                                                    </div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input type="number"
                                                                            min="1" max="1000000000"
                                                                            class="form-control" name="so_luong[]"
                                                                            required /></div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input type="number"
                                                                            min="1" max="1000000000"
                                                                            class="form-control" name="gia_nhap[]"
                                                                            required /></div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input
                                                                            placeholder="dd/mm/yyyy" type="date"
                                                                            class="form-control" name="ngay_san_xuat[]"
                                                                            value="{{ old('ngay_san_xuat[]') }}" required>
                                                                    </div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input type="number"
                                                                            min="1" max="1000000000"
                                                                            class="form-control" name="tg_bao_quan[]"
                                                                            required /></div>
                                                                </td>
                                                                <td class="tb-col tb-col-end"><button type="button"
                                                                        class="btn btn-danger btn-sm remove-item">Remove</button>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-primary btn-sm" id="add-item">Add
                                                    Item</button>
                                            </div>
                                        </div>
                                        <div class="gap-col">
                                            <ul class="d-flex align-items-center gap g-3">
                                                <li><button type="submit" class="btn btn-primary">Lưu</button></li>
                                                <li><a href="{{ url()->previous() }}" class="btn border-0">Quay
                                                        lại</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="ma_phieu_nhap" value="{{ $ma_phieu_nhap }}" disabled>
                            <input type="hidden" name="data">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.js-select-mhh').select2();
        });


        const addItemBtn = document.getElementById('add-item')
        const container = document.getElementById('tb-container')

        addItemBtn.addEventListener('click', function() {
            const hangHoaTemplate = document.getElementById('hang-hoa-template')
            const hangHoa = hangHoaTemplate.content.cloneNode(true)
            const inputs = hangHoa.querySelectorAll('input')

            inputs.forEach(function(input) {
                input.value = ''
            });

            const delBtn = hangHoa.querySelector('.remove-item')
            delBtn.addEventListener('click', function() {
                delBtn.closest('.item-row').remove()
            })

            container.appendChild(hangHoa);
        });

        const formCreate = document.getElementById('form-create')

        const quill = new Quill('#quill_editor', {
            theme: 'snow'
        });

        formCreate.onsubmit = function(e) {
            e.preventDefault()
            const ma_phieu_nhap = $('input[name="ma_phieu_nhap"]').val()
            const ngay_nhap = $('input[name="ngay_nhap"]').val()
            const mo_ta = quill.getContents().ops[0].insert

            id_user = {{ auth()->user()->id }}

            let data = [{
                ma_phieu_nhap: ma_phieu_nhap,
                ngay_nhap: ngay_nhap,
                mo_ta: mo_ta === "\n" ? '' : mo_ta,
                id_user: id_user
            }]

            $('table tr.item-row').each(function() {
                const item = {
                    ma_hang_hoa: $(this).find('input[name="ma_hang_hoa[]"]').val(),
                    ma_ncc: $(this).find('input[name="ma_ncc[]"]').val(),
                    so_luong: $(this).find('input[name="so_luong[]"]').val(),
                    gia_nhap: $(this).find('input[name="gia_nhap[]"]').val(),
                    ngay_san_xuat: $(this).find('input[name="ngay_san_xuat[]"]').val(),
                    tg_bao_quan: $(this).find('input[name="tg_bao_quan[]"]').val()
                }
                data.push(item);
            });

            console.log(data);

            const token = '{{ csrf_token() }}'
            const apiUrl = '{{ route('api.nhap-kho.store') }}'

            $.ajax({
                type: 'POST',
                url: apiUrl,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                data: JSON.stringify(data),
                success: function(response) {
                    console.log(response);
                    if (response.type === 'success') {
                        window.location.href = response.redirect;
                    } else {
                        // handle error
                    }
                },
                error: function(xhr, status, error) {
                    console.log(status)
                    console.log(error);
                }
            });

            return true
        }
    </script>
@endsection
