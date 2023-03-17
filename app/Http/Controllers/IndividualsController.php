<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Individual;
use Illuminate\Http\Request;

class IndividualsController extends Controller
{
    public function index()
    {
        try {
            $individuals = Individual::with('contact_address', 'billing_address')->get();
            return response()->json($individuals);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'phone' => 'required|string|max:20',
            'billing_address.street' => 'required|string|max:50',
            'billing_address.city' => 'required|string|max:50',
            'billing_address.post_code' => 'required|string|max:10',
            'contact_address.street' => 'string|max:50',
            'contact_address.city' => 'string|max:50',
            'contact_address.post_code' => 'string|max:10',
        ]);


        try {
            $billing_address = new Address();
            $billing_address->street = $request->input('billing_address.street');
            $billing_address->city = $request->input('billing_address.city');
            $billing_address->post_code = $request->input('billing_address.post_code');
            $billing_address->save();

            if ($request['contact_address'] !== null) {
                $contact_address = new Address();
                $contact_address->street = $request->input('contact_address.street');
                $contact_address->city = $request->input('contact_address.city');
                $contact_address->post_code = $request->input('contact_address.post_code');
                $contact_address->save();
            }

            $individual = new Individual();
            $individual->name = $request->input('name');
            $individual->surname = $request->input('surname');
            $individual->email = $request->input('email');
            $individual->phone = $request->input('phone');
            $individual->id_billing_address = $billing_address->id;

            if ($request['contact_address'] !== null) {
                $individual->id_contact_address = $contact_address->id;
            }
            $individual->save();

            return response()->json(['message' => 'Individual created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to create individual'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'phone' => 'required|string|max:20',
            'billing_address.street' => 'required|string|max:50',
            'billing_address.city' => 'required|string|max:50',
            'billing_address.post_code' => 'required|string|max:10',
            'contact_address.street' => 'string|max:50',
            'contact_address.city' => 'string|max:50',
            'contact_address.post_code' => 'string|max:10',
        ]);

        try {

            $individual = Individual::findOrFail($id);

            $billing_address = Address::findOrFail($individual->id_billing_address);
            $billing_address->street = $request->input('billing_address.street');
            $billing_address->city = $request->input('billing_address.city');
            $billing_address->post_code = $request->input('billing_address.post_code');
            $billing_address->save();

            if ($request['contact_address'] !== null) {
                $contact_address = Address::find($individual->id_contact_address);

                if ($contact_address === null) {
                    $contact_address = new Address();
                }

                $contact_address->street = $request->input('contact_address.street');
                $contact_address->city = $request->input('contact_address.city');
                $contact_address->post_code = $request->input('contact_address.post_code');
                $contact_address->save();
            }

            $individual->name = $request->input('name');
            $individual->surname = $request->input('surname');
            $individual->email = $request->input('email');
            $individual->phone = $request->input('phone');
            $individual->id_billing_address = $billing_address->id;

            if ($request['contact_address'] !== null) {
                $individual->id_contact_address = $contact_address->id;
            }
            $individual->save();

            return response()->json(['message' => 'Individual updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to update individual'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Individual::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'Individual deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete individual'], 500);
        }
    }
}
