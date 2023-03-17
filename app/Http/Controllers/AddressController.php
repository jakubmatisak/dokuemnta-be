<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{

    public function index()
    {
        try {
            $addresses = Address::all();
            return response()->json(['addresses' => $addresses], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'post_code' => 'required|string|max:10',
        ]);

        try {
            $address = new Address();
            $address->street = $request->input('street');
            $address->city = $request->input('city');
            $address->post_code = $request->input('post_code');
            $address->save();

            return response()->json(['message' => 'Address created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to create address'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'post_code' => 'required|string|max:10',
        ]);

        try {
            $address = Address::findOrFail($id);
            $address->street = $request->input('street');
            $address->city = $request->input('city');
            $address->post_code = $request->input('post_code');
            $address->save();

            return response()->json(['message' => 'Address updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to update address'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $address = Address::findOrFail($id);
            $address->delete();

            return response()->json(['message' => 'Address deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete address'], 500);
        }
    }
}

