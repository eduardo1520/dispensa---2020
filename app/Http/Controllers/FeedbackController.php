<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedback = Feedback::all();
        return view('feedback.index', compact('feedback'));
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
        foreach ($request->all() as $req) {
            foreach ($req as $r) {
                $data[$r['name']] = $r['value'];
            }
        }

        $data['prioridade'] = $data['tipo'] == 'S' ? 'B' : $data['prioridade'];
        $validacao = \Validator::make($data,[
            'tipo' => 'required|string|max:1',
            'prioridade' => 'required|string|max:1',
            'descricao' => 'required|string|max:500',
            'user_id' => 'required|integer',
        ]);

        if($validacao->fails()){
            dd($validacao->errors());
//            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $resultado = Feedback::create($data);
        return response($resultado);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Feedback::find($id);
        return response($data);
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
        foreach ($request->all() as $req) {
            foreach ($req as $r) {
                $data[$r['name']] = $r['value'];
            }
        }

        $data['prioridade'] = $data['tipo'] == 'S' ? 'B' : $data['prioridade'];
        $validacao = \Validator::make($data,[
            'tipo' => 'required|string|max:1',
            'prioridade' => 'required|string|max:1',
            'descricao' => 'required|string|max:500',
            'user_id' => 'required|integer',
        ]);

        if($validacao->fails()){
            dd($validacao->errors());
//            return redirect()->back()->withErrors($validacao)->withInput();
        }

        $resultado = Feedback::find($id)->update($data);
        return response($resultado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultado = Feedback::find($id)->delete();
        return response($resultado);
    }
}
