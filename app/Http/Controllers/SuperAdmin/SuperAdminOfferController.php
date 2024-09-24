<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\City;
use App\Models\Specialization;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;

class SuperAdminOfferController extends Controller
{

    ////////////////////admin methods/////////////////////
    public function loadOffers()
{
    if (auth('superadmin')->check()) {
        $offers = Offer::with(['city', 'specialization'])->get();
    } elseif (auth('admin')->check()) {
        $adminId = auth('admin')->id();
        $offers = Offer::with(['city', 'specialization'])
            ->where('admin_id', $adminId)
            ->get();
    } else {
        abort(403, 'Unauthorized');
    }

    return view('superadmin.offers.index', compact('offers'));
}


    public function createOffers()
    {
        $cities = City::all();
        $specializations = Specialization::all();
        return view('superadmin.offers.create', compact('cities', 'specializations'));
    }

    public function storeOffers(StoreOfferRequest $request)
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
            'admin_id' => null,
        ]));

        return redirect()->route('superadmin.offers.index')->with('success', 'Offer created successfully.');
    }

    public function editOffers($id)
    {
        $offer = Offer::findOrFail($id);
        $cities = City::all();
        $specializations = Specialization::all();
        return view('superadmin.offers.edit', compact('offer', 'cities', 'specializations'));
    }

    public function updateOffers(UpdateOfferRequest $request, $id)
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
        return redirect()->route('superadmin.offers.index')->with('success', 'Offer updated successfully.');
    }

    public function deleteOffers($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();
        return redirect()->route('superadmin.offers.index')->with('success', 'Offer deleted successfully.');
    }

}
