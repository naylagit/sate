@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3 d-flex">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-text"></i></div>
                            Kategori Menu
                        </h1>

                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="/kategorimenu/create">
                            <i class="me-1" data-feather="plus"></i>
                            Tambahkan Kategori Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">Daftar Kategori Menu </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>

                        @foreach ($fields as $field)
                            <th>{{ $field['label'] }}</th>
                        @endforeach

                        <th class="text-center">Aksi</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $key => $d)
                        <tr>


                            @foreach ($fields as $field)
                                @if ($field['name'] == 'status')
                                    <td>
                                        @if ($d['status'] == 1)
                                            <span class="badge bg-green-soft text-green">Tersedia</span>
                                        @elseif ($d['status'] == 2)
                                            <span class="badge bg-red-soft text-red">Tidak Tersedia</span>
                                        @elseif ($d['status'] == 3)
                                            <span class="badge bg-yellow-soft text-yellow">Dipesan</span>
                                        @endif

                                    </td>
                                @else
                                    <td>
                                        {{ $d[$field['name']] }}
                                    </td>
                                @endif
                            @endforeach




                            <td class="text-center">
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="/kategorimenu/{{ $d['id'] }}/edit"><i data-feather="edit"></i></a>
                                <form action="{{ url('kategorimenu/' . $d['id']) }}" method="POST" style="display:inline;">
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
