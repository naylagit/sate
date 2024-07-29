@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Verifikasi {{ Str::ucfirst($page) }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary"
                            href="/data/{{ $page }}/{{ $data['user_id'] }}/{{ \Carbon\Carbon::now()->month }}">
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

            <?php
            $hasImageField = !empty(
                array_filter($fields, function ($field) {
                    return $field['type'] === 'file';
                })
            );
            ?>


            <form method="POST" action="/verifikasi/{{ $page }}/{{ $data['id'] }}"
                {{ $hasImageField ? 'enctype=multipart/form-data' : '' }}>
                @csrf
                @method('PUT')

                @foreach ($fields as $field)
                    @if ($field['type'] != 'select')
                        <div class="row gx-3 mb-3">
                            <div class="col-md-8">
                                <label class="small mb-1" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                <input class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                    type="{{ $field['type'] }}" placeholder="Masukkan {{ $field['label'] }}"
                                    value="{{ $field['value'] }}" readonly />
                            </div>
                        </div>
                    @else
                        <div class="row mb-3 gx-3">
                            <div class="col-md-8">
                                <label class="small mb-1">{{ $field['label'] }}</label>
                                <select class="form-select" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                    aria-label="Default select example">
                                    <option selected disabled>Pilih {{ $field['label'] }}:</option>
                                    {{-- @foreach ($field['options'] as $option)
                                        <option value="{{ $option }}"
                                            @if ($field['value'] == $option) selected @endif>{{ $option }}
                                        </option>
                                    @endforeach --}}

                                    <option value="1" @if ($field['value'] == 1) selected @endif>
                                        Belum Jatuh Tempo
                                    </option>
                                    <option value="2" @if ($field['value'] == 2) selected @endif>
                                        Menunggu Pembayaran
                                    </option>
                                    <option value="3" @if ($field['value'] == 3) selected @endif>
                                        Dibayarkan
                                    </option>
                                </select>
                            </div>
                        </div>
                    @endif
                @endforeach

                <button class="btn btn-primary" type="submit">Update {{ Str::ucfirst($page) }}</button>
            </form>
        </div>
    </div>
@endsection
