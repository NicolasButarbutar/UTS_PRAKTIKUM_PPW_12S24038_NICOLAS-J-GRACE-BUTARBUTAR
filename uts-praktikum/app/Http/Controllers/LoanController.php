<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('category');

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

        $Loan = $query->paginate(6)->withQueryString();
        $categories = Category::all();

        return view('loan.index', compact('loan', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('loan.create', compact('categories'));
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
            $path = $file->storeAs('loan', $filename, 'public');
            $validated['image_path'] = $path;
        }

        Loan::create($validated);

        return redirect()->route('loan.index')
            ->with('success', 'Aset perangkat berhasil ditambahkan!');
    }

    public function show($id)
    {
        $loan = Loan::with('category')->findOrFail($id);
        return view('loan.show', compact('loan'));
    }
}