<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $model) {
        //
        return view('admin.users.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        dd(["here"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        //
        dd($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        dd($user);
    }
    /**
     * API to return all users
     */
    public function list(User $model) {
        return response()->json(($model::with('department')->orderBy('id', 'ASC')->get()));
    }
    /**
     * API to return all roles
     */
    public function getAllRoles (Role $model){
        return response()->json(($model::orderBy('name', 'ASC')->get(['id','name'])));
    }

    public function upsert(Request $request)
    {
        /*$this->authorize('manage', 'App\Category');
        $categories = $request->post('categories');
        foreach ($categories as $cat) {
            if ($cat['id']) {
                Category::where('id', $cat['id'])->update($cat);
            }
            else {
                Category::create($cat);
            }
        }
        return ['success' => true, 'categories' => Category::all()];*/
        dd($request->all());
    }

}
