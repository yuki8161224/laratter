<?php

namespace App\Http\Controllers;

use App\Models\UserBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    public function block($userId)
    {
        UserBlock::create([
            'user_id' => Auth::id(),
            'blocked_user_id' => $userId,
        ]);

        return redirect()->back()->with('message', 'ユーザーをブロックしました。');
    }

    public function unblock($userId)
    {
        UserBlock::where('user_id', Auth::id())
            ->where('blocked_user_id', $userId)
            ->delete();

        return redirect()->back()->with('message', 'ユーザーのブロックを解除しました。');
    } //
}
