<?php

namespace App\Http\Controllers;

use App\Notification;
use App\ProductWriteOff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createNotifications(array $dados)
    {
        $now = Carbon::now();
        if(count($dados) == 1 && $dados['category_id']) {
            $user = \Auth::user()->id;
            if($user !== 1){
                $categories = ProductWriteOff::where('category_id',$dados['category_id'])
                    ->where('user_id', $user)
                    ->get();
            } else {
                $categories = ProductWriteOff::where('category_id',$dados['category_id'])
                    ->get();
            }

            if(!empty($categories)) {
                foreach ($categories as $idx =>$category) {
                    $notification[$idx] = [
                        'product_id' => $category->product_id,
                        'category_id' => $category->category_id,
                        'qtde' => 0,
                        'user_id' => \Auth::user()->id,
                        'created_at' => Carbon::parse($now)->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::parse($now)->format('Y-m-d H:i:s'),
                    ];
                }
                $result = Notification::insert($notification);
            }
        } else {
            $dados['user_id'] = \Auth::user()->id;
            $result = Notification::create($dados);
        }

        return $result;

    }

    public function getNotificationsAjax()
    {

        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');

        $user = \Auth::user()->id;

        $notifications = \DB::select('CALL sp_notificacoes(?)',[$user]);

        $notifications = array_map(function($obj) {
            return (array) $obj;
        }, $notifications);

        foreach ($notifications as $idx => $notification) {
            if($notification['created_at']) {
                $notifications[$idx]['created_at'] = strftime('%d de %B de %Y, as %H:%M:%Shs', strtotime($notification['created_at']));
            }
        }
        return response($notifications, 200);
    }

    public function viewNotificationsAjax(Request $request)
    {
        $dados = $request->all();
        $user = \Auth::user()->id;
        $result = \DB::select('CALL sp_atualiza_notificacoes(?,?)',[$dados['id'],$user]);
        return response($result, 200);
    }
}
