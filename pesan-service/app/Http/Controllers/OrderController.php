<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validasi jika customer_id dan menu_id tidak ada di request
        $validated = $request->validate([
            'customer_id' => 'required|integer',
            'menu_id' => 'required|integer',
        ]);

        // Ambil data customer_id dan menu_id dari request
        $customerId = $request->input('customer_id');
        $menuId = $request->input('menu_id');

        // Ambil data customer dari UserService
        $customerResponse = Http::get("http://localhost:8001/api/customers/{$customerId}");

        // Log untuk debugging
        \Log::info('Customer Response:', $customerResponse->json());

        if (!$customerResponse->ok() || !isset($customerResponse['success']) || !$customerResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan dari UserService',
            ], 404);
        }

        // Ambil data menu dari MenuService
        $menuResponse = Http::get("http://localhost:8002/api/menus/{$menuId}");
        $menuData = $menuResponse->json();

        // Log untuk debugging
        \Log::info('Menu Response:', ['menuData' => $menuData]);

        // Cek jika response menu tidak valid
        if (!$menuResponse->ok() || empty($menuData)) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan dari MenuService',
            ], 404);
        }

        // Mengambil data customer dan menu
        $customer = $customerResponse['data'];
        $menu = $menuData; // Tidak perlu menggunakan ['data'] karena menuData langsung ada

        // Simpan ke tabel orders
        $order = Order::create([
            'customer_id' => $customer['id'],
            'customer_name' => $customer['name'],
            'menu_id' => $menu['id'],
            'menu_name' => $menu['name'],
            'price' => $menu['price'],
        ]);

        // Mengembalikan respons sukses dengan data order yang baru dibuat
        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dilakukan',
            'data' => $order,
        ]);
    }

    public function index()
    {
        // Mengambil semua data order dari database
        return response()->json([
            'success' => true,
            'data' => Order::all(),
        ]);
    }

    public function show($id)
    {
        // Menampilkan detail order berdasarkan ID
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'customer_id' => 'required|integer',
            'menu_id' => 'required|integer',
        ]);

        // Mencari order berdasarkan ID
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan',
            ], 404);
        }

        // Ambil data customer_id dan menu_id dari request
        $customerId = $request->input('customer_id');
        $menuId = $request->input('menu_id');

        // Ambil data customer dari UserService
        $customerResponse = Http::get("http://localhost:8001/api/customers/{$customerId}");

        if (!$customerResponse->ok() || !isset($customerResponse['success']) || !$customerResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan dari UserService',
            ], 404);
        }

        // Ambil data menu dari MenuService
        $menuResponse = Http::get("http://localhost:8002/api/menus/{$menuId}");
        $menuData = $menuResponse->json();

        if (!$menuResponse->ok() || empty($menuData)) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan dari MenuService',
            ], 404);
        }

        // Update order
        $order->customer_id = $customerResponse['data']['id'];
        $order->customer_name = $customerResponse['data']['name'];
        $order->menu_id = $menuData['id'];
        $order->menu_name = $menuData['name'];
        $order->price = $menuData['price'];
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil diperbarui',
            'data' => $order,
        ]);
    }

    public function destroy($id)
    {
        // Mencari order berdasarkan ID
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan',
            ], 404);
        }

        // Menghapus order
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dihapus',
        ]);
    }
}
