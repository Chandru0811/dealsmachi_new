<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use App\Models\Shop;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;
            $success['token'] = $token;
            $success['userDetails'] =  $user;

            return $this->success('LoggedIn Successfully!', $success);
        }

        return $this->error('For Incorrect Password,Email.', ['error' => 'For Incorrect Password,Email']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 2
        ]);

        return $this->success('Vendor Registered Successfully!',$user);
    }

    public function shopregistration(Request $request)
    {
        $user_id = Auth::id();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:shops,name',
            'company_registeration_no'=>'required|string',
            'legal_name' => 'required|string',
            'slug' => 'required|unique:shops,slug',
            'email' => 'required|email|unique:shops,email,',
            'description' => 'required|string',
            'external_url' => 'nullable|url',
            'mobile' => 'required|string|unique:shops,mobile',
            'street' => 'required|string',
            'zip_code'=>'required|string',
            'country'=>'required|string'
        ], [
            'name.required' => 'The name field is required.',
            'company_registeration_no.required' => 'The company registeration number field is required.',
            'company_registeration_no.unique' => 'The company registeration number field is unique.',
            'legal_name.required' => 'The legal name field is required.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug must be unique.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email must be unique.',
            'description.required' => 'The description field is required.',
            'external_url.url' => 'The website URL must be a valid URL.',
            'mobile.required' => 'The mobile number  is required.',
            'mobile.unique' => 'Mobile number already exists.',
            'street.required'=>'Street is required',
            'zip_code.required'=>'Zip Code is required',
            'country.required'=>'Country is required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $Shop = Shop::create($request->all());

        $user = User::where('id',$user_id)->update(['shop_id' => $Shop->id]);

        return $this->success('Shop Registered Successfully!',$Shop);

    }
}
