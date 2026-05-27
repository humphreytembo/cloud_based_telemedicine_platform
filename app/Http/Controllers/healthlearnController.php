<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HealthLearnController extends Controller
{
    /**
     * All articles data lives here.
     * Later you can move this to a database table + Article model.
     */
    private function articles(): array
    {
        return [
            [
                'slug'     => 'understanding-heart-health',
                'title'    => 'Understanding Your Heart: A Complete Guide to Cardiovascular Wellness',
                'category' => 'heart',
                'tag'      => 'Heart Health',
                'author'   => 'Dr. Mwansa',
                'read_time'=> '8 min read',
                'date'     => 'May 2025',
                'excerpt'  => 'Learn how your heart works, key risk factors for heart disease, and practical lifestyle changes that can significantly improve your cardiovascular health.',
                'content'  => 'Your heart beats about 100,000 times a day. Understanding how it works — and what strains it — is the first step toward lasting cardiovascular health...',
            ],
            [
                'slug'     => 'stress-management',
                'title'    => '5 Proven Techniques to Manage Daily Stress',
                'category' => 'mind',
                'tag'      => 'Mental Health',
                'author'   => 'Dr. Banda',
                'read_time'=> '5 min read',
                'date'     => 'April 2025',
                'excerpt'  => 'Chronic stress takes a serious toll on the body and mind. These five science-backed techniques can help you regain calm and control.',
                'content'  => 'Stress is a normal part of life, but chronic stress can lead to anxiety, depression, high blood pressure, and weakened immunity...',
            ],
            [
                'slug'     => 'balanced-diet',
                'title'    => 'Building a Balanced Plate: Macro & Micronutrients Explained',
                'category' => 'nutrition',
                'tag'      => 'Nutrition',
                'author'   => 'Dr. Phiri',
                'read_time'=> '6 min read',
                'date'     => 'March 2025',
                'excerpt'  => 'No single food is a magic bullet. A healthy diet is about consistent patterns and variety across all food groups.',
                'content'  => 'Macronutrients — carbohydrates, proteins, and fats — provide energy. Micronutrients — vitamins and minerals — support every bodily function...',
            ],
            [
                'slug'     => 'vaccines-101',
                'title'    => 'Vaccines 101: Why Immunisation Matters for Everyone',
                'category' => 'prevention',
                'tag'      => 'Prevention',
                'author'   => 'Dr. Mwansa',
                'read_time'=> '4 min read',
                'date'     => 'February 2025',
                'excerpt'  => 'Vaccines have eliminated or dramatically reduced some of the deadliest diseases in history. Here is why they still matter today.',
                'content'  => 'Immunisation works by training your immune system to recognise and fight specific pathogens without you having to get sick first...',
            ],
        ];
    }

    // ─────────────────────────────────────────
    // GET /health-learn
    // ─────────────────────────────────────────
    public function index()
    {
        $articles = $this->articles();

        return view('healthlearning', compact('articles'));
    }

    // ─────────────────────────────────────────
    // GET /health-learn/{slug}
    // ─────────────────────────────────────────
    public function show(string $slug)
    {
        $articles = $this->articles();

        // Find the article matching the slug
        $article = collect($articles)->firstWhere('slug', $slug);

        if (!$article) {
            abort(404, 'Article not found.');
        }

        // Related articles — same category, excluding current
        $related = collect($articles)
            ->where('category', $article['category'])
            ->where('slug', '!=', $slug)
            ->values()
            ->all();

        return view('healtharticle', compact('article', 'related'));
    }
}