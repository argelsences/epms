<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;

use Illuminate\Validation\Rule;

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
     * @TODO for removal
     */
    public function upsertVersion1(UserRequest $request)
    {
        /*if ( auth()->user()->can(['edit user', 'add user']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit user', 'api') && auth()->user()->hasPermissionTo('add user', 'api') ){
            return response('Unauthorized', 403);
        }

        $user = $request->post('payload');

        
        if ( $user['id'] ){
            // retrieve the user object
            $theUser = User::findOrFail($user['id']);

            // update the user object with updated details
            $updateSuccess = $theUser->update([
                'name' => $user['name'],
                'designation' => $user['designation'],
                'department_id' => $user['department_id'],
                'designation' => $user['designation'],
            ]);
            
            // if password is changed, update it
            if (isset($user['password']) && $user['password'] !== ''){
                $theUser->update([
                    'password' => Hash::make($user['password']),
                ]);
            }
            
            // remove all roles of the user first
            foreach($theUser->getRoleNames() as $role){
                $theUser->removeRole($role);
            }
            // update user role
            $roleStoreSuccess = $this->storeRole($theUser, $user['role_id']);
        }
        else{
            $theUser = User::create([
                'name' => $user['name'],
                'designation' => $user['designation'],
                'department_id' => $user['department_id'],
                'designation' => $user['designation'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
            
            // assign the roles
            $roleStoreSuccess = $this->storeRole($theUser, $user['role_id']);
        }
        
        // return the same data compared to list to ensure using the same 
        $success = ($theUser && $roleStoreSuccess) ? true : false;
        return ['success' => $success,];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upsert(UserRequest $request)
    {
        /*if ( auth()->user()->can(['edit user', 'add user']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit user', 'api') && auth()->user()->hasPermissionTo('add user', 'api') ){
            return response('Unauthorized', 403);
        }

        $user = $request->post('payload');

        
        if ( $user['id'] ){
            // retrieve the user object
            $theUser = User::findOrFail($user['id']);

            // update the user object with updated details
            $updateSuccess = $theUser->update([
                'name' => $user['name'],
                'designation' => $user['designation'],
                'department_id' => $user['department_id'],
                'designation' => $user['designation'],
            ]);
            
            // if password is changed, update it
            if (isset($user['password']) && $user['password'] !== ''){
                $theUser->update([
                    'password' => Hash::make($user['password']),
                ]);
            }
            
            // remove all roles of the user first
            foreach($theUser->getRoleNames() as $role){
                $theUser->removeRole($role);
            }
            // update user role
            $roleStoreSuccess = $this->storeRole($theUser, $user['role_name']);
        }
        else{
            $theUser = User::create([
                'name' => $user['name'],
                'designation' => $user['designation'],
                'department_id' => $user['department_id'],
                'designation' => $user['designation'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
            
            // assign the roles
            $roleStoreSuccess = $this->storeRole($theUser, $user['role_name']);
        }
        
        // return the same data compared to list to ensure using the same 
        $success = ($theUser && $roleStoreSuccess) ? true : false;
        return ['success' => $success,];
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
    }
    /**
     * API to return all users
     */
    public function list(User $model) {

        if (!auth()->user()->can(['list user'])){
            return response('Unauthorized', 403);
        }

        /*if (!auth()->user()->hasPermissionTo('list user', 'api') ){
            return response('Unauthorized', 403);
        }*/

        $dataObject = [];

        // fix for listing only based on department of is a super admin

        if (auth()->user()->is_super_admin('api')){
            $users = $model::with(['department:id,name','roles:id,name'])
                ->orderBy('id', 'ASC')
                ->get();
        }
        else {
            $users = $model::with(['department:id,name','roles:id,name'])
                ->filterByDepartment()
                ->orderBy('id', 'ASC')
                ->get();
        }        
        
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
        //////return response()->json($users);
        return response()->json($dataObject);
    }
    /**
     * API to return all roles
     */
    public function getAllRoles (Role $model){

        if (!auth()->user()->can(['list role'])){
            return response('Unauthorized', 403);
        }
        /*if (auth()->user()->hasPermissionTo('list role', 'api') ){
            return response('Unauthorized', 403);
        }*/
        $uniqueRoles = $model::select('name')->groupBy('name')->get();

        //return response()->json(($model::orderBy('name', 'ASC')->get(['id','name'])));
        return response()->json($uniqueRoles);
    }

    /**
     * Assign role to a user
     */
    private function storeRole( User $user, $role_name ){
        
        $assignedRole = false;

        /*if (isset($role_id)){
            $role_r = Role::where('id', '=', $role_id)->firstOrFail();
            // $role_r is the object, pass it as it is needed by polymorph table model_has_roles
            // better this way, but you can also use the name itself
            $assignedRole = $user->assignRole($role_r); //Assigning role to user
        }*/
        if (isset($role_name)){
            $role_r = Role::where('name', '=', $role_name)->get();
            // $role_r is the object, pass it as it is needed by polymorph table model_has_roles
            // better this way, but you can also use the name itself
            $assignedRole = $user->assignRole($role_r); //Assigning role to user
        }

        return $assignedRole;
    }

    /**
     * Assign role to a user using role id as parameter
     * 
     */
    private function storeRoleByRoleID( User $user, $role_id ){
        
        $assignedRole = false;

        if (isset($role_id)){
            $role_r = Role::where('id', '=', $role_id)->firstOrFail();
            // $role_r is the object, pass it as it is needed by polymorph table model_has_roles
            // better this way, but you can also use the name itself
            $assignedRole = $user->assignRole($role_r); //Assigning role to user
        }

        return $assignedRole;
    }

    /**
     * API
     * 
     * Retrieve profile of the current logged in user
     */
    public function getProfile(){
        $user = Auth::user();
        $objUser = User::with(['department','roles'])->findOrFail($user->id);
        return response()->json( $objUser );
    }

}
