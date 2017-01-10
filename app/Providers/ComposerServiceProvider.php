<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Lots;
use App\Bets;
use App\Users;
use App\Articles;
use App\Categories;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * get data to all views
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view)
        {

            $top_lots = Lots::where('disabled', 0)
                ->orderBy('end_auction', 'asc')
                ->take(6)
                ->get()
                ->toArray();
            
            foreach ($top_lots as &$value) {
                $value['images'] = explode(';', $value['images'])[0];
                $value['description'] = mb_substr($value['description'], 0, 100) . '...';
                $value['owner_name'] = Users::find($value['owner_id'])->username;
                $value['bet_count'] = Lots::find($value['id'])->bets->count();

                $best_bet = Bets::where('lot_id', $value['id'])
                    ->orderBy('bet_price', 'desc')
                    ->orderBy('created_at', 'asc')
                    ->first();
                if ($best_bet) {
                    $final_price = $best_bet->bet_price;
                } else {
                    $final_price = '-';
                }
                $value['best_bet'] = $final_price;
            }  
            
            $all_lots = Lots::where('disabled', 0)
                ->get()
                ->toArray();
            foreach ($all_lots as $value) {
                $tmp_arr = explode(';', $value['images']);
                foreach ($tmp_arr as $tmp_val) {
                    $images[] = ['pic' => '/img/gallery/' . $value['id'] . '/' . $tmp_val, 'lot_id' => $value['id']];
                }
            };
            shuffle($images);

            $articles = Articles::all();

            if(Auth::user()) {
                $user_lot_count = Users::find(Auth::user()->id)->lots->count();
                $user_bet_count = Users::find(Auth::user()->id)->bets->count();
                $user_bet_count_win = Lots::all()->where('winner_id', Auth::user()->id)->count();
            } else {
                $user_lot_count = null;
                $user_bet_count = null;
                $user_bet_count_win = null;
            }

            $lot_count = Lots::count();
            $user_count = Users::count();

            $categories = Categories::where('parent_id', '=', 0)->get();
            $allCategories = Categories::all();

            $view->with(['lot_count' => $lot_count, 
                'user_count' => $user_count, 
                'user_lot_count' => $user_lot_count, 
                'user_bet_count' => $user_bet_count, 
                'user_bet_count_win' => $user_bet_count_win,
                'top_lots' => $top_lots,
                'images' => $images,
                'articles' => $articles,
                'categories' => $categories,
                'allCategories' => $allCategories]
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
