<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryGroup;
use App\Models\DealCategory;
use App\Models\Category;
use App\Traits\ApiResponses;
use App\Models\Product;
use App\Models\Bookmark;
use App\Models\CouponCodeUsed;
use App\Models\DealClick;
use App\Models\Dealenquire;
use App\Models\DealShare;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DealViews;

class HomeController extends Controller
{
    use ApiResponses;

    public function index(Request $request)
    {
        $categoryGroups = CategoryGroup::where('active', 1)->with('categories')->take(10)->get();
        $hotpicks = DealCategory::where('active', 1)->get();
        $products = Product::where('active', 1)->with(['shop:id,city,shop_ratings'])->orderBy('created_at', 'desc')->get();

        $treandingdeals = DealViews::whereDate('viewed_at', Carbon::today())->get();
        $populardeals = DealViews::select('deal_id', DB::raw('count(*) as total_views'))->groupBy('deal_id')->limit(5)->orderBy('total_views', 'desc')->having('total_views', '>', 10)->get();
        $earlybirddeals = Product::where('active', 1)->whereDate('start_date', now())->get();
        $lastchancedeals = Product::where('active', 1)->whereDate('end_date', now())->get();
        $limitedtimedeals = Product::where('active', 1)->whereRaw('DATEDIFF(end_date, start_date) <= ?', [2])->get();


        $bookmarkedProducts = collect();

        if (Auth::check()) {
            $userId = Auth::id();
            $bookmarkedProducts = Bookmark::where('user_id', $userId)->pluck('deal_id');
        } else {
            $ipAddress = $request->ip();
            $bookmarkedProducts = Bookmark::where('ip_address', $ipAddress)->pluck('deal_id');
        }

        return view('home', compact('categoryGroups', 'hotpicks', 'products', 'bookmarkedProducts', 'treandingdeals', 'populardeals', 'earlybirddeals', 'lastchancedeals', 'limitedtimedeals'));
    }

    public function clickcounts(Request $request)
    {
        $dealId = $request->id;
        $userId = Auth::check() ? Auth::id() : null;
        $ipAddress = $request->ip();

        DealClick::create([
            'deal_id' => $dealId,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'clicked_at' => Carbon::now(),
        ]);

        return $this->ok('DealClicks Added Successfully!');
    }

    public function viewcounts(Request $request)
    {
        $dealId = $request->id;
        $userId = Auth::check() ? Auth::id() : null;
        $ipAddress = $request->ip();

        DealViews::create([
            'deal_id' => $dealId,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'viewed_at' => Carbon::now(),
        ]);

        return $this->ok('DealViews Added Successfully!');
    }

    public function productdescription($id, Request $request)
    {
        $this->viewcounts($request);

        $product = Product::with(['shop', 'shop.hour', 'shop.policy'])->where('id', $id)
            ->where('active', 1)
            ->first();

        if (!$product) {
            return redirect()->route('home')->with('error', 'Product not found or inactive.');
        }

        $bookmarkedProducts = collect();

        if (Auth::check()) {
            $userId = Auth::id();
            $bookmarkedProducts = Bookmark::where('user_id', $userId)->pluck('deal_id');
        } else {
            $ipAddress = $request->ip();
            $bookmarkedProducts = Bookmark::where('ip_address', $ipAddress)->pluck('deal_id');
        }

        $pageurl = url()->current();
        $pagetitle = $product->name;
        $pagedescription = $product->description;
        $pageimage = $product->image_url1;

        $shareButtons = \Share::page(
            $pageurl,
            $pagetitle
        )->facebook()->twitter()->linkedin()->whatsapp()->telegram();

        return view('productDescription', compact('product', 'bookmarkedProducts', 'shareButtons', 'pageurl', 'pagetitle', 'pagedescription', 'pageimage'));
    }

