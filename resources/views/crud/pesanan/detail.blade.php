@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Detail {{ Str::ucfirst($page) }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="/{{ $page }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali ke List {{ Str::ucfirst($page) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header">Data {{ Str::ucfirst($page) }}</div>

                <div class="card-body">

                    <div class="row  mb-3">
                        <div class="col-md-12">
                            <label class="small mb-1" for="nama_user">Kasir</label>
                            <input class="form-control" id="nama_user" name="nama_user" type="text" placeholder=" harga"
                                value={{ $data['nama'] }} readonly />
                        </div>
                    </div>

                    <div class="row  mb-3">
                        <div class="col-md-12">
                            <label class="small mb-1" for="nama_user">Tanggal</label>
                            <input class="form-control" id="nama_user" name="nama_user" type="text" placeholder=" harga"
                                value={{ $data['created_at'] }} readonly />
                        </div>
                    </div>

                </div>
            </div>

            <div class="card mb-4">


                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>QTY</th>
                                <th>Subtotal</th>
                                <th>Ket</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($pesananMenu as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->menu->nama }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->subtotal }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-6">
            <div class="card mb-4">

                <div class="card-body">

                    <form method="POST" action="/pesanan" id="mainForm">
                        @csrf

                        <div class="row mb-3 gx-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Jenis Pesanan</label>
                                <select class="form-select" id="jenis" name="jenis"
                                    aria-label="Default select example" disabled>
                                    <option selected disabled>Pilih Jenis Pesanan:</option>
                                    <option value="1" @if ($data['jenis'] == 1) selected @endif>
                                        Dine In
                                    </option>
                                    <option value="2" @if ($data['jenis'] == 2) selected @endif>
                                        Take Out
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1"> Meja</label>
                                <select class="form-select" id="meja_id" name="meja_id"
                                    aria-label="Default select example" disabled>
                                    <option selected disabled> Meja:</option>

                                    @foreach ($meja as $item)
                                        <option value="{{ $item['id'] }}"
                                            @if ($data['meja_id'] == $item['id']) selected @endif>
                                            {{ $item['nama'] }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>








                    </form>
                </div>
            </div>
            <div class="card mb-4">

                <div class="card-body">

                    <form method="POST" action="/pesanan" id="mainForm">
                        @csrf





                        <div class="row  mb-3">
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="total">Total</label>
                                <input class="form-control" id="total" name="total" type="text"
                                    placeholder=" Total" value={{ $data['total'] }} readonly />
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1">Pilih Metode Pembayaran</label>
                                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran"
                                    aria-label="Default select example" disabled>
                                    <option selected disabled>Pilih Metode Pembayaran:</option>
                                    <option value="cash" @if ($data['metode_pembayaran'] == 'cash') selected @endif>
                                        Cash
                                    </option>
                                    <option value="qris" @if ($data['metode_pembayaran'] == 'qris') selected @endif>
                                        Qris
                                    </option>


                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="total">Dibayarkan</label>
                                <input class="form-control" id="dibayarkan" name="dibayarkan" type="text"
                                    placeholder=" dibayarkan" value={{ $data['dibayarkan'] }} readonly />

                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="total">Kembalian</label>
                                <input class="form-control" id="kembalian" name="kembalian" type="text"
                                    placeholder=" kembalian" value={{ $data['kembalian'] }} readonly />

                            </div>

                        </div>





                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
