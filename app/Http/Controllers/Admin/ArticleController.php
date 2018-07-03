<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.article.index', [
            'articles' => Article::with('userCreated', 'userModified')->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create', [
            'article' => [],
            'categories' => Category::with('children')->where('parent_id', '0')->get(),
            'delimiter' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = Article::create($request->all());

        if ($request->input('categories')) :
            $article->categories()->attach($request->input('categories'));
        endif;
        //dd($_POST);

        if ($request->file('file')) {
            $file = Storage::putFileAs('public/images', $request->file('file'), time() . $request->file('file')->getClientOriginalName());
            dd($file);
            $articl = Article::find($article->id);
            $articl->image = asset(Storage::url($file));
            $articl->save();
        }

        return redirect()->route('admin.article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.article.edit', [
            'article' => $article,
            'categories' => Category::with('children')->where('parent_id', '0')->get(),
            'delimiter' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->except('slug'));

        $article->categories()->detach();
        if ($request->input('categories')) :
            $article->categories()->attach($request->input('categories'));
        endif;

        if ($request->file('file')) {
            $file = Storage::putFileAs('public/images', $request->file('file'), time() . $request->file('file')->getClientOriginalName());

            $articl = Article::find($article->id);
            $articl->image = asset(Storage::url($file));
            $articl->save();
        }

        return redirect()->route('admin.article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->categories()->detach();
        $article->delete();

        return redirect()->route('admin.article.index');
    }

}
