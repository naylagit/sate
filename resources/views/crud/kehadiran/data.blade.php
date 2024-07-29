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

                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">Data Kehadiran

            <div class="">
                <select id="monthFilter" class="form-select d-inline w-auto">
                    <option value="all" {{ $month == 'all' ? 'selected' : '' }}>All</option>
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
                <a class="btn btn-green " href='/export/data/kehadiran/{{ $month }}'>
                    <i data-feather="link" class="me-2"></i> Export
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
                        <th class="text-center">Actions</th>

                    </tr>
                </thead>
 
                <tbody>
                    @foreach ($data as $key => $d)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>

                            @foreach ($fields as $field)
                                @if ($field['name'] == 'todays_kehadiran_status')
                                    <td>
                                        @if ($d['todays_kehadiran_status'] == 'hadir')
                                            <span class="badge bg-green-soft text-green"> {{ $d[$field['name']] }}</span>
                                        @elseif ($d['todays_kehadiran_status'] == 'izin')
                                            <span class="badge bg-yellow-soft text-yellow"> {{ $d[$field['name']] }}</span>
                                        @elseif ($d['todays_kehadiran_status'] == 'tidak hadir')
                                            <span class="badge bg-red-soft text-red"> {{ $d[$field['name']] }}</span>
                                        @else
                                            <span class="badge bg-red-soft text-red"> Belum Input Kehadiran</span>
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
                                    href="/data/{{ $page }}/{{ $d['id'] }}/{{ \Carbon\Carbon::now()->month }}"><i
                                        class="fa-solid fa-info"></i></a>
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
            var url = '/data/kehadiran/all';
            if (month) {
                url += '/' + month;
            }
            window.location.href = url;
        });
    </script>
@endpush
