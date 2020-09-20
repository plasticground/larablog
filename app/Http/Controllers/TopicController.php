<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{
    private $validateRules = [
        'title' => 'required|min:2|max:255',
        'description' => 'required|min:6|max:255',
        'body' => 'required|min:20',
        'image' => 'image|max:10240',
        'category' => 'exists:categories,title'
    ];

    /**
     * TopicController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $option = $request->get('option', 'id');
        $search = $option == 'is_featured' ? 1 : $request->get('search', '');
        $limit = $request->get('limit', 25);

        $topics = Topic::where($option, 'like', "%{$search}%")
            ->latest()
            ->paginate($limit);
        return view('topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all()->sortBy('title');
        $tags = Tag::all()->sortBy('title');
        return view('topics.create', compact('categories', 'tags'));
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

        $file = $request->file('image');

        $category = Category::whereTitle($request->get('category'))->first();

        $tags = explode(',', $request->get('tags'));
        $tagsIds = [];
        foreach ($tags as $tag) {
            array_push($tagsIds, Tag::whereTitle($tag)->firstOrCreate(['title' => $tag])->id);
        }

        if($file)
        {
            $file->storeAs('public/uploads', $name = $file->hashName());
            $topic = $request->user()->topics()->create($request->except('image') + ['image' => $name]);
        } else {
            $topic = $request->user()->topics()->create($request->except('image'));
        }

        $topic->setCategory($category);
        $topic->setTags($tagsIds);
        $topic->toggleFeatured($request->get('featured'));

        return redirect()->route('topics.show', $topic)
            ->with('status', 'Тема создана!');
    }

    /**
     * Display the specified resource.
     *
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Topic $topic)
    {
        $topic->visit();
        $comments = $topic->comments;
        return view('topics.show', compact('topic', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit(Topic $topic)
    {
        $categories = Category::all()->sortBy('title');
        $tags = Tag::all()->sortBy('title');
        return view('topics.edit', compact('topic', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Topic $topic)
    {
        $request->validate($this->validateRules);

        $file = $request->file('image');

        $topic->slug = null;

        $category = Category::whereTitle($request->get('category'))->first();

        $tags = explode(',', $request->get('tags'));
        $tagsIds = [];
        foreach ($tags as $tag) {
            array_push($tagsIds, Tag::whereTitle($tag)->firstOrCreate(['title' => $tag])->id);
        }

        if ($file)
        {
            if ($img = $topic->image) {
                Storage::delete($img);
            }
            $file->storeAs('public/uploads', $name = $file->hashName());
            $topic->update($request->except('image') + ['image' => $name]);
        } else {
            $topic->update($request->except('image'));
        }

        $topic->setCategory($category);
        $topic->setTags($tagsIds);
        $topic->toggleFeatured($request->get('featured'));

        return redirect()->route('topics.show', $topic)
            ->with('status', 'Изменения сохранены!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Topic $topic)
    {
        Storage::delete($topic->image);
        $topic->delete();
        return redirect()->route('topics.index');
    }
}
