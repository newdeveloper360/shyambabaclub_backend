<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class GroupMemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('searchValue')) {
            $searchValue = $request->searchValue;
            $users = User::where('role', 'user')
                ->where(function ($query) use ($searchValue) {
                    $query->where('name', 'LIKE', '%' . $searchValue . '%')
                        ->orWhere('phone', 'LIKE', '%' . $searchValue . '%');
                })->latest()->paginate(250);
            return view('dashboard.group-members.index', compact('users', 'searchValue'));
        }
        $users = User::where('role', 'user')->latest()->paginate(250);
        return view('dashboard.group-members.index', compact('users'));
    }

    public function toggleGroupMember(Request $request)
    {                
        $user = User::find($request->user_id);
        if ($user) {
            $user->is_group_member = !$user->is_group_member;
            $user->save();
            return redirect()->route('group-members.index')->with('success', $user->is_group_member ? 'User added to group successfully' : 'User removed from group successfully');
        }
        return redirect()->route('group-members.index')->with('error', 'User not found');
    }
}
