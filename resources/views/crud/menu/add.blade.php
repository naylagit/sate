@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Tambah {{ Str::ucfirst($page) }}
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
    <div class="card mb-4">
        <div class="card-header">Data {{ Str::ucfirst($page) }}</div>
        <div class="card-body">
            <form method="POST" action="{{ url('/menu') }}">
                @csrf

                @foreach ($fields as $field)
                    @if ($field['type'] != 'select')
                        <div class="row gx-3 mb-3">
                            <div class="col-md-8">
                                <label class="small mb-1" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                <input class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                    type="{{ $field['type'] }}" placeholder="Masukkan {{ $field['label'] }}" />
                            </div>
                        </div>
                    @elseif($field['name'] == 'kategori_id')
                        <div class="row mb-3 gx-3">
                            <div class="col-md-8">
                                <label class="small mb-1">{{ $field['label'] }}</label>
                                <select class="form-select" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                    aria-label="Default select example">
                                    <option selected disabled>Pilih {{ $field['label'] }}:</option>
                                    @foreach ($field['options'] as $key => $option)
                                        <option value="{{ $key }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @elseif($field['name'] == 'status')
                        <div class="row mb-3 gx-3">
                            <div class="col-md-8">
                                <label class="small mb-1">{{ $field['label'] }}</label>
                                <select class="form-select" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                    aria-label="Default select example">
                                    <option selected disabled>Pilih {{ $field['label'] }}:</option>
                                    @foreach ($field['options'] as $key => $option)
                                        <option value="{{ $key }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                @endforeach

                <button class="btn btn-primary" type="submit">Tambah {{ Str::ucfirst($page) }}</button>
            </form>
        </div>
    </div>
@endsection
