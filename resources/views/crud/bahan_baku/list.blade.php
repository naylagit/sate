@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3 d-flex">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="box"></i></div>
                            Bahan Baku
                        </h1>

                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="/bahanbaku/create">
                            <i class="me-1" data-feather="plus"></i>
                            Tambahkan Bahan Baku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">Daftar Bahan Baku
            <a class="btn btn-green " href='/bahanbaku/export'>
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
                        <th class="text-center">Kelola</th>
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
                                @if ($field['name'] == 'updated_at')
                                    <td>
                                        {{ \Carbon\Carbon::parse($d[$field['name']])->format('d-m-Y H:i') }}
                                    </td>
                                @else
                                <td>
                                    {{ $d[$field['name']] }}
                                </td>
                                @endif
                            @endforeach

                            <td class="text-center">
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="/bahanbaku/kelola/{{ $d['id'] }}/masuk"><i
                                        data-feather="plus-circle"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="/bahanbaku/kelola/{{ $d['id'] }}/keluar"><i
                                        data-feather="minus-circle"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="/bahanbaku/kelola/{{ $d['id'] }}/busuk"><i data-feather="clock"></i></a>
                            </td>

 
                            <td class="text-center">
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="/bahanbaku/{{ $d['id'] }}/edit"><i data-feather="edit"></i></a>
                                <form action="{{ url('bahanbaku/' . $d['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-datatable btn-icon btn-transparent-dark">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
