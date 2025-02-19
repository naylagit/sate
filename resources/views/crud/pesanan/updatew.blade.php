@extends('layout')

@section('header')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Tambah {{ Str::ucfirst($page) }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="/{{ $page }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali ke List {{ Str::ucfirst($page) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col-7">
            <div class="card mb-4">
                <div class="card-header">Tambahkan {{ Str::ucfirst($page) }}</div>

                <div class="card-body">



                    <div class="row mb-3 gx-3">
                        <div class="col-md-12">
                            <label class="small mb-1">Nama Menu</label>
                            <select class="form-select" id="menu" name="menu" aria-label="Default select example">
                                <option selected disabled>Pilih Menu:</option>
                                @foreach ($menu as $item)
                                    <option value="{{ $item['id'] }}" data-harga="{{ $item['harga'] }}">
                                        {{ $item['nama'] }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>



                    <div class="row  mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="harga">Harga Satuan</label>
                            <input class="form-control" id="harga" name="harga" type="text" placeholder=" harga" />
                        </div>

                        <div class="col-md-6">
                            <label class="small mb-1" for="jumlah">Jumlah</label>
                            <input class="form-control" id="jumlah" name="jumlah" type="text"
                                placeholder=" jumlah" />
                        </div>



                    </div>

                    <div class="row  mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="subtotal">Subtotal</label>
                            <input class="form-control" id="subtotal" name="subtotal" type="text"
                                placeholder=" subtotal" />
                        </div>

                        <div class="col-md-6">
                            <label class="small mb-1" for="keterangan">Keterangan</label>
                            <input class="form-control" id="keterangan" name="keterangan" type="text"
                                placeholder=" keterangan" />
                        </div>



                    </div>

                    <button class="btn btn-primary" id="addMenuButton">Tambah Menu </button>

                </div>
            </div>

            <div class="card mb-4">


                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>QTY</th>
                                <th>Subtotal</th>
                                <th>Ket</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-5">
            <div class="card mb-4">

                <div class="card-body">

                    <form method="POST" action="/pesanan" id="mainForm">
                        @csrf

                        <div class="row mb-3 gx-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Jenis Pesanan</label>
                                <select class="form-select" id="jenis" name="jenis"
                                    aria-label="Default select example">
                                    <option selected disabled>Pilih Jenis Pesanan:</option>
                                    <option value="1">
                                        Dine In
                                    </option>
                                    <option value="2">
                                        Take Out
                                    </option>


                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1">Pilih Meja</label>
                                <select class="form-select" id="meja_id" name="meja_id"
                                    aria-label="Default select example">
                                    <option selected disabled>Pilih Meja:</option>

                                    @foreach ($meja as $item)
                                        <option value="{{ $item['id'] }}">
                                            {{ $item['nama'] }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Status</label>
                                <select class="form-select" id="status" name="status"
                                    aria-label="Default select example">
                                    <option value="1">
                                        Pending
                                    </option>
                                    <option value="2">
                                        Selesai
                                    </option>


                                </select>
                            </div>

                        </div>



                        {{-- <div class="row  mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="total">Total</label>
                                <input class="form-control" id="total" name="total" type="text"
                                    placeholder=" Total" />
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1">Pilih Metode Pembayaran</label>
                                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran"
                                    aria-label="Default select example">
                                    <option selected disabled>Pilih Metode Pembayaran:</option>
                                    <option value="cash">
                                        Cash
                                    </option>
                                    <option value="qris">
                                        Qris
                                    </option>


                                </select>
                            </div>

                        </div> --}}




                        {{-- <button class="btn btn-primary" type="submit">Simpan </button> --}}

                </div>
            </div>
            <div class="card mb-4">

                <div class="card-body">

                    <div class="row ">
                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="total">Total</label>
                            <input class="form-control" id="total" name="total" type="text"
                                placeholder=" Total" />
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="small mb-1">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran"
                                aria-label="Default select example">
                                <option selected disabled>Metode Pembayaran:</option>
                                <option value="cash">
                                    Cash
                                </option>
                                <option value="qris">
                                    Qris
                                </option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="dibayarkan">Dibayarkan</label>
                            <input class="form-control" id="dibayarkan" name="dibayarkan" type="text"
                                placeholder=" Masukkan Jumlah Dibayarkan" />
                        </div>

                        <div class="col-md-12 mb-3">
                            <button class="btn btn-primary w-100" id="calculate-change">Hitung </button>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="small mb-1" for="kembalian">Kembalian</label>
                            <input class="form-control" id="kembalian" name="kembalian" type="text"
                                placeholder="Jumlah Kembalian" readonly />
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-success w-100" type="submit">Selesaikan Pesanan </button>
                        </div>

                    </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#calculate-change').click(function(e) {
                e.preventDefault();

                // Get the total and dibayarkan values
                var total = parseFloat($('#total').val());
                var dibayarkan = parseFloat($('#dibayarkan').val());

                // Validate the inputs
                if (isNaN(total) || isNaN(dibayarkan)) {
                    alert('Please enter valid numbers for Total and Dibayarkan.');
                    return;
                }

                // Calculate kembalian
                var kembalian = dibayarkan - total;

                // Update the kembalian input field
                $('#kembalian').val(kembalian.toFixed(2));
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const menuSelect = document.getElementById('menu');
            const hargaInput = document.getElementById('harga');
            const jumlahInput = document.getElementById('jumlah');
            const subtotalInput = document.getElementById('subtotal');
            const keteranganInput = document.getElementById('keterangan');
            const addMenuButton = document.getElementById('addMenuButton');
            const tableBody = document.querySelector('#datatablesSimple tbody');
            const totalInput = document.getElementById('total');

            let itemNumber = 1; // To keep track of the item number

            deleteFirstRow();



            menuSelect.addEventListener('change', function() {
                const selectedOption = menuSelect.options[menuSelect.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                hargaInput.value = harga;
                calculateSubtotal();
            });

            jumlahInput.addEventListener('input', function() {
                calculateSubtotal();
            });

            addMenuButton.addEventListener('click', function() {
                const selectedOption = menuSelect.options[menuSelect.selectedIndex];
                const namaMenu = selectedOption.text;
                const jumlah = jumlahInput.value;
                const subtotal = subtotalInput.value;
                const keterangan = keteranganInput.value;

                if (namaMenu && jumlah && subtotal && keterangan) {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                    <td>${itemNumber}</td>
                    <td>${namaMenu}</td>
                    <td>${jumlah}</td>
                    <td>${subtotal}</td>
                    <td>${keterangan}</td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
                    </td>
                `;
                    tableBody.appendChild(newRow);
                    itemNumber++;

                    updateTotal();



                    // Clear the form
                    menuSelect.value = '';
                    hargaInput.value = '';
                    jumlahInput.value = '';
                    subtotalInput.value = '';
                    keteranganInput.value = '';
                } else {
                    alert('Please fill in all fields before adding.');
                }
            });

            function calculateSubtotal() {
                const harga = parseFloat(hargaInput.value) || 0;
                const jumlah = parseFloat(jumlahInput.value) || 0;
                const subtotal = harga * jumlah;
                subtotalInput.value = subtotal.toFixed(2);
            }

            function deleteFirstRow() {
                const firstRow = tableBody.querySelector('tr');
                if (firstRow) {
                    firstRow.remove();
                }

            }

            function updateTotal() {
                let total = 0;
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    if (index > 0) { // Skip the first row
                        const subtotal = parseFloat(row.children[3].textContent) || 0;
                        total += subtotal;
                    } else {
                        row.style.display = 'none'; // Hide the first row
                    }
                });
                totalInput.value = total.toFixed(2);
            }

            window.deleteRow = function(button) {
                const row = button.closest('tr');
                row.remove();
                updateTotal();

                // Adjust item numbers
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    row.children[0].textContent = index + 1;
                });
                itemNumber = rows.length + 1;
            }

            mainForm.addEventListener('submit', function(event) {
                // Remove previous hidden inputs if any
                const previousInputs = mainForm.querySelectorAll('input[name="items[]"]');
                previousInputs.forEach(input => input.remove());

                // Append hidden inputs for each row
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    if (index > 0) { // Skip the first row
                        const produk = row.children[1].textContent;
                        const qty = row.children[2].textContent;
                        const subtotal = row.children[3].textContent;
                        const ket = row.children[4].textContent;

                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'items[]';
                        input.value = JSON.stringify({
                            produk,
                            qty,
                            subtotal,
                            ket
                        });
                        mainForm.appendChild(input);
                    }
                });
            });
        });
    </script>
@endpush
