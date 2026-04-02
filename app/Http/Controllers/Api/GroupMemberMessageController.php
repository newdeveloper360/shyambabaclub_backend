<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GroupMemberMessage;
use Illuminate\Http\Request;

class GroupMemberMessageController extends Controller
{
    public function index()
    {
        $data = GroupMemberMessage::latest()->get();
        return response()->success("Group member messages fetched successfully", compact('data'));
    }
}
