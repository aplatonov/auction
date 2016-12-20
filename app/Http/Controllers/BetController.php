<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use App\Lots;
use App\Bets;
use App\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
use Carbon\Carbon;

class BetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        dd($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function makeBet(Request $request)
    {
        if (is_numeric($request->input('bet_price'))) {
            $was_same_bet = Bets::where('lot_id', $request->input('lot_id'))
                                    ->where('user_id', $request->input('user_id'))
                                    ->where('bet_price', $request->input('bet_price'))
                                    ->count();
            if ($was_same_bet == 0 && Lots::find($request->input('lot_id'))->end_auction>=Carbon::now() && Lots::find($request->input('lot_id'))->disabled == 0) {
                $bet = new Bets;
                $bet->lot_id = $request->input('lot_id');
                $bet->user_id = $request->input('user_id');
                $bet->bet_price = $request->input('bet_price');
                $bet->save();
            }
        }
        
        /*
          завершаем аукцион по данному лоту, 
          объявляем победителя (id в базу, письма победтелю и хозяину),
          пишем окончат. цену,
          блокируем лот
          пишем причину блокировки: 3-определен победитель (была хотя бы одна ставка)
                                    4-истекло время (ставок не было)
          в таблице ставок помечаем победившую ставку
        */

        if (Lots::find($request->input('lot_id'))->disabled == 0 && Lots::find($request->input('lot_id'))->end_auction<=Carbon::now()) {
            $lot = Lots::find($request->input('lot_id'));
            $lot->disabled = 1; 
            $lot->disabled_date = Carbon::now();

            //побеждает ставка с самой большой ценой, сделанная раньше всех
            $best_bet = Bets::where('lot_id', $request->input('lot_id'))
                                ->orderBy('bet_price', 'desc')
                                ->orderBy('created_at', 'asc')
                                ->first();
            if($best_bet) {
                $lot->final_price = $best_bet->bet_price;
                $lot->disable_reason_id = 3;
                $lot->winner_id = $best_bet->user_id;
                $best_bet->is_final = 1;
                $best_bet->save();
            } else {
                $lot->disable_reason_id = 4;
            }

            $lot->save();
        }   

        $last_five_bets = DB::table('bets')
                            ->join('users', 'bets.user_id', '=', 'users.id')
                            ->select('bets.*', 'users.username')
                            ->where('lot_id', $request->input('lot_id'))
                            ->orderBy('bet_price', 'desc')
                            ->orderBy('created_at', 'asc')
                            ->take(5)
                            ->get()
                            ->toArray();
        
       $last_user_bets = DB::table('bets')
                            ->join('users', 'bets.user_id', '=', 'users.id')
                            ->select('bets.*', 'users.username')
                            ->where('lot_id', $request->input('lot_id'))
                            ->where('user_id', $request->input('user_id'))
                            ->orderBy('bet_price', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get()
                            ->toArray();

        return Response::json([$last_five_bets, $last_user_bets]);
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
}
