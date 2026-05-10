<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FriendshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Friends/Index', [
            'allUsers' => UserResource::collection(
                User::where('id', '!=', auth()->user()->id)->whereNotIn('id', auth()->user()->getFriendIdsExcluding())->get()
            ),
            'friends' => auth()->user()->friends(),
            'pendingRequests' => auth()->user()
                ->receivedFriendRequests()
                ->where('status', 'pending')
                ->with('sender')
                ->get(),
                ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Friendship $friendship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friendship $friendship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friendship $friendship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friendship $friendship)
    {
        //
    }

    public function sendRequest(User $user)
    {
        if ($user->id === auth()->id()) {
            abort(403, 'Cannot send friend request to yourself.');
        }

        Friendship::firstOrCreate([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
        ]);

        return back();
    }

    public function accept(Friendship $friendship)
    {
        if ($friendship->receiver_id !== auth()->id()) {
            abort(403);
        }

        $friendship->update(['status' => 'accepted']);

        return back();
    }

    public function decline(Friendship $friendship)
    {
        if ($friendship->receiver_id !== auth()->id()) {
            abort(403);
        }

        $friendship->update(['status' => 'declined']);

        return back();
    }

    public function remove(User $user)
    {
        Friendship::where(function ($q) use ($user) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', auth()->id());
        })->delete();

        return back();
    }
}

//     public function sendRequest(User $user) 
//     {
//         Friendship::firstOrCreate([
//             'sender_id' => auth()->user()->id,
//             'receiver_id' => $user->id,
//         ], [
//             'status' => 'pending',
//         ]);

//         return redirect()->back()->with('success', 'Friend request sent.');
//     }

//     public function acceptRequest(Friendship $friendship) 
//     {
//         // dd($friendship);
//         if ($friendship->receiver_id !== auth()->user()->id) {
//             return redirect()->back()->with('error', 'Unauthorized action.');
//         }

//         $friendship->update(['status' => 'accepted']);

//         return redirect()->back()->with('success', 'Friend request accepted.');
//     }

//     public function declineRequest(Friendship $friendship) 
//     {
//         // dd($friendship);
//         if ($friendship->receiver_id !== auth()->user()->id) {
//             return redirect()->back()->with('error', 'Unauthorized action.');
//         }

//         $friendship->update(['status' => 'rejected']);

//         return redirect()->back()->with('success', 'Friend request declined.');
//     }
// }
