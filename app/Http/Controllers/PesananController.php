<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Pengelolaan;
use App\Exports\BahanBakuExport;
use App\Exports\PenjualanExport;
use App\Exports\KeuntunganExport;
use App\Exports\LaporanBahanBakuExport;
use App\Models\Pesananmenu;
use App\Models\Pemasukan;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananController extends Controller
{
     public function pesanan()
     {

        $data = Pesanan::with('user')->orderBy('created_at', 'desc')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'id_transaksi' => '#'.$item->id_transaksi,
                'user_id' => $item->user_id,
                'nama' => $item->user->nama,
                'jenis' => $item->jenis,
                'meja' => $item->meja,
                'total' => $item->total,
                'metode_pembayaran' => $item->metode_pembayaran,
                'created_at' => $item->created_at,
                'status' => $item->status,
            ];
        });
        

         $fields = [
             ['type' => 'text', 'name' => 'id', 'label' => 'ID Transaksi'],
             ['type' => 'text', 'name' => 'created_at', 'label' => 'Tanggal'],
             ['type' => 'text', 'name' => 'total', 'label' => 'Total Transaksi'],
             ['type' => 'select', 'name' => 'status', 'label' => 'Status'],
         ];
 
         return view('crud.pesanan.list', compact('fields', 'data'));
     }

     public function penjualan()
     {

        // $data = PesananMenu::select('menu_id', DB::raw('SUM(jumlah) as total_sum'))
        // ->groupBy('menu_id')
        // ->with('menu')
        // ->get();

        //  $fields = [
        //      ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Menu'],
        //      ['type' => 'text', 'name' => 'nama', 'label' => 'Kategori'],
        //      ['type' => 'text', 'name' => 'total_sum', 'label' => 'Jumlah Terjual(Porsi)'],
        //      ['type' => 'text', 'name' => '', 'label' => 'Harga'],
        //  ];

        $data = PesananMenu::select('menu_id', DB::raw('SUM(jumlah) as total_sum'), DB::raw('SUM(subtotal) as total_subtotal'))
            ->groupBy('menu_id')
            ->with(['menu.kategori'])
            ->get();

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Menu'],
            ['type' => 'text', 'name' => 'total_sum', 'label' => 'Jumlah Terjual (Porsi)'],
            ['type' => 'text', 'name' => 'total_subtotal', 'label' => 'Subtotal (Harga)'],
        ];
 
         return view('crud.pesanan.penjualan', compact('fields', 'data'));
     }

    //  public function dashboard()
    //  {

    //   $currentMonth = Carbon::now()->month;
    //     $currentYear = Carbon::now()->year;
        
    //     $pemasukan = Pemasukan::whereMonth('created_at', $currentMonth)
    //                              ->whereYear('created_at', $currentYear)
    //                              ->sum('nominal');

    //                              $pengeluaran = Pengeluaran::whereMonth('created_at', $currentMonth)
    //                              ->whereYear('created_at', $currentYear)
    //                              ->sum('nominal');

    //                              $penjualan = Pesananmenu::whereMonth('created_at', $currentMonth)
    //                              ->whereYear('created_at', $currentYear)
    //                              ->sum('jumlah');



                    
    //      return view('dashboard', compact('pemasukan', 'pengeluaran', 'penjualan'));
    //  }

    public function dashboard() {
        $page = 'dashboard';
        $end = Carbon::now();
    
        $pemasukan = DB::table('pemasukans')
            ->select(DB::raw('SUM(nominal) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        $pengeluaran = DB::table('pengeluarans')
            ->select(DB::raw('SUM(nominal) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        $months = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('F Y'); // Full month name and year
        })->reverse()->values();
    
        $pemasukanData = $months->map(function ($month) use ($pemasukan) {
            $parsedMonth = Carbon::parse($month)->format('Y-m');
            return $pemasukan->firstWhere('month', $parsedMonth)->total ?? 0;
        });
    
        $pengeluaranData = $months->map(function ($month) use ($pengeluaran) {
            $parsedMonth = Carbon::parse($month)->format('Y-m');
            return $pengeluaran->firstWhere('month', $parsedMonth)->total ?? 0;
        });
    
        return view('dashboard', compact('pemasukanData', 'pengeluaranData', 'months', 'page'));
    }
    

     public function createPesanan()
     {
        $title = 'Pesaanan';
        $page = 'pesanan';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Menu'],
            ['type' => 'select', 'name' => 'kategori', 'label' => 'Kategori Menu'],
            ['type' => 'number', 'name' => 'harga', 'label' => 'Harga Menu'],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status'],
        ];
          $latestPesanan = Pesanan::orderBy('id', 'desc')->first();
          if ($latestPesanan) {
            $latestId = $latestPesanan->id;
            $id = 'P' . str_pad((int) substr($latestId, 1) + 1, 5, '0', STR_PAD_LEFT);
        } else {
            // First entry
            $id = 'P00001';
        }
        $id_transaksi = $id;

        $menu = Menu::where('status', 1)->get();
        $meja = Meja::where('status', 1)->get();
 
         return view('crud.pesanan.add', compact('fields','page', 'title', 'menu', 'meja', 'id_transaksi', 'id'));
     }

     
 
     public function storePesanan(Request $request)
     {
         $validated = $request->validate([
             'jenis' => 'required|string|max:255',
             'meja_id' => 'required|string|max:255',
             'total' => 'required|string|max:255',
             'metode_pembayaran' => 'required|string|max:255',
             'dibayarkan' => 'required|string|max:255',
             'kembalian' => 'required|string|max:255',
             'status' => 'required|string|max:255',
             'nm_cust' => 'required|string|max:255',
             'keterangan' => 'nullable|string|max:255',
         ]);

         $validated['id'] = $request->input('id_transaksi');

         if($validated['status'] == 2){
            $existPesanan = Pesanan::where('id', $request->input('id_transaksi'))->first();

            if($existPesanan){
                $existMenu = PesananMenu::where('pesanan_id',$existPesanan->id)->first();
                $existPesanan->delete();
                $existMenu->delete();
            }
           
         }

         $validated['user_id'] = Auth::user()->id;    


         $pesanan = Pesanan::create($validated);


         if($validated['status'] == 2){
            Pemasukan::create([
                'nominal' => $validated['total'],
                'keterangan' => 'Penjualan-'.$pesanan['created_at']
            ]);

            if($validated['metode_pembayaran'] == 'debit'){

                Pembayaran::create([
                    'pesanan_id' => $pesanan['id'],
                    'bank' =>  $request->input('bank'),
                    'norek' =>  $request->input('norek'),
                ]);
            }
         }
         foreach ($request['items'] as $itemData) {
            $item = json_decode($itemData, true);

            $menu = Menu::where('nama', $item['produk'])->first();

            $pesananMenu = new PesananMenu([
                'pesanan_id' => $pesanan['id'],
                'menu_id' => $menu['id'],
                'jumlah' => $item['qty'],
                'subtotal' => $item['subtotal'],
                'keterangan' => $item['ket'],
            ]);

            $pesananMenu->save();



            $items[] = $pesananMenu;

        }

        $order = Pesanan::with('user','pembayaran')->find($pesanan['id']);

        $items = PesananMenu::with('menu')->where('pesanan_id', $pesanan['id'])->get();

    



        if($validated['status'] == 2 ){
            $pdf = Pdf::loadView('pdf.faktur', compact('order', 'items'))->setPaper('a4')->setWarnings(false)->save('faktur_pembayaran.pdf');

            return $pdf->download('faktur_pembayaran.pdf');

        
        }   else {
                return redirect('pesanan')->with('success', 'Pesanan berhasil ditambahkan');
             
        }


     }

 
     public function editPesanan($id)
     {
        $title = 'Pesanan';
        $page = 'pesanan';

         $data = Pesanan::with('user')->findOrFail($id);
         $data['nama'] = $data->user->nama;

         $dataMenu = Pesananmenu::where('');

         $pesananMenu = PesananMenu::with('menu')->where('pesanan_id', $id)->get();

         $menu = Menu::where('status', 1)->get();
         $meja = Meja::where('status', 1)->get();

        
         return view('crud.pesanan.detail',  compact('page', 'title','data', 'menu', 'meja', 'pesananMenu'));
     }

     public function editPesananPending($id)
     {
        $title = 'Pesanan';
        $page = 'pesanan';

         $data = Pesanan::with('user')->findOrFail($id);
         $data['nama'] = $data->user->nama;

         $dataMenu = Pesananmenu::where('');

         $pesananMenu = PesananMenu::with('menu')->where('pesanan_id', $id)->get();

         $menu = Menu::where('status', 1)->get();
         $meja = Meja::where('status', 1)->get();

        
         return view('crud.pesanan.update',  compact('page', 'title','data', 'menu', 'meja', 'pesananMenu'));
     }

      public function exportBahanBaku()
      {
        return Excel::download(new BahanBakuExport, 'Bahan Baku-'.Carbon::now()->toDateString().'.xlsx');
      }

      public function exportPenjualan()
      {
        return Excel::download(new PenjualanExport, 'Penjualan-'.Carbon::now()->toDateString().'.xlsx');
      }

      public function exportKeuntungan()
      {
        return Excel::download(new KeuntunganExport, 'Keuntungan-'.Carbon::now()->toDateString().'.xlsx');
      }


}
