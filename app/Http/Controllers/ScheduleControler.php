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


class ScheduleControler extends Controller
{
   
    public function menu(){
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        $DSNguonLuc = null;
        $tongtiet = 0;
        $dem = 0;
        $tongsolop = Classes::where('id', 'like', $year.'%')->get()->count();
        $SOTIETDAY1TUANGV = 40;
        $dktaotkb = true;
        foreach (Subject::all() as $key => $Mon) {
            $hientai = Teacher::where('group', '=', $Mon->id)->get()->count();
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

    public function xemphancongcu(){
        //kiem tra
        //neu co tk tham thoi thi lay cai tam toi ra
        // neu khong co tam thoi thi lay cai moi nhat ra
        // trong truong hop nay chi don gian la lay cai moi nhat ra
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        $DSPHANCONG = null;
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
                $DSPHANCONG[$dem++] = $addnew;
            }
        }
        $check = $this->check();
        $listsubject = null;
        foreach (Subject::all() as $key => $Mon) {
            $listsubject[$key] = $Mon->subject_name;
        }
        $DSTHEOLOP = null;
        
        foreach (Classes::where("id", "like", $year."%")->get() as $key => $Lop) {
            $addnew = null;
            $addnew[0] = $Lop->classname;
            foreach (Subject::all() as $key2 => $Mon) {
                $addnew[$key2 + 1] = "";
                $PCL = Phancong::where("class_id", "=", $Lop->id)->get();
                //echo "count". $PCL->count();
                foreach ($PCL as $Gv) {
                    if($Gv->teacher->teach->id == $Mon->id){
                        $addnew[$key2+1] = $Gv->teacher->user->fullname;
                        break;
                    }
                }
            }
            $DSTHEOLOP[$key] = $addnew;
        }    
        return view('schedule.phancongcu')->with('danhsachgv', $DSPHANCONG)->with("check", $check)->with("listsubject", $listsubject)->with("dshtheolop", $DSTHEOLOP);
    }

    public function phancong()
    {
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        tkb::truncate();
        //Phancong::truncate();
        Phancong::where("class_id", "like", $year."%")->delete();
       
        //xu li cho truong hop co giao vien chu nhiem
        $DSLOPHOC = Classes::where("id", "like", $year."%")->get();
        foreach ($DSLOPHOC as $Lop) {
            $addnew = new Phancong;
            $addnew->teacher_id = $Lop->Teacher->id ;
            $addnew->class_id = $Lop->id;
            $addnew->save();
        }

        //xu li cho tat cac cac lop con lai
        $DSMONHOC = Subject::all();
        $DSGIAOVIEN = Teacher::all();
        $DSGVCN = null;
        $num = 0;
        foreach ($DSLOPHOC as $Lop) {
            $DSGVCN[$num] = $Lop->teacher;
            $num++;
        }

        foreach ($DSMONHOC as $Mon) {
            //ds giao vien day cho mon hoc nay
            //if($Mon->id != 3)
              //  continue;
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

        $DSPHANCONG  = null;
        $DSGIAOVIEN = Teacher::OrderBy("group", "desc")->get();
        
        
        foreach($DSGIAOVIEN as $dem1 => $Gv){
            //if($Gv->id != "t_0000000")
              //  continue;
            $DS1GV = null;
            $DS1GV = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $Gv->id)->get();
            $addnew = null;
            $addnew[0] = $Gv->id;
            $addnew[1] = $Gv->user->fullname;
            $addnew[2] = $Gv->teach->subject_name;
            $addnew[3] = Classes::where("id","like", $year."%")->where("homeroom_teacher", "=", $Gv->id)->first();
            if($addnew[3] == null)
                $addnew[3] = "";
            else
                $addnew[3] = $addnew[3]->classname;
            foreach ($DS1GV as $dem2 => $Lop) {
                $addnew[$dem2 + 4] = $Lop->classes->classname; 
            }
            $DSPHANCONG[$dem1] = $addnew;
        }
        
         $check = $this->check();  

        $DSTHEOLOP = null;
        
        foreach (Classes::where("id", "like", $year."%")->get() as $key => $Lop) {
            $addnew = null;
            $addnew[0] = $Lop->classname;
            foreach (Subject::all() as $key2 => $Mon) {
                $addnew[$key2 + 1] = "";
                $PCL = Phancong::where("class_id", "=", $Lop->id)->get();
                //echo "count". $PCL->count();
                foreach ($PCL as $Gv) {
                    if($Gv->teacher->teach->id == $Mon->id){
                        $addnew[$key2+1] = $Gv->teacher->user->fullname;
                        break;
                    }
                }
            }
            $DSTHEOLOP[$key] = $addnew;
        }

        $listsubject = null;
        foreach (Subject::all() as $key => $Mon) {
            $listsubject[$key] = $Mon->subject_name;
        }
        
       // return view('schedule.phanlop')->with('danhsachgv', $DSPHANCONG)->with("check", $check)

        return view('schedule.bangphancong')->with('danhsachgv', $DSPHANCONG)->with("check", $check)->with('dshtheolop', $DSTHEOLOP)->with('listsubject', $listsubject);
        //DANG XU LY TIEP O PHAN XY GIAO DIEN VOI LAI PHAN CONG CHO GIAO VIEN , NHUNG THOI KHOA BIEU KHONG SAP XEP DC
    }



