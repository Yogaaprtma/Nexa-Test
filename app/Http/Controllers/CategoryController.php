<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function createCategory()
    {
        return view('admin.category.create');
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string',
            'deskripsi' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('category.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Menyimpan gambar category product
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('category_images', 'public');
        }

        Category::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath
        ]);

        return redirect()->route('category.page')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string',
            'deskripsi' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('category.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $category = Category::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('category_images', 'public');
        } else {
            $gambarPath = $category->gambar;
        }

        $category->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath
        ]);

        return redirect()->route('category.page')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.page')->with('success', 'Kategori berhasil dihapus!');
    }
}
