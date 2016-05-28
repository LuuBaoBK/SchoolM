<?php

namespace App\Http\Controllers\Admin\Schedule;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Subject;
use App\Model\Teacher;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\tkb;
use App\Model\Schedule;
use App\User;
use App\Model\Sysvar;

class ScheduleController extends Controller
{
    private $TEACHER_MAX_PERIOD_PER_WEEK = 40;
    private $WARNING_COLOR = "#f39c12";

    public function main_menu_view(){
        $total_period['class'] = 0;
        $editable = "";
        $year = substr(date("Y"),2,2);
        $year = (date('m') < 8)? ($year-1) : $year;
        $class_count = Classes::where('id','like',$year."%")->count();
        $subject_list = Subject::all();
        foreach ($subject_list as $key => $subject) {
            $teacher_available = Teacher::where('group','=',$subject->id)->where('active','=',1)->count();
            $teacher_need = ceil($subject->total_time * $class_count / $this->TEACHER_MAX_PERIOD_PER_WEEK);
            $subject_list[$key]->teacher_need = $teacher_need;
            $subject_list[$key]->teacher_available = $teacher_available;
            if ($teacher_available < $teacher_need){
                 $subject_list[$key]->style_on_view = $this->WARNING_COLOR;
                 $editable = "disabled";
            }
            else{
                $subject_list[$key]->style_on_view = "";
            }
            $total_period['class'] += $subject->total_time;
        }
        $total_period['max'] = 46;
        $total_period['color'] = ($total_period['class'] > $total_period['max']) ? $this->WARNING_COLOR : "";
        $editable = ($total_period['class'] > $total_period['max']) ? "disabled" : $editable;
        return view('adminpage.schedule.main_menu',['subject_list' => $subject_list, 'total_period' => $total_period]);
    }

    public function teacher_assigment(){
        $subject_list = Subject::all();
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        $class_list = Classes::where('id','like',$year."%")->get();
        $teacher_list = Teacher::where('active','=',1)->get();
        foreach ($teacher_list as $key => $teacher) {
            $teacher->teacher_fullname = $teacher->user->fullname;
            $teacher->subject = $teacher->teach->subject_name;
            $homeroom = $teacher->classes()->where('id','like',$year."%")->first();
            if($homeroom == null){
                $teacher->homeroom = "";
            }
            else{
                $teacher->homeroom = $homeroom->classname;
            }
            
            $teacher->assigment = "";
            $phancong = Phancong::where('teacher_id','=',$teacher->id)->where('class_id','like',$year."%")->get();

            foreach ($phancong as $key => $value) {
                $teacher->assigment .= substr(str_replace("_","",$value->class_id),2)." ";
            }
            $phancong = substr($phancong, 0,-1);
        }

        foreach ($class_list as $class_list_key => $class) {
            $phancong = Phancong::where('class_id','=',$class->id)->get();
            foreach ($phancong as $phancong_key => $teacher) {
                $user = User::find($teacher->teacher_id);
                $subject = Subject::find($user->teacher->group);
                $class_list[$class_list_key][$subject->subject_name] = $user->fullname;
            }
        }
            
        $duplicated_list = $this->checkDuplicated_Assigment();
        $no_assigment_list = $this->checkNoAssigment();

        return view('adminpage.schedule.teacher_assigment',[
            'subject_list' => $subject_list, 
            'teacher_list' => $teacher_list, 
            'class_list' => $class_list,
            'duplicated_list' => $duplicated_list,
            'no_assigment_list' => $no_assigment_list
            ]);
    }

