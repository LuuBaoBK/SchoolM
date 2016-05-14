<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\tkb;
use App\Model\Teacher;
use App\Model\Subject;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\Sysvar;

class ScheduleControler extends Controller
{
   
    public function menu(){
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        $DSNguonLuc = null;
        $tongtiet = 0;
        $dem = 0;
        $tongsolop = Classes::where('id', 'like', $year.'%')->get()->count();
        $SOTIETDAY1TUANGV = 40;
        $dktaotkb = true;
        foreach (Subject::all() as $key => $Mon) {
            $hientai = Teacher::where('group', '=', $Mon->id)->where('active','=','1')->get()->count();
            $addnew[0] = $Mon->subject_name;
            $addnew[1] = $hientai;
            $toithieu = (int)($Mon->total_time * $tongsolop / $SOTIETDAY1TUANGV)+1;
            $addnew[2] = $toithieu;
            $DSNguonLuc[$key] = $addnew;
            $tongtiet += $Mon->total_time;
            if($hientai < $toithieu)
                $dktaotkb = false;
        }
        $somon = Subject::all()->count();
        $addnew[0] = "Số tiết học trong tuần";
        $addnew[1] = $tongtiet;
        $addnew[2] = 46;
        if($tongtiet > 46)
            $dktaotkb = false;
        $DSNguonLuc[$somon] = $addnew;
        $cotkb = false;
        if(tkb::all()->count() > 0)
            $cotkb = true;
        return view("schedule.menu")->with('nguonluc', $DSNguonLuc)->with("dk", $dktaotkb)->with('cotkb', $cotkb);
    }


    public function createnewphancong(){
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        $this->TaoPhanCongMoi();

        $DSPHANCONG  = $this->getDSPCTheoGV($year);
        
        $check = $this->checkPhanCong();  

        $DSTHEOLOP = $this->getDSPCTheoClass($year);
       
        $result['danhsachgv'] =  $DSPHANCONG;
        $result["check"] =  $check;
        $result['danhsachlop'] = $DSTHEOLOP;

       return $result;
        //return "oke";
    }

    public function chinhsuaphancong(){
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;

        $DSPHANCONG = $this->getDSPCTheoGV($year);
        $check      = $this->checkPhanCong();
        $listsubject = $this->getListSubject();
        $DSTHEOLOP  =   $this->getDSPCTheoClass($year);

        return view('schedule.phanconghientai')
                ->with('danhsachgv',    $DSPHANCONG)
                ->with("check",         $check)
                ->with("listsubject",   $listsubject)
                ->with("dshtheolop",    $DSTHEOLOP);
    }


    public function getListSubject(){
        foreach (Subject::all() as $key => $Mon) {
            $listsubject[$key] = $Mon->subject_name;
        }
        return $listsubject;
    }

