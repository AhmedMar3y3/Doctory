<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Specialization;

class OfferController extends Controller
{
    ////////////////////user methods/////////////////////
    public function getAll()
    {
        $offers = Offer::with(['city', 'specialization'])->get();
        return response()->json($offers);
    }
    public function show($id)
    {
        $offer = Offer::with(['city', 'specialization'])->findOrFail($id);
        return response()->json($offer);
    }

    ////////////////////admin methods/////////////////////
    public function index()
    {
        $offers = Offer::with(['city', 'specialization'])->get();
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        $cities = City::all();
        $specializations = Specialization::all();
        return view('admin.offers.create', compact('cities', 'specializations'));
    }

    public function store(StoreOfferRequest $request)
    {
        $validated = $request->validated();
        $city = City::where('name', $validated['city'])->firstOrFail();
        $specialization = Specialization::where('name', $validated['specialization'])->firstOrFail();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }
        $offer = Offer::create(array_merge($validated, [
            'city_id' => $city->id,
            'specialization_id' => $specialization->id,
        ]));

        return redirect()->route('admin.offers.index')->with('success', 'Offer created successfully.');
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        $cities = City::all();
        $specializations = Specialization::all();
        return view('admin.offers.edit', compact('offer', 'cities', 'specializations'));
    }

    public function update(UpdateOfferRequest $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $validated = $request->validated();
        $updateData = [];
        if ($request->hasFile('image')) {
            $updateData['image'] = $request->file('image')->store('images', 'public');
        }
        foreach (['title', 'OldPrice', 'NewPrice', 'address'] as $field) {
            if (array_key_exists($field, $validated)) {
                $updateData[$field] = $validated[$field];
            }
        }
        foreach (['city' => 'city_id', 'specialization' => 'specialization_id'] as $field => $foreignKey) {
            if (isset($validated[$field])) {
                $model = $field === 'city' ? City::class : Specialization::class;
                $instance = $model::where('name', $validated[$field])->firstOrFail();
                $updateData[$foreignKey] = $instance->id;
            }
        }

        $offer->update($updateData);
        return redirect()->route('admin.offers.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();
        return redirect()->route('admin.offers.index')->with('success', 'Offer deleted successfully.');
    }

}
