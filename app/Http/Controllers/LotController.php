<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lots;
use App\Bets;
use App\Categories;
use App\Pay_status;
use App\SimpleImage;
use File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class LotController extends Controller
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
        return redirect('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lotCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'lot_name' => 'required|unique:lots|max:200',
            'description' => 'required',
            'category_id' => 'required',
            'start_price' => 'required|numeric',
            'begin_auction' => 'required|date|before:end_auction',
            'end_auction' => 'required|date|after:begin_auction',
            'disabled' => 'boolean',
        ]); 

        $form = $request->all();

        if (isset($form['disabled'])) {
            $form['disabled'] = '1';
            $form['disable_reason_id'] = 6;
            $form['disabled_date'] = Carbon::now();            
        }
        else {
            $form['disabled'] = '0';
            $form['disable_reason_id'] = null;
            $form['disabled_date'] = null;
        }
        
        if(!empty($form['images'])) {
            $f_names = $form['images'];

            foreach ($f_names as $file) {
                $new_files[$file->getRealPath()] = str_random(8) . '.' . $file->getClientOriginalExtension();
            }
            $form['images'] = implode(';', $new_files);

            $lot = Lots::create($form);
            if ($lot) {
                $root = $_SERVER['DOCUMENT_ROOT'] . '/img/gallery/' . $lot->id;
                if(!file_exists($root)) {
                    if (!mkdir($root, 0777, true)) {
                        dump('Не могу создать папку для файлов');
                    }
                }
                foreach ($f_names as $file) {
                    $image = new SimpleImage;
                    $image->load($file->getRealPath());
                    $image->resizeToWidth(800);
                    $image->save($file->getRealPath());
                    $f_name = $new_files[$file->getRealPath()];
                    $file->move($root,$f_name);
                }
            }
        }
        else {
            $lot = Lots::create($form);
        }
        return redirect('lots/'.$lot->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lot = Lots::findOrFail($id);
        $category = $lot->category->name_cat;
        $owner = $lot->users->username;

        if ($lot->disabled) {
            $disable = 'ДА';    
        } else {
            $disable = 'НЕТ';
        }
        if ($lot->disabled_date) {
            $disable .= ' ('.$lot->disabled_date.') ';
        }
        if ($lot->disable_reason_id) {
            $disable .= $lot->disabl->block_descr;
        }

        if ($lot->final_price) {
            $final_price = $lot->final_price;
        } else {
            /* побеждает ставка с самой большой ценой, сделанная раньше всех */
            $best_bet = Bets::where('lot_id', $lot->id)
                                ->orderBy('bet_price', 'desc')
                                ->orderBy('created_at', 'asc')
                                ->first();
            if ($best_bet) {
                $final_price = $best_bet->bet_price;
            } else {
                $final_price = 'ставок не было';
            }
        }

        if ($lot->winner_id) {
            $winner = $lot->winner->username;
        } else {
            $winner = $lot->winner_id;
        }

        if ($lot->pay_status_id) {
            $pay_status = $lot->pay_status->pay_descr;
        } else {
            $pay_status = $lot->pay_status_id;
        }

        $pay_status_arr = Pay_status::all();

        $lot['images'] = explode(';', $lot['images']);

        return view('lots', ['lot' => $lot, 'category' => $category, 'owner' => $owner, 'disable' => $disable, 'final_price' => $final_price, 'winner' => $winner, 'pay_status' => $pay_status, 'pay_status_arr' => $pay_status_arr]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lot = Lots::find($id);
        if (empty($lot['images'])) {
            $old_images = $lot['images'];
        }
        else {
            $old_images = explode(';', $lot['images']);
        }

        $readonly = Bets::where('lot_id', $lot->id)->count() > 0 ? 'readonly' : '';

        return view('lotEdit', ['lot'=>$lot, 'old_images'=>$old_images, 'readonly' => $readonly]);
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
        $lot = Lots::find($id);

        $this->validate($request, [
            'lot_name' => 'max:200',
            'description' => 'required',
            'category_id' => 'required',
            'start_price' => 'required|numeric',
            'begin_auction' => 'required|date|before:end_auction',
            'end_auction' => 'required|date|after:begin_auction',
            'disabled' => 'boolean',
        ]); 
        $root = $_SERVER['DOCUMENT_ROOT'] . '/img/gallery/' . $lot->id;
        $form = $request->all();

        if (isset($form['disabled'])) {
            $form['disabled'] = '1';
            $form['disable_reason_id'] = 6;
            $form['disabled_date'] = Carbon::now();            
        }
        else {
            $form['disabled'] = '0';
            $form['disable_reason_id'] = null;
            $form['disabled_date'] = null;
        }

        if (!empty($form['old_img'])) {
            $all_img = $form['old_img'];
        } else {
            $all_img = array();
        }

        if(!file_exists($root)) {
            if (!mkdir($root, 0777, true)) {
                dump('Не могу создать папку для файлов');
            }
        }

        if(!empty($form['images'])) {
            $f_names = $form['images'];

            foreach ($f_names as $file) {
                $new_files[$file->getRealPath()] = str_random(8) . '.' . $file->getClientOriginalExtension();
            }

            $all_img = array_merge($all_img, $new_files);

            if ($lot) {
                foreach ($f_names as $file) {
                    $image = new SimpleImage;
                    $image->load($file->getRealPath());
                    $image->resizeToWidth(800);
                    $image->save($file->getRealPath());
                    $f_name = $new_files[$file->getRealPath()];               
                    $file->move($root,$f_name);                
                }
            }
        }

        $form['images'] = implode(';', $all_img);
        $lot->update($form);
        
        $filesInDir = File::files($root);
        foreach ($filesInDir as $file) {
            if(!in_array(basename($file), $all_img)) {
                File::delete($file);
            }
        }

        return redirect('lots/'.$lot->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lot = Lots::find($id);
        $root = $_SERVER['DOCUMENT_ROOT'] . '/img/gallery/' . $lot->id;
        $lot->delete();
        File::deleteDirectory($root);
        return redirect('userlots');
    }

    /**
     * Update the pay status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payStatus(Request $request)
    {
        $lot = Lots::findOrFail($request->input('lot_id'));
        $pay_status_id = $request->input('pay_status_id');
        if ($lot) {
            $lot->pay_status_id = $pay_status_id;
            $lot->save();
            $data = array( 'text' => 'success');
        } else {
            $data = array( 'text' => 'fail' . $pay_status_id );
        }
        return Response::json($data);
    }          
 
}
