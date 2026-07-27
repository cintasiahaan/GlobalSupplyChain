<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleManagementController extends Controller
{
    public function index()
    {
        $articles = Article::latest('published_at')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'author' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($request->title) . '-' . time();
        $validated['author'] = $request->author ?? 'Supply Chain Analyst';
        $validated['published_at'] = now();

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel analisis berhasil diterbitkan.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
