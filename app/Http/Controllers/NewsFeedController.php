<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Media;
use App\Models\NewsFeed;
use Illuminate\Http\Request;
use App\Traits\NewsFeedTrait;
use Illuminate\Support\Facades\Http;

class NewsFeedController extends Controller
{
    use NewsFeedTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allArticles = $this->getAllNews();
        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->get();
        $media = Media::where('user_id', auth()->id())->get();
        return view('pages.feed', compact('allArticles', 'emails', 'media'));
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
        $imagePath = null;
        if ($request->hasFile('urlToImage')) {
            $file = $request->file('urlToImage');
            $destinationPath = public_path('newsFeed');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $imagePath = 'newsFeed/' . $fileName;
        }

        NewsFeed::create([
            'title' => $request->title,
            'content' => $request->content ?? null,
            'source' => $request->source ?? null,
            'description' => $request->description ?? null,
            'urlToImage' => $imagePath,
            'url' => $request->url ?? null,
            'user_id' => auth()->id(),
            'publishedAt' => now(),
        ]);

        return redirect()->back()->with('success', 'News successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsFeed $newsFeed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsFeed $newsFeed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsFeed $newsFeed)
    {
        $newsFeed->update($request->all());

        return redirect()->back()->with('success', 'News updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsFeed $newsFeed)
    {
        $newsFeed->delete();

        return response()->json([
            'success' => true,
            'message' => 'News deleted successfully.'
        ]);
    }

    public function searchNews(Request $request)
    {
        $query = $request->get('query', '');

        // Fetch API news, even if query is empty
        $apiNewsResponse = Http::get(env('NEWS_API_BASE_URL') . 'everything', [
            'apiKey' => env('NEWS_API_KEY'),
            'q' => $query ?: 'latest', // If query is empty, fetch general news
            'pageSize' => 30,
        ]);

        $apiNewsArticles = $apiNewsResponse->json()['articles'] ?? [];

        // Filter API news
        $apiNewsArticles = array_filter($apiNewsArticles, function ($article) {
            return !is_null($article['author']) && $article['title'] !== '[Removed]';
        });

        // Format the published date
        $apiNewsArticles = array_map(function ($article) {
            $article['publishedAt'] = \Carbon\Carbon::parse($article['publishedAt'])->format('d-M-Y h:i A');
            return $article;
        }, $apiNewsArticles);

        // Fetch user-added news from the database
        $userNewsArticles = NewsFeed::query()
            ->when(!empty($query), function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('content', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->get();

        // Merge API and user news
        $allArticles = array_merge($apiNewsArticles, $userNewsArticles->toArray());

        // Sort by published date
        usort($allArticles, function ($a, $b) {
            return strtotime($b['publishedAt']) - strtotime($a['publishedAt']);
        });

        return response()->json($allArticles);
    }
}
