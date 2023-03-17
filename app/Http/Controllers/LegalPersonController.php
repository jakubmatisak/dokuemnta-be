<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\LegalPerson;
use App\Models\Office;
use Illuminate\Http\Request;

class LegalPersonController extends Controller
{
    public function index()
    {
        try {
            $legal_persons = LegalPerson::with('contact_address', 'billing_address', 'office.legal_person' )->get();
            return response()->json($legal_persons);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function existingLegalPersons()
    {
        try {
            $legal_persons = LegalPerson::all();
            return response()->json($legal_persons);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'registration_number' => 'required|string|max:10',
            'vat_number' => 'required|string|max:12',
            'tin' => 'required|string|max:10',
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

            $legal_person = new LegalPerson();
            $legal_person->name = $request->input('name');
            $legal_person->registration_number = $request->input('registration_number');
            $legal_person->vat_number = $request->input('vat_number');
            $legal_person->tin = $request->input('tin');
            $legal_person->id_billing_address = $billing_address->id;

            if ($request['contact_address'] !== null) {
                $legal_person->id_contact_address = $contact_address->id;
            }
            $legal_person->save();

            if( $request->input('id_office') !== null) {
                $office = new Office();
                $office->id_legal_person = $legal_person->id;
                $office->id_office = $request->input('id_office');
                $office->save();
            }

            return response()->json(['message' => 'Legal person created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to create legal person '], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'registration_number' => 'required|string|max:10',
            'vat_number' => 'required|string|max:12',
            'tin' => 'required|string|max:10',
            'billing_address.street' => 'required|string|max:50',
            'billing_address.city' => 'required|string|max:50',
            'billing_address.post_code' => 'required|string|max:10',
            'contact_address.street' => 'string|max:50',
            'contact_address.city' => 'string|max:50',
            'contact_address.post_code' => 'string|max:10',
        ]);

        try {

            $legal_person = LegalPerson::findOrFail($id);

            $billing_address = Address::findOrFail($legal_person->id_billing_address);
            $billing_address->street = $request->input('billing_address.street');
            $billing_address->city = $request->input('billing_address.city');
            $billing_address->post_code = $request->input('billing_address.post_code');
            $billing_address->save();

            if ($request['contact_address'] !== null) {
                $contact_address = Address::find($legal_person->id_contact_address);

                if ($contact_address === null) {
                    $contact_address = new Address();
                }

                $contact_address->street = $request->input('contact_address.street');
                $contact_address->city = $request->input('contact_address.city');
                $contact_address->post_code = $request->input('contact_address.post_code');
                $contact_address->save();
            }

            $legal_person->name = $request->input('name');
            $legal_person->registration_number = $request->input('registration_number');
            $legal_person->vat_number = $request->input('vat_number');
            $legal_person->tin = $request->input('tin');
            $legal_person->id_billing_address = $billing_address->id;

            if ($request['contact_address'] !== null) {
                $legal_person->id_contact_address = $contact_address->id;
            }
            $legal_person->save();

            if( $request->input('id_office') !== null) {
                $office = Office::where('id_office', $legal_person->id)->first();

                if ($office === null) {
                    $office = new Office();
                }

                $office->id_legal_person = $legal_person->id;
                $office->id_office = $request->input('id_office');
                $office->save();
            }

            return response()->json(['message' => 'Individual updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to update individual'], 500);
        }
    }

    public function destroy($id)
    {
       try {
            $legal_person = LegalPerson::findOrFail($id);
            $legal_person->delete();

            Office::where('id_legal_person', $id)->delete();

            return response()->json(['message' => 'Legal person deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete legal person'], 500);
        }
    }
}
