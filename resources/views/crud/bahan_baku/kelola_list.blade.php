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

            </div>
        </div>
    </div>
</header>
@endsection


@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">Laporan Pengelolaan Bahan Baku

        <div class="">
            <select id="monthFilter" class="form-select d-inline w-auto">
                <option value="all" {{ $month == 'all' ? 'selected' : '' }}>All</option>
                @foreach (range(1, 12) as $m)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                </option>
                @endforeach
            </select>
            <a class="btn btn-green " href='/bahanbaku/export/laporan/{{ $month }}'>
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
        var url = '/bahanbaku/laporan';
        if (month) {
            url += '/' + month;
        }
        window.location.href = url;
    });
</script>
@endpush