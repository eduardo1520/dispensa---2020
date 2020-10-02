<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        if(isset($data['password']) && $data['password'] != ""){
            $validacao = \Validator::make($data,[
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($id)],
                'password' => 'required|string|min:6',
                'password_confirmation' => 'nullable|min:6|max:12|required_with:password|same:password'
            ]);
            $data['password'] = bcrypt($data['password']);
        }else{
            $validacao = \Validator::make($data,[
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($id)]
            ]);
            unset($data['password']);
        }

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }
        $data['admin'] = empty($request->input('admin')) ? 'N' : $request->input('admin');
        User::find($id)->update($data);
        return redirect()->route('home');
    }
}
