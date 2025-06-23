<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\NewsFeed;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;


trait NewsFeedTrait
{
    public function getAllNews()
    {
        try {
            $countryCode = auth()->user()->country?->code;

            $response = Http::get(env('NEWS_API_BASE_URL') . 'top-headlines', [
                'apiKey' => env('NEWS_API_KEY'),
                'country' => $countryCode,
                'category' => 'general',
                'pageSize' => 30,
            ]);

            if ($response->failed()) {
                return ['error' => 'Failed to retrieve news. Please try again later.'];
            }

            $newsArticles = $response->json()['articles'] ?? [];

            $newsArticles = array_filter($newsArticles, function ($article) {
                return !is_null($article['author']) && $article['title'] !== '[Removed]';
            });

            $newsArticles = array_values($newsArticles);

            $newsArticles = array_map(function ($article) {
                $article['publishedAt'] = Carbon::parse($article['publishedAt'])->format('d-M-Y h:i A');
                return $article;
            }, $newsArticles);

            $userNewsArticles = NewsFeed::where('user_id', auth()->id())->orderByDesc('publishedAt')->get();

            $allArticles = array_merge($newsArticles, $userNewsArticles->toArray());

            usort($allArticles, function ($a, $b) {
                return strtotime($b['publishedAt']) - strtotime($a['publishedAt']);
            });

            return $allArticles;

        } catch (ConnectionException $e) {
            return ['error' => 'You don’t have an internet connection. Please check and try again.'];
        }
    }
}
