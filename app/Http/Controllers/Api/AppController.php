<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Models\CategoryGroup;
use App\Models\Category;
use App\Models\Slider;
use App\Traits\ApiResponses;
use App\Models\DealCategory;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AppController extends Controller
{
    use ApiResponses;

    public function homepage()
    {
        $today = now()->toDateString();

        $categoryGroups = CategoryGroup::where('active',1)->get();
        $sliders = Slider::get();
        $cashBackDeals = DealCategory::where('active',1)->get();
        $trendingDeals = Product::where('active', 1) 
                                ->withCount(['views' => function ($query) use ($today) {
                                    $query->whereDate('viewed_at', $today);
                                }])
                                ->orderBy('views_count', 'desc')
                                ->take(10)
                                ->get();
        // Check if $treandingDeals is empty
            if ($trendingDeals->isEmpty()) {
                // If empty, get all active deals
                $trendingDeals = Product::where('active', 1)->get();
            }
        $popularDeals = Product::where('active', 1)->withCount('views')->orderBy('views_count', 'desc')->take(10)->get();//mostly viewed
        if ($popularDeals->isEmpty()) {
            // If empty, get all active deals
            $popularDeals = Product::where('active', 1)->get();
        }
        $earlyBirdDeals = Product::where('active',1)->whereDate('start_date',now())->get();
        $limitedDeals = Product::where('active',1)->whereRaw('DATEDIFF(end_date, start_date) <= ?', [2])->get();
        $lastChangeDeals = Product::where('active',1)->whereDate('end_date',now())->get();
        $HandPickedDeals = Product::where('active',1)->get();
        $homePageData = [
            'categoryGroups' => $categoryGroups,
            'sliders' => $sliders,
            'cashBackDeals'=> $cashBackDeals,
            'trendingDeals'=>$trendingDeals,
            'popularDeals'=>$popularDeals,
            'earlyBirdDeals'=>$earlyBirdDeals,
            'limitedDeals'=>$limitedDeals,
            'lastChangeDeals'=>$lastChangeDeals,
            'HandPickedDeals'=>$HandPickedDeals
        ];
        return $this->success( 'HomePage Retrieved Successfully!',$homePageData);

    }

    public function categories($id)
    {
        $categories = Category::where('active',1)->where('category_group_id',$id)->get();
        return $this->success( 'Categories Retrieved Successfully!',$categories);
    }

    public function getDeals($category_id)
    {
        $deals = Product::with('shop')->where('category_id', $category_id)->where('active', 1)->get();
        $brands = Product::where('active', 1)->distinct()->pluck('brand');
        $discounts = Product::where('active', 1)->distinct()->pluck('discount_percentage');
        $rating_items = Shop::where('active', 1)->select('shop_ratings', DB::raw('count(*) as rating_count'))->groupBy('shop_ratings')->get();
        $priceRanges = [];
        $priceStep = 2000;
        $minPrice = Product::min(DB::raw('LEAST(original_price, discounted_price)'));
        $maxPrice = Product::max(DB::raw('GREATEST(original_price, discounted_price)'));

        for ($start = $minPrice; $start <= $maxPrice; $start += $priceStep) {
            $end = $start + $priceStep;

            if ($end > $maxPrice) {
                $priceRanges[] = [
                    'label' => '$' . number_format($start, 2) . ' - $' . number_format($end, 2)
                ];
                break;
            }
            $priceRanges[] = [
                'label' => '$' . number_format($start, 2) . ' - $' . number_format($end, 2)
            ];
        }
        $shortby = DealCategory::where('active', 1)->get();
        $totaldeals = $deals->count();
        
        $dealdata = [
            'deals' => $deals,
            'brands' => $brands,
            'discounts' => $discounts,
            'rating_items' => $rating_items,
            'priceRanges' => $priceRanges,
            'shortby' => $shortby,
            'totaldeals' => $totaldeals,
        ];

        return $this->success( 'Deals Retrieved Successfully!',$dealdata);
    }

    public function dealDescription($id)
    {
        $deal = Product::with(['shop', 'shop.hour','shop.policy'])->where('id', $id)
        ->where('active', 1)
        ->first();

        return $this->success( 'Deals Retrieved Successfully!',$deal);
    }

    public function search(Request $request)
    {
        $term = $request->input('q');
        $perPage = $request->input('per_page', 10);

        $query = Product::with('shop', 'bookmark')->where('active', 1);

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
                $query->whereIn('discount_percentage', $discountTerm);
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
            
            $priceRange = $request->input('price_range');
        
            
            $priceRange = str_replace(['$', ',', ' '], '', $priceRange[0]);
            $priceRange = explode('-', $priceRange);
        
            
            $minPrice = isset($priceRange[0]) ? (float)$priceRange[0] : null;
            $maxPrice = isset($priceRange[1]) ? (float)$priceRange[1] : null;
        
            
            $query->where(function ($priceQuery) use ($minPrice, $maxPrice) {
                if ($maxPrice !== null) {
                    
                    $priceQuery->whereBetween('original_price', [$minPrice, $maxPrice])
                               ->orWhereBetween('discounted_price', [$minPrice, $maxPrice]);
                } else {
                    
                    $priceQuery->where('original_price', '>=', $minPrice)
                               ->orWhere('discounted_price', '>=', $minPrice);
                }
            });
        }
        

        if ($request->has('short_by')) {
            $shortby = $request->input('short_by');
            if ($shortby == 'trending') {
                $query->withCount(['views' => function ($viewQuery) {
                    $viewQuery->whereDate('viewed_at', now()->toDateString());
                }])->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->orderBy('views_count', 'desc');
            } elseif ($shortby == 'popular') {
                $query->withCount('views')->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->orderBy('views_count', 'desc');
            } elseif ($shortby == 'early_bird') {
                $query->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->whereDate('start_date', now());
            } elseif ($shortby == 'last_chance') {
                $query->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->whereDate('end_date', now());
            } elseif ($shortby == 'limited_time') {
                $query->with(['shop:id,country,state,city,street,street2,zip_code,shop_ratings'])
                    ->whereRaw('DATEDIFF(end_date, start_date) <= ?', [2]);
            }
        }

        $deals = $query->paginate($perPage);

        $brands = Product::where('active', 1)->distinct()->pluck('brand');
        $discounts = Product::where('active', 1)->distinct()->pluck('discount_percentage');
        $rating_items = Shop::where('active', 1)
            ->select('shop_ratings', DB::raw('count(*) as rating_count'))
            ->groupBy('shop_ratings')
            ->get();

        $priceRanges = [];
        $priceStep = 2000;
        $minPrice = Product::min(DB::raw('LEAST(original_price, discounted_price)'));
        $maxPrice = Product::max(DB::raw('GREATEST(original_price, discounted_price)'));

        for ($start = $minPrice; $start <= $maxPrice; $start += $priceStep) {
            $end = $start + $priceStep;

            if ($end > $maxPrice) {
                $priceRanges[] = [
                    'label' => '$' . number_format($start, 2) . ' - $' . number_format($end, 2)
                ];
                break;
            }
            $priceRanges[] = [
                'label' => '$' . number_format($start, 2) . ' - $' . number_format($end, 2)
            ];
        }

        $shortby = DealCategory::where('active', 1)->get();
        $totaldeals = $deals->total();

        $dealdata = [
            'deals' => $deals,
            'brands' => $brands,
            'discounts' => $discounts,
            'rating_items' => $rating_items,
            'priceRanges' => $priceRanges,
            'shortby' => $shortby,
            'totaldeals' => $totaldeals,
        ];

        return $this->success( 'Deals Retrieved Successfully!',$dealdata);
    }

    public function addBookmark(Request $request, $deal_id)
    {
        $deal = Product::findOrFail($deal_id);

        $user_id = Auth::check() ? Auth::id() : null;

        if ($user_id) {
            $existing_bookmark = Bookmark::where('deal_id', $deal->id)->where('user_id', $user_id)->first();
        } else {
            $existing_bookmark = Bookmark::where('deal_id', $deal->id)->whereNull('user_id')->where('ip_address', $request->ip())->first();
        }

        if ($existing_bookmark) {
            return response()->json(['message' => 'Deal already bookmarked'], 409);
        }

        Bookmark::updateOrCreate(
            [
                'deal_id' => $deal->id,
                'user_id' => $user_id,
                'ip_address' => $request->ip(),
            ]
        );

        return $this->ok('Item Added SuccessFully!');
    }

    public function removeBookmark(Request $request, $deal_id)
    {
        $user_id = Auth::check() ? Auth::id() : null;

        if ($user_id) {
            $bookmark = Bookmark::where('deal_id', $deal_id)->where('user_id', $user_id)->first();
        } else {
            $bookmark = Bookmark::where('deal_id', $deal_id)->whereNull('user_id')->where('ip_address', $request->ip())->first();
        }

        if ($bookmark) {
            $bookmark->delete();
            return $this->ok('Item Removed from Bookmark!');
        } else {
            return $this->error('Bookmark Not Found.', ['error' => 'Bookmark Not Found']);
        }
    }

    public function totalItems(Request $request)
    {
        $user_id = Auth::check() ? Auth::id() : null;

        $bookmarkCount = Bookmark::where(function ($query) use ($user_id, $request) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->whereNull('user_id')->where('ip_address', $request->ip());
            }
        })->count();

        return response()->json(['total_items' => $bookmarkCount]);
    }

    public function getBookmarks(Request $request)
    {
        $user_id = Auth::check() ? Auth::id() : null;

        $bookmarks = Bookmark::where(function ($query) use ($user_id, $request) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->whereNull('user_id')->where('ip_address', $request->ip());
            }
        })->with('deal')->paginate(10);

        return $this->success('Item Added SuccessFully!', $bookmarks);
    }
}