    public function checkredirection(){
        return $this->checkPhanCong();
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

    public function getDSPCTheoGV($year){//return ds giao vien sap xep theo thu tu cac mon hoc
        //[id][fullname][subjectname][classhome][class respond][.....]
        $result = null;
        $dem  = 0;

        foreach (Subject::all() as $Mon) {
            $DSGV = Teacher::where('group', "=", $Mon->id)->where('active','=','1')->get();
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


    public function phancong_index(){
        $listsubject = $this->getListSubject();
        return view('schedule.phancong_index')->with("listsubject", $listsubject);
    }

    public function tkbgv_index(){
        return view("schedule.tkbgv_index");
    }

    public function getNewSchedule(){

        $year = substr(Date('Y'), 2);
        if(date("m") <= 8)
            $year--;
        tkb::truncate();
        $thoikhoabieu   = $this->createnewschedule();
        $bangphancong   = $this->getDSPCTheoGV($year);
        $randomngay     = $this->randomlist(5);
        $randomtietngay = $this->randomlist(10);
        $randomtiettuan = $this->randomlist(50);
        $randomteacher  = $this->randomlist(Teacher::where('active','=','1')->count());


        foreach ($randomteacher as $row){//Uu tien cho giao vien chu nhiem
            $teacher = $thoikhoabieu[$row];// = bangphancong[$row]
            for($ngay = 0; $ngay < 5; $ngay++){//xep theo ngay 1 ngay khong dc qua 2 tiet
                for($tiet = 0; $tiet < 10; $tiet ++){
                    $lop = $teacher[3];
                    if($lop == "")
                        continue;
                    $colum = $randomngay[$ngay]*10 + $randomtietngay[$tiet] + 5;//vi tri tren tkb
                    if($thoikhoabieu[$row][$colum] == "" && $this->count_class_col($lop, $colum, $thoikhoabieu) == 0 
                        &&  $this->count_class_row($lop, $row, $thoikhoabieu ) < Teacher::where("id", "=", $teacher[0])->first()->teach->total_time 
                        &&  $this->gioihanngay($lop, $row, $colum, $thoikhoabieu)){
                        $thoikhoabieu[$row][$colum] = $lop;
                        $thoikhoabieu[$row][4]--;
                    }
                }
            }
        }

        foreach ($randomteacher as $row){//Xep cho cac lop con lai, random theo ngay->uu tien xep cac mon nhieu tiet
            $teacher = $bangphancong[$row];
            $sllop = count($teacher) - 4;
            if($sllop <= 0 || $thoikhoabieu[$row][4] == 0)//he tiet day hay da pphan cong xong
                continue;
            $randlop = $this->randomlist($sllop);
            foreach( $randlop as $rowlop){
                $lop = $teacher[$rowlop + 4];
                foreach ($randomngay as $key1 => $ngay) {
                    for($tiet = 0; $tiet < 10; $tiet ++){
                        $colum = $ngay*10 + $tiet + 5;

                        if($thoikhoabieu[$row][$colum] == "" && $this->count_class_col($lop, $colum, $thoikhoabieu) == 0 
                        &&  $this->count_class_row($lop, $row, $thoikhoabieu ) < Teacher::where("id", "=", $teacher[0])->first()->teach->total_time 
                        &&  $this->gioihanngay($lop, $row, $colum, $thoikhoabieu)){
                            $thoikhoabieu[$row][$colum] = $lop;
                            $thoikhoabieu[$row][4]--;
                        }
                    }
                }
            }
        }


        foreach ($randomteacher as $row){//Xep cho cac lop con lai, random theo ngay->uu tien xep cac mon nhieu tiet
            $teacher = $bangphancong[$row];
            $sllop = count($teacher) - 4;
            if($sllop <= 0 || $thoikhoabieu[$row][4] == 0)//he tiet day hay da pphan cong xong
                continue;
            $randlop = $this->randomlist($sllop);
            foreach($randlop as $rowlop){
                $lop = $teacher[$rowlop + 4];
                foreach ($randomtiettuan as $tiet) {
                    $colum = $tiet +  5;
                    if($thoikhoabieu[$row][$colum] == "" && $this->count_class_col($lop, $colum, $thoikhoabieu) == 0 
                        &&  $this->count_class_row($lop, $row, $thoikhoabieu ) < Teacher::where("id", "=", $teacher[0])->first()->teach->total_time 
                        &&  $this->gioihanngay($lop, $row, $colum, $thoikhoabieu)){
                            $thoikhoabieu[$row][$colum] = $lop;
                            $thoikhoabieu[$row][4]--;
                    }
                }
            }
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
            for($i = 0; $i < 50; $i++){
                    $col = $i +  5;
                    $this->xulitrung($thoikhoabieu, $row, $col);
            }
            
        }
        

        tkb::truncate();
        for($i = 0; $i < count($thoikhoabieu);$i++){
            $addnew = null;
            $addnew = new tkb;
            $addnew->teacher_id = $thoikhoabieu[$i][0];
            $addnew->teacher_name = $thoikhoabieu[$i][1];
            $addnew->subject_name= $thoikhoabieu[$i][2];
            $addnew->homeroom_class = $thoikhoabieu[$i][3];
            $addnew->sotietconlai = $thoikhoabieu[$i][4];
            for($j = 0; $j < 50; $j++){
                $pro = "T".$j;
                $addnew->$pro = $thoikhoabieu[$i][$j+5];
            }

            $addnew->save();
        }

        //update time
        $date = date("d");
        $month = date("m");
        $year = date("Y");
        $time = Sysvar::where('id','=','tkb_date')
                      ->update(['value' => $date."-".$month."-".$year ]);
        //End Update Time

        $dsloptrung = $this->checkTKB();
        $result['dsloptrung'] = $dsloptrung; 
        $result['thoikhoabieu'] = $thoikhoabieu; 
        return $result;
        //return "oke";
    }

    public function createnewschedule(){
        $year = substr(Date('Y'), 2);
       if(date("m") <= 8)
            $year--;
       $listclass = Classes::where("id", "like", $year."%");

       $thoikhoabieu = null;
       $count_gv = 0;
       foreach (Subject::all() as $key1 => $subject) {
           $listTearcherofSub = Teacher::where("group", "=", $subject->id)->where('active','=','1')->get();
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
       //return "oke";
    }

    public function TaoPhanCongMoi(){
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        //tkb::truncate();
        Phancong::where("class_id", "like", $year."%")->delete();
        $DSLOPHOC = Classes::where("id", "like", $year."%")->get();
        $DSMONHOC = Subject::all();
        $DSGIAOVIEN = Teacher::where('active','=','1')->get();
       
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

            $DSGV1Mon = Teacher::where("group","=", $Mon->id)->where('active','=','1')->get();
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

            $agv = 0;
            $offset = 0;
            $agv = (int)(count($DSLOPChuaPC)/count($DSGV1Mon));
            $offset = count($DSLOPChuaPC)%count($DSGV1Mon);

            $offset . "". $Mon->id ." ".count($DSGV1MonSorted). "<br>";
            shuffle($DSLOPChuaPC);
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
        // // Xoa mon Hóa lớp 6,7
        // $DSGV_Hoa = Teacher::select('id')->where('group','=','4')->get();
        // Phancong::where('class_id','like',$year."_6%")->whereIn('teacher_id',$DSGV_Hoa)->delete();
        // Phancong::where('class_id','like',$year."_7%")->whereIn('teacher_id',$DSGV_Hoa)->delete();
    }

    public function edit(Request $request){

        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;

        $id = $request['id'];
        $PC = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $id)->get();
        $phancong = null;
        for($i = 0; $i < $PC->count(); $i++){
            $phancong[$i] = $PC[$i]->classes->classname;
        }
        
        $chuaphancong = null;
        $dslophoc = Classes::where("id", "like", $year."%")->get();
        $count_chua = 0;

        for($i = 0; $i < $dslophoc->count(); $i++){
            $kt = false;
            foreach ($dslophoc[$i]->phancongs as $pc) {
                if($pc->teacher_id == $id ){
                    $kt = true;
                    break;
                }
            }
            if(!$kt){
                $chuaphancong[$count_chua]=$dslophoc[$i]->classname;
                $count_chua++;
            }
            
        }

        $lopcn = Classes::where("id", "like", $year."%")->where("homeroom_teacher", "=", $id)->first()['classname'];
        $teacher = Teacher::where("id", "=", $id)->get();
        $teacher = $teacher[0];
        $msgv = $id;
        $name = $teacher->user->fullname;
        $subj = $teacher->teach->subject_name;
        $giaovien['id'] = $msgv;
        $giaovien['name'] = $name;
        $giaovien['lopcn'] = $lopcn;
        $giaovien['phancong'] = $phancong;
        $giaovien['chuaphancong'] = $chuaphancong;
        $giaovien['subj'] = $subj;

        return $giaovien;
    }

    public function addnew(Request $request){
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        $id = $request['id'];
        $listClass = $request['listClass'];

        for($i = 0; $i < count($listClass); $i++){
            $addnew = new Phancong;
            $addnew->teacher_id = $id;
            $class_id = Classes::where("id", "like", $year."%")->where("classname", "=", $listClass[$i])->first();
            $addnew->class_id = $class_id->id;
            $addnew->save();
        };
        
        
        $check = $this->checkPhanCong();  

       return $check;
    }

    public function removeclass(Request $request){
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        $id = $request['id'];
        $listClass = $request['listClass'];
        for($i = 0; $i < count($listClass); $i++){
            $class_id = Classes::where("id", "like", $year."%")->where("classname", "=", $listClass[$i] )->first();
            $class_id = $class_id->id;
            Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $id)->where("class_id", "=", $class_id)->delete();
        }
     
        return $this->checkPhanCong();
    }


    public function checkPhanCong(){
    
        $dsloptrung = null;
        $num_trung = 0;
        $dschuaphan = null;
        $num_chuaphan = 0;
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;

        $dsphancong = Phancong::where("class_id", "like", $year."%")->get();
        
        foreach ($dsphancong as $pc1) {
            $count = 0;
            foreach($dsphancong as $pc2){//kiem tra xem co bi trung khong
                if($pc1->teacher_id != $pc2->teacher_id and $pc1->class_id == $pc2->class_id and $pc1->teacher->teach->id == $pc2->teacher->teach->id){
                    $count++;        
                }
            }
            
            if($count > 0){//neu trung thi cho vao trong list bi trung
                $isexisted = false;
                for ($i = 0; $i < count($dsloptrung) ;$i++){
                    if($dsloptrung[$i][0] == $pc1->classes->classname and $dsloptrung[$i][1] == $pc1->teacher->teach->subject_name){
                        $isexisted = true;
                    } 
                }
                if(!$isexisted){
                    $dsloptrung[$num_trung] = array($pc1->classes->classname, $pc1->teacher->teach->subject_name);
                    $num_trung++;

                }
            }
        }

        $dsmonhoc = Subject::all();
        $dslophoc = Classes::where("id", "like", $year."%")->get();
        foreach ($dsmonhoc as $mon) {
            foreach($dslophoc as $lophoc){
                $chuaday = true;
                foreach($dsphancong as $phancong){
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
        
        return $result;
    }

    public function checkTKB(){
        //kiem tra nhung lop chua phan cong
        $DSLOPChuaPC = null;
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        $dem  = 0;
        foreach (tkb::all() as $Gv) {
            if($Gv->sotietconlai != 0){
                $DSDuocPhan = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $Gv->teacher_id)->get();
                $sotietquydinh = $Gv->teacher->teach->total_time;
                foreach ($DSDuocPhan as $LopDcPhan) {
                    $sotietdaday = 0;
                    for($i = 0; $i < 50; $i++){
                        $t = "T".$i;
                        if($Gv->$t == $LopDcPhan->classes->classname)
                            $sotietdaday++;
                    }
                    if($sotietquydinh > $sotietdaday)
                        $DSLOPChuaPC[$dem++] = array($Gv->teacher_id , $Gv->teacher->teach->subject_name, $LopDcPhan->classes->classname, $sotietquydinh - $sotietdaday); 

                }
            }
        }

        // kiem tra nhung lop pan cong bi trung
        $DSTRUNG = null;
        $dem = 0;
        for($i = 0; $i < 50; $i++){
            $t = "T".$i;
            $DSLOPHOC = Classes::where("id", "like", $year."%")->get();
            foreach ($DSLOPHOC as $lophoc) {
                $count_day = 0;
                foreach (tkb::all() as $Gv) {
                    if($Gv->$t == $lophoc->classname)
                    $count_day++;
                }

                if($count_day > 1)
                    $DSTRUNG[$dem++] = array($lophoc->classname, $i, $count_day);
            }
            
        }
        
        return $DSTRUNG;
    }


    public function tkbgvthaydoi_index(){
        return view('schedule.tkbgvthaydoi_index');
    }

    
    public function tkbgvthaydoi_capnhat(){

        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        
        //$thoikhoabieu   = $this->createnewschedule();
        $bangphancong   = $this->getDSPCTheoGV($year);
        $randomngay     = $this->randomlist(5);
        $randomtietngay = $this->randomlist(10);
        $randomtiettuan = $this->randomlist(50);
        $randomteacher  = $this->randomlist(Teacher::where('active','=','1')->count());
        

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

        //update time
        $date = date("d");
        $month = date("m");
        $year = date("Y");
        $time = Sysvar::where('id','=','tkb_date')
                      ->update(['value' => $date."-".$month."-".$year ]);
        //End Update Time

        $DSLOPTRUNG = $this->checkTKB();
        $result['thoikhoabieu'] = $thoikhoabieu;
        $result['dsloptrung'] = $DSLOPTRUNG;
        return $result;        
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

    public function xulitrung(&$TKB, $row, $col){
        if($this->count_lop($TKB, $col, $TKB[$row][$col]) > 1){
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

            if($this->isTrungtren($TKB, $row, $col, $rowT))
            {
            } 
            else if($this->isTrungduoi($TKB, $row, $col, $rowT)){
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
                $count++;
            }
        
        return $count;
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

    public function tkblop_index()
    {
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        $thoikhoabieu = tkb::all();
        $ds_lh = Classes::where("id", "like", $year."%")->get();
        for($i = 0; $i < $ds_lh->count(); $i++)
            $danhsachlop[$i] = $ds_lh[$i]->classname;

        for( $i = 0; $i < count($danhsachlop); $i++){
            for( $j = 0; $j < 52; $j ++){
                $motlop[$j]="";
            }
            $motlop[0] = $i+1;//stt 
            $motlop[1] = $danhsachlop[$i];
            $motlop[2] = "cc";
            $motlop[11] = "cc";
            $motlop[46] = "sh";
            $motlop[51] = "sh";
            $thoikhoabieu_lophoc[$i] = $motlop;
        }

        for ($j = 0; $j < count($thoikhoabieu_lophoc); $j++) {
            foreach ($thoikhoabieu as $gv) {
                for($i = 0 ; $i < 50; $i++){
                    $pro = "T".$i;
                    if($gv->$pro == $thoikhoabieu_lophoc[$j][1]){
                        $thoikhoabieu_lophoc[$j][$i + 2] = "<span>".$gv->subject_name . "</span><br><span>". $gv->teacher_id."</span>";
                    }
                }
            }
        }

        return view('schedule.tkblop_index')->with("thoikhoabieu", $thoikhoabieu_lophoc);
    }

    public function tkbhientai(){
        $year = substr(date('Y'),2);
        if(date("m") < 8)
            $year--;
        foreach(tkb::all() as $key => $gv){
            $addnew = null;
            $addnew[0] = $gv->teacher_id;
            $addnew[1] = $gv->teacher_name;
            $addnew[2] = $gv->subject_name;
            $addnew[3] = $gv->homeroom_class;
            $addnew[4] = $gv->sotietconlai;
            for($i = 0; $i < 50 ; $i++) {
                $t = "T".$i;
                $addnew[$i + 5] = $gv->$t;
            }
            
            $thoikhoabieu[$key] = $addnew;
        }

        $DSLOPChuaPC = $this->checkTKB();

        return view('schedule.xemtkbhientai')->with('thoikhoabieu', $thoikhoabieu)->with("chuaphan", $DSLOPChuaPC);         
    }

    public function phancongcacnam(){
        return view('schedule.phancongcacnam');
    }

    public function bangphancongcu(Request $request){
        $year = $request['year'];
        //$year = 14;//$request['year'];
        $DSPHANCONG = null;
        $pc = Phancong::where("class_id", "like", $year."%")->get();
        if($pc->count() == 0)
            return null;
        $DSGV = Teacher::all();
        foreach ($DSGV as $key => $value) {
            $addnew = null;
            $addnew[0] = $value->id;
            $addnew[1] = $value->user->fullname;
            $addnew[2] = $value->teach->subject_name;
            $addnew[3] = Classes::where("id", "like", $year."%")->where("homeroom_teacher", "=", $value->id)->first();
            if($addnew[3] != null){
                $addnew[3] = $addnew[3]->classname;
            }
            else $addnew[3] = "";
            $listclass = Phancong::where("teacher_id", "=", $value->id)->where("class_id", "like", $year."%")->get();
            foreach ($listclass as $key2 => $value2) {
                $addnew[$key2 + 4] = $value2->classes->classname;
            }

            $DSPHANCONG[$key] = $addnew;

        }

        return $DSPHANCONG;
        //return "oke";

    }


    // public function phanconglop(){
    //     $year = substr(date('Y'),2);
    //     if(date("m") < 8)
    //         $year--;
    //     $DSPHANCONG = null;
    //     $dem  = 0;
    //     foreach (Subject::all() as $Mon) {
    //         $DSGV = Teacher::where('group', "=", $Mon->id)->get();
    //         foreach ($DSGV as $GV) {
    //             $addnew = null;
    //             $addnew[0] = $GV->id;
    //             $addnew[1] = $GV->user->fullname;
    //             $addnew[2]  = $GV->teach->subject_name;
    //             $addnew[3] = Classes::where('id', "like", $year.'%')->where("homeroom_teacher", "=", $GV->id)->first();
    //             if($addnew[3] == null)
    //                 $addnew[3] = "";
    //             else
    //                 $addnew[3] = $addnew[3]->classname;

    //             $DSPC = Phancong::where("class_id", "like", $year."%")->where('teacher_id', '=', $GV->id)->get();
    //             foreach ($DSPC as $key => $Lop) {
    //                 $addnew[$key + 4] = $Lop->classes->classname;
    //             }
    //             $DSPHANCONG[$dem++] = $addnew;
    //         }
    //     }
    //     $check = $this->checkPhanCong();    

    //     $DSTHEOLOP = null;
        
    //     foreach (Classes::where("id", "like", $year."%")->get() as $key => $Lop) {
    //         $addnew = null;
    //         $addnew[0] = $Lop->classname;
    //         foreach (Subject::all() as $key2 => $Mon) {
    //             $addnew[$key2 + 1] = "";
    //             $PCL = Phancong::where("class_id", "=", $Lop->id)->get();
    //             //echo "count". $PCL->count();
    //             foreach ($PCL as $Gv) {
    //                 if($Gv->teacher->teach->id == $Mon->id){
    //                     $addnew[$key2+1] = $Gv->teacher->user->fullname;
    //                     break;
    //                 }
    //             }
    //         }
    //         $DSTHEOLOP[$key] = $addnew;
    //     }

    //     $listsubject = null;
    //     foreach (Subject::all() as $key => $Mon) {
    //         $listsubject[$key] = $Mon->subject_name;
    //     }

    //     return view('schedule.phanlop')->with('danhsachgv', $DSPHANCONG)->with("check", $check)->with('dshtheolop', $DSTHEOLOP)->with('listsubject', $listsubject);
    // }

    public function updatetkbgv(Request $request){
        $tkb = $request['tkbgv'];
        foreach ($tkb as $key1 => $rowgv) {
            $update = tkb::where("teacher_id", "=", $rowgv[0])->first();

            for( $i = 0; $i < 50; $i++){
                $tiet = "T".$i;
                $update->$tiet = $rowgv[$i + 5];
            }
            
            $update->save();
        }

        //update time
        $date = date("d");
        $month = date("m");
        $year = date("Y");
        $time = Sysvar::where('id','=','tkb_date')
                      ->update(['value' => $date."-".$month."-".$year ]);
        //End Update Time
            
        return $tkb;
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

    public function printcheck2($arr){
        if($arr){
            for($i = 0; $i < count($arr); $i++)
                echo $arr[$i]. "|";
        }
    }


    public function updatetkbclass(Request $request){
        $listclass = $request['listclass'];
        $listteacher = null;

        $listteacher = $this->createnewschedule();
        foreach ($listteacher as $key1 => $oneteacher) {
            foreach ($listclass as $class) {
                for($i = 0; $i < 50; $i++){
                    if($class[$i + 2] == $oneteacher[0])
                        $oneteacher[$i + 5] = $class[1];
                }
            }
            $listteacher[$key1] = $oneteacher;   
            $teacher = tkb::where("teacher_id", "=", $oneteacher[0])->first();
            for($j = 0; $j < 50; $j++){
                $t = "T".$j;
                $teacher->$t = $oneteacher[$j + 5];
            }
             $teacher->update();
        }

        //update time
        $date = date("d");
        $month = date("m");
        $year = date("Y");
        $time = Sysvar::where('id','=','tkb_date')
                      ->update(['value' => $date."-".$month."-".$year ]);
        //End Update Time
        return $listclass;
    }
}
