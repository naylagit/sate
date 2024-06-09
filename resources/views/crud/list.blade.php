@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3 d-flex">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Daftar {{ $page }}
                        </h1>

                    </div>
                    <div class="col-12 col-xl-auto mb-3">


                        @if ($data->isEmpty() || $data[0]['tanggal'] != \Carbon\Carbon::now()->toDateString())
                            <a class="btn btn-sm btn-light text-primary" href="/{{ $page }}/create">
                                <i class="me-1" data-feather="user-plus"></i>
                                Tambahkan {{ $page }}
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    @if ($page == 'kehadiran' && Auth::user()->role != 'owner')
        @if ($data->isEmpty())
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger " role="alert">
                    Anda belum mempunyai data kehadiran
                </div>
            </div>
        @elseif ($data[0]['tanggal'] != \Carbon\Carbon::now()->toDateString())
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger " role="alert">
                    Anda belum menambahkan kehadiran hari ini
                </div>
            </div>
        @endif
    @endif



    <div class="card">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        @foreach ($fields as $field)
                            <th>{{ $field['label'] }}</th>
                        @endforeach
                        <th>Actions</th>

                    </tr>
                </thead>
                {{-- <tfoot>
                    <tr>
                        <th>No</th>
                        @foreach ($fields as $field)
                            <th>{{ $field['label'] }}</th>
                        @endforeach
                        <th>Actions</th>
                    </tr>
                </tfoot> --}}
                <tbody>
                    @foreach ($data as $key => $d)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>

                            @foreach ($fields as $field)
                                @if ($field['name'] == 'status')
                                    <td>
                                        @if ($d['status'] == 'aktif' || $d['status'] == 'hadir')
                                            <span class="badge bg-green-soft text-green"> {{ $d[$field['name']] }}</span>
                                        @elseif ($d['status'] == 'non-aktif' || $d['status'] == 'tidak hadir')
                                            <span class="badge bg-red-soft text-red"> {{ $d[$field['name']] }}</span>
                                        @elseif ($d['status'] == 'izin')
                                            <span class="badge bg-yellow-soft text-yellow"> {{ $d[$field['name']] }}</span>
                                        @endif

                                    </td>
                                @elseif($field['name'] == 'verifikasi')
                                    <td>
                                        @if ($d['verifikasi'] == 'diverifikasi')
                                            <span class="badge bg-green-soft text-green"> {{ $d[$field['name']] }}</span>
                                        @elseif ($d['verifikasi'] == 'belum diverifikasi')
                                            <span class="badge bg-danger-soft text-danger"> {{ $d[$field['name']] }}</span>
                                        @endif

                                    </td>
                                @else
                                    <td>
                                        {{ $d[$field['name']] }}
                                    </td>
                                @endif
                            @endforeach





                            <td>

                                @if ($page == 'kehadiran')
                                    @if ($data[0]['tanggal'] == \Carbon\Carbon::now()->toDateString())
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                            href="/{{ $page }}/{{ $d['id'] }}/edit"><i
                                                data-feather="edit"></i></a>
                                        <form action="{{ url($page . '/' . $d['id']) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-datatable btn-icon btn-transparent-dark">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                        href="/{{ $page }}/{{ $d['id'] }}/edit"><i
                                            data-feather="edit"></i></a>
                                    <form action="{{ url($page . '/' . $d['id']) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-datatable btn-icon btn-transparent-dark">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                @endif


                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
