<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $validateRules = [
        'title' => 'required|min:2|max:32|unique:tags|alpha_dash'
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
        $tags = Tag::orderBy($order)
            ->paginate($limit);
        return view('admin.tags.index', compact('tags'));
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
        $tags = Tag::orderBy($order)
            ->paginate($limit);
        return view('admin.tags.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->validateRules);

        Tag::create($request->all());

        return redirect()->route('tags.create')
            ->with('status', 'Тег создан');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request, Tag $tag)
    {
        $limit = $request->get('limit', 10);
        $order = $request->get('orderby', 'id');
        $tags = Tag::orderBy($order)
            ->paginate($limit);

        return view('admin.tags.edit', compact('tag', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate($this->validateRules);

        $tag->slug = null;

        $tag->update($request->all());

        return redirect()->back()
            ->with('status', 'Тег изменён');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->back()
            ->with('status', 'Успешно удалено');
    }
}
