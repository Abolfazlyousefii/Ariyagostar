<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->latest()->paginate(20);

        return view('front::user.favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)->where('product_id', $request->product_id)->first();

        if (!$favorite) {
            $user->favorites()->create([
                'product_id' => $request->product_id
            ]);

            $action = 'create';
        } else {
            $favorite->delete();
            $action = 'delete';
        }

        return response()->json(['action' => $action]);
    }

    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id != auth()->user()->id) {
            abort(404);
        }

        $favorite->delete();

        return redirect()->route('front.favorites.index');
    }
}
