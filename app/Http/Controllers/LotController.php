<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lots;
use App\Categories;
use App\SimpleImage;
use File;
use Illuminate\Support\Facades\Auth;

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
        //return view('home');
        return redirect('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::all();
        return view('lotCreate', ['categories'=>$categories]);
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
            //'images.*' => 'mimes:jpeg,gif,png',

        ]); 

        $form = $request->all();

        if(!empty($form['images'])) {
            $f_names = $form['images'];


            foreach ($f_names as $file) {
                $new_files[$file->getRealPath()] = str_random(8) . '.' . $file->getClientOriginalExtension();
                //dump($file);
            }
            //dd(gd_info());
            $form['images'] = implode(';', $new_files);
            //dd($form);

            if (isset($form['disabled'])) {
                $form['disabled'] = '1';
            }
            else {
                $form['disabled'] = '0';
            }            

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
        $lot['images'] = explode(';', $lot['images']);

        return view('lots', compact('lot'));
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
        $categories = Categories::all();
        //dd($lot['images']);
        if (empty($lot['images'])) {
            $old_images = $lot['images'];
        }
        else {
            $old_images = explode(';', $lot['images']);
        }

        return view('lotEdit', ['lot'=>$lot, 'categories'=>$categories, 'old_images'=>$old_images]);
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
            //'images.*' => 'mimes:jpeg,gif,png',

        ]); 
        $root = $_SERVER['DOCUMENT_ROOT'] . '/img/gallery/' . $lot->id;

        $form = $request->all();
        //dd($lot, $form);

        if (isset($form['disabled'])) {
            $form['disabled'] = '1';
        }
        else {
            $form['disabled'] = '0';
        }

        if (!empty($form['old_img'])) {
            $all_img = $form['old_img'];
        } else {
            $all_img = array();
            //dd($form);
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
                    $file->move($root,$f_name);                }
            }
        }

        $form['images'] = implode(';', $all_img);
        $lot->update($form);
        
        //тут надо удалить все лишние файлы из папки
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
        //dd($id);
    }
}
