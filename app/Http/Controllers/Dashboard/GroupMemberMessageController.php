<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GroupMemberMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GroupMemberMessageController extends Controller
{
    public function index()
    {
        $groupMemberMessages = GroupMemberMessage::paginate(25);
        return view('dashboard.group-member-messages.index', compact('groupMemberMessages'));
    }

    public function store(Request $request)
    {        
        $request->validate([
            'message' => 'required|string|max:255',
            'link' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        
        $groupMemberMessage = GroupMemberMessage::create([
            'message' => $request->message,
            'link' => $request->link,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = Storage::disk('public')->put('group-member-messages', $image);
            $groupMemberMessage->image = Storage::url($path);
            $groupMemberMessage->save();
        }
        
        return redirect()->route('group-member-messages.index')->with('success', 'Group member message created successfully');
    }
}
