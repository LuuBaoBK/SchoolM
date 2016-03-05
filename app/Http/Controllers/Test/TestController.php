<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Excel;
use Storage;
use App\User;
use App\Transcript;

class TestController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(){
            // Excel::load('public\uploads\16783.xlsx', function($reader) {

            //     $results = $reader->all();
            //     $record = $reader->toArray();
            //     dd($record);

            // }, 'UTF-8');
       $score = Transcript::truncate();
    }

    public function uploadFiles() {
 
        $input = Input::all();
        
        $rules = array(
            'file' => 'image|max:3000',
        );
    
       // PASS THE INPUT AND RULES INTO THE VALIDATOR
        $validation = Validator::make($input, $rules);
 
        // CHECK GIVEN DATA IS VALID OR NOT
        if ($validation->fails()) {
            return Redirect::to('/')->with('message', $validation->errors->first());
        }
        
        
           $file = array_get($input,'file');
           // SET UPLOAD PATH
            $destinationPath = 'uploads';
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();
            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = rand(11111, 99999) . '.' . $extension;
            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($destinationPath, $fileName);
        
        // IF UPLOAD IS SUCCESSFUL SEND SUCCESS MESSAGE OTHERWISE SEND ERROR MESSAGE
        if ($upload_success) {
            return Redirect::to('/')->with('message', 'Image uploaded successfully');
        }
    }

    public function test_read(Request $request){
        $input = Input::all();

        // echo "Upload: " . $_FILES["fileToUpload"]["name"] . "<br />";
        // echo "Type: " . $_FILES["fileToUpload"]["type"] . "<br />";
        // echo "Size: " . ($_FILES["fileToUpload"]["size"] / 1024) . " Kb<br />";
        // echo "Stored in: " . $_FILES["fileToUpload"]["tmp_name"];

        $file = array_get($input,'fileToUpload');
       // SET UPLOAD PATH
        $destinationPath = 'uploads';
        // GET THE FILE EXTENSION
        $extension = $file->getClientOriginalExtension();
        // RENAME THE UPLOAD WITH RANDOM NUMBER
        $fileName = rand(11111, 99999) . '.' . $extension;
        // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
        $upload_success = $file->move($destinationPath, $fileName);

        return $this->read($fileName);
    }

    public function read($fileName){
        Excel::load('public\uploads\\'.$fileName, function($reader) {

            $results = $reader->all();
            $record = $reader->toArray();
            dd($record);

        }, 'UTF-8');
    }
}