    public function create_new_assigment(Request $request){   
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        $class_list = Classes::where('id','like',$year."%")->get();
        $subject_list = Subject::all();
        // xoa bang phan cong neu da ton tai de tao bang phan cong moi
        Phancong::where('class_id','like',$year."%")->delete();
        // phan cong cho tung mon hoc
        foreach ($subject_list as $subject_list_key => $subject) {
            $temp_homeroom_list = array();
            // danh sach gv day mon hoc do
            $teacher_list = Teacher::where('group','=',$subject->id)->where('active','=',1)->get();
            // ko co gv nao day mon nay thi bo qua phan cong
            if(count($teacher_list) == 0)
                continue;
            $temp_class_list = array();
            // tao danh sach lop tam de phancong
            foreach ($class_list as $class_list_key => $class) {
                array_push($temp_class_list, $class->id);
            }
            shuffle($temp_class_list);
            // lay cac lop cn ra xep truoc
            foreach ($teacher_list as $teacher_list_key => $teacher) {
                $homeroom = $teacher->classes()->where('id','like',$year."%")->first();
                if($homeroom != null){
                    array_push($temp_homeroom_list, $homeroom->id);
                    $new_phancong = new Phancong;
                    $new_phancong->teacher_id = $teacher->id;
                    $new_phancong->class_id = $homeroom->id;
                    $new_phancong->save();
                }
            }
            // bo cac lop chu nhiem da xep
            $temp_class_list = array_diff($temp_class_list,$temp_homeroom_list);
            $temp_class_list = array_values($temp_class_list);
            // xep gv cho cac lop con lai
            $teacher_prerare = 0;
            $count_teacher_list = count($teacher_list);
            while(count($temp_class_list) > 0){
                $new_phancong = new Phancong;
                $new_phancong->teacher_id = $teacher_list[$teacher_prerare]->id;
                $new_phancong->class_id = $temp_class_list[0];
                $new_phancong->save();

                if(count($temp_class_list) > 1){
                    $temp_class_list = array_slice($temp_class_list, 1);
                } 
                else{
                    $temp_class_list = null;
                }
                   
                if($teacher_prerare == (count($teacher_list)-1))
                    $teacher_prerare = 0;
                else
                    $teacher_prerare += 1;
            }
            // if($key == 0)
            // dd(Phancong::where('class_id','like',$year."%")->get());
        }
        return "success";
    }

    public function get_classes_list(Request $request){
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $yearr;
        $added_classes = Phancong::where('teacher_id','=',$request['teacher_id'])->where('class_id','like',$year."%")->get();
        $not_add_classes = Classes::whereNotIn(
                                                'id',
                                                Phancong::select('class_id')
                                                        ->where('class_id','like',$year."%")->where('teacher_id','=',$request['teacher_id'])
                                                        ->get())
                                    ->where('id','like',$year.'%')
                                    ->get();
        foreach ($added_classes as $key => $value) {
            $added_classes[$key]['classname'] = substr(str_replace("_", "", $value->class_id),2);
        }
        $record['added_classes'] = $added_classes;
        $record['not_add_classes'] = $not_add_classes;
        return $record;
    }

    public function update_assigment(Request $request){
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        $teacher_id = $request['teacher_id'];
        $class_list = $request['class_list'];
        Phancong::where('teacher_id','=',$teacher_id)
                ->where('class_id','like',$year."%")
                ->delete();
        if(count($class_list) > 0){
            foreach ($class_list as $key => $class) {
                $phancong = new Phancong;
                $phancong->teacher_id = $teacher_id;
                $phancong->class_id   = $class;
                $phancong->save();
            }
        }
        return "success";
    }

    private function checkDuplicated_Assigment(){
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        $subject_list = Subject::all();
        $duplicated_list = array();
        foreach ($subject_list as $subject_list_key => $subject) {
            $temp = $subject->subject_name."";
            $teacher_list = Teacher::select('id')
                                   ->where('group','=',$subject->id)
                                   ->where('active','=',1)
                                   ->get();
            $class_list = Classes::select('id')->where('id','like',$year."%")->get();
            $check_insert = false;
            foreach ($class_list as $value) {                
                $duplicated_class = Phancong::whereIn('teacher_id',$teacher_list)
                                            ->where('class_id','=',$value->id)
                                            ->get();
                if(count($duplicated_class) > 1){
                        $temp .= " ".substr(str_replace("_", "", $value->id),2);
                    $check_insert = true;
                }
            }
            if($check_insert){
                array_push($duplicated_list, $temp);
            }   
        }
        return $duplicated_list;
    }

