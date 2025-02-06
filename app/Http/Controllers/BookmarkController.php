<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function add(Request $request, $deal_id)
    {
        $deal = Product::findOrFail($deal_id);
        $user_id = Auth::check() ? Auth::id() : null;

        if ($user_id) {
            $existing_bookmark = Bookmark::where('deal_id', $deal->id)->where('user_id', $user_id)->first();
        } else {
            $existing_bookmark = Bookmark::where('deal_id', $deal->id)->whereNull('user_id')->where('ip_address', $request->ip())->first();
        }

        if ($existing_bookmark) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Deal already bookmarked']);
            }
            return redirect()->back()->with('message', 'Deal already bookmarked');
        }

        Bookmark::updateOrCreate(
            [
                'deal_id' => $deal->id,
                'user_id' => $user_id,
                'ip_address' => $request->ip(),
            ]
        );

        if ($request->ajax()) {
            $bookmarkCount = $this->getBookmarkCount($request);
            return response()->json(['message' => 'Deal added to bookmarks successfully!', 'total_items' => $bookmarkCount]);
        }

        return redirect()->back()->with('message', 'Deal added to bookmarks successfully!');
    }


    public function remove(Request $request, $deal_id)
    {
        $user_id = Auth::check() ? Auth::id() : null;

        if ($user_id) {
            $bookmark = Bookmark::where('deal_id', $deal_id)->where('user_id', $user_id)->first();
        } else {
            $bookmark = Bookmark::where('deal_id', $deal_id)->whereNull('user_id')->where('ip_address', $request->ip())->first();
        }

        if ($bookmark) {
            $bookmark->delete();

            if ($request->ajax()) {
                $bookmarkCount = $this->getBookmarkCount($request);
                return response()->json(['message' => 'Item removed from bookmarks!', 'total_items' => $bookmarkCount]);
            }

            return redirect()->back()->with('message', 'Item removed from bookmarks!');
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Bookmark not found'], 404);
        }

        return redirect()->back()->with('message', 'Bookmark not found');
    }

    private function getBookmarkCount(Request $request)
    {
        $user_id = Auth::check() ? Auth::id() : null;

        $bookmarkCount = Bookmark::where(function ($query) use ($user_id, $request) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->whereNull('user_id')->where('ip_address', $request->ip());
            }
        })
            ->whereHas('deal', function ($query) {
                $query->where('active', 1)
                    ->whereNull('deleted_at');
            })->count();

            // dd($bookmarkCount);

        return $bookmarkCount;
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
        })
            ->whereHas('deal', function ($query) {
                $query->where('active', 1)
                    ->whereNull('deleted_at');
            })->count();

        return response()->json(['total_items' => $bookmarkCount]);
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $ip_address = $request->ip();

            Bookmark::whereNull('user_id')
                ->where('ip_address', $ip_address)
                ->update(['user_id' => $user_id]);
        }

        $user_id = Auth::check() ? Auth::id() : null;

        $bookmarks = Bookmark::where(function ($query) use ($user_id, $request) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->whereNull('user_id')->where('ip_address', $request->ip());
            }
        })
        ->whereHas('deal', function ($query) {
            $query->where('active', 1)
                  ->whereNull('deleted_at');
        })
        ->with(['deal' => function($query) {
            $query->where('active', 1)->whereNull('deleted_at')->with(['productMedia:id,resize_path,order,type,imageable_id']);
        }, 'deal.shop'])
        ->paginate(10);

        return view('bookmark', compact('bookmarks'));
    }
}
