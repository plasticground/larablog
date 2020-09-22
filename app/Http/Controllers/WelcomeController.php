<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $featuredTopic = Topic::where('is_featured', '=', 1)->get();
        $featuredTopic = $featuredTopic->isEmpty() ? null : $featuredTopic->random();
        $lastTopic = Topic::latest('created_at')->first();
        $updatedTopic = Topic::whereColumn('updated_at', '>', 'created_at')->latest('updated_at')->first();
        return view('welcome', compact(['featuredTopic', 'lastTopic', 'updatedTopic']));
    }
}
