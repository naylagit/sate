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
                    {{-- <div class="col-12 col-xl-auto mb-3">

                        @if ($data->isEmpty() || $data[0]['tanggal'] != \Carbon\Carbon::now()->toDateString())
                            <a class="btn btn-sm btn-light text-primary" href="{{ $page }}/create">
                                <i class="me-1" data-feather="user-plus"></i>
                                Tambahkan {{ $page }}
                            </a>
                        @endif

                    </div> --}}
                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    <div class="card">

        <div class="card-body">
            <div class="d-flex justify-content-between">
                <a href="/export/kehadiran/list/{{ request()->segment(3) }}" class="btn btn-success"><i
                        class="fa-solid fa-file-excel me-2"></i>Export</a>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        @php
                            $months = [
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December',
                            ];
                            $currentMonth = request()->segment(3); // Get the month from the URL
                        @endphp


                        @if (!$currentMonth)
                            {{ $months[\Carbon\Carbon::now()->month] }}
                        @else
                            {{ $months[$currentMonth] }}
                        @endif





                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        @foreach ($months as $key => $month)
                            <a class="dropdown-item {{ $key == $currentMonth ? 'active' : '' }}"
                                href="{{ url('kehadiran/list/' . $key) }}">{{ $month }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>

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
                                    href="/{{ $page }}/{{ $d['id'] }}"><i class="fa-solid fa-info"></i></a>


                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
