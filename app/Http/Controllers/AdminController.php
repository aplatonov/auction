<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Exception;
use Response;
use App\Users;
use App\Lots;
use App\Bets;
use Carbon\Carbon;
use App\Order;
use App\Mail\OrderShipped;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
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
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUsers()
    {
        $users = Users::paginate(config('app.users_on_page_admin'));

        return view('adminUsers', ['users' => $users, 'message'=>'']);
    }

    /**
     * Destroy a user instance after by valid user role.
     *
     * @param  integer  $id
     * @return string
     */
    public function destroyUser($id)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($id);
            $username = $user->username;
            try {
                $user->delete();
                return redirect()->back()->with('message', 'Пользователь '.$username.' удален');
            } catch (Exception $e) {
                return redirect()->back()->with('message', 'Невозможно удалить пользователя '.$username.'. Возможно у него есть лоты или ставки.');
            }
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для удаления пользователя');
        }
    }

    /**
     * Confirm user registration in DB
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmUser(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($request->input('user_id'));
            $user->confirmed = 1;
            $user->save();
            $data = array( 'text' => 'success' );
        } else {
            $data = array( 'text' => 'fail' );
        }
        return Response::json($data);
    }

    /**
     * Set in DB block field for user
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blockUser(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($request->input('user_id'));
            $user->valid = $request->input('action');
            $user->save();
            $data = array( 'text' => 'success' );
        } else {
            $data = array( 'text' => 'fail' . $request->input('action') );
        }
        return Response::json($data);
    }         

    /**
     * Grant user administrator rights in DB
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminUser(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($request->input('user_id'));
            $user->role_id = $request->input('action');
            $user->save();
            $data = array( 'text' => 'success' );
        } else {
            $data = array( 'text' => 'fail' . $request->input('action') );
        }
        return Response::json($data);
    }         

    /**
     * Return lots array in view
     *
     * @param  Illuminate\Http\Request  $request
     * @return view
     */
    public function showLots(Request $request)
    {
        $order = $request->get('order'); 
        $dir = $request->get('dir'); 
        $page_appends = null;

        $lots = DB::table('lots')
            ->select('lots.id as id',
                'lot_name',
                'categories.name_cat as name_cat',
                'images',
                'start_price',
                'users.username as owner_id',
                'begin_auction',
                'end_auction',
                'final_price',
                'users2.username as winner_id',
                'pay_status_id',
                'disabled_date',
                'disable_reason_id'
            )
            ->leftJoin('categories', 'lots.category_id', '=', 'categories.id')
            ->leftJoin('users', 'lots.owner_id', '=', 'users.id')
            ->leftJoin('users as users2', 'lots.winner_id', '=', 'users2.id');

        if ($order && $dir) {
            $lots = $lots->orderBy($order, $dir);
            $page_appends = [
                'order' => $order,
                'dir' => $dir,
            ];
        } 

        $lots = $lots->paginate(config('app.lots_on_page_admin'));
        $block_reasons = DB::table('block_reasons')->get()->toArray();

        $data['lots'] = $lots;
        $data['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data['page_appends'] = $page_appends;
        $data['block_reasons'] = $block_reasons;

        return view('adminLots', ['data' => $data, 'message'=>'']);
    }

    /**
     * Delete lot from DB
     *
     * @param  int  $id
     * @return string
     */
    public function deleteLot($id)
    {
        if (Auth::user()->role_id == 1) {
            $lot = Lots::findOrFail($id);
            $lotname = $lot->lot_name;
            try {
                $lot->delete();
                return redirect()->back()->with('message', 'Лот <strong>'.$lotname.'</strong> удален');
            } catch (Exception $e) {
                return redirect()->back()->with('message', 'Невозможно удалить лот <strong>'.$lotname.'</strong>.');
            }
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для удаления лота');
        }
    }    

    /**
     * Block lot in DB
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blockLot(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $lot = Lots::findOrFail($request->input('lot_id'));
            $disable_reason_id = $request->input('disable_reason_id');
            if ($disable_reason_id == 0) {
                $lot->disabled = 0;
                $lot->disable_reason_id = null;
                $lot->disabled_date = null;
                $new_date = '';
            } else {
                $lot->disabled = 1;
                $lot->disable_reason_id = $disable_reason_id;
                $lot->disabled_date = Carbon::now();
                $new_date = $lot->disabled_date->toDateTimeString();
            }
            $lot->save();
            $data = array( 'text' => 'success', 'new_date' => $new_date);
        } else {
            $data = array( 'text' => 'fail' . $disable_reason_id );
        }
        return Response::json($data);
    }          

    /**
     * Check lots in DB and block it if need
     *
     * @param  Illuminate\Http\Request  $request
     * @return string
     */
    public function checkLots(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            /*
             * проверяем все незаблокированные лоты, 
             * объявляем победителя (id в базу, письма победителю и хозяину),
             * пишем окончат. цену,
             * блокируем лот
             * пишем причину блокировки: 3-определен победитель (была хотя бы одна ставка)
             *                           4-истекло время (ставок не было)
             * в таблице ставок помечаем победившую ставку
            */

            $lots = Lots::where('disabled', '=', '0')->get();
            $lot_processed = 0;
            $lot_disabled = 0;

            foreach ($lots as $lot) {
                if ($lot->end_auction<=Carbon::now()) {
                    $lot_disabled++;
                    $lot->disabled = 1; 
                    $lot->disabled_date = Carbon::now();

                    /* побеждает ставка с самой большой ценой, сделанная раньше всех */
                    $best_bet = Bets::where('lot_id', $lot->id)
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

                    $data['link'] = '/lots/'.$lot->id;
                    if (isset($lot->winner->username)) {
                        $data['winner_name'] = $lot->winner->username;
                        $data['winner_email'] = $lot->winner->email;
                    } else {
                        $data['winner_name'] = 'победитель отсутствует';
                        $data['winner_email'] = 'admin@auction.ru';
                    }
                    $data['owner_name'] = $lot->users->username;
                    $data['owner_email'] =  $lot->users->email;
                    $data['lot_name'] = $lot->lot_name;
                    $data['final_price'] = $lot->final_price;
                    $data['finish_date'] = Carbon::now();

                    $lot->save();

                    Mail::send('layouts.finishlot', $data, function ($message) use ($data)
                        {
                            $message->to($data['owner_email'], $data['owner_name'])
                                ->cc($data['winner_email'], $data['winner_name'])
                                ->bcc('admin@auction.ru')
                                ->subject('Окончание торга по лоту ' . $data['lot_name'])
                                ->replyTo('admin@auction.ru');
                        });
                }
                $lot_processed++;
            }
            $near_lot = Lots::where('disabled', '=', '0')
                ->orderBy('end_auction', 'asc')
                ->first()->end_auction;
            return view('checkLots')->with(['message' => Carbon::now() . ' Лоты обработаны', 'stat' => 'Обработано лотов: ' . $lot_processed . '<br>Заблокировано лотов: ' . $lot_disabled . '<br>Рекомендуемая дата следующего запуска: ' . $near_lot]);
        } else {
            return view('checkLots')->with(['message' => 'Недостаточно прав для обработки торгов']);
        }    
    }
}
