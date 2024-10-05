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
            return response()->json(['message' => 'Deal already bookmarked'], 409);
        }

        Bookmark::updateOrCreate(
            [
                'deal_id' => $deal->id,
                'user_id' => $user_id,
                'ip_address' => $request->ip(),
            ]
        );

        return redirect()->back()->with('message', 'Deal Added to Bookmark Successfully!');
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
            return redirect()->back()->with('message', 'Item Removed from Bookmark!');
        }

        return redirect()->back()->with('message', 'Bookmark not found');
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

    public function index(Request $request)
    {
        $user_id = Auth::check() ? Auth::id() : null;

        $bookmarks = Bookmark::where(function ($query) use ($user_id, $request) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->whereNull('user_id')->where('ip_address', $request->ip());
            }
        })->with('deal')->paginate(10);

        return view('bookmark', compact('bookmarks'));
    }
}
