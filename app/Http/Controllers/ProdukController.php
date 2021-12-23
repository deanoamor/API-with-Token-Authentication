<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{


    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $produk = Produk::all();
        return response()->json([
            'Status' => 'success',
            'Message' => 'Produk berhasil ditemukan',
            'Data' => $produk,
        ]);
    }


    public function indexspecific($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'Status' => 'error',
                'Message' => 'Produk tidak ditemukan',
            ]);
        }
        return response()->json([
            'Status' => 'success',
            'Message' => 'Produk berhasil ditemukan',
            'Data' => $produk,
        ]);
    }

    public function store(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'decs' => 'required|string',
                'jumlah' => 'required|integer',
                'harga' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $produk = Produk::create([
                'name' => $request->name,
                'decs' => $request->decs,
                'jumlah' => $request->jumlah,
                'harga' => $request->harga,
            ]);

            return response()->json([
                'Status' => 'success',
                'Message' => 'Produk berhasil ditambahkan',
                'Data' => $produk,
            ]);
        } catch (Exception $error) {
            return response()->json([
                'Status' => 'error',
                'Message' => 'Ada yang salah',
                'error' => $error,
            ]);
        }
    }

    public function update(request $request, $id)
    {

        try {

            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json(['message' => 'Produk tidak ditemukan!'], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'decs' => 'required|string',
                'jumlah' => 'required|integer',
                'harga' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $produk->update([
                'name' => $request->name,
                'decs' => $request->decs,
                'jumlah' => $request->jumlah,
                'harga' => $request->harga,
            ]);

            return response()->json([
                'Status' => 'success',
                'Message' => 'Produk berhasil diupdate',
                'Data' => $produk,
            ]);
        } catch (Exception $error) {
            return response()->json([
                'Status' => 'error',
                'Message' => 'Ada yang salah',
                'error' => $error,
            ]);
        }
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan!'], 404);
        }

        $produk->delete();
        return response()->json([
            'Status' => 'success',
            'Message' => 'Produk berhasil didelete',
        ]);
    }
}
