<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $topics = Topic::all();
        return view('topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('topics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $file = $request->file('image');

        $request->validate([
            'title' => 'required|min:2|max:255',
            'description' => 'required|min:6',
            'body' => 'required|min:20'
        ]);

        if(isset($file))
        {
            $file->storeAs('public/uploads', $name = $file->hashName());
            $topic = $request->user()->topics()->create($request->except('image') + ['image' => $name]);
        } else {
            $topic = $request->user()->topics()->create($request->except('image'));
        }
        return redirect()->route('topics.show', $topic)
            ->with('status', 'New topic has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit(Topic $topic)
    {
        return view('topics.edit', compact('topic'));
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
        $file = $request->file('image');

        $request->validate([
            'title' => 'required|min:2|max:255',
            'description' => 'required|min:6',
            'body' => 'required|min:20'
        ]);

        if (isset($file))
        {
            $file->storeAs('public/uploads', $name = $file->hashName());
            $topic->update($request->except('image') + ['image' => $name]);
        } else {
            $topic->update($request->except('image'));
        }

        return redirect()->route('topics.show', $topic)
            ->with('status', 'Topic modified!');
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
        $topic->delete();
        return redirect()->route('topics.index');
    }
}
