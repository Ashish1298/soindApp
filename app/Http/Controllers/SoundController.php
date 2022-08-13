<?php

namespace App\Http\Controllers;

use App\Models\Sound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SoundController extends Controller
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
        try {
            $request->validate([
                'image'=>'required',
                'sound'=>'required'

            ]);
            $sound = new Sound();
            if($request->file('image')){
                $file = $request->file('image');
                $filename= $file->getClientOriginalName();
                $file->move(public_path('image'), $filename); 
                $sound ['image']= $filename;
                
                if($request->file('sound')){
                    $sound_file = $request->file('sound');
                    $sound_file_name= $sound_file->getClientOriginalName();
                    $sound_file->move(public_path('sound'), $sound_file_name); 
                    $sound ['sound']= $sound_file_name;
                } 
            }
            $sound ['title']= $request->title;
            $sound->save();

        } catch (\Exception $e) {
            dd($e);
            return redirect()-> back()->with('error', 'there is error in'. $e);
        }
        return redirect()-> back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function show(Sound $sound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function edit(Sound $sound ,$id)
    {
        $item = Sound::find($id);
        return view('update', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sound $sound,$id)
    {
        try {
            $request->validate([
                'image'=>'required',
                'sound'=>'required'

            ]);
            $sound = Sound::find($id);
            if($request->file('image')){
                $file = $request->file('image');
                $filename= $file->getClientOriginalName();
                $file->move(public_path('image'), $filename); 
                $sound ['image']= $filename;
                
                if($request->file('sound')){
                    $sound_file = $request->file('sound');
                    $sound_file_name= $sound_file->getClientOriginalName();
                    $sound_file->move(public_path('sound'), $sound_file_name); 
                    $sound ['sound']= $sound_file_name;
                }
            }
            $sound ['title']= $request->title;
            $sound->update();
            

        } catch (\Exception $e) {
            dd($e);
            return redirect()-> back()->with('error', 'there is error in'. $e);
        }
        return redirect()-> route('home');
    }

    public function delete(Request $request, $id){
        $data = Sound::find($id);
        $destination1 ='image/'.$data->image;
        $destination2 ='sound/'.$data->sound;
        if(File::exists($destination1,$destination2)){

            File::delete($destination1,$destination2);
        }
        $data->delete();
        return redirect()->back();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sound $sound)
    {
        //
    }
}
