<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function index($user_id)
    {
        $addresses = Address::where('user_id', $user_id)->get();
        return view('addresses.index', compact('addresses'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|string|max:200',
            'email'       => 'required|email|max:200',
            'phone'       => 'required|digits:10',
            'postalcode'  => 'required|digits:6',
            'address'     => 'required|string',
            'type'         => 'required|string',
            'default'      => 'nullable|boolean',
        ], [
            'first_name.required'    => 'Please provide your first name.',
            'first_name.string'      => 'First name must be a valid text.',
            'first_name.max'         => 'First name may not exceed 200 characters.',
            'email.required'         => 'Please provide an email address.',
            'email.email'            => 'Please provide a valid email address.',
            'email.max'              => 'Email may not exceed 200 characters.',
            'phone.required'         => 'Please provide a phone number.',
            'phone.digits'           => 'Phone number must be exactly 10 digits.',
            'postalcode.required'    => 'Please provide a postal code.',
            'postalcode.digits'      => 'Postal code must be exactly 6 digits.',
            'address.required'       => 'Please provide an address.',
            'address.string'         => 'Address must be a valid text.',
            'type.required'          => 'Please provide the address type.',
            'type.string'            => 'Address type must be a valid text.',
        ]);

        if ($request->has('default') && $request->default == 1) {
            Address::where('user_id', Auth::id())
                ->where('default', 1)
                ->update(['default' => 0]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $addressData = $request->all();
        $addressData['user_id'] = Auth::id();

        $addressData['default'] = $request->has('default') ? 1 : 0;

        $address = Address::create($addressData);

        return response()->json([
            'success' => true,
            'message' => 'Address Created Successfully!',
            'address' => $address
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $address = Address::findOrFail($id);
        return view('addresses.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function changeSelectedId(Request $request)
    {
        $selectedId = $request->input('selected_id');

        if (!$selectedId) {
            return response()->json(['success' => false, 'message' => 'No address selected.'], 400);
        }

        session(['selectedId' => $selectedId]);

        $selectedAddress = Address::find($selectedId);

        return response()->json(['success' => true, 'selectedId' => $selectedId, 'selectedAddress' => $selectedAddress]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|string|max:200',
            'email'       => 'required|email|max:200',
            'phone'       => 'required|digits:10',
            'postalcode'  => 'required|digits:6',
            'address'     => 'required|string',
            'type'        => 'required|string',
            'default'     => 'nullable|boolean'
        ], [
            'first_name.required'    => 'Please provide your first name.',
            'first_name.string'      => 'First name must be a valid text.',
            'first_name.max'         => 'First name may not exceed 200 characters.',
            'email.required'         => 'Please provide an email address.',
            'email.email'            => 'Please provide a valid email address.',
            'email.max'              => 'Email may not exceed 200 characters.',
            'phone.required'         => 'Please provide a phone number.',
            'phone.digits'           => 'Phone number must be exactly 10 digits.',
            'postalcode.required'    => 'Please provide a postal code.',
            'postalcode.digits'      => 'Postal code must be exactly 6 digits.',
            'address.required'       => 'Please provide an address.',
            'address.string'         => 'Address must be a valid text.',
            'type.required'          => 'Please provide the address type.',
            'type.string'            => 'Address type must be a valid text.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $address = Address::where('id', $request->address_id)->where('user_id', Auth::id())->first();

        if (!$address) {
            return redirect()->back()->with('error', 'Address not found!');
        }

        $default = $request->has('default') ? $request->default : $request->default_hidden;

        if ($default == "1") {
            Address::where('user_id', Auth::id())
                ->where('default', 1)
                ->where('id', '!=', $request->address_id)
                ->update(['default' => 0]);
        }

        $address->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'postalcode' => $request->postalcode,
            'address'    => $request->address,
            'state'      => $request->state,
            'city'       => $request->city,
            'type'       => $request->type,
            'unit'       => $request->unit,
            'default'    => $default,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address Updated Successfully!',
            'address' => $address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$address) {
            return response()->json(['success' => false, 'message' => 'Address not found or unauthorized action!'], 404);
        }

        $address->delete();

        return response()->json(['success' => true, 'message' => 'Address Deleted Successfully!'], 200);
    }
}
