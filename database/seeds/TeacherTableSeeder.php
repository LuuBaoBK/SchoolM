<?php

use Illuminate\Database\Seeder;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $group = array(1,1,1,2,2,2,3,3,4,4,5,5,6,7,8,9,10,10,11,11,12,12,13,14,14);
        $subject_name = array("Toán", "Ngữ Văn", "Vật Lý", "Hóa Học", "Sinh Học", "Lịch Sử", "Địa Lý", "Âm Nhạc", "GDCD", "Thể Dục", "Tin Học", "Anh Văn", "Mỹ Thuật", "Công Nghệ");
        $position = (2,3,3,3,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,5,5,5,6,6,6);
        shuffle($group);
        shuffle($group);
        for($i=0; $i<=24; $i++){
            $offset = 9-strlen($i);
            $id = substr('t_0000000', 0,$offset);
            $id = $id.$i;
            $mobilephone = '09';
            $homephone = '08';
            for($k=0; $k<8; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                $homephone = $homephone.rand(0,9);
            }
    		DB::table('teachers')->insert([
    			'id' =>	$id,
                'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'group' => $group[$i],
                'position' => $position[$i],
                'specialized' => $subject_name[$group[$i] - 1],
                'incomingday' => "2010-".rand(1,12)."-".rand(1,28),
                'active' => 1
        	]);
    	}
    }
}
