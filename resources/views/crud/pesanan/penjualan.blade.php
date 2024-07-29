@extends('layout')

@section('header')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3 d-flex">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="credit-card"></i></div>
                        Penjualan
                    </h1>

                </div>
            </div>
        </div>
    </div>
</header>
@endsection


@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">Daftar Penjualan
        <a class="btn btn-green " href='/penjualan/export'>
            <i data-feather="upload" class="me-2"></i> Export
        </a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No</th>
                    @foreach ($fields as $field)
                    <th>{{ $field['label'] }}</th>
                    @endforeach



                </tr>
            </thead>

            <tbody>
                @foreach ($data as $key => $d)
                <tr>
                    <td>
                        {{ $key + 1 }}
                    </td>

                    @foreach ($fields as $field)
                    @if ($field['name'] == 'total_sum')
                    <td>
                      {{ number_format($d[$field['name']], 0, ',', '.') }}
                    </td>
                    @elseif ($field['name'] == 'total_subtotal')
                    <td>
                     Rp {{ number_format($d[$field['name']], 0, ',', '.') }}
                    </td>
                    @elseif ($field['name'] == 'nama')
                    <td>
                        {{ $d->menu->nama }}
                    </td>
                    @else
                    <td>
                        {{ $d[$field['name']] }}
                    </td>
                    @endif
                    @endforeach





                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection