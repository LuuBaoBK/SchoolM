<?php

use Illuminate\Database\Seeder;
use App\Model\Phancong;
use App\Model\Subject;
use App\Model\Teacher;
use App\Model\Classes;

class PhancongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = "14";
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
    }
}