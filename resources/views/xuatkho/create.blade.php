@extends('default')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Xuất kho</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('nhap-kho.index') }}">Quản lý xuất
                                                kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Xuất kho</li>
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
                                                            <div class="form-group">
                                                                <label for="ma_phieu_xuat" class="form-label">Mã phiếu xuất</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" minlength="1" maxlength="255" class="form-control" name="ma_phieu_xuat"
                                                                        value="{{ $ma_phieu_xuat }}" disabled>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('ma_phieu_xuat') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ngay_xuat" class="form-label">Ngày xuất</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="date" class="form-control" name="ngay_xuat" value="{{ old('ngay_xuat') }}"
                                                                        required>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('ngay_xuat') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"> <label for="khach_hang" class="form-label">Khách hàng</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="khach_hang" placeholder="Nhập khách hàng"
                                                                        value="{{ old('khach_hang') }}" required>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('khach_hang') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"> <label for="dia_chi" class="form-label">Địa chỉ</label>
                                                                <div class="form-control-wrap"> <input type="text" class="form-control" name="dia_chi"
                                                                        placeholder="Nhập địa chỉ" value="{{ old('dia_chi') }}" required>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('dia_chi') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" id="quill_editor" value="{!! old('mo_ta') !!}" data-toolbar="minimal"
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
                                            <ul class="d-flex justify-content-end gap g-3">
                                                <li>
                                                    <button id="btn-submit" type="submit" class="btn btn-primary d-md-inline-flex">
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Xác nhận</span>
                                                    </button>
                                                </li>
                                                <li style="margin-left: 10px">
                                                    <button id="btn-export" type="submit" class="btn btn-primary d-md-inline-flex">
                                                        <em class="icon ni ni-file-download"></em>
                                                        <span>Export</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group my-5">
                                <label for="searchInput" class="form-label w-full">Tìm kiếm</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-icon start">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <input type="text" class="form-control" name="searchInput" id="searchInput" placeholder="Input text placeholder">
                                </div>
                            </div>
                            <div class="card" id="hang-hoa-container">
                                <table class="table" data-nk-container="table-responsive">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="tb-col"><span class="overline-title">Mã hàng hóa</span></th>
                                            <th class="tb-col"><span class="overline-title">Tên hàng hóa</span></th>
                                            <th class="tb-col"><span class="overline-title">ĐVT</span></th>
                                            <th class="tb-col"><span class="overline-title">Tồn kho</span></th>
                                            <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                            <th class="tb-col"><span class="overline-title">Đơn giá</span></th>
                                            <th class="tb-col"><span class="overline-title">Thành tiền</span></th>
                                            <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast fade hide alert" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            const formCreate = document.getElementById('form-create')
            const inNum = document.querySelectorAll('input[type="number"]');
            const quill = new Quill('#quill_editor', {
                theme: 'snow'
            });
            let selectedValues = []

            inNum.forEach(e => {
                e.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    } else if (this.value > parseInt(e.getAttribute('max'))) {
                        this.value = parseInt(e.getAttribute('max'));
                    }
                });
            });

            $('#searchInput').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('api.xuat-kho.search') }}",
                        data: {
                            searchInput: request.term, // dữ liệu nhập vào
                            selectedValues: selectedValues
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            response(
                                $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        so_luong: item.so_luong,
                                        gia_nhap: item.gia_nhap,
                                        ngay_san_xuat: item.ngay_san_xuat,
                                        tg_bao_quan: item.tg_bao_quan,
                                        ma_hang_hoa: item.get_hang_hoa.ma_hang_hoa,
                                        ten_hang_hoa: item.get_hang_hoa.ten_hang_hoa,
                                        don_vi_tinh: item.get_hang_hoa.don_vi_tinh,
                                        hang_hoa: item
                                    }
                                })
                            );
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    let hang_hoa = ui.item.hang_hoa
                    selectedValues.push(hang_hoa.id)

                    const htmls = `<tr>
                                    <input type="hidden" class="hang-hoa" value="${hang_hoa.id}">
                                    <td class="tb-col"><span>${hang_hoa.ma_hang_hoa}</span></td>
                                    <td class="tb-col"><span>${hang_hoa.get_hang_hoa.ten_hang_hoa}</span></td>
                                    <td class="tb-col"><span>${hang_hoa.get_hang_hoa.don_vi_tinh}</span></td>
                                    <td class="tb-col"><span>${hang_hoa.so_luong}</span></td>
                                    <td class="tb-col"><input style="width:100%;" type="number" min="0" max="${hang_hoa.so_luong}" class="so-luong"></td>
                                    <td class="tb-col"><input style="width:80%" type="number" min="0" class="gia">  VNĐ</td>
                                    <td class="tb-col"><span class="thanh-tien"> 0 VNĐ</span></td>
                                    <td class="tb-col tb-col-end"><button type="button" class="btn-delete btn btn-danger">Xóa</button></td>
                                </tr>`

                    const $htmls = $(htmls);
                    const $soLuong = $htmls.find('.so-luong');
                    const $gia = $htmls.find('.gia');
                    const $thanhTien = $htmls.find('.thanh-tien');
                    const btnXoa = $htmls.find('.btn-delete');

                    btnXoa.on('click', function() {
                        const $row = $(this).closest('tr');
                        $row.remove();
                        selectedValues = selectedValues.filter(function(id) {
                            return id !== hang_hoa.id;
                        });
                    });

                    $soLuong.on('input', function() {
                        if (this.value <= 0) {
                            this.value = '';
                        } else if (this.value > parseInt($soLuong.attr('max'))) {
                            this.value = parseInt($soLuong.attr('max'));
                        }
                    });

                    $soLuong.on('keyup', function() {
                        if ($soLuong.val() > 0 && $gia.val() > 0) {
                            let tongTien = $soLuong.val() * $gia.val();
                            $thanhTien.html(
                                `<span>${new Intl.NumberFormat('vi-VN', { maximumSignificantDigits: 3 }).format(tongTien)} VNĐ</span>`
                            );
                        } else {
                            $thanhTien.html(`<span>0 VNĐ</span>`);
                        }
                    });

                    $gia.on('keyup', function() {
                        if ($soLuong.val() > 0 && $gia.val() > 0) {
                            let tongTien = $soLuong.val() * $gia.val();
                            $thanhTien.html(
                                `<span>${new Intl.NumberFormat('vi-VN', { maximumSignificantDigits: 3 }).format(tongTien)} VNĐ</span>`
                            );
                        } else {
                            $thanhTien.html(`<span>0 VNĐ</span>`);
                        }
                    });

                    $('tbody').append($htmls)
                }
            }).autocomplete("instance")._renderItem = function(ul, item) {
                return $("<li>")
                    .append(`
                            <div>
                                MHH: ${item.ten_hang_hoa} - Tên: ${item.ma_hang_hoa} - SL: ${item.so_luong} - Giá: ${item.gia_nhap}
                                - NSX: ${item.ngay_san_xuat} - TGBQ: ${item.tg_bao_quan}
                            </div>
                        `)
                    .appendTo(ul);
            };

            const btnSubmit = document.getElementById('btn-submit')
            const btnExport = document.getElementById('btn-export')
            let apiUrl = ''

            btnSubmit.onclick = function() {
                apiUrl = '{{ route('api.xuat-kho.store') }}'
            }

            btnExport.onclick = function() {
                apiUrl = '{{ route('xuat-kho.export') }}'
            }


            formCreate.onsubmit = function(e) {
                e.preventDefault()
                const ma_phieu_xuat = $('input[name="ma_phieu_xuat"]').val()
                const ngay_xuat = $('input[name="ngay_xuat"]').val()
                const khach_hang = $('input[name="khach_hang"]').val()
                const dia_chi = $('input[name="dia_chi"]').val()
                const mo_ta = quill.getContents().ops[0].insert
                const id_user = {{ auth()->user()->id }}
                console.log(mo_ta);

                let data = [{
                    ma_phieu_xuat: ma_phieu_xuat,
                    ngay_xuat: ngay_xuat,
                    khach_hang: khach_hang,
                    dia_chi: dia_chi,
                    mo_ta: mo_ta === "\n" ? '' : mo_ta,
                    id_user: id_user
                }]

                $('tbody tr').each(function() {
                    const item = {
                        id_chi_tiet_hang_hoa: $(this).find('.hang-hoa').val(),
                        so_luong: $(this).find('.so-luong').val(),
                        gia_xuat: $(this).find('.gia').val()
                    }
                    data.push(item);
                });

                const token = '{{ csrf_token() }}'

                $.ajax({
                    type: 'POST',
                    url: apiUrl,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        if (response.type === 'success') {
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                            });
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 3000);
                        } else if (response.type === 'export') {
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#fc0303',
                                confirmButtonText: 'OK',
                                cancelButtonText: 'Đóng'
                            }).then((result) => {
                                if (result.value) {
                                    let downloadLink = document.createElement("a");
                                    downloadLink.href = response.downloadUrl;
                                    document.body.appendChild(downloadLink);
                                    downloadLink.click();
                                    document.body.removeChild(downloadLink);
                                }
                            }).catch((error) => {
                                console.log(error);
                            });
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        var errorText = '';

                        $.each(errors, function(index, error) {
                            $.each(error, function(key, value) {
                                errorText += value + "\n";
                            })
                        })

                        alert(errorText);
                    }
                });

                return true
            }
        });
    </script>
@endsection
