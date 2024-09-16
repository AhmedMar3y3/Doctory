<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Storage;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $pharmacies = Pharmacy::all();
        return response()->json($pharmacies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        $pharmacies = Pharmacy::all();
        return view('admin.pharmacies.index', compact('pharmacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pharmacies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('pharmacies', 'public');

        $pharmacy = Pharmacy::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.pharmacies.index')->with('success', 'Pharmacy created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        return view('admin.pharmacies.edit', compact('pharmacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pharmacy = Pharmacy::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($pharmacy->image);
            $imagePath = $request->file('image')->store('pharmacies', 'public');
            $pharmacy->image = $imagePath;
        }

        $pharmacy->name = $validated['name'] ?? $pharmacy->name;
        $pharmacy->phone = $validated['phone'] ?? $pharmacy->phone;

        $pharmacy->save();

        return redirect()->route('admin.pharmacies.index')->with('success', 'Pharmacy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        Storage::disk('public')->delete($pharmacy->image);

        $pharmacy->delete();
        return redirect()->route('admin.pharmacies.index')->with('success', 'Pharmacy deleted successfully.');
    }
}