    private function checkNoAssigment(){
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        $subject_list = Subject::all();
        $no_assigment_list = array();
        foreach ($subject_list as $subject_list_key => $subject) {
            $temp = $subject->subject_name."";
            $teacher_list = Teacher::select('id')
                                   ->where('group','=',$subject->id)
                                   ->where('active','=',1)
                                   ->get();
            $class_list = Classes::select('id')->where('id','like',$year."%")->get();
            $check_insert = false;
            foreach ($class_list as $value) {                
                $not_add_classes = Phancong::whereIn('teacher_id',$teacher_list)
                                            ->where('class_id','=',$value->id)
                                            ->get();
                if(count($not_add_classes) == 0){
                        $temp .= " ".substr(str_replace("_", "", $value->id),2);
                    $check_insert = true;
                }
            }
            if($check_insert){
                array_push($no_assigment_list, $temp);
            }   
        }
        return $no_assigment_list;
    }

    public function new_schedule_index(){
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;

        $duplicated_list = $this->checkDuplicated_Assigment();
        $no_assigment_list = $this->checkNoAssigment();

        $stop = false; $color = "";
        $total_period_per_week = 0;
        $subject_list = Subject::all();
        foreach ($subject_list as $subject_list_key => $subject) {
            $teacher_list = Teacher::select('id')->where('group','=',$subject->id)->where('active','=',1)->get();
            $assigment_classes = Phancong::whereIn('teacher_id',$teacher_list)->where('class_id','like',$year."%")->get();
            $used_teachers_list = Phancong::whereIn('teacher_id',$teacher_list)->where('class_id','like',$year."%")->groupBy('teacher_id')->get();
            $total_class = count($assigment_classes);
            $total_period = ceil($total_class*$subject->total_time);
            $total_used_teachers = count($used_teachers_list);
            $teacher_need = ceil($total_period / $this->TEACHER_MAX_PERIOD_PER_WEEK);
            $subject_list[$subject_list_key]['teacher_need'] = $teacher_need;
            $subject_list[$subject_list_key]['total_used_teachers'] = $total_used_teachers;
            $subject_list[$subject_list_key]['style_on_view'] = ($total_used_teachers < $teacher_need) ? $this->WARNING_COLOR : "";
            $stop = ($total_used_teachers < $teacher_need) ? true : $stop;
            if(count($assigment_classes) > 0){
                $total_period_per_week += $subject->total_time;
            }
        }
        if($total_period_per_week > 46){
            $stop = true;
            $color = $this->WARNING_COLOR;
        }
        $total['class'] = $total_period_per_week;
        $total['max'] = 46;
        $total['color'] = $color;
        if(count($duplicated_list) > 0 || $stop || count($no_assigment_list) > 0){
            return view('adminpage.schedule.error_before_schedule',[
                'duplicated_list' => $duplicated_list,
                'no_assigment_list' => $no_assigment_list,
                'subject_list'  => $subject_list,
                'total_period' => $total
            ]);
        }
        else{
            return view('adminpage.schedule.schedule_create_page');
        }
    }

    public function create_schedule(Request $request){
        $error_list = $this->create_blank_schedule();
        if(count($error_list)>0){
            $error_list['status'] = "error";
            return $error_list;
        }
        else{
            return "next_request";
        }
    }