    public function dealcategorybasedproducts($slug, Request $request)
    {
        $shortBy = $request->input('short_by');
        if ($shortBy) {
            return redirect()->route('deals.categorybased', ['slug' => $shortBy] + $request->except('short_by'));
        }

        $perPage = $request->input('per_page', 10);
        $today = now()->toDateString();
        $deals = collect();

        $query = Product::where('active', 1)->with('shop:id,country,state,city,street,street2,zip_code,shop_ratings');

        if ($slug == 'trending') {
            $query->withCount(['views' => function ($query) use ($today) {
                $query->whereDate('viewed_at', $today);
            }])->orderBy('views_count', 'desc');
            $brands = $query->get()->pluck('brand')->filter(fn($brand) => !empty($brand))->unique()->sortBy(fn($brand) => strtolower($brand))->values();
            $discounts = $query->get()->pluck('discount_percentage')->map(fn($d) => round($d))->unique()->sort()->values();
            $shopIds = $query->get()->pluck('shop_id');
            $rating_items = Shop::whereIn('id', $shopIds)->select('shop_ratings')->distinct()->orderBy('shop_ratings', 'asc')->get();
        } elseif ($slug == 'popular') {
            $query->withCount('views')->orderBy('views_count', 'desc');
            $brands = $query->get()->pluck('brand')->filter(fn($brand) => !empty($brand))->unique()->sortBy(fn($brand) => strtolower($brand))->values();
            $discounts = $query->get()->pluck('discount_percentage')->map(fn($d) => round($d))->unique()->sort()->values();
            $shopIds = $query->get()->pluck('shop_id');
            $rating_items = Shop::whereIn('id', $shopIds)->select('shop_ratings')->distinct()->orderBy('shop_ratings', 'asc')->get();
        } elseif ($slug == 'early_bird') {
            $query->whereDate('start_date', now());
            $brands = $query->get()->pluck('brand')->filter(fn($brand) => !empty($brand))->unique()->sortBy(fn($brand) => strtolower($brand))->values();
            $discounts = $query->get()->pluck('discount_percentage')->map(fn($d) => round($d))->unique()->sort()->values();
            $shopIds = $query->get()->pluck('shop_id');
            $rating_items = Shop::whereIn('id', $shopIds)->select('shop_ratings')->distinct()->orderBy('shop_ratings', 'asc')->get();
        } elseif ($slug == 'last_chance') {
            $query->whereDate('end_date', now());
            $brands = $query->get()->pluck('brand')->filter(fn($brand) => !empty($brand))->unique()->sortBy(fn($brand) => strtolower($brand))->values();
            $discounts = $query->get()->pluck('discount_percentage')->map(fn($d) => round($d))->unique()->sort()->values();
            $shopIds = $query->get()->pluck('shop_id');
            $rating_items = Shop::whereIn('id', $shopIds)->select('shop_ratings')->distinct()->orderBy('shop_ratings', 'asc')->get();
        } elseif ($slug == 'limited_time') {
            $query->whereRaw('DATEDIFF(end_date, start_date) <= ?', [2]);
            $brands = $query->get()->pluck('brand')->filter(fn($brand) => !empty($brand))->unique()->sortBy(fn($brand) => strtolower($brand))->values();
            $discounts = $query->get()->pluck('discount_percentage')->map(fn($d) => round($d))->unique()->sort()->values();
            $shopIds = $query->get()->pluck('shop_id');
            $rating_items = Shop::whereIn('id', $shopIds)->select('shop_ratings')->distinct()->orderBy('shop_ratings', 'asc')->get();
        } elseif ($slug == 'nearby') {
            $user_latitude = $request->input('latitude');
            $user_longitude = $request->input('longitude');

            if (!isset($user_latitude) || !isset($user_longitude)) {
                return view('errors.locationError');
            }

            $shops = Shop::select(
                "shops.id",
                DB::raw("6371 * acos(cos(radians($user_latitude)) * cos(radians(shops.shop_lattitude)) * cos(radians(shops.shop_longtitude) - radians($user_longitude)) + sin(radians($user_latitude)) * sin(radians(shops.shop_lattitude))) AS distance")
            )->having('distance', '<=', 20)->orderBy('distance', 'asc')->get();

            $shopIds = $shops->pluck('id');
            $query->whereIn('shop_id', $shopIds);
            $brands = $query->get()->pluck('brand')->filter(fn($brand) => !empty($brand))->unique()->sortBy(fn($brand) => strtolower($brand))->values();
            $discounts = $query->get()->pluck('discount_percentage')->map(fn($d) => round($d))->unique()->sort()->values();
            $shopIds = $query->get()->pluck('shop_id');
            $rating_items = Shop::whereIn('id', $shopIds)->select('shop_ratings')->distinct()->orderBy('shop_ratings', 'asc')->get();
        }

        if ($request->has('brand') && is_array($request->brand)) {
            $query->whereIn('brand', $request->brand);
        }

        if ($request->has('discount') && is_array($request->discount)) {
            $discountTerms = $request->discount;
            $roundedDiscounts = array_map('round', $discountTerms);
            $query->whereIn(DB::raw('ROUND(discount_percentage)'), $roundedDiscounts);
        }

        if ($request->has('price_range')) {
            $priceRanges = $request->input('price_range');
            $query->where(function ($priceQuery) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    $cleanRange = str_replace(['$', ',', ' '], '', $range);
                    $priceRange = explode('-', $cleanRange);
                    $minPrice = isset($priceRange[0]) ? (float)$priceRange[0] : null;
                    $maxPrice = isset($priceRange[1]) ? (float)$priceRange[1] : null;
                    if ($maxPrice !== null) {
                        $priceQuery->orWhereBetween('discounted_price', [$minPrice, $maxPrice]);
                    } else {
                        $priceQuery->orWhere('discounted_price', '>=', $minPrice);
                    }
                }
            });
        }

        if ($request->has('rating_item') && is_array($request->rating_item)) {
            $ratings = $request->rating_item;
            $query->whereHas('shop', function ($q) use ($ratings) {
                $q->whereIn('shop_ratings', $ratings);
            });
        }
        
        $deals = $query->paginate($perPage);

        $label = match ($slug) {
            'trending' => 'TRENDING',
            'popular' => 'POPULAR',
            'early_bird' => 'EARLY BIRD',
            'last_chance' => 'LAST CHANCE',
            'limited_time' => 'LIMITED TIME',
            'nearby' => 'NEAR BY',
            default => '',
        };

        $deals->getCollection()->transform(function ($product) use ($label) {
            $product->label = $label;
            return $product;
        });

        $priceRanges = [];
        $priceStep = 2000;
        $minPrice = Product::min(DB::raw('LEAST(original_price, discounted_price)'));
        $maxPrice = Product::max(DB::raw('GREATEST(original_price, discounted_price)'));

        for ($start = $minPrice; $start <= $maxPrice; $start += $priceStep) {
            $end = $start + $priceStep;
            $priceRanges[] = [
                'label' => '$' . number_format($start, 2) . ' - $' . number_format($end, 2)
            ];
        }

        $shortby = DealCategory::where('active', 1)->get();
        $totaldeals = $deals->total();
        $bookmarkedProducts = collect();
        if (Auth::check()) {
            $userId = Auth::id();
            $bookmarkedProducts = Bookmark::where('user_id', $userId)->pluck('deal_id');
        } else {
            $ipAddress = $request->ip();
            $bookmarkedProducts = Bookmark::where('ip_address', $ipAddress)->pluck('deal_id');
        }

        return view('productfilter', compact('deals', 'brands', 'discounts', 'rating_items', 'priceRanges', 'shortby', 'totaldeals', 'bookmarkedProducts'));
    }

    public function subcategorybasedproducts(Request $request, $slug)
    {
        $perPage = $request->input('per_page', 10);
        $category = Category::where('slug', $slug)->first();

        $query = Product::with('shop')->whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
            ->where('active', 1);

        if ($request->has('brand') && is_array($request->brand)) {
            $query->whereIn('brand', $request->brand);
        }

        if ($request->has('discount') && is_array($request->discount)) {
            $discountTerms = $request->discount;
            if (count($discountTerms) > 0) {
                $roundedDiscounts = array_map('round', $discountTerms);
                $query->whereIn(DB::raw('ROUND(discount_percentage)'), $roundedDiscounts);
            }
        }

        if ($request->has('price_range')) {
            $priceRanges = $request->input('price_range');

            // Apply price range filters for each selected range
            $query->where(function ($priceQuery) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    // Clean and split the price range
                    $cleanRange = str_replace(['Rs', ',', ' '], '', $range);
                    $priceRange = explode('-', $cleanRange);

                    $minPrice = isset($priceRange[0]) ? (float)$priceRange[0] : null;
                    $maxPrice = isset($priceRange[1]) ? (float)$priceRange[1] : null;

                    // Apply the range filter
                    if ($maxPrice !== null) {
                        $priceQuery->orWhereBetween('discounted_price', [$minPrice, $maxPrice]);
                    } else {
                        $priceQuery->orWhere('discounted_price', '>=', $minPrice);
                    }
                }
            });
        }


        if ($request->has('rating_item') && is_array($request->rating_item)) {
            $ratings = $request->rating_item;
            if (!empty($ratings)) {
                $query->whereHas('shop', function ($q) use ($ratings) {
                    $q->whereIn('shop_ratings', $ratings);
                });
            }
        }

        if ($request->has('short_by')) {
            $shortby = $request->input('short_by');
            if ($shortby == 'trending') {
                $query->withCount(['views' => function ($viewQuery) {
                    $viewQuery->whereDate('viewed_at', now()->toDateString());
                }])->orderBy('views_count', 'desc');
            } elseif ($shortby == 'popular') {
                $query->withCount('views')->orderBy('views_count', 'desc');
            } elseif ($shortby == 'early_bird') {
                $query->whereDate('start_date', now());
            } elseif ($shortby == 'last_chance') {
                $query->whereDate('end_date', now());
            } elseif ($shortby == 'limited_time') {
                $query->whereRaw('DATEDIFF(end_date, start_date) <= ?', [2]);
            } elseif ($shortby == 'nearby') {
                $user_latitude = $request->input('latitude');
                $user_longitude = $request->input('longitude');

                if (!isset($user_latitude) || !isset($user_longitude)) {
                    return view('errors.locationError');
                }

                $shops = Shop::select(
                    "shops.id",
                    "shops.name",
                    DB::raw("6371 * acos(cos(radians(" . $user_latitude . "))
                            * cos(radians(shops.shop_lattitude))
                            * cos(radians(shops.shop_longtitude) - radians(" . $user_longitude . "))
                            + sin(radians(" . $user_latitude . "))
                            * sin(radians(shops.shop_lattitude))) AS distance")
                )
                    ->having('distance', '<=', 20)
                    ->orderBy('distance', 'asc')
                    ->get();

                $shopIds = $shops->pluck('id');

                $query->whereIn('shop_id', $shopIds);
            }
        }

        $deals = $query->paginate($perPage);

        $brands = Product::where('active', 1)->where('category_id', $category->id)->whereNotNull('brand')->where('brand', '!=', '')->distinct()->orderBy('brand', 'asc')->pluck('brand');
        $discounts = Product::where('active', 1)->where('category_id', $category->id)->pluck('discount_percentage')->map(function ($discount) {
            return round($discount);
        })->unique()->sort()->values();
        $rating_items = Shop::where('active', 1)->select('shop_ratings', DB::raw('count(*) as rating_count'))->groupBy('shop_ratings')->get();

        $priceRanges = [];
        $priceStep = 2000;
        $minPrice = Product::min(DB::raw('LEAST(original_price, discounted_price)'));
        $maxPrice = Product::max(DB::raw('GREATEST(original_price, discounted_price)'));

        for ($start = $minPrice; $start <= $maxPrice; $start += $priceStep) {
            $end = $start + $priceStep;

            if ($end > $maxPrice) {
                $priceRanges[] = [
                    'label' => 'Rs' . number_format($start, 2) . ' - Rs' . number_format($end, 2)
                ];
                break;
            }
            $priceRanges[] = [
                'label' => 'Rs' . number_format($start, 2) . ' - Rs' . number_format($end, 2)
            ];
        }

        $shortby = DealCategory::where('active', 1)->get();
        $totaldeals = $deals->total();
        $categorygroup = CategoryGroup::where('id', $category->category_group_id)->first();
        $bookmarkedProducts = collect();
        if (Auth::check()) {
            $userId = Auth::id();
            $bookmarkedProducts = Bookmark::where('user_id', $userId)->pluck('deal_id');
        } else {
            $ipAddress = $request->ip();
            $bookmarkedProducts = Bookmark::where('ip_address', $ipAddress)->pluck('deal_id');
        }

        return view('productfilter', compact('deals', 'brands', 'discounts', 'rating_items', 'priceRanges', 'shortby', 'totaldeals', 'category', 'categorygroup', 'bookmarkedProducts'));
    }

    public function search(Request $request)
    {
        $term = $request->input('q');
        $perPage = $request->input('per_page', 10);

        $query = Product::with('shop')->where('active', 1);

        if (!empty($term)) {
            $query->where(function ($subQuery) use ($term) {
                $subQuery->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhereHas('shop', function ($shopQuery) use ($term) {
                        $shopQuery->where('name', 'LIKE', '%' . $term . '%')
                            ->orWhere('country', 'LIKE', '%' . $term . '%')
                            ->orWhere('state', 'LIKE', '%' . $term . '%')
                            ->orWhere('city', 'LIKE', '%' . $term . '%')
                            ->orWhere('street', 'LIKE', '%' . $term . '%')
                            ->orWhere('street2', 'LIKE', '%' . $term . '%');
                    });
            });
        }

        if ($request->has('brand')) {
            $brandTerms = $request->input('brand');
            if (is_array($brandTerms) && count($brandTerms) > 0) {
                $query->whereIn('brand', $brandTerms);
            }
        }

        if ($request->has('discount')) {
            $discountTerm = $request->input('discount');
            if (is_array($discountTerm) && count($discountTerm) > 0) {
                $roundedDiscounts = array_map('round', $discountTerm);
                $query->whereIn(DB::raw('ROUND(discount_percentage)'), $roundedDiscounts);
            }
        }

        if ($request->has('rating_item') && is_array($request->rating_item)) {
            $ratings = $request->rating_item;
            if (!empty($ratings)) {
                $query->whereHas('shop', function ($q) use ($ratings) {
                    $q->whereIn('shop_ratings', $ratings);
                });
            }
        }

        if ($request->has('price_range')) {
            $priceRanges = $request->input('price_range');
            $query->where(function ($priceQuery) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    $cleanRange = str_replace(['$', ',', ' '], '', $range);
                    $priceRange = explode('-', $cleanRange);

                    $minPrice = isset($priceRange[0]) ? (float)$priceRange[0] : null;
                    $maxPrice = isset($priceRange[1]) ? (float)$priceRange[1] : null;

                    if ($maxPrice !== null) {
                        $priceQuery->orWhereBetween('discounted_price', [$minPrice, $maxPrice]);
                    } else {
                        $priceQuery->orWhere('discounted_price', '>=', $minPrice);
                    }
                }
            });
        }

        if ($request->has('short_by')) {
            $shortby = $request->input('short_by');
            if ($shortby == 'trending') {
                $query->withCount(['views' => function ($viewQuery) {
                    $viewQuery->whereDate('viewed_at', now()->toDateString());
                }])
                    ->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->orderBy('views_count', 'desc')
                    ->addSelect(DB::raw("'TRENDING' as label"));
            } elseif ($shortby == 'popular') {
                $query->withCount('views')
                    ->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->orderBy('views_count', 'desc')
                    ->addSelect(DB::raw("'POPULAR' as label"));
            } elseif ($shortby == 'early_bird') {
                $query->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->whereDate('start_date', now())
                    ->whereHas('shop')
                    ->select('*', DB::raw("'EARLY BIRD' as label"));
            } elseif ($shortby == 'last_chance') {
                $query->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->whereDate('end_date', now())
                    ->addSelect(DB::raw("'LAST CHANCE' as label"));
            } elseif ($shortby == 'limited_time') {
                $query->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->whereRaw('DATEDIFF(end_date, start_date) <= ?', [2])
                    ->select('*', DB::raw("'LIMITED TIME' as label"));
            } elseif ($shortby == 'nearby') {
                $user_latitude = $request->input('latitude');
                $user_longitude = $request->input('longitude');

                if (!isset($user_latitude) || !isset($user_longitude)) {
                    return view('errors.locationError');
                }

                $shops = Shop::select(
                    "shops.id",
                    "shops.name",
                    DB::raw("6371 * acos(cos(radians(" . $user_latitude . "))
                            * cos(radians(shops.shop_lattitude))
                            * cos(radians(shops.shop_longtitude) - radians(" . $user_longitude . "))
                            + sin(radians(" . $user_latitude . "))
                            * sin(radians(shops.shop_lattitude))) AS distance")
                )
                    ->having('distance', '<=', 20)
                    ->orderBy('distance', 'asc')
                    ->get();

                $shopIds = $shops->pluck('id');

                $query->whereIn('shop_id', $shopIds);
            }
        }

        $deals = $query->paginate($perPage);

        $brands = Product::where('active', 1)->whereNotNull('brand')->where('brand', '!=', '')->distinct()->orderBy('brand', 'asc')->pluck('brand');
        $discounts = Product::where('active', 1)->pluck('discount_percentage')->map(function ($discount) {
            return round($discount);
        })->unique()->sort()->values();
        $rating_items = Shop::where('active', 1)->select('shop_ratings', DB::raw('count(*) as rating_count'))->groupBy('shop_ratings')->get();

        $priceRanges = [];
        $priceStep = 2000;
        $minPrice = Product::min(DB::raw('LEAST(original_price, discounted_price)'));
        $maxPrice = Product::max(DB::raw('GREATEST(original_price, discounted_price)'));

        for ($start = $minPrice; $start <= $maxPrice; $start += $priceStep) {
            $end = $start + $priceStep;
            if ($end > $maxPrice) {
                $priceRanges[] = ['label' => '$' . number_format($start, 2) . ' - $' . number_format($end, 2)];
                break;
            }
            $priceRanges[] = ['label' => '$' . number_format($start, 2) . ' - $' . number_format($end, 2)];
        }

        $shortby = DealCategory::where('active', 1)->get();
        $totaldeals = $deals->total();
        $bookmarkedProducts = collect();
        if (Auth::check()) {
            $userId = Auth::id();
            $bookmarkedProducts = Bookmark::where('user_id', $userId)->pluck('deal_id');
        } else {
            $ipAddress = $request->ip();
            $bookmarkedProducts = Bookmark::where('ip_address', $ipAddress)->pluck('deal_id');
        }

        return view('productfilter', compact('deals', 'brands', 'discounts', 'rating_items', 'priceRanges', 'shortby', 'totaldeals', 'bookmarkedProducts'));
    }

    public function couponCodeCopied(Request $request)
    {
        $dealId = $request->id;
        $userId = Auth::check() ? Auth::id() : null;
        $ipAddress = $request->ip();

        CouponCodeUsed::create([
            'deal_id' => $dealId,
            'coupon_code' => $request->coupon_code,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'copied_at' => Carbon::now(),
        ]);

        return $this->ok('Coupon Code Copied Successfully!');
    }

    public function dealshare(Request $request)
    {
        $dealId = $request->id;
        $userId = Auth::check() ? Auth::id() : null;
        $ipAddress = $request->ip();

        DealShare::create([
            'deal_id' => $dealId,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'share_at' => Carbon::now(),
        ]);

        return $this->ok('DealShare Added Successfully!');
    }

    public function dealenquire(Request $request)
    {
        $dealId = $request->id;
        $userId = Auth::check() ? Auth::id() : null;
        $ipAddress = $request->ip();

        Dealenquire::create([
            'deal_id' => $dealId,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'enquire_at' => Carbon::now(),
        ]);

        return $this->ok('Dealenquire Added Successfully!');
    }
}
