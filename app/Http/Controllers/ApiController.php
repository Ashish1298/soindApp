<?php

namespace App\Http\Controllers;

use App\Models\Sound;
use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function allsound()
    {
        $sound = Sound::all();
        return response([
            'status' => '200',
            'sound' => $sound,
        ]);
    }
    function create(Request $request)
    {

        try {
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

            return response([
                'status' => '200'
            ]);
        } catch (Exception $exception) {
            return response([
                'status' => '400',
                'exception' => 'error' . $exception
            ]);
        }
    
    }

    function singlesound($id)
    {
        $sound = Sound::find($id);

        return response([
            'status' => '200',
            'sound' => $sound,
        ]);
    }
}