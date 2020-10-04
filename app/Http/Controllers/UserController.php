<?php


namespace App\Http\Controllers;

use App\Category;
use App\Feedback;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
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
        $data = $request->all();
        $validacao = \Validator::make($data,[
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'admin' => 'string|max:1',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'nullable|min:6|max:12|required_with:password|same:password'
        ]);

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $data['password'] = bcrypt($data['password']);
        $data['admin'] = empty($request->admin) ? "N": $request->admin;
        $resposta = User::create($data);

        if($resposta)
            return redirect()->route('user.index')->with('success','Usuário criado com sucesso!');
        return back()->with('error','Erro ao criar o usuário!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.user',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = $request->all();

        if($data['password'] && $data['password_confirmation']) {
            $validacao = \Validator::make($data,[
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($id)],
                'admin' => 'string|max:1',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'nullable|min:6|max:12|required_with:password|same:password'
            ]);
            $data['password'] = bcrypt($data['password']);
        } else {
            $validacao = \Validator::make($data,[
                'name' => 'required|string|max:255',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($id)],
                'admin' => 'string|max:1',
            ]);
            unset($data['password']);
        }

        if($validacao->fails()){
            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $resultado = User::find($id)->update($data);

        if($resultado)
            return redirect()->route('user.index')->with('success','Usuário atualizado com sucesso!');
        return back()->with('error','Erro ao atualizar o usuário!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultado = User::find($id)->delete();
        return response($resultado);
    }

    public function relatorio()
    {
        $users = User::select('id','name','last_name','admin','email','created_at','updated_at','deleted_at')
            ->orderBy('name', 'asc')
            ->orderBy('created_at', 'desc')
            ->orderBy('deleted_at', 'desc')
            ->withTrashed()
            ->paginate(5);
        return view('users.relatorio',compact('users'));
    }
}
