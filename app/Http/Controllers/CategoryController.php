<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $validateRules = [
        'title' => 'required|min:2|max:32|unique:categories'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $order = $request->get('orderby', 'id');
        $categories = Category::orderBy($order)
            ->paginate($limit);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $limit = $request->get('limit', 10);
        $order = $request->get('orderby', 'id');
        $categories = Category::orderBy($order)
            ->paginate($limit);
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->validateRules);

        Category::create($request->all());

        return redirect()->route('categories.create')
            ->with('status', 'Категория создана');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request, Category $category)
    {
        $limit = $request->get('limit', 10);
        $order = $request->get('orderby', 'id');
        $categories = Category::orderBy($order)
            ->paginate($limit);

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $request->validate($this->validateRules);

        $category->slug = null;

        $category->update($request->all());

        return redirect()->back()
            ->with('status', 'Категория изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()
            ->with('status', 'Успешно удалено');
    }
}