    public function make_schedule(){
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

    private function create_blank_schedule(){
        tkb::truncate();
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        $error_list = array();
        $teacher_list = Teacher::whereIn('id',
                                            Phancong::select('teacher_id')
                                                    ->where('class_id','like',$year."%")
                                                    ->groupBy('teacher_id')
                                                    ->get()
                                        )->get();
        foreach ($teacher_list as  $teacher) {
            $tkb_new_row = new tkb;
            $tkb_new_row->teacher_id = $teacher->id;
            $tkb_new_row->subject_name = $teacher->group;
            $temp_homeroom = $teacher->classes;
            $temp_homeroom = (count($temp_homeroom) != 0) ? $teacher->classes()->where('id','like',$year."%")->first()->id : "";
            $tkb_new_row->homeroom_class = $temp_homeroom;
            $temp_count = count(Phancong::where('teacher_id','=',$teacher->id)
                                                        ->where('class_id','like',$year."%")
                                                        ->get());
            $tkb_new_row->sotietconlai = $temp_count*(Subject::where('id','=',$teacher->group)->first()->total_time);

            $tkb_new_row->T0  = "cc" ;
            $tkb_new_row->T9 = "cc";
            $tkb_new_row->T40 = "sh";
            $tkb_new_row->T49 = "sh";
            if($tkb_new_row->sotietconlai > $this->TEACHER_MAX_PERIOD_PER_WEEK){
                $temp['teacher_id'] = $teacher->id;
                $temp['fullname'] = $teacher->user->fullname;
                $temp['subject'] = Subject::find($teacher->group)->subject_name;
                $temp['total_time'] = $tkb_new_row->sotietconlai;
                $temp['max_time'] = $this->TEACHER_MAX_PERIOD_PER_WEEK;
                array_push($error_list, $temp);
            }
            $tkb_new_row->save();
        }
        return $error_list;
    }

    public function confirm_schedule(Request $request){
        $tkb = $request['tkb'];

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
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;

        $tkb = tkb::all();
        Schedule::where('class_id','like',$year."%")->delete();
        foreach ($tkb as $key => $row) {
            for($i=0;$i<5;$i++){
                for($j=0;$j<10;$j++){
                    $period = "T".($j+$i*10);
                    if($row->$period != "" && $row->$period != "cc" && $row->$period != "sh"){
                        $schedule_row = new Schedule;
                        $schedule_row->teacher_id = $row->teacher_id;
                        $schedule_row->class_id = Classes::where('id','like',$year."%")->where('classname','=',$row->$period)->first()->id;
                        $schedule_row->period = $j;
                        $schedule_row->day = $i+2;
                        $schedule_row->save();
                    }
                    else{
                        continue;
                    }
                }
            }
        }
        return "nothing";
    }

    public function edit_current_index(){
        $year = substr(date("Y"),2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        tkb::truncate();
        $subject_list = Subject::all();
        $teacher_list_id = Schedule::select('teacher_id')->where('class_id','like',$year."%")->groupBy('teacher_id')->get();
        foreach ($teacher_list_id as $key => $teacher_id) {

            $teacher = Teacher::find($teacher_id->teacher_id);
            $tkb_row = new tkb;
            $tkb_row->teacher_id = $teacher->id;
            $tkb_row->teacher_name = $teacher->user->fullname;
            $tkb_row->subject_name = $teacher->teach->subject_name;
            $homeroom = $teacher->classes()->where('id','like',$year."%")->first();
            if($homeroom != null)
                $tkb_row->homeroom_class = $homeroom->classname;
            else
                $tkb_row->homeroom_class = "";
            $tkb_row->save();
        }
        $tkb_new = tkb::all();
        foreach ($tkb_new as $key => $tkb_row) {
            for($i=0;$i<5;$i++){
                for($j=0;$j<10;$j++){
                    $period = "T".($j + $i*10);
                    if($period == "T0" || $period == "T9" ){
                        $tkb_row->$period = "cc";
                    }
                    else if($period == "T40" || $period == "T49"){
                        $tkb_row->$period = "sh";
                    }
                    else{
                        $classname = Schedule::where('period','=',$j)
                                                ->where('day','=',$i+2)
                                                ->where('teacher_id','=',$tkb_row->teacher_id)
                                                ->first();
                    
                        if($classname != null){
                            $tkb_row->$period = substr(str_replace("_", "", $classname->class_id), 2);
                        }
                        else{
                            $tkb_row->$period = "";
                        }
                    }
                    
                    $tkb_row->save();
                }
            }
        }

        $thoikhoabieu = tkb::all();
        return view('adminpage.schedule.edit_current')->with('thoikhoabieu', $thoikhoabieu);
    }

    public function edit_current_index_stu(){
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

        // return view('schedule.tkblop_index')->with("thoikhoabieu", $thoikhoabieu_lophoc);
        return view('adminpage.schedule.edit_current_stu')->with('thoikhoabieu', $thoikhoabieu_lophoc);
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
}