    public function edit(Request $request){
        $year = substr(date('Y'),2);
        if(date("M") < 8)
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
        //$msgv = "t_0008";
        $name = $teacher->user->fullname;
        $subj = $teacher->teach->subject_name;
        $giaovien['id'] = $msgv;
        $giaovien['name'] = $name;
        $giaovien['lopcn'] = $lopcn;
        $giaovien['phancong'] = $phancong;
        $giaovien['chuaphancong'] = $chuaphancong;
        $giaovien['subj'] = $subj;
        //---------------------------

        return $giaovien;
    }

    public function addnew(Request $request){
        $year = substr(date('Y'),2);
        if(date("M") < 8)
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
        $check = $this->check();
        return $check;
    }

    public function removeclass(Request $request){
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        $id = $request['id'];
        $listClass = $request['listClass'];
        for($i = 0; $i < count($listClass); $i++){
            $class_id = Classes::where("id", "like", $year."%")->where("classname", "=", $listClass[$i] )->first();
            $class_id = $class_id->id;
            Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $id)->where("class_id", "=", $class_id)->delete();
        }
        return $this->check();

    }


    public function check(){
        $dsloptrung = null;
        $num_trung = 0;
        $dschuaphan = null;
        $num_chuaphan = 0;
        $year = substr(date('Y'),2);
        if(date("M") < 8)
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
        $dslophoc = Classes::where("id", "like", $year."%")->get();
        foreach ($dsmonhoc as $mon) {
            // if($mon->id != 9)
            //     continue;
            
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
        // $this->printcheck1($dsloptrung);
        // $this->printcheck1($dschuaphan);
        return $result;
    }

    public function checkthoikhoabieu(){
        //kiem tra nhung lop chua phan cong
        $DSLOPChuaPC = null;
        $year = substr(date('Y'),2);
        if(date("M") < 8)
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
        // dang su vi ve vie tra ket qua ve cho phep bi trung
        //return $DSLOPChuaPC;
        return $DSTRUNG;
    }

    public function checkTkb(){
        $TKB = null;
        foreach(tkb::all as $key => $gv){
            $addnew = null;
            $addnew[0] = $gv->teacher_id;
            $addnew[1] = $gv->teacher->user->fullname;
            $addnew[2] = $gv->teacher->teach->subject_name;
            $addnew[3] = $gv->sotietconlai;
            for($i = 0; $i < 50; $i++){
                $t = "T".$i;
                $addnew[$i+4] = $gv->$t;
            }
            $TKB[$key] = $addnew;
        }
        //$this->printcheck1($TKB);   
        return "oke";
    }

    public function tkbgvtaomoi()
    {
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        $dsmonhoc1 = Subject::all();
        $dsmonhoc = null;
        $dsmonhoc[0] = array("mon", 6, 7, 8, 9);
        for( $i = 0; $i < $dsmonhoc1->count(); $i++){
            $mhoc = null;
            $mhoc[0] = $dsmonhoc1[$i]->subject_name;
            $mhoc[1] = $dsmonhoc1[$i]->total_time;
            $mhoc[2] = $dsmonhoc1[$i]->total_time;
            $mhoc[3] = $dsmonhoc1[$i]->total_time;
            $mhoc[4] = $dsmonhoc1[$i]->total_time;
            $dsmonhoc[$i + 1] = $mhoc;
        }

        $somon = $dsmonhoc1->count();
        $tong   = 0;
        $i = 0;
        $sotiettoida1ngay = 4;
        $sotiettoida1buoi = 2;
        foreach ($dsmonhoc as $key) {
            $tong = 0;
            for(  $i = 1; $i <= 4; $i++)
                $tong += $key[$i];
            $tongtiethoc = $tong;
        }

        $ds_lh = Classes::where("id", "like", $year."%")->get();
        for($i = 0; $i < $ds_lh->count(); $i++)
            $danhsachlop[$i] = $ds_lh[$i]->classname;
        

        $danhsachgv_1 = Teacher::all();
        $danhsachgv = null;

        for( $i = 0; $i < $danhsachgv_1->count(); $i++){
            $gv = $danhsachgv_1[$i];
            $gv_ = null;
            $gv_[0] = $gv->id;
            $gv_[1] = $gv->teach->subject_name;
            $gv_[2] = Classes::where("homeroom_teacher", "=", $gv->id)->where("id", "like",$year."%")->first();
            $gv_[2] = $gv_[2]['classname'];
            if($gv_[2] == null)
                $gv_[2] = "";
            $dscaclop = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $gv->id)->get();//sau nay them nam hoc
            for( $j = 0; $j < $dscaclop->count(); $j++){
                $gv_[$j + 3] = $dscaclop[$j]->classes ->classname;
            }

            $danhsachgv[$i] = $gv_;
        }

        for($i = 1; $i < count($dsmonhoc); $i ++){
            $count = 0;
            foreach ($danhsachgv as $gv) {
                if($gv[1] == $dsmonhoc[$i][0])
                    $count++;
            }
            $sogiaovienBomon[$dsmonhoc[$i][0]] = $count;
        }

        for( $i = 1; $i < count($dsmonhoc); $i++){
            $count = 0;
            foreach ($danhsachlop as $lop) {
                if($this->soTietTuan($dsmonhoc[$i][0], $lop, $somon, $dsmonhoc) > 0)
                    $count++;
            }
            $solophoc1mon[$dsmonhoc[$i][0]] = $count;
        }

        for($i = 0; $i < count($danhsachlop); $i++){
            $lop = $danhsachlop[$i];
            for($j = 1; $j <= $somon; $j ++){
                if($this->soTietTuan($dsmonhoc[$j][0], $lop, $somon, $dsmonhoc) > 0 ){//lop co hoc mon nay
                    $count = 0;
                    foreach ($danhsachgv as $gv) {
                        if($gv[1] == $dsmonhoc[$j][0])
                            for($k = 0; $k < count($gv) - 3; $k ++){
                                if($gv[$k + 3] == $lop)
                                    $count++;
                            }
                    }
                }
            }

            $countGVCN = 0;
            foreach ($danhsachgv as $gv) {
                if($gv[2] == $lop)
                    $countGVCN++;
            }
        }

        $sogiaovien = 0;

        foreach ($danhsachgv as $gv){
            $tong = 0;
            for( $i = 3; $i < count($gv); $i++){
                $tong += $this->soTietTuan($gv[1], $gv[$i] , $somon, $dsmonhoc);
            }
            $tongtietday[$sogiaovien] = $tong;
            $sogiaovien++;
        }

        $sogiaovien = 0;
        foreach ($danhsachgv as $gv) {
            for( $i = 0 ; $i < 54; $i++){
                $gvien[$i] = "";
            }
            $gvien[0] = $gv[0]; //msgv
            $gvien[1] = Teacher::where("id", "=", $gvien[0])->get();
            $gvien[1] = $gvien[1][0]->user->fullname;
            $gvien[2] = $gv[1]; //mon hoc
            $gvien[3] = $tongtietday[$sogiaovien]; //so tiet con lai
            $gvien[4] = "cc";//chao co
            $gvien[13] = "cc";//chao co
            $gvien[48] = "sh";//sinh hoat
            $gvien[53] = "sh";//sinh hoat
            $thoikhoabieu[$sogiaovien] = $gvien;
            $sogiaovien++; 
        }


        $randgv = $this->randomlist($sogiaovien);
        $randtiet = $this->randomlist(50);
        $randngay = $this->randomlist(5);//chi hoc thu 2->6
        $randtiet_ngay = $this->randomlist(10);


        foreach ($randgv as $gv){//Uu tien cho giao vien chu nhiem
            for($ngay = 0; $ngay < 5; $ngay++){//xep theo ngay 1 ngay khong dc qua 2 tiet
                for($tiet = 0; $tiet < 10; $tiet ++){
                    $lop = $danhsachgv[$gv][2];
                    $tiettkb = $randngay[$ngay]*10 + $randtiet_ngay[$tiet] + 4;//vi tri tren tkb
                    if($thoikhoabieu[$gv][$tiettkb] == "" && $this->chuaCoGVKhacDay($tiettkb, $lop, $thoikhoabieu) && $this->lt_tietTuan($gv, $lop, $thoikhoabieu, $danhsachgv, $somon, $dsmonhoc) &&
                            $this->khongday1ngayquanhieu($gv, $lop, $tiettkb, $thoikhoabieu)){
                        $thoikhoabieu[$gv][$tiettkb] = $lop;
                        $thoikhoabieu[$gv][3]--;
                    }
                }
            }
        }



        foreach ($randgv as $gv){//Xep cho cac lop con lai, random theo ngay->uu tien xep cac mon nhieu tiet
            $sllop = count($danhsachgv[$gv]) - 3;
            if($sllop <= 0 || $thoikhoabieu[$gv][3]==0)//he tiet day hay da pphan cong xong
                continue;

            $randlop = $this->randomlist($sllop);
            for($i = 0; $i < $sllop; $i++){
                $lop = $danhsachgv[$gv][$randlop[$i] + 3];
                for($ngay = 0; $ngay < 5; $ngay++){//xep theo ngay 1 ngay khong dc qua 2 tiet
                    for($tiet = 0; $tiet < 10; $tiet ++){
                        $tiettkb = $randngay[$ngay]*10 + $tiet + 4;//vi tri tren tkb
                        if($thoikhoabieu[$gv][$tiettkb] == "" && $this->chuaCoGVKhacDay($tiettkb, $lop, $thoikhoabieu) && $this->lt_tietTuan($gv, $lop, $thoikhoabieu, $danhsachgv, $somon, $dsmonhoc) &&
                                $this->khongday1ngayquanhieu($gv, $lop, $tiettkb, $thoikhoabieu)){
                            $thoikhoabieu[$gv][$tiettkb] = $lop;
                            $thoikhoabieu[$gv][3]--;
                        }
                            
                    }
                }//LIEU CO XET TRUONG HOP LA SO TIET HON HO SO VOI QUY DINH CHUA
            }
        }
        //ngay tai day co the co them mot ham de dao lon lamcho du lieu co tinh tham my hon


        foreach ($randgv as $gv){//Xep cho cac lop con lai, random theo ngay->uu tien xep cac mon nhieu tiet
            $sllop = count($danhsachgv[$gv]) - 3;
            if($sllop <= 0 || $thoikhoabieu[$gv][3]==0)
                continue;
            $randlop = $this->randomlist($sllop);
            for($i = 0; $i < $sllop; $i++){
                $lop = $danhsachgv[$gv][$randlop[$i] + 3];
                for($_tiet = 0; $_tiet < 50; $_tiet++){//xep theo ngay 1 ngay khong dc qua 2 tiet
                    $tiettkb = $randtiet[$_tiet] + 4;//vi tri tren tkb
                    if($thoikhoabieu[$gv][$tiettkb] == "" && $this->chuaCoGVKhacDay($tiettkb, $lop, $thoikhoabieu) && $this->lt_tietTuan($gv, $lop,$thoikhoabieu, $danhsachgv, $somon, $dsmonhoc) &&
                            $this->khongday1ngayquanhieu($gv, $lop, $tiettkb, $thoikhoabieu )){
                        $thoikhoabieu[$gv][$tiettkb] = $lop;
                        $thoikhoabieu[$gv][3]--;
                    }
                }
            }
        }

        foreach ($randgv as $gv){//giao vien ta lop theo tuan tu, tiet random
            $sllop = count($danhsachgv[$gv]) - 3;
            if($sllop <= 0 || $thoikhoabieu[$gv][3]==0)
                continue;
            $randlop = $this->randomlist($sllop);
            for($i = 0; $i < $sllop; $i++){
                $lop = $danhsachgv[$gv][$randlop[$i] + 3];
                for($_tiet = 0; $_tiet < 50; $_tiet++){//xep theo ngay 1 ngay khong dc qua 2 tiet
                    $tiettkb = $randtiet[$_tiet] + 4;//vi tri tren tkb
                    if($thoikhoabieu[$gv][$tiettkb] == "" && $this->lt_tietTuan($gv, $lop,$thoikhoabieu, $danhsachgv, $somon, $dsmonhoc) &&
                            $this->khongday1ngayquanhieu($gv, $lop, $tiettkb, $thoikhoabieu )){
                        $thoikhoabieu[$gv][$tiettkb] = $lop;
                        $thoikhoabieu[$gv][3]--;
                    }
                }
            }
        }
        

        //chap nhan trung de xep tkb
        //phan xu li ve dich chuyen de duoc du lieu nhu y  muon
        foreach ($thoikhoabieu as $row => $Gv) {
            for($i = 0; $i < 5; $i++){
                for($j = 0; $j < 10; $j++){
                    $tiet = $i*10 + $j;
                    $this->xulitrung($thoikhoabieu, $row, $tiet);
                }
            }
            
        }
        //end----------------------

        tkb::truncate();
        for($i = 0; $i < count($thoikhoabieu);$i++){
            $addnew = null;
            $addnew = new tkb;
            $addnew->teacher_id = $thoikhoabieu[$i][0];
            $addnew->sotietconlai = $thoikhoabieu[$i][3];
            for($j = 0; $j < 50; $j++){
                $pro = "T".$j;
                $addnew->$pro = $thoikhoabieu[$i][$j+4];
            }

            $addnew->save();
        }


        //$this->printcheck1($thoikhoabieu);
        $DSLOPChuaPC = $this->checkthoikhoabieu();

       return view('schedule.tkb_giaovien')->with('thoikhoabieu', $thoikhoabieu)->with("chuaphan", $DSLOPChuaPC);
    }

    public function tkbgvthaydoi(){

        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        $dsmonhoc1 = Subject::all();
        $dsmonhoc = null;
        $dsmonhoc[0] = array("mon", 6, 7, 8, 9);
        for( $i = 0; $i < $dsmonhoc1->count(); $i++){
            $mhoc = null;
            $mhoc[0] = $dsmonhoc1[$i]->subject_name;
            $mhoc[1] = $dsmonhoc1[$i]->total_time;
            $mhoc[2] = $dsmonhoc1[$i]->total_time;
            $mhoc[3] = $dsmonhoc1[$i]->total_time;
            $mhoc[4] = $dsmonhoc1[$i]->total_time;
          //  echo "mon: ". $mhoc[0] . " sotiet: " . $mhoc[1] . "<br>";
            $dsmonhoc[$i + 1] = $mhoc;
        }

        $somon = $dsmonhoc1->count();
        $tong   = 0;
        $i = 0;
        $sotiettoida1ngay = 4;
        $sotiettoida1buoi = 2;
        foreach ($dsmonhoc as $key) {
            $tong = 0;
            for(  $i = 1; $i <= 4; $i++)
                $tong += $key[$i];
            $tongtiethoc = $tong;
        }

        $ds_lh = Classes::where("id", "like", $year."%")->get();
        for($i = 0; $i < $ds_lh->count(); $i++){
            $danhsachlop[$i] = $ds_lh[$i]->classname;
            //echo "lop: ". $danhsachlop[$i] . "<br>";
        }

        $danhsachgv_1 = Teacher::all();
        $danhsachgv = null;

        for( $i = 0; $i < $danhsachgv_1->count(); $i++){
            $gv = $danhsachgv_1[$i];
            $gv_ = null;
            $gv_[0] = $gv->id;
            $gv_[1] = $gv->teach->subject_name;
            $gv_[2] = Classes::where("homeroom_teacher", "=", $gv->id)->where("id", "like",$year."%")->first();
            $gv_[2] = $gv_[2]['classname'];
            if($gv_[2] == null)
                $gv_[2] = "";
            $dscaclop = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $gv->id)->get();//sau nay them nam hoc
            for( $j = 0; $j < $dscaclop->count(); $j++){
                $gv_[$j + 3] = $dscaclop[$j]->classes ->classname;
            }

            $danhsachgv[$i] = $gv_;
        }

        for($i = 1; $i < count($dsmonhoc); $i ++){
            $count = 0;
            foreach ($danhsachgv as $gv) {
                if($gv[1] == $dsmonhoc[$i][0])
                    $count++;
            }
            $sogiaovienBomon[$dsmonhoc[$i][0]] = $count;
        }

        for( $i = 1; $i < count($dsmonhoc); $i++){
            $count = 0;
            foreach ($danhsachlop as $lop) {
                if($this->soTietTuan($dsmonhoc[$i][0], $lop, $somon, $dsmonhoc) > 0)
                    $count++;
            }
            $solophoc1mon[$dsmonhoc[$i][0]] = $count;
        }

        for($i = 0; $i < count($danhsachlop); $i++){
            $lop = $danhsachlop[$i];
            for($j = 1; $j <= $somon; $j ++){
                if($this->soTietTuan($dsmonhoc[$j][0], $lop, $somon, $dsmonhoc) > 0 ){//lop co hoc mon nay
                    $count = 0;
                    foreach ($danhsachgv as $gv) {
                        if($gv[1] == $dsmonhoc[$j][0])
                            for($k = 0; $k < count($gv) - 3; $k ++){
                                if($gv[$k + 3] == $lop)
                                    $count++;
                            }
                    }
                }
            }

            $countGVCN = 0;
            foreach ($danhsachgv as $gv) {
                if($gv[2] == $lop)
                    $countGVCN++;
            }
        }

        $sogiaovien = 0;

        foreach ($danhsachgv as $gv){
            $tong = 0;
            for( $i = 3; $i < count($gv); $i++){
                $tong += $this->soTietTuan($gv[1], $gv[$i] , $somon, $dsmonhoc);
            }
            $tongtietday[$sogiaovien] = $tong;
            $sogiaovien++;
        }

        $sogiaovien = 0;
         foreach(tkb::all() as $key => $gv){
            $addnew = null;
            $addnew[0] = $gv->teacher_id;
            $addnew[1] = $gv->teacher->user->fullname;

            $addnew[2] = Classes::where("id", "like", $year."%")->where("homeroom_teacher", "=", $gv->teacher_id)->first();
            if($addnew[2] == null)
                $addnew[2] = "";
            else
                $addnew[2] = $addnew[2]->classname;
            //$addnew[3] = $gv->sotietconlai;
            $DSPHANCONG = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $gv->teacher_id)->get();
            for($i = 0; $i < 50 ; $i++) {
                $t = "T".$i;
                if($i == 0 || $i == 9 || $i == 44 || $i == 49){
                    $addnew[$i + 4] = $gv->$t;
                    continue;
                }
                $addnew[$i + 4] = "";
                foreach ($DSPHANCONG as $lop) {
                    if($lop->classes->classname == $gv->$t){
                        $addnew[$i + 4] = $gv->$t;
                        break;
                    }
                }
            }

            $countdaphan = 0;
            for($i = 0; $i < 50 ; $i++) {
                if($i == 0 || $i == 9 || $i == 44 || $i == 49){
                    $addnew[$i + 4] = $gv->$t;
                    continue;
                }
                if($addnew[$i + 4] != "")
                $countdaphan++;
            }
            $addnew[3] = $DSPHANCONG->count()*$gv->teacher->teach->total_time - $countdaphan;
            
            $thoikhoabieu[$key] = $addnew;
        }

        $sogiaovien = Teacher::all()->count();
        $randgv = $this->randomlist($sogiaovien);
        $randtiet = $this->randomlist(50);
        $randngay = $this->randomlist(5);//chi hoc thu 2->6
        $randtiet_ngay = $this->randomlist(10);

        foreach ($randgv as $gv){//giao vien ta lop theo tuan tu, tiet random
            $sllop = count($danhsachgv[$gv]) - 3;
            if($sllop <= 0 || $thoikhoabieu[$gv][3]==0)
                continue;
            $randlop = $this->randomlist($sllop);
            for($i = 0; $i < $sllop; $i++){
                $lop = $danhsachgv[$gv][$randlop[$i] + 3];
                for($_tiet = 0; $_tiet < 50; $_tiet++){//xep theo ngay 1 ngay khong dc qua 2 tiet
                    $tiettkb = $randtiet[$_tiet] + 4;//vi tri tren tkb
                    if($thoikhoabieu[$gv][$tiettkb] == "" && $this->lt_tietTuan($gv, $lop,$thoikhoabieu, $danhsachgv, $somon, $dsmonhoc) &&
                            $this->khongday1ngayquanhieu($gv, $lop, $tiettkb, $thoikhoabieu )){
                        $thoikhoabieu[$gv][$tiettkb] = $lop;
                        $thoikhoabieu[$gv][3]--;
                    }
                }
            }
        }
        

        //chap nhan trung de xep tkb
        //phan xu li ve dich chuyen de duoc du lieu nhu y  muon
        foreach ($thoikhoabieu as $row => $Gv) {
            for($i = 0; $i < 5; $i++){
                for($j = 0; $j < 10; $j++){
                    $tiet = $i*10 + $j;
                    $this->xulitrung($thoikhoabieu, $row, $tiet);
                }
            }
            
        }
        //end----------------------

        tkb::truncate();
        for($i = 0; $i < count($thoikhoabieu);$i++){
            $addnew = null;
            $addnew = new tkb;
            $addnew->teacher_id = $thoikhoabieu[$i][0];
            $addnew->sotietconlai = $thoikhoabieu[$i][3];
            for($j = 0; $j < 50; $j++){
                $pro = "T".$j;
                $addnew->$pro = $thoikhoabieu[$i][$j+4];
            }

            $addnew->save();
        }


        //$this->printcheck1($thoikhoabieu);
        $DSLOPChuaPC = $this->checkthoikhoabieu();

       return view('schedule.tkb_giaovien_old')->with('thoikhoabieu', $thoikhoabieu)->with("chuaphan", $DSLOPChuaPC);        
    }

    public function xulitrung(&$TKB, $row, $tiet){
        if($this->count_lop($TKB, $tiet, $TKB[$row][$tiet+4]) >= 2){
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

            if($this->isTrungtren($TKB, $row, $tiet, $rowT)){
            } 
            else if($this->isTrungduoi($TKB, $row, $tiet, $rowT)){
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

    public function printcheck2($arr){
        if($arr){
            for($i = 0; $i < count($arr); $i++)
                echo $arr[$i]. "|";
        }
    }


    function lt_tietTuan($gv, $lop, $thoikhoabieu, $danhsachgv, $somon, $dsmonhoc){//vd: giao vien chi gap lop trong 4 tiet/tuan
        $count = 0;
        for($i = 0; $i < 50; $i++){
            if($thoikhoabieu[$gv][$i + 4] == $lop)
                $count ++;
        }
        
        if ($count < $this->soTietTuan($danhsachgv[$gv][1], $lop, $somon, $dsmonhoc))
            return true;
        else 
            return false;
    }

    function chuaCoGVKhacDay($tiet, $lop, $thoithoikhoabieu){//tra ve true neu chua co ai day
        foreach ($thoithoikhoabieu as $gv) {
            if($gv[$tiet] == $lop)
            return false;
        }
        return true;
    }

    function khongday1ngayquanhieu($gv, $lop, $tiet, $thoikhoabieu){//vi du khong dc day nhieu hon 2 tiet 1 ngay

    //dieu kien kiem tra: 1 buoi khong qua 2 tiet, 1 ngay khong qua 4 tiet, va 2 tiet trong 1 buoi phai lien ke nhau
        $countNgay = 0;
        $countSang = 0;
        $countChieu = 0;
        $ngay = (int)(($tiet - 4)/10);
        $tietdautkb = $ngay*10 + 4;

        for($i = 0; $i < 10; $i++){
            if($thoikhoabieu[$gv][$tietdautkb + $i] == $lop)
                $countNgay++;
            
        }

        $buoi = ($tiet - 4)%10;
        if($buoi < 5){//buoi sang
            for($i = 0; $i < 5; $i++){
                if($thoikhoabieu[$gv][$tietdautkb + $i] == $lop){
                    if(abs($buoi - $i) != 1)//neu dung dieu kien nay thi toi da 2 tiet/buoi, khong thay doi dc
                        return false;
                    $countSang++;
                }
            }
        }else{//buoi chieu
            for( $i = 5; $i < 10; $i ++){
                if($thoikhoabieu[$gv][$tietdautkb + $i] == $lop){
                    if(abs($buoi - $i) != 1)
                        return false;
                    $countChieu++;
                }
            }
        }
        //NOTE: neu tiet roi vao buoi sang thi $countChieu = 0, nen can kiem tra $countNgay de ket qua chinh xac

        if($countNgay < 4 || $countSang < 2 || $countChieu < 2)    
            return true;
        else 
            return false;
    }

    public function soTietTuan($mon, $lop, $somon, $dsmonhoc){//tra ve so tiet ma mot lop x phai hoc mon y trong tuan
        $sotiethoc = 0;
        for($i = 0; $i < $somon; $i ++){
            if($dsmonhoc[$i+1][0] == $mon){
                if(substr($lop, 0, 1) == 6){
                    $sotiethoc = $dsmonhoc[$i + 1][1];
                }else if(substr($lop, 0, 1) == 7){
                    $sotiethoc = $dsmonhoc[$i + 1][2];
                }else if(substr($lop, 0, 1) == 8){
                    $sotiethoc = $dsmonhoc[$i + 1][3];
                }else if(substr($lop, 0, 1) == 9){
                            $sotiethoc = $dsmonhoc[$i + 1][4];
                }

                break;
            }
        }

        return $sotiethoc;
    }

    function randomlist($num){
        for( $i = 0 ; $i  < $num; $i++){
            $order[$i] = $i;
        }
        shuffle($order);
        return $order;
    }

    public function tkblop(Request $request)
    {
        $year = substr(date('Y'),2);
        if(date("M") < 8)
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
                        $thoikhoabieu_lophoc[$j][$i + 2] = $gv->teacher->teach->subject_name;
                    }
                }
            }
        }

        return view('schedule.tkb_lophoc')->with("thoikhoabieu", $thoikhoabieu_lophoc);
    }

    public function tkbhientai(){
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        foreach(tkb::all() as $key => $gv){
            $addnew = null;
            $addnew[0] = $gv->teacher_id;
            $addnew[1] = $gv->teacher->user->fullname;

            $addnew[2] = Classes::where("id", "like", $year."%")->where("homeroom_teacher", "=", $gv->teacher_id)->first();
            if($addnew[2] == null)
                $addnew[2] = "";
            else
                $addnew[2] = $addnew[2]->classname;
            $addnew[3] = $gv->sotietconlai;
            $DSPHANCONG = Phancong::where("class_id", "like", $year."%")->where("teacher_id", "=", $gv->teacher_id)->get();
            for($i = 0; $i < 50 ; $i++) {
                $t = "T".$i;
                $addnew[$i + 4] = $gv->$t;
            
            }

            
            $thoikhoabieu[$key] = $addnew;
        }

        $DSLOPChuaPC = $this->checkthoikhoabieu();

        return view('schedule.xemtkb')->with('thoikhoabieu', $thoikhoabieu)->with("chuaphan", $DSLOPChuaPC);         
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

    }


    public function phanconglop(){
        $year = substr(date('Y'),2);
        if(date("M") < 8)
            $year--;
        $DSPHANCONG = null;
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
                $DSPHANCONG[$dem++] = $addnew;
            }
        }
        $check = $this->check();    

        $DSTHEOLOP = null;
        
        foreach (Classes::where("id", "like", $year."%")->get() as $key => $Lop) {
            $addnew = null;
            $addnew[0] = $Lop->classname;
            foreach (Subject::all() as $key2 => $Mon) {
                $addnew[$key2 + 1] = "";
                $PCL = Phancong::where("class_id", "=", $Lop->id)->get();
                //echo "count". $PCL->count();
                foreach ($PCL as $Gv) {
                    if($Gv->teacher->teach->id == $Mon->id){
                        $addnew[$key2+1] = $Gv->teacher->user->fullname;
                        break;
                    }
                }
            }
            $DSTHEOLOP[$key] = $addnew;
        }

        $listsubject = null;
        foreach (Subject::all() as $key => $Mon) {
            $listsubject[$key] = $Mon->subject_name;
        }

        return view('schedule.phanlop')->with('danhsachgv', $DSPHANCONG)->with("check", $check)->with('dshtheolop', $DSTHEOLOP)->with('listsubject', $listsubject);
    }

}
