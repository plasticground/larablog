<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $validateRules = [
        'text' => 'required|max:2500'
    ];

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->validateRules);
        Comment::create($request->all());
        return redirect()->back()->with('status', 'Коментарий отправлен');
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('status', 'Комментарий удалён');
    }
}
