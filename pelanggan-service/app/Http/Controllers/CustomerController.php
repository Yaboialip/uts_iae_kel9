<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email',
            ]);
    
            $customer = Customer::create($validated);
    
            return response()->json([
                'success' => true,
                'data' => $customer
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }
    }
    

    public function update(Request $request, $id)
{
    try {
        // Cari customer berdasarkan ID
        $customer = Customer::find($id);

        // Kalau tidak ketemu
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan',
            ], 404);
        }

        // Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
        ]);

        // Update data
        $customer->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil diupdate',
            'data' => $customer
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Balas jika validasi gagal
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Catch error umum lainnya
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function destroy($id)
{
    try {
        $customer = Customer::find($id);

        // Kalau customer tidak ditemukan
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan',
            ], 404);
        }

        // Hapus customer
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dihapus',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menghapus customer',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
