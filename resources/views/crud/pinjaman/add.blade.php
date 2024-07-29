@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="settings"></i></div>
                            Tambahkan {{ Str::ucfirst($page) }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ url($page) }}">
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
            // Check if there is any field of type 'image'
            $hasImageField = !empty(
                array_filter($fields, function ($field) {
                    return $field['type'] === 'file';
                })
            );
            ?>

            <form method="POST" action="{{ url($page) }}" {{ $hasImageField ? 'enctype=multipart/form-data' : '' }}>
                @csrf

                @foreach ($fields as $field)
                    @if ($field['name'] == 'gaji')
                        <div class="row gx-3 mb-3">
                            <div class="col-md-8">
                                <label class="small mb-1" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                <input class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                    type="{{ $field['type'] }}" placeholder="Masukkan {{ $field['label'] }}"
                                    value="{{ $data['total'] }}" {{ $field['type'] == 'file' ? '' : 'required' }}
                                    readonly />
                            </div>
                        </div>
                    @else
                        <div class="row gx-3 mb-3">
                            <div class="col-md-8">
                                <label class="small mb-1" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                <input class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                    type="{{ $field['type'] }}" placeholder="Masukkan {{ $field['label'] }}"
                                    value="" {{ $field['type'] == 'file' ? '' : 'required' }} />
                            </div>
                        </div>
                    @endif
                @endforeach

                <button class="btn btn-primary" type="submit">Ajukan {{ Str::ucfirst($page) }}</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gaji = parseFloat(document.getElementById('gaji').value);
            const totalField = document.querySelector('[name="total"]');

            totalField.addEventListener('input', function() {
                let totalValue = parseFloat(totalField.value);
                if (totalValue > gaji) {
                    totalField.value = gaji;
                    alert('Total Pinjaman tidak bisa melebihi jumlah Gaji.');
                }
            });

            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                let totalValue = parseFloat(totalField.value);
                if (totalValue > gaji) {
                    event.preventDefault();
                    alert('Total Pinjaman tidak bisa melebihi jumlah Gaji.');
                }
            });
        });
    </script>
@endsection
