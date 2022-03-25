<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
//        $categories = auth()->user()->categories()->paginate(5);
        $category = new Category();
        $categories = Category::getCategoriesByUserId(auth()->user())->paginate(5);
        return view('category.index', compact('categories', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $category = new Category();
        return view('category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $res = Category::create([
            'category_name' => $request->category_name,
            'user_id' => auth()->id()
        ]);
        $message = $res ? "Categoria creata con succeesso" : 'Categoria non creata';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        if ($request->ajax()){
            return $res;
        }
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        return view('category.create', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $res = $category->update($request->all());
        $message = $res ? "Categoria modificata con succeesso" : 'Categoria non modificata';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        if ($request->ajax()){
            return $res;
        }
        return redirect()->route('categories.index');
    }


    public function destroy(Category $category)
    {
        $res = $category->delete();
        $message = $res ? "Categoria eliminata con succeesso" : 'Categoria non modificata';
        $tipo = $res ? 'success' : 'danger';
        if (request()->ajax()){
            return [
                'success' => (bool)$res,
                'message' => $message,
                'tipo' => $tipo
            ];
        }
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        return redirect()->route('categories.index');
    }
}
