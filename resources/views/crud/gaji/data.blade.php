@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3 d-flex">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Daftar {{ Str::ucfirst($page) }}
                        </h1>

                    </div>

                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    @if ($page == 'kehadiran' && Auth::user()->id == $id)
        @if ($data->isEmpty())
        @elseif ($data[0]['tanggal'] != \Carbon\Carbon::now()->toDateString())
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger " role="alert">
                    Anda belum menambahkan kehadiran hari ini
                </div>
            </div>
        @endif
    @endif



    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">Data {{ Str::ucfirst($page) }}

            <div class="">
                <select id="monthFilter" class="form-select d-inline w-auto">
                    <option value="all" {{ $month == 'all' ? 'selected' : '' }}>All</option>
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
                <a class="btn btn-green " href='/export/data/{{ $page }}/{{ $month }}'>
                    <i data-feather="upload" class="me-2"></i> Export
                </a>

            </div>

        </div>
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
                <tbody>
                    @foreach ($data as $key => $d)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>

                            @foreach ($fields as $field)
                                @if ($field['type'] == 'number')
                                    <td>
                                        Rp {{ number_format($d[$field['name']], 0, ',', '.') }}
                                    </td>
                                @elseif ($field['name'] == 'status')
                                    <td>
                                        @if ($d['status'] == 1)
                                            <span class="badge bg-yellow-soft text-yellow"> Belum Jatuh Tempo</span>
                                        @elseif ($d['status'] == 2)
                                            <span class="badge bg-red-soft text-red"> Menuggu Pembayaran</span>
                                        @elseif ($d['status'] == 3)
                                            <span class="badge bg-green-soft text-green">Dibayarkan</span>
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
                            <td class="text-center">

                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                    href="/data/{{ $page }}/{{ $d['user_id'] }}"><i
                                        class="fa-regular fa-eye"></i></a>


                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('monthFilter').addEventListener('change', function() {
            var month = this.value;
            var url = '/data/gaji/all';
            if (month) {
                url += '/' + month;
            }
            window.location.href = url;
        });
    </script>
@endpush
