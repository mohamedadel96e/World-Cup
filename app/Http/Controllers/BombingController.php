<?php

namespace App\Http\Controllers;

use App\Models\BombingView;
use App\Models\Bombing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;




class BombingController extends Controller
{
    use AuthorizesRequests;
    public function markAsSeen()
    {
        $user = Auth::user();

        $bombings = Bombing::where('target_country_id', $user->country_id)
            ->whereDoesntHave('views', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get();

        foreach ($bombings as $bombing) {
            BombingView::firstOrCreate([
                'bombing_id' => $bombing->id,
                'user_id' => $user->id,
            ]);
        }

        return back()->with('success', 'Bombings marked as seen.');
    }
}