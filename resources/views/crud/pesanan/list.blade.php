@extends('layout')

@section('header')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3 d-flex">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="airplay"></i></div>
                        Pesanan
                    </h1>

                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="/pesanan/create">
                        <i class="me-1" data-feather="plus"></i>
                        Tambahkan Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection


@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">Daftar Pesanan
        <a class="btn btn-green " href='/pesanan/export'>
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

                    <th class="text-center">Aksi</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($data as $key => $d)
                <tr>
                    <td>
                        {{ $key + 1 }}
                    </td>

                    @foreach ($fields as $field)
                    @if ($field['name'] == 'total')
                    <td>
                        Rp {{ number_format($d[$field['name']], 0, ',', '.') }}
                    </td>
                    @elseif ($field['name'] == 'created_at')
                    <td>
                        {{ \Carbon\Carbon::parse($d[$field['name']])->format('d-m-Y H:i') }}
                    </td>
                    @elseif ($field['name'] == 'status')
                    <td>
                        @if ($d['status'] == 2)
                        <span class="badge bg-green-soft text-green">Selesai</span>
                        @elseif ($d['status'] == 1)
                        <span class="badge bg-blue-soft text-blue">Pending</span>
                        @endif

                    </td>
                    @else
                    <td>
                        {{ $d[$field['name']] }}
                    </td>
                    @endif
                    @endforeach




                    <td class="text-center">


                        @if ($d['status'] == 2)
                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/pesanan/{{ $d['id'] }}/edit"><i data-feather="info"></i></a>
                        @else
                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/pesanan/{{ $d['id'] }}/editpending"><i data-feather="info"></i></a>
                        @endif

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection