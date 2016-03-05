<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use Input;
use Excel;
use Storage;
use App\Model\tkb;
use App\Model\Teacher;
use App\Model\Subject;
use App\Model\Classes;
use App\Model\Phancong;
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
        //return view('test');

         $dsloptrung = null;
        $num_trung = 0;
        $dschuaphan = null;
        $num_chuaphan = 0;

        $dsphancong = Phancong::where("class_id", "like", "15%")->get();
        
        foreach ($dsphancong as $pc1) {
            $count = 0;
            foreach($dsphancong as $pc2){//kiem tra xem co bi trung khong
                if($pc1->teacher_id != $pc2->teacher_id and $pc1->class_id == $pc2->class_id and $pc1->teacher->teach->id == $pc2->teacher->teach->id){
                    $count++;        
                }
            }
            
            if($count > 0){//neu trung thi cho vao trong list bi trung
                $isexist = false;
                for ($i = 0; $i < count($dsloptrung) ;$i++){
                    if($dsloptrung[$i][0] == $pc1->classes->classname and $dsloptrung[$i][1] == $pc1->teacher->teach->subject_name){
                        $isexist = true;
                    } 
                }
                if(!$isexist){
                    $dsloptrung[$num_trung] = array($pc1->classes->classname, $pc1->teacher->teach->subject_name);
                    $num_trung++;

                }
            }
        }

        //xu li chua phan cong
        $dsmonhoc = Subject::all();
        $dslophoc = Classes::where("id", "like", "15%")->get();
        foreach ($dsmonhoc as $mon) {
            if($mon->id != 9)
                continue;
            
            foreach($dslophoc as $lophoc){
                $chuaday = true;
                foreach($dsphancong as $phancong){
                     // echo "pc: gv". $phancong->teacher->teach->id.", mon ". $phancong->teacher->teach->subject_name."<br>";
                     // echo "xet lop: ".$lophoc->id ." ,mon". $mon->subject_name. "<br>"; 
                    if($phancong->teacher->teach->id == $mon->id and $lophoc->id == $phancong->class_id)
                    {
                        $chuaday = false;
                        break;
                    }
                }
                if($chuaday){
                    $dschuaphan[$num_chuaphan] = array($lophoc->classname, $mon->subject_name);
                    $num_chuaphan++;
                }
            }
        }
        
        $result['dsloptrung'] = $dsloptrung;
        $result['dschuaphan'] = $dschuaphan;
        $this->printcheck1($dsloptrung);
        $this->printcheck1($dschuaphan);
        //return $result;

    }
    
    public function xulitrung(&$TKB, $row, $tiet){
        if($this->count_lop($TKB, $tiet, $TKB[$row][$tiet+4]) >= 2){
            echo "<br>Phat hien co trung <br>";
            $rowT = null;
            $tiettrong = null;
            
            for( $i = 0 ; $i < 50 ; $i++){
                if($TKB[0][$i+4] == 'cc' || $TKB[0][$i+4] == 'sh' )
                    continue;
                if($this->count_lop($TKB, $i, $TKB[$row][$tiet+4]) == 0){
                    $tiettrong = $i;
                    break;
                }
            }
            echo "tiet thay the: " . $tiettrong ."<br>";

            if($this->isTrungtren($TKB, $row, $tiet, $rowT))
            {
                echo "tren, row: ". $row .", tiet ". $tiet .", RowT ". $rowT . "<br>"; 
            } 
            else if($this->isTrungduoi($TKB, $row, $tiet, $rowT)){
                echo "duoi, row: ". $row .", tiet ". $tiet .", RowT ". $rowT . "<br>";     
            }    
            $dem = $TKB[$rowT][$tiet + 4];
            $TKB[$rowT][$tiet + 4] =  $TKB[$rowT][$tiettrong + 4];
            $TKB[$rowT][$tiettrong + 4] = $dem;
            $this->xulitrung($TKB, $rowT, $tiettrong);
        }
    }

    
    public function isTrungtren($TKB, $row, $tiet, &$rowT){
        if($row == 0)
            return false;
        $col = $tiet + 4;
        $lop = $TKB[$row][$col];
        $row --;
        for($i = $row; $i >= 0; $i--)
            if($TKB[$i][$col] == $lop){
                $rowT = $i;
                return true;
            }
        return false;
    }


    public function isTrungduoi($TKB, $row, $tiet, &$rowT){
        if($row == count($TKB)-1)
            return false;
        $col = $tiet+ 4;
        $lop = $TKB[$row][$col];
        $row++;
        for($i = $row; $i < count($TKB) ; $i++)
            if($TKB[$i][$col] == $lop){
                $rowT = $i;
                return true;
            }
        
        return false;
    }

    
    public function count_lop($tkb,$tiet, $lop){
        
        $count = 0;
        $col = $tiet + 4;
        if($lop == "cc" || $lop == "" || $lop == "sh" )
            return -1;

        for($i = 0; $i < count($tkb);$i++)
            if($tkb[$i][$col] == $lop){
                //echo " thong tin ".$tkb[$i][$col].", ".$lop ."<br>";
                $count++;
            }
        
        return $count;
    }


     public function printcheck1($arr){
        if ($arr != null)

            foreach($arr as $key){
                echo "<br>";
                for( $i = 0; $i < count($key); $i++){
                    echo $key[$i] . " | ";
                }
            }
    }

    public function printchectkb($tkb){
        if(!$tkb)
            return;
        echo "<table><tr><th>id</th><th>name</th><th>mon</th><th>conlai</th>";

        for($i = 0; $i < 50; $i++){
            echo "<th>".$i."</th>";
        }
        echo "</tr>";
        
        foreach ($tkb as $gv) {
            echo "<tr>";
             for($i = 0; $i < 54; $i++){
                echo "<td>".$gv[$i]."</td>";
            }   
            echo "</tr>";
        }
        echo "</table";
        
        
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
