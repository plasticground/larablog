<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 25);
        $orderBy = $request->get('orderby', 'id');
        $search = $request->get('search', '');

        $users = User::where('id', '=', str_replace('#', '', $search))
            ->orWhere('name', 'LIKE', "%${search}%")
            ->orderBy($orderBy)
            ->paginate($limit);
        return view('profile.index', compact('users', 'request'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $user = auth()->user();

        $file = $request->file('avatar');

        $request->validate([
            'name' => [
                'required',
                'min:2',
                'max:32',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
            'description' => 'required|min:6|max:255',
            'avatar' => 'nullable|image|max:2480'
        ]);

        if ($file)
        {
           if ($ava = $user->avatar) {
               Storage::delete($ava);
           }

            $file->storeAs('public/uploads/pfp', $name = $file->hashName());
            $user->update($request->except('avatar') + ['avatar' => $name]);
        } else {
            $user->update($request->except('avatar'));
        }

        return redirect()->route('profile.show', $user->id)
            ->with('status', 'Изменения сохранены');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $user = User::all()->find($id);
        if (!$user) {
            return $this->index($request);
        }
        $limit = $request->get('limit', 25);
        $topics = $user->topics()
            ->latest('updated_at')
            ->paginate($limit);

        if ($user == auth()->user()) {
            return view('profile.my', compact('user', 'topics'));
        }
        return view('profile.show', compact('user', 'topics'));
    }
}
