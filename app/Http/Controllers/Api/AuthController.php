<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\AdminProductAddedNotification;
use App\Mail\ProductAddedSuccessfully;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    use ApiResponses;

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'role' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     }

    //     $credentials = $request->only('email', 'password');
    //     $role = $request->input('role');

    //     $user = User::where('email', $credentials['email'])
    //     ->where('role', $role)->whereNull('deleted_at')->first();
    //     if($user){
    //     if($request->role == 3)
    //     {
    //         if ($user && Auth::attempt($credentials)) {
    //             $token = $user->createToken('Personal Access Token')->accessToken;
    //             $cartnumber = $request->input('cartnumber') ?? session()->get('cartnumber');
    //             if ($cartnumber) {
    //                 $guest_cart = Cart::where('cart_number', $cartnumber)->whereNull('customer_id')->first();

    //                 if ($guest_cart) {
    //                     // Assign guest cart to the registered user
    //                     $guest_cart->customer_id = $user->id;
    //                     $guest_cart->save();
        
    //                     // Update session cartnumber
    //                     session(['cartnumber' => $guest_cart->cart_number]);
    //                 }
    //             } 
                
    //             $success['token'] = $token;
    //             $success['userDetails'] =  $user;
    //             $success['cart_number'] = $cartnumber;
    //             $message = "Welcome {$user->name}, You have successfully logged in. Grab the latest DealsMachi offers now!";
    //         }else{
    //             return $this->error('Invalid email or password. Please check your credentials and try again.,Email.', ['error' => 'Invalid email or password. Please check your credentials and try again.,Email']);
    //         }
    //     }elseif($request->role == 2)
    //     {
    //         if ($user && Auth::attempt($credentials)) {
    //             $token = $user->createToken('Personal Access Token')->accessToken;
    //             $referreralCode = 'DMR500' . $user->id;
                
    //             $success['referrer_code'] = $referreralCode;
    //             $success['token'] = $token;
    //             $success['userDetails'] =  $user;
    //             $message = 'LoggedIn Successfully!';
    //         }else{
    //             return $this->error('Invalid email or password. Please check your credentials and try again.,Email.', ['error' => 'Invalid email or password. Please check your credentials and try again.,Email']);
    //         }
    //     }else{
    //         if ($user && Auth::attempt($credentials)) {
    //             $token = $user->createToken('Personal Access Token')->accessToken;
    //         }else{
    //             return $this->error('Invalid email or password. Please check your credentials and try again.,Email.', ['error' => 'Invalid email or password. Please check your credentials and try again.,Email']);
    //         }
            
    //         $success['token'] = $token;
    //         $success['userDetails'] =  $user;
    //         $message = 'LoggedIn Successfully!';
    //     }
    //     }else{
    //         return $this->error('User not registered, Please register a new account.', 404);
    //     }


    //     return $this->success($message, $success);
    // }
    
        public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        $user = User::where('email', $credentials['email'])
            ->where('role', $role)
            ->whereNull('deleted_at')
            ->first();

        if (!$user) {
            return $this->error('User not registered, Please register a new account.', 404);
        }

        if (!Auth::attempt($credentials)) {
            return $this->error('Invalid email or password. Please check your credentials and try again.', ['error' => 'Invalid email or password.']);
        }

        $token = $user->createToken('Personal Access Token')->accessToken;
        $cartnumber = $request->input('cartnumber') ?? session()->get('cartnumber');

        $existing_cart = Cart::where('customer_id', $user->id)->first();

        $guest_cart = $cartnumber ? Cart::where('cart_number', $cartnumber)->whereNull('customer_id')->first() : null;

        if ($existing_cart && $guest_cart) {
            foreach ($guest_cart->items as $item) {
                $existing_cart_item = CartItem::where('cart_id', $existing_cart->id)
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existing_cart_item) {
                    $existing_cart_item->quantity += $item->quantity;
                    $existing_cart_item->save();
                } else {
                    $item->cart_id = $existing_cart->id;
                    $item->save();
                }
            }

            // Update totals
            $existing_cart->update([
                'item_count' => $existing_cart->item_count + $guest_cart->item_count,
                'quantity' => $existing_cart->quantity + $guest_cart->quantity,
                'total' => $existing_cart->total + $guest_cart->total,
                'discount' => $existing_cart->discount + $guest_cart->discount,
                'shipping' => $existing_cart->shipping + $guest_cart->shipping,
                'packaging' => $existing_cart->packaging + $guest_cart->packaging,
                'handling' => $existing_cart->handling + $guest_cart->handling,
                'taxes' => $existing_cart->taxes + $guest_cart->taxes,
                'grand_total' => $existing_cart->grand_total + $guest_cart->grand_total,
                'shipping_weight' => $existing_cart->shipping_weight + $guest_cart->shipping_weight,
            ]);

            $guest_cart->delete();

            $final_cart = $existing_cart;
        } elseif (!$existing_cart) {
            if ($guest_cart) {
                $guest_cart->update(['customer_id' => $user->id]);
                $final_cart = $guest_cart;
            } else {
                $final_cart = (object) [
                    'id' => null,
                    'cart_number' => $request->cartnumber,
                ];
            }
        } else {
            // Use existing user cart
            $final_cart = $existing_cart;
        }

        // Update session cartnumber
        session(['cartnumber' => $final_cart->cart_number]);

        // Response Data
        $success = [
            'token' => $token,
            'userDetails' => $user,
            'cart_number' => $final_cart->cart_number,
            'cart_id' => $final_cart->id
        ];

        $message = "Welcome {$user->name}, You have successfully logged in. Grab the latest DealsMachi offers now!";

        return $this->success($message, $success);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('role', $request->role);
                }),
            ],
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'referral_code' => $request->referral_code,
            'type' => $request->type
        ]);

        Auth::login($user);

        $referrerCode = 'DMR500' . $user->id;
        $token = $user->createToken('Personal Access Token')->accessToken;

        // Handle cart assignment
        $cartnumber = $request->input('cartnumber') ?? session()->get('cartnumber');

        if ($cartnumber) {
            $guest_cart = Cart::where('cart_number', $cartnumber)->whereNull('customer_id')->first();

            if ($guest_cart) {
                // Assign guest cart to the registered user
                $guest_cart->customer_id = $user->id;
                $guest_cart->save();

                // Update session cartnumber
                session(['cartnumber' => $guest_cart->cart_number]);
            }
        }

        $success['token'] = $token;
        $success['userDetails'] = $user;
        $success['referrer_code'] = $referrerCode;
        $success['cart_number'] = $cartnumber;

        return $this->success('Registered Successfully!', $success);
    }


    public function shopregistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:shops,name',
            'company_registeration_no' => 'required|string',
            'legal_name' => 'required|string',
            'slug' => 'required|unique:shops,slug',
            'email' => 'required|email|unique:shops,email,',
            'description' => 'required|string',
            'external_url' => 'nullable',
            'mobile' => 'required|string|unique:shops,mobile',
            'street' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'country' => 'nullable|string'
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
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $Shop = Shop::create($request->all());

        $user = User::where('id', $Shop->owner_id)->update(['shop_id' => $Shop->id]);

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

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        $resetLink = "https://dealsmachi.com/dealsmachiVendor/resetpassword?token=" . $token . "&email=" . urlencode($request->email);

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

    public function verifyAccount($id)
    {
        $user = User::find($id);
        $shop = Shop::where('owner_id',$user->id)->first();
        $product = Product::where('shop_id',$shop->id)->latest()->first();

        if ($user && !$user->email_verified_at) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            Mail::to($shop->email)->send(new ProductAddedSuccessfully($shop,$product));

            $adminEmail = 'info@dealslah.com';

            Mail::to($adminEmail)->send(new AdminProductAddedNotification($user, $product));

            return response()->json(['message' => 'Email verified successfully.']);
        }

        return response()->json(['message' => 'User not found or already verified.'], 404);
    }
    
    public function socialLoginResponse(Request $request, $socialprovider)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'profile_id' => 'required|string',
                'role'=> 'required|string',
            ]);

            $findUser = User::where('auth_provider', $socialprovider)
                ->where('auth_provider_id', $validatedData['profile_id'])
                ->first();

            if ($findUser) {
                Auth::login($findUser);
                $message = "Welcome {$findUser->name}, You have successfully logged in. \nGrab the latest Dealslah offers now!";
                $loggedInUser = $findUser;
            } else {
                $existingUser = User::where('email', $validatedData['email'])->first();

                if ($existingUser) {
                    Auth::login($existingUser);
                    $message = "Welcome {$existingUser->name}, You have successfully logged in. \nGrab the latest Dealslah offers now!";
                    $loggedInUser = $existingUser;
                } else {
                    $newUser = User::create([
                        'name' => $validatedData['name'],
                        'email' => $validatedData['email'],
                        'auth_provider_id' => $validatedData['profile_id'],
                        'auth_provider' => $socialprovider,
                        'password' => Hash::make('12345678'),
                        'role' => $validatedData['role']
                    ]);

                    Auth::login($newUser);
                    $message = "Welcome {$newUser->name}, You have successfully registered. \nGrab the latest Dealslah offers now!";
                    $loggedInUser = $newUser;
                }
            }

            // Generate token
            $token = $loggedInUser->createToken('Personal Access Token')->accessToken;

            // Handle cart merging
            $cartnumber = $request->input('cartnumber') ?? session()->get('cartnumber');
            $existing_cart = Cart::where('customer_id', $loggedInUser->id)->first();
            $guest_cart = $cartnumber ? Cart::where('cart_number', $cartnumber)->whereNull('customer_id')->first() : null;

            if ($existing_cart && $guest_cart) {
                foreach ($guest_cart->items as $item) {
                    $existing_cart_item = CartItem::where('cart_id', $existing_cart->id)
                        ->where('product_id', $item->product_id)
                        ->first();

                    if ($existing_cart_item) {
                        $existing_cart_item->quantity += $item->quantity;
                        $existing_cart_item->save();
                    } else {
                        $item->cart_id = $existing_cart->id;
                        $item->save();
                    }
                }

                // Update totals
                $existing_cart->update([
                    'item_count' => $existing_cart->item_count + $guest_cart->item_count,
                    'quantity' => $existing_cart->quantity + $guest_cart->quantity,
                    'total' => $existing_cart->total + $guest_cart->total,
                    'discount' => $existing_cart->discount + $guest_cart->discount,
                    'shipping' => $existing_cart->shipping + $guest_cart->shipping,
                    'packaging' => $existing_cart->packaging + $guest_cart->packaging,
                    'handling' => $existing_cart->handling + $guest_cart->handling,
                    'taxes' => $existing_cart->taxes + $guest_cart->taxes,
                    'grand_total' => $existing_cart->grand_total + $guest_cart->grand_total,
                    'shipping_weight' => $existing_cart->shipping_weight + $guest_cart->shipping_weight,
                ]);

                $guest_cart->delete();
                $final_cart = $existing_cart;
            } elseif (!$existing_cart) {
                if ($guest_cart) {
                    $guest_cart->update(['customer_id' => $loggedInUser->id]);
                    $final_cart = $guest_cart;
                } else {
                    $final_cart = (object)[
                        'id' => null,
                        'cart_number' => $cartnumber,
                    ];
                }
            } else {
                $final_cart = $existing_cart;
            }

            // Update session cart number
            session(['cartnumber' => $final_cart->cart_number]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'token' => $token,
                'user' => $loggedInUser,
                'cart_number' => $final_cart->cart_number,
                'cart_id' => $final_cart->id,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
