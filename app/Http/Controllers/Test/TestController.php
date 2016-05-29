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
use App\Model\StudentClass;
use App\Model\Schedule;

use App\Model\Admin;
use App\Model\Sysvar;
use App;
use Chrisbjr\ApiGuard\Models\ApiKey;
use Illuminate\Console\Command;
class TestController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(){
        $apiKey = ApiKey::make('a_0000010');
        return $apiKey;
        $apiKey->save();
        // $apiKey = ApiKey::make($this->getOption('user-id', null), $this->getOption('level', 10), $this->getOption('ignore-limits', 1));
        // Phancong::where('class_id','like','15%')->delete();
        // tkb::truncate();
        // Schedule::truncate();
        // Phancong::truncate();
        return date("d-m-Y h:m:s");
    }
    // public function test(){
    //     $group = array(1,1,1,2,2,2,3,3,4,4,5,5,6,7,8,9,10,10,11,11,12,12,13,14,14);
    //     $subject_name = array("Toán", "Ngữ Văn", "Vật Lý", "Hóa Học", "Sinh Học", "Lịch Sử", "Địa Lý", "Âm Nhạc", "GDCD", "Thể Dục", "Tin Học", "Anh Văn", "Mỹ Thuật", "Công Nghệ");
    //     $position = array(2,3,3,3,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,5,5,5,6,6,6);
    //     shuffle($group);
    //     for($i=0; $i<=24; $i++){
    //         $offset = 9-strlen($i);
    //         $id = substr('t_0000000', 0, $offset);
    //         $id = $id.$i;
    //         $mobilephone = '09';
    //         $homephone = '08';
    //         for($k=0; $k<8; $k++){
    //             $mobilephone = $mobilephone.rand(0,9);
    //             $homephone = $homephone.rand(0,9);
    //         }
    //         DB::table('teachers')->insert([
    //             'id' => $id,
    //             'mobilephone' => $mobilephone,
    //             'homephone' => $homephone,
    //             'group' => $group[$i],
    //             'position' => $position[$i],
    //             'specialized' => $subject_name[$group[$i] - 1],
    //             'incomingday' => "2010-".rand(1,12)."-".rand(1,28),
    //             'active' => 1
    //         ]);
    //     }
    // }

    public function test1(){

        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        
        //$thoikhoabieu   = $this->createnewschedule();
        $bangphancong   = $this->getDSPCTheoGV($year);
        $randomngay     = $this->randomlist(5);
        $randomtietngay = $this->randomlist(10);
        $randomtiettuan = $this->randomlist(50);
        $randomteacher  = $this->randomlist(Teacher::all()->count());
        

        $sogiaovien = 0;
        foreach(tkb::all() as $key => $gv){
            $addnew = null;
            $addnew[0] = $gv->teacher_id;
            $addnew[1] = $gv->teacher_name;
            $addnew[2] = $gv->subject_name;
            $addnew[3] = $gv->homeroom_class;
            $addnew[4] = 0;
            $DSPHANCONG = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $gv->teacher_id)->get();
            for($i = 0; $i < 50 ; $i++) {
                $t = "T".$i;
                if($i == 0 || $i == 9 || $i == 44 || $i == 49){
                    $addnew[$i + 5] = $gv->$t;
                    continue;
                }
                $addnew[$i + 5] = "";
                foreach ($DSPHANCONG as $lop) {
                    if($lop->classes->classname == $gv->$t){
                        $addnew[$i + 5] = $gv->$t;
                        break;
                    }
                }
            }

            $countdaphan = 0;
            for($i = 0; $i < 50 ; $i++) {
                if($i == 0 || $i == 9 || $i == 44 || $i == 49){
                    continue;
                }
                if($addnew[$i + 5] != "")
                $countdaphan++;
            }
            $addnew[4] = $DSPHANCONG->count()*$gv->teacher->teach->total_time - $countdaphan;

            $thoikhoabieu[$key] = $addnew;
        }

        foreach ($bangphancong as $row => $teacher){
            $sllop = count($teacher) - 4;
            if($sllop <= 0 || $thoikhoabieu[$row][4] == 0)//he tiet day hay da pphan cong xong
                continue;
          
            $randlop = $this->randomlist($sllop);
            foreach ($randlop as $key1 => $rowlop) {
                $lop = $teacher[$rowlop + 4];
                foreach ($randomtiettuan as $tiet) {
                    $colum = $tiet +  5;
                    if($thoikhoabieu[$row][$colum] == ""
                        &&  $this->count_class_row($lop, $row, $thoikhoabieu ) < Teacher::where("id", "=", $teacher[0])->first()->teach->total_time 
                        &&  $this->gioihanngay($lop, $row, $colum, $thoikhoabieu)){
                            $thoikhoabieu[$row][$colum] = $lop;
                            $thoikhoabieu[$row][4]--;
                    }
                }
            }
        }

        foreach ($thoikhoabieu as $row => $Gv) {
            for($i = 0; $i < 5; $i++){
                for($j = 0; $j < 10; $j++){
                    $tiet = $i*10 + $j + 5;
                    $this->xulitrung($thoikhoabieu, $row, $tiet);
                }
            }
        }

        $this->printcheck1($thoikhoabieu);
        tkb::truncate();
        for($i = 0; $i < count($thoikhoabieu);$i++){
            $addnew = new tkb;
            $addnew->teacher_id     = $thoikhoabieu[$i][0];
            $addnew->teacher_name   = $thoikhoabieu[$i][1];
            $addnew->subject_name   = $thoikhoabieu[$i][2];
            $addnew->homeroom_class = $thoikhoabieu[$i][3];
            $addnew->sotietconlai   = $thoikhoabieu[$i][4];
            for($j = 0; $j < 50; $j++){
                $t = "T".$j;
                $addnew->$t = $thoikhoabieu[$i][$j+5];
            }

            $addnew->save();
        }

        $DSLOPChuaPC = $this->checkTKB();
        $result['thoikhoabieu'] = $thoikhoabieu ;
        $result['chuaphan'] = $DSLOPChuaPC;
        return $result;        
    }



   
     public function TaoPhanCongMoi()
    {
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        tkb::truncate();
        Phancong::where("class_id", "like", $year."%")->delete();
        $DSLOPHOC = Classes::where("id", "like", $year."%")->get();
        $DSMONHOC = Subject::all();
        $DSGIAOVIEN = Teacher::all();
       
        //xu li cho truong hop co giao vien chu nhiem
        foreach ($DSLOPHOC as $Lop) {
            $addnew = new Phancong;
            $addnew->teacher_id = $Lop->Teacher->id ;
            $addnew->class_id = $Lop->id;
            $addnew->save();
        }

        //xu li cho tat cac cac lop con lai
        $DSGVCN = null;
        $num = 0;
        foreach ($DSLOPHOC as $Lop) {
            $DSGVCN[$num] = $Lop->teacher;
            $num++;
        }

        foreach ($DSMONHOC as $Mon) {

            $DSGV1Mon = Teacher::where("group","=", $Mon->id)->get();
            if($DSGV1Mon->count() == 0)
                continue;

            //ds giao bo mon nhung khong chu nhiem
            $DSGV1MonSorted = null;
            $dem = 0;
            foreach ($DSGV1Mon as $Gv) {
                if(Classes::where("id","like", $year."%")->where("homeroom_teacher", "=",$Gv->id )->first() == null){
                    $DSGV1MonSorted[$dem] = $Gv;
                    $dem++;
                }
            }

            //ds giao bo mon la chu nhiem ve mon nay
            foreach ($DSGVCN as $Gv) {
                if($Gv->teach->id == $Mon->id){
                    $DSGV1MonSorted[$dem] = $Gv;
                    $dem++;
                }
            }
            
            //ds cac lop chua phan cong ve mon nay$DSLOPChuaPC = null;
            $dem = 0;
            $DSLOPChuaPC = null;
            foreach ($DSLOPHOC as $Lop) {
                if($Lop->teacher->teach->id != $Mon->id){
                    $DSLOPChuaPC[$dem] = $Lop;
                    $dem++;
                }
            }

            //tong so giao vien bo mon
            // tinh off set
            // tinh avg
            $agv = 0;
            $offset = 0;
            $agv = (int)(count($DSLOPChuaPC)/count($DSGV1Mon));
            $offset = count($DSLOPChuaPC)%count($DSGV1Mon);

            $offset . "". $Mon->id ." ".count($DSGV1MonSorted). "<br>";

            $count_lop = 0;
            for($i = 0; $i < $offset; $i++){
                for($j = 0; $j <= $agv; $j++){
                    $addnew = new Phancong;
                    $addnew->teacher_id = $DSGV1MonSorted[$i]->id;
                    $addnew->class_id = $DSLOPChuaPC[$count_lop]->id;
                    $addnew->save();
                    $count_lop++;    
                }
                
            }
            for($i = $offset; $i < count($DSGV1Mon); $i++){
                for($j = 0; $j < $agv; $j++){
                    $addnew = new Phancong;
                    $addnew->teacher_id = $DSGV1MonSorted[$i]->id;
                    $addnew->class_id = $DSLOPChuaPC[$count_lop]->id;
                    $addnew->save();
                    $count_lop++;    
                }
                
            }
        }

        
    }


    public function gioihanngay($lop, $row,  $col, $thoikhoabieu){
        $countNgay = 0;
        $countSang = 0;
        $countChieu = 0;

        $ngay = (int)(($col - 5)/10);
        $tietdau = $ngay*10 + 5;
        for($i = 0; $i < 10; $i++){
            if($thoikhoabieu[$row][$tietdau + $i] == $lop)
                $countNgay++;
        }

        $buoi = ($col - 5)%10;
        if($buoi < 5){
            for($i = 0; $i < 5; $i++){
                if($thoikhoabieu[$row][$tietdau + $i] == $lop){
                    if(abs($buoi - $i) != 1)//neu dung dieu kien nay thi toi da 2 tiet/buoi, khong thay doi dc
                        return false;
                    $countSang++;
                }
            }
        }else{//buoi chieu
            for( $i = 5; $i < 10; $i ++){
                if($thoikhoabieu[$row][$tietdau + $i] == $lop){
                    if(abs($buoi - $i) != 1)
                        return false;
                    $countChieu++;
                }
            }
        }

        if($countNgay < 4 || $countSang < 2 || $countChieu < 2)    
            return true;
        else 
            return false;
    }

    public function createnewschedule(){
        $year = substr(Date('Y'), 2);
       if(Date("M") <= 8)
            $year--;
       $listclass = Classes::where("id", "like", $year."%");

       $thoikhoabieu = null;
       $count_gv = 0;
       foreach (Subject::all() as $key1 => $subject) {
           $listTearcherofSub = Teacher::where("group", "=", $subject->id)->get();
           foreach ($listTearcherofSub as $key2 => $teacher) {
                $addnew    = null;
                $addnew[0] = $teacher->id;
                $addnew[1] = $teacher->user->fullname;
                $addnew[2] = $teacher->teach->subject_name;
                $addnew[3] = Classes::where("id", "like", $year."%")->where("homeroom_teacher", "=", $teacher->id)->first();
                if($addnew[3] == null)
                    $addnew[3] = "";
                else
                    $addnew[3] = $addnew[3]->classname;

                $addnew[4] = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $teacher->id)->get()->count()*$subject->total_time;
                
                for($i = 0; $i < 50; $i++)
                    $addnew[$i + 5] = "";
                $addnew[5]  = "cc" ;
                $addnew[14] = "cc";
                $addnew[49] = "sh";
                $addnew[54] = "sh";

                $thoikhoabieu[$count_gv] = $addnew;
                $count_gv++;
           }
       }
       return $thoikhoabieu;
    }

    public function kiemtratinhhoply(){
        //ham nay tra ve dieu kien co the cho vao them tiet hien tai hay khong??
        // viec xe dua tren so tiet day mon do
        // 1 hay 2 tiet thi khong cho phep
        // nhieu hon 2 tiet : chia thanh cac cum 2 tiet, va neu
        //-> xem thu no la buoi hoc nao, neu da co trong buoi hoc roi thi them, lien tiep trong buoi hoc do, 
        // tong so tiet phai be hon 3.
        // -> viec them lai tu dau lam

    }

    public function randomlist($num){
        $result = null;
        if($num > 0){
            for($i = 0; $i < $num; $i++)
                $result[$i] = $i;
        }
        shuffle($result);

        return $result;
    }

    public function count_class_col($class, $col, $tkb){
        $count = 0;
        for($i = 0; $i < count($tkb); $i++){
            if($tkb[$i][$col]  == $class)
                $count++;
        }

        return $count;
    }

    public function count_class_row($class, $row, $tkb){
        $count = 0;
        for($i = 0; $i < 50; $i++){
            if($tkb[$row][$i + 5] == $class)
                $count++;
        }

        return $count;
    }

    public function listSubject(){
        foreach (Subject::all() as $key => $Mon) {
            $listsubject[$key] = $Mon->subject_name;
        }

        return $listsubject;
    }

    public function getDSPCTheoClass($year){
        //lay theo nam nen tet cua cac lop cung la doc nhat
        //[classname][gv_toan][gv_van]... theo thu tu ds trong list subject

        $result = null;
        foreach (Classes::where("id", "like", $year."%")->get() as $key => $Lop) {
            $addnew = null;
            $addnew[0] = $Lop->classname;
            foreach (Subject::all() as $key2 => $Mon) {
                $addnew[$key2 + 1] = "";
                $PCL = Phancong::where("class_id", "=", $Lop->id)->get();
                foreach ($PCL as $Gv) {
                    if($Gv->teacher->teach->id == $Mon->id){
                        $addnew[$key2+1] = $Gv->teacher->user->fullname;
                        break;
                    }
                }
            }
            $result[$key] = $addnew;
        }

        return $result;
    }


     //get danh sach phan cong
    public function getDSPCTheoGV($year){//return ds giao vien sap xep theo thu tu cac mon hoc
        //[id][fullname][subjectname][classhome][class respond][.....]
        $result = null;
        $dem  = 0;

        foreach (Subject::all() as $Mon) {
            $DSGV = Teacher::where('group', "=", $Mon->id)->get();
            foreach ($DSGV as $GV) {
                $addnew = null;
                $addnew[0] = $GV->id;
                $addnew[1] = $GV->user->fullname;
                $addnew[2]  = $GV->teach->subject_name;
                $addnew[3] = Classes::where('id', "like", $year.'%')->where("homeroom_teacher", "=", $GV->id)->first();
                if($addnew[3] == null)
                    $addnew[3] = "";
                else
                    $addnew[3] = $addnew[3]->classname;

                $DSPC = Phancong::where("class_id", "like", $year."%")->where('teacher_id', '=', $GV->id)->get();
                foreach ($DSPC as $key => $Lop) {
                    $addnew[$key + 4] = $Lop->classes->classname;
                }
                $result[$dem++] = $addnew;
            }
        }

        return $result;
    }


    
    
    public function xulitrung(&$TKB, $row, $col){
        if($this->count_lop($TKB, $col, $TKB[$row][$col]) > 1){
            echo "<br>Phat hien co trung <br>";
            $rowT = null;
            $colempty = null;
            
            for( $i = 0 ; $i < 50 ; $i++){
                if($TKB[0][$i + 5] == 'cc' || $TKB[0][$i + 5] == 'sh' )
                    continue;
                if($this->count_lop($TKB, $i + 5, $TKB[$row][$col]) == 0){
                    $colempty = $i + 5;
                    break;
                }
            }
            echo "tiet thay the: " . $colempty ."<br>";

            if($this->isTrungtren($TKB, $row, $col, $rowT))
            {
                echo "tren, row: ". $row .", tiet ". ($col - 5) .", RowT ". $rowT . "<br>"; 
            } 
            else if($this->isTrungduoi($TKB, $row, $col, $rowT)){
                echo "duoi, row: ". $row .", tiet ". ($col - 5) .", RowT ". $rowT . "<br>";     
            }    
            $dem = $TKB[$rowT][$col];
            $TKB[$rowT][$col] =  $TKB[$rowT][$colempty];
            $TKB[$rowT][$colempty] = $dem;
            $this->xulitrung($TKB, $rowT, $colempty);
        }
    }

    
    public function isTrungtren($TKB, $row, $col, &$rowT){
        if($row == 0)
            return false;
        $lop = $TKB[$row][$col];
        $row --;
        for($i = $row; $i >= 0; $i--)
            if($TKB[$i][$col] == $lop){
                $rowT = $i;
                return true;
            }
        return false;
    }


    public function isTrungduoi($TKB, $row, $col, &$rowT){
        if($row == count($TKB)-1)
            return false;
        $lop = $TKB[$row][$col];
        $row++;
        for($i = $row; $i < count($TKB) ; $i++)
            if($TKB[$i][$col] == $lop){
                $rowT = $i;
                return true;
            }
        
        return false;
    }

    
    public function count_lop($tkb, $col, $lop){
        
        $count = 0;
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
