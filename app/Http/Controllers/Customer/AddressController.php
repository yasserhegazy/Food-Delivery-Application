<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('customer.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('customer.addresses.form');
    }

    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();

        if ($request->is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Address added successfully.');
    }

    public function edit(\App\Models\Address $address)
    {
        $this->authorize('update', $address);
        return view('customer.addresses.form', compact('address'));
    }

    public function update(StoreAddressRequest $request, \App\Models\Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validated();

        if ($request->is_default) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(\App\Models\Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return redirect()->route('customer.addresses.index')->with('success', 'Address deleted successfully.');
    }
}
