@extends('layout')

@section('header')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                        Tambah Kategori Pengeluaran
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="/{{ $page }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke List Kategori Pengeluaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">Kategori Pengeluaran</div>
    <div class="card-body">

        <form method="POST" action="/kategoripengeluaran">
            @csrf

            @foreach ($fields as $field)
            <div class="row gx-3 mb-3">
                <div class="col-md-8">
                    <label class="small mb-1" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                    <input class="form-control @error($field['name']) is-invalid @enderror" id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="{{ $field['type'] }}" placeholder="Masukkan {{ $field['label'] }}" />
                    @error($field['name'])
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            @endforeach


            <button class="btn btn-primary" type="submit">Tambah Kategori Pengeluaran</button>
        </form>
    </div>
</div>
@endsection