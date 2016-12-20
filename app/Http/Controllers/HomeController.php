<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Lots;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lots = Lots::where('disabled', 0)->paginate(4); 
        foreach ($lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
        };

        $top_lots = Lots::where('disabled', 0)
            ->orderBy('end_auction', 'asc')
            ->take(5)
            ->get()
            ->toArray();
        
        foreach ($top_lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
            $value['description'] = mb_substr($value['description'], 0, 100) . '...';
        }  
        //dd($lots);

        return view('home', ['lots' => $lots, 'top_lots' => $top_lots, 'title' => 'Все лоты']);
    }

    public function indexUserLots()
    {
        $lots = Lots::where('owner_id', Auth::user()->id)->paginate(4); 
        foreach ($lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
        };

        $top_lots = Lots::where('disabled', 0)
            ->orderBy('end_auction', 'asc')
            ->take(5)
            ->get()
            ->toArray();
        
        foreach ($top_lots as &$value) {
            $value['images'] = explode(';', $value['images'])[0];
            $value['description'] = mb_substr($value['description'], 0, 100) . '...';
        }  
        //dd($lots);

        if (Auth::check()) {
            $username = ' ('. Auth::user()->username . ')';
        } else {
            $username = '';
        }

        return view('home', ['lots' => $lots, 'top_lots' => $top_lots, 'title' => 'Ваши лоты'.$username]);
    }    
}
