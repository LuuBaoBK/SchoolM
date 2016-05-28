<?php

use Illuminate\Database\Seeder;
use App\Model\Teacher;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_group = array("A","B","C","D",);
        $teacher_list = Teacher::select('id')->get();
        $teacher_id_list = array();
        foreach ($teacher_list as $key => $teacher) {
            array_push($teacher_id_list, $teacher->id);
        }
        shuffle($teacher_id_list);
        $offset = count($list_group) - 1;
        // 2014-2015
        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '14_6_'.$group."_".($i+1),
                'scholastic' => '14',
                'classname' => '6'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }

        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '14_7_'.$group."_".($i+1),
                'scholastic' => '14',
                'classname' => '7'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i+4],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }

        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '14_8_'.$group."_".($i+1),
                'scholastic' => '14',
                'classname' => '8'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i+8],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }

        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '14_9_'.$group."_".($i+1),
                'scholastic' => '14',
                'classname' => '9'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i+12],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }

        //2015-2016

        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '15_6_'.$group."_".($i+1),
                'scholastic' => '15',
                'classname' => '6'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }

        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '15_7_'.$group."_".($i+1),
                'scholastic' => '15',
                'classname' => '7'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i+4],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }

        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '15_8_'.$group."_".($i+1),
                'scholastic' => '15',
                'classname' => '8'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i+8],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }

        for($i=0;$i<4;$i++){
            $group = $list_group[rand(0,$offset)];
            DB::table('classes')->insert([
                'id' => '15_9_'.$group."_".($i+1),
                'scholastic' => '15',
                'classname' => '9'.$group.($i+1),
                'homeroom_teacher' => $teacher_id_list[$i+12],
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }
    }
}
