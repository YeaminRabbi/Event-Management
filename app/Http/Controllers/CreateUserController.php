<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
class CreateUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminpanel.admin-list.index',[
            'admins' => User::with('roles')->role(['admin','super-admin'])->orderBy('id', 'DESC')->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminpanel.admin-list.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'role_id' => 'required'            
        ]);

        if (User::where('phone', '=', $request->phone)->orWhere('email', '=', $request->email)->exists()) {
            return back()->with('success', 'Email or Phone already exist!');
         }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone =  $request->phone;
        $user->gender =  $request->gender;
            
        if(isset($request->password)){
            $user->password =  Hash::make($request->password);
            $user->pass =  $request->password;            
        }
        $user->save();
        $user->assignRole($request->role_id);

        return back()->with('success', 'Admin has been created!');
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
    public function edit($id)
    {
        return view('adminpanel.admin-list.edit',[
            'user' => User::with('roles')->find($id)
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'role_id' => 'required'            
        ]);

        if (User::where('phone', '=', $request->phone)->orWhere('email', '=', $request->email)->exists()) {
            return back()->with('success', 'Email or Phone already exist!');
         }

        $user = User::find($id);
        $user->name = $request->name;

        $user->gender =  $request->gender;
            
        if(isset($request->password)){
            $user->password =  Hash::make($request->password);
            $user->pass =  $request->password;            
        }
        $user->save();

        $user->syncRoles($request->role_id);

        return back()->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return back()->with('success', 'Admin deleted Successfully!');
    }
}
