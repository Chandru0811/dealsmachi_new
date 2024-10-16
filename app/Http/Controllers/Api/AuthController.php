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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

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

        return $this->error('Invalid email or password. Please check your credentials and try again.,Email.', ['error' => 'Invalid email or password. Please check your credentials and try again.,Email']);
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

        return $this->success('Vendor Registered Successfully!', $user);
    }

    public function shopregistration(Request $request)
    {
        $user_id = Auth::id();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:shops,name',
            'company_registeration_no' => 'required|string',
            'legal_name' => 'required|string',
            'slug' => 'required|unique:shops,slug',
            'email' => 'required|email|unique:shops,email,',
            'description' => 'required|string',
            'external_url' => 'nullable|url',
            'mobile' => 'required|string|unique:shops,mobile',
            'street' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string'
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
            'street.required' => 'Street is required',
            'zip_code.required' => 'Zip Code is required',
            'country.required' => 'Country is required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $Shop = Shop::create($request->all());

        $user = User::where('id', $user_id)->update(['shop_id' => $Shop->id]);

        return $this->success('Shop Registered Successfully!', $Shop);
    }

    public function logout(Request $request)
    {
        // Get the authenticated user's token
        $token = $request->user()->token();

        // Revoke the token
        $token->revoke();

        return $this->ok('logged Out Successfully!');
    }

    public function forgetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists'   => 'The email does not exist.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();
        $username = $user->name;

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);


        $resetLink = "http://127.0.0.1:8000/resetpassword?token=" . $token . "&email=" . urlencode($request->email);

        Mail::send('email.forgotPassword', ['resetLink' => $resetLink, 'name' => $username, 'token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });        

        return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }

    public function resetpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return response()->json(['message' => 'Invalid Token']);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return response()->json(['message' => 'Your password has been changed!']);
    }
}
