<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Lots;
use App\Bets;
use App\Users;
use App\Categories;

class HomeController extends Controller
{
    /**
     * Fill arrays to view
     *
     * @return array
     */

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
     * Show paginated not blocked lots
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lots = Lots::where('disabled', 0)->paginate(config('app.lots_on_page'));
        foreach ($lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
            $value['description'] = mb_substr($value['description'], 0, 100) . '...';
        };

        return view('home', ['lots' => $lots, 'title' => 'Действующие лоты']);
    }

    /**
     * Show paginated logged in user lots
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUserLots()
    {
        $lots = Lots::where('owner_id', Auth::user()->id)->paginate(config('app.lots_on_page')); 
        foreach ($lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
            $value['description'] = mb_substr($value['description'], 0, 100) . '...';
        };

        if (Auth::check()) {
            $username = ' ('. Auth::user()->username . ')';
        } else {
            $username = '';
        }

        return view('home', ['lots' => $lots, 'title' => 'Ваши лоты '.$username]);
    }    

    /**
     * Show paginated lots winned by logged in user
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUserWinLots()
    {
        $lots = Lots::where('winner_id', Auth::user()->id)->paginate(config('app.lots_on_page')); 
        foreach ($lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
            $value['description'] = mb_substr($value['description'], 0, 100) . '...';
        };

        if (Auth::check()) {
            $username = ' ('. Auth::user()->username . ')';
        } else {
            $username = '';
        }

        return view('home', ['lots' => $lots, 'title' => 'Выигранные Вами лоты '.$username]);
    }    

    /**
     * Show paginated blocked lots
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBlockedLots()
    {
        $lots = Lots::where('disabled', '<>', 0)->paginate(config('app.lots_on_page'));
        foreach ($lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
            $value['description'] = mb_substr($value['description'], 0, 100) . '...';
        };

        return view('home', ['lots' => $lots, 'title' => 'Заблокированные лоты']);
    }    
    
    /**
     * Show paginated lots by category
     *
     * @param  integer $category_id
     * @return \Illuminate\Http\Response
     */
    public function indexCategoryLots($category_id)
    {
        $name_cat = Categories::findOrFail($category_id)->name_cat;

        $lots = Lots::where('category_id', '=', $category_id)->paginate(config('app.lots_on_page'));
        
        foreach ($lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
            $value['description'] = mb_substr($value['description'], 0, 100) . '...';
        };

        return view('home', ['lots' => $lots, 'title' => 'Лоты категории: ' . $name_cat]);
    }        
}
