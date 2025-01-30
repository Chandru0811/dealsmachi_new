<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferrerDetail;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReferrerDetailController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $ReferrerDetails = ReferrerDetail::orderBy('id', 'desc')->get();

        return $this->success('Referrer Details Retrieved successfully.', $ReferrerDetails);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referrer_id'    => 'required|integer|exists:users,id',
            'referrer_name'  => 'required|string|max:255',
            'referrer_number' => 'required|string|max:20',
            'vendor_id'      => 'required|integer|exists:users,id',
            'vendor_name'    => 'required|string|max:255',
            'date'          => 'required|date',
            'amount'        => 'required|numeric|min:0',
        ], [
            'referrer_id.required'   => 'Referrer ID is required.',
            'referrer_id.integer'    => 'Referrer ID must be a valid number.',
            'referrer_id.exists'     => 'Referrer ID must exist in users table.',
            'vendor_id.exists'       => 'Vendor ID must exist in vendors table.',
            'amount.numeric'         => 'Amount must be a valid number.',
            'date.date'              => 'Please enter a valid date format.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $ReferrerDetails = ReferrerDetail::create($validatedData);

        return $this->success('Category Group Created Successfully!', $ReferrerDetails);
    }


    public function show(string $id)
    {
        $ReferrerDetails = ReferrerDetail::find($id);


        if (!$ReferrerDetails) {
            return $this->error('Referrer Details Not Found.', ['error' => 'Referrer Details Not Found']);
        }

        return $this->success('Referrer Details Retrived Succesfully!', $ReferrerDetails);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
