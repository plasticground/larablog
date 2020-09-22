<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topics(Request $request)
    {
        $option = $request->get('option', 'id');
        $search = $option == 'is_featured' ? 1 : $request->get('search', '');
        $limit = $request->get('limit', 25);

        $topics = Topic::where($option, 'like', "%{$search}%")
            ->latest()
            ->paginate($limit);
        return view('admin.topics.index', compact('topics'));
    }
}
