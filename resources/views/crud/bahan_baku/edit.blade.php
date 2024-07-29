@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Edit {{ $title }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ url($page) }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali ke List {{ $title }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">Data {{ $title }}</div>
        <div class="card-body">


            <form method="POST" action="{{ url($page) }}/{{ $data['id'] }}">
                @csrf
                @method('PUT')

                @foreach ($fields as $field)
                    <div class="row gx-3 mb-3">
                        <div class="col-md-8">
                            <label class="small mb-1" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                            <input class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                type="{{ $field['type'] }}" placeholder="Masukkan {{ $field['label'] }}"
                                value="{{ $field['value'] }}" required />
                        </div>
                    </div>
                @endforeach

                <button class="btn btn-primary" type="submit">Update {{ $title }}</button>
            </form>
        </div>
    </div>
@endsection
