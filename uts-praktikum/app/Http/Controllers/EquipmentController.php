<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('asset_code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $equipments = $query->paginate(6)->withQueryString();
        $categories = Category::all();

        return view('equipments.index', compact('equipments', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('equipments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_code' => 'required|unique:equipments,asset_code',
            'name' => 'required|min:5|max:150',
            'category_id' => 'required|exists:categories,id',
            'specification' => 'required',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'daily_rental_fee' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->hashName();
            $path = $file->storeAs('equipments', $filename, 'public');
            $validated['image_path'] = $path;
        }

        Equipment::create($validated);

        return redirect()->route('equipments.index')
            ->with('success', 'Aset perangkat berhasil ditambahkan!');
    }

    public function show($id)
    {
        $equipment = Equipment::with('category')->findOrFail($id);
        return view('equipments.show', compact('equipment'));
    }
}