<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::all());
    }

    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan'], 404);
        }

        return response()->json($menu);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 400);
    }

    $menu = Menu::create($request->only('name', 'description', 'price'));

    return response()->json([
        'success' => true,
        'message' => 'Menu berhasil ditambahkan',
        'data' => $menu,
    ]);
}

public function update(Request $request, $id)
{
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json([
            'success' => false,
            'message' => 'Menu tidak ditemukan',
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|required|string',
        'price' => 'sometimes|required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 400);
    }

    $menu->update($request->only('name', 'description', 'price'));

    return response()->json([
        'success' => true,
        'message' => 'Menu berhasil diperbarui',
        'data' => $menu
    ]);
}

public function destroy($id)
{
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json([
            'success' => false,
            'message' => 'Menu tidak ditemukan',
        ], 404);
    }

    $menu->delete();

    return response()->json([
        'success' => true,
        'message' => 'Menu berhasil dihapus',
    ]);
}
}