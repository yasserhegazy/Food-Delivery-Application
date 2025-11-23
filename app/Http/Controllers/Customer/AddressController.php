<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Address added successfully.');
    }

    public function edit(\App\Models\Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }
        return view('customer.addresses.form', compact('address'));
    }

    public function update(Request $request, \App\Models\Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(\App\Models\Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('customer.addresses.index')->with('success', 'Address deleted successfully.');
    }
}
