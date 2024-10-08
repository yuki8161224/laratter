<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tweets = Tweet::with(['user', 'liked'])->latest()->get();
        $tweets = Tweet::withCount('comments')->get();
        $tweets = Tweet::with('user', 'liked')
            ->latest()
            ->paginate(10);
        // dd($tweets);
        return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tweets.create'); //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        // ツイートを作成
        $tweet = $request->user()->tweets()->create($request->only('tweet'));


        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        $tweet->load('comments');
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        return view('tweets.edit', compact('tweet')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        $tweet->update($request->only('tweet'));

        return redirect()->route('tweets.show', $tweet); //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();

        return redirect()->route('tweets.index'); //
    }
    public function search(Request $request)
    {

        $query = Tweet::query();

        // キーワードが指定されている場合のみ検索を実行
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('tweet', 'like', '%' . $keyword . '%');
        }

        // ページネーションを追加（1ページに10件表示）
        $tweets = $query
            ->latest()
            ->paginate(10);

        return view('tweets.search', compact('tweets'));
    }
    public function ranking()
    {
        $tweets = Tweet::with(['user', 'liked'])
            ->withCount('liked')
            ->orderBy('liked_count', 'desc')
            ->take(10)
            ->get();

        return view('tweets.ranking', compact('tweets'));
    }
    public function bookmarks()
    {
        // 現在ログインしているユーザーがいいねしたツイートを取得
        $tweets = auth()->user()->likedTweets()->with('user')->paginate(10);

        return view('tweets.bookmark', compact('tweets'));
    }
}
