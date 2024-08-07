@extends('layout')


@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <!-- <h1 class="page-header-title">
                                                                                                                                                                                                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                                                                                                                                                                                                            Dashboard
                                                                                                                                                                                                        </h1>
                                                                                                                                                                                                        <div class="page-header-subtitle">Ringkasan Bulan Ini</div> -->
                        <h3 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Ringkasan Bulan Ini
                        </h3>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">
                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                            <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-calendar text-primary">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg></span>

                            <input class="form-control ps-0 pointer" value=" {{ \Carbon\Carbon::now()->format('F Y') }}">
                        </div>
                    </div>
                    {{-- <div class="col-12 col-xl-auto mt-4">
                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                            <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                                placeholder="Select date range..." />
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    <div class="row mt-n10">
        @php
            $currentMonthIndex = count($months) - 1;
            $currentMonthPemasukan = $pemasukanData[$currentMonthIndex];
            $currentMonthPengeluaran = $pengeluaranData[$currentMonthIndex];
            $currentMonthProfit = $currentMonthPemasukan - $currentMonthPengeluaran;
        @endphp
        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Pemasukan</div>
                            <div class="text-lg fw-bold"> Rp {{ number_format($currentMonthPemasukan, 0, ',', '.') }}</div>
                        </div>
                        <i class="feather-xl text-white-50" data-feather="calendar"></i>
                    </div>
                </div>
                </tr>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="/pemasukan">View Report</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Pengeluaran</div>
                            <div class="text-lg fw-bold"> Rp {{ number_format($currentMonthPengeluaran, 0, ',', '.') }}
                            </div>
                        </div>
                        <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="/pengeluaran">View Report</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Keuntungan</div>
                            <div class="text-lg fw-bold">Rp {{ number_format($currentMonthProfit, 0, ',', '.') }}</div>
                        </div>
                        <i class="feather-xl text-white-50" data-feather="check-square"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <!-- Bar chart example-->
            <div class="card mb-4">
                <div class="card-header">Pemasukan</div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="pemasukanChart" width="1130" height="480"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Bar chart example-->
            <div class="card mb-4">
                <div class="card-header">Pengeluaran</div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="pengeluaranChart" width="1130" height="480"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">Daftar Keuntungan
            <a class="btn btn-green " href='/keuntungan/export'>
                <i data-feather="upload" class="me-2"></i> Export
            </a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                        <th>Keuntungan</th>
                    </tr>
                </thead>

                <tbody>


                    @foreach ($months->reverse() as $key => $item)
                        <tr>
                            <td>{{ $item }}</td>
                            <td>Rp {{ number_format($pemasukanData->reverse()[$key], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pengeluaranData->reverse()[$key], 0, ',', '.') }}</td>
                            <td>Rp
                                {{ number_format($pemasukanData->reverse()[$key] - $pengeluaranData->reverse()[$key], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var pemasukanCtx = document.getElementById('pemasukanChart').getContext('2d');
            var pengeluaranCtx = document.getElementById('pengeluaranChart').getContext('2d');

            var months = @json($months);
            var pemasukanData = @json($pemasukanData);
            var pengeluaranData = @json($pengeluaranData);

            new Chart(pemasukanCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Pemasukan',
                        data: pemasukanData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue color
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue color
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(pengeluaranCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Pengeluaran',
                        data: pengeluaranData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue color
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue color
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
