<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
   
    public function index()
    {
        $users = User::paginate(10);
        
        return view('users.index', ['users'=>$users]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|min:3',
            'email'=> 'required|string|email|unique:users',
            'password'=> 'required|min:5|max:15',
            'type'=> 'required'
        ]);
            
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->type = $request->type;
        $user->save();
        return response()->json(['user'=> $user],200);
    }
    public function update(Request $request,User $user){
        $user = User::findOrFail($user->id);
        
        $this->validate($request,[
            'name' => 'required|min:3|max:150',
            'email'=> 'required|email|max:100',Rule::unique('users')->ignore($user->id,'id'),
            'password'=> 'sometimes|nullable|between:5,15',
            'type'=>  'required'
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if(isset($request->password)){
            //$request->merge(['password' => bcrypt($request->password)]);
            $user->password = bcrypt($request->password);
        }    
        $user->type = $request->type;
        
        $user->save();
        return response()->json(['user'=> $user],200);
        
        
    }
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(["user"=> $user],200);
    }
}
