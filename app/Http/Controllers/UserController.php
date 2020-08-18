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
    public function update(Request $request)
    {
        //
        //dd($request->all());
        /////$this->authorize('manage', 'App\Category');
        $user = $request->post('user');
        
        $theUser = User::findOrFail($user['id']);
        $updateSuccess = $theUser->update([
            'name' => $user['name'],
            'designation' => $user['designation'],
            'department_id' => $user['department_id'],
            'designation' => $user['designation'],
        ]);
        
        if (isset($user['password']) && $user['password'] !== ''){
            /*$theUser->update([
                'password' => Hash::make($user['password']),
            ]);*/
        }
        /*foreach ($categories as $cat) {
            if ($cat['id']) {
                Category::where('id', $cat['id'])->update($cat);
            }
            else {
                Category::create($cat);
            }
        }
        return ['success' => true, 'categories' => Category::all()];*/
        // return the same data compared to list to ensure using the same 
        return ['success' => true,];
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

        $dataObject = [];

        $users = $model::with(['department:id,name','roles:id,name'])
                ->orderBy('id', 'ASC')
                ->get();
        
        foreach ($users as $user){
            
            $dataObject[] = (object) [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'designation' => $user->designation,
                'department_id' => $user->department_id,
                'department_name' => $user->department->name,
                'role_id' => $user->roles[0]->id,
                'role_name' => $user->roles[0]->name
            ];
        }

        /*return response()->json((
            $model::with(['department:id,name','roles:id,name'])
            ->orderBy('id', 'ASC')
            ->get())
        );*/

        return response()->json($dataObject);
    }
    /**
     * API to return all roles
     */
    public function getAllRoles (Role $model){
        return response()->json(($model::orderBy('name', 'ASC')->get(['id','name'])));
    }

    /////public function update(Request $request)
    ////{
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
        /////dd($request->all());
    /////}

}
