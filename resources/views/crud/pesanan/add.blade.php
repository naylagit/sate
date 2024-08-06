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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="modal fade" id="successModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="successModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title " id="successModalTitle">Pesanan Selesai</h5>

                </div>
                <div class="modal-body d-flex justify-content-center"><i class="text-green" data-feather="check-circle"
                        style="height: 75px; width: 75px;"></i></div>
                <div class="modal-footer justify-content-center"><a href='/pesanan' class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

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
                            <input class="form-control" id="hargaDisplay" name="hargaDisplay" type="text"
                                placeholder="harga" readonly />
                            <input class="form-control" id="harga" name="harga" type="hidden" placeholder="harga"
                                readonly />
                        </div>

                        <div class="col-md-6">
                            <label class="small mb-1" for="jumlah">Jumlah Porsi</label>
                            <input class="form-control" id="jumlah" name="jumlah" type="text"
                                placeholder=" jumlah" />
                        </div>



                    </div>



                    <div class="row  mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="subtotal">Subtotal</label>
                            <input class="form-control" id="subtotalDisplay" name="subtotalDisplay" type="text"
                                placeholder=" subtotal" readonly />

                            <input class="form-control" id="subtotal" name="subtotal" type="hidden"
                                placeholder=" subtotal" readonly />
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

                <form method="POST" action="/pesanan" id="mainForm">
                    @csrf


                    <div class="card-body">




                        <div class="row  mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="">Nomor Pesanan</label>
                                <input class="form-control" id="" name="" type="text"
                                    placeholder=" Nomor Pesanan" value={{ $id }} readonly />
                            </div>
                            <input class="form-control" id="id_transaksi" name="id_transaksi" type="hidden"
                                placeholder=" Nomor Pesanan" value={{ $id_transaksi }} readonly />
                            <div class="col-md-6">
                                <label class="small mb-1" for="">Waktu Pesanan</label>
                                <input class="form-control" id="" name="" type="text"
                                    placeholder=" " value="{{ date('Y-m-d H:i:s') }}" readonly />
                            </div>
                            <div class="col-md-12">
                                <label class="small mb-1" for="nm_cust">Nama Customer</label>
                                <input class="form-control" id="nm_cust" name="nm_cust" type="text"
                                    placeholder=" Nama Customer" required />
                            </div>




                        </div>



                    </div>
            </div>
            <div class="card mb-4">

                <div class="card-body">



                    <div class="row  gx-3">
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
                        <input class="form-control" id="status" name="status" type="hidden" value="2" />
                        <div class="col-md-6">
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
                                        Debit
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
                            <label class="small mb-1" for="total">Total Belanja</label>
                            <input class="form-control" id="totalDisplay" name="totalDisplay" type="text"
                                placeholder=" Total" readonly />
                            <input class="form-control" id="total" name="total" type="hidden"
                                placeholder=" Total" readonly />
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
                                    Debit
                                </option>
                            </select>
                        </div>

                        {{-- <div class="col-md-6 mb-3">
                            <label class="small mb-1">Keterangan</label>
                            <input class="form-control" id="keterangan" name="keterangan" type="text"
                                placeholder=" Masukkan Keterangan" required />

                        </div> --}}

                        <div class="d-none">

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
                                <input class="form-control" id="kembalian" name="kembalian" type="hidden"
                                    placeholder="Jumlah Kembalian" readonly />
                                <input class="form-control" id="kembalianDisplay" name="kembalianDisplay" type="text"
                                    placeholder="Jumlah Kembalian" readonly />
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="small mb-1">Nama Bank</label>
                                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran"
                                    aria-label="Default select example">
                                    <option selected disabled>Pilh Bank:</option>
                                    <option value="cash">
                                        Cash
                                    </option>
                                    <option value="qris">
                                        Debit
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="dibayarkan">Nomor Rekening</label>
                                <input class="form-control" id="dibayarkan" name="dibayarkan" type="text"
                                    placeholder=" Masukkan Nomor Rekening" />
                            </div>

                            {{-- <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="dibayarkan">Dibayarkan</label>
                                <input class="form-control" id="dibayarkan" name="dibayarkan" type="text"
                                    placeholder=" Masukkan Jumlah Dibayarkan" />
                            </div> --}}

                            {{-- <div class="col-md-12 mb-3">
                                <button class="btn btn-primary w-100" id="calculate-change">Hitung </button>
                            </div> --}}

                            {{-- <div class="col-md-12 mb-3">
                                <label class="small mb-1" for="kembalian">Kembalian</label>
                                <input class="form-control" id="kembalian" name="kembalian" type="hidden"
                                    placeholder="Jumlah Kembalian" readonly />
                                <input class="form-control" id="kembalianDisplay" name="kembalianDisplay" type="text"
                                    placeholder="Jumlah Kembalian" readonly />
                            </div> --}}

                        </div>



                        <div class="col-md-12">
                            <button class="btn btn-warning w-100 mb-3" id="pendingButton">Pending </button>
                            <button class="btn btn-success w-100" id="submitButton" type="submit">Selesaikan Pesanan
                            </button>
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
                } else if (dibayarkan < total) {
                    alert('Uang yang dibayarkan kurang dari total');
                    return;
                }

                // Calculate kembalian
                var kembalian = dibayarkan - total;

                // Update the kembalian input field
                $('#kembalian').val(kembalian.toFixed(2));
                $('#kembalianDisplay').val('Rp ' + kembalian.toLocaleString());
            });

            $('#submitButton').click(function(e) {
                $('#successModal').modal('show');
            });

            $('#pendingButton').click(function(e) {
                e.preventDefault();

                // Set the status to "pending"
                $('#status').val(1);

                const previousInputs = mainForm.querySelectorAll('input[name="items[]"]');
                previousInputs.forEach(input => input.remove());

                const tableBody = document.querySelector('#datatablesSimple tbody');

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

                // Submit the form
                $('#mainForm').submit();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const menuSelect = document.getElementById('menu');
            const hargaInput = document.getElementById('harga');
            const hargaDisplay = document.getElementById('hargaDisplay');
            const jumlahInput = document.getElementById('jumlah');
            const subtotalInput = document.getElementById('subtotal');
            const subtotalDisplay = document.getElementById('subtotalDisplay');
            const keteranganInput = document.getElementById('keterangan');
            const addMenuButton = document.getElementById('addMenuButton');
            const tableBody = document.querySelector('#datatablesSimple tbody');
            const totalInput = document.getElementById('total');
            const totalDisplay = document.getElementById('totalDisplay');

            let itemNumber = 1;

            deleteFirstRow();



            menuSelect.addEventListener('change', function() {
                const selectedOption = menuSelect.options[menuSelect.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                hargaInput.value = parseInt(harga);
                hargaDisplay.value = 'Rp ' + parseInt(harga).toLocaleString();
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
                const subtotal_display = 'Rp ' + parseInt(subtotalInput.value).toLocaleString();
                const keterangan = keteranganInput.value;

                if (namaMenu && jumlah && subtotal && keterangan) {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                    <td>${itemNumber}</td>
                    <td>${namaMenu}</td>
                    <td>${jumlah}</td>
                    <td class='d-none'>${subtotal}</td>
                    <td>${subtotal_display}</td>
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
                    hargaDisplay.value = '';
                    subtotalDisplay.value = '';
                } else {
                    alert('Please fill in all fields before adding.');
                }
            });

            function calculateSubtotal() {
                const harga = parseFloat(hargaInput.value) || 0;
                const jumlah = parseFloat(jumlahInput.value) || 0;
                const subtotal = parseInt(harga * jumlah);
                subtotalInput.value = subtotal;
                subtotalDisplay.value = 'Rp ' + subtotal.toLocaleString();
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
                totalDisplay.value = 'Rp ' +
                    total.toLocaleString();


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

                const modal = document.getElementById('successModal');



            });
        });
    </script>
@endpush
