<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstnamelist = array("Lưu", "Nguyễn", "Trần", "Lê", "Đinh", "Lý", "Trịnh", "Hoàng", "Võ", "Vương", "Phạm", "Huỳnh", "Hồ", "Đỗ", "Ngô", "Dương");
        $middlenamelist = array( "Quốc" , "Quang", "Xuân", "Bảo", "Anh", "Tiến", "Ngọc", "Vân", "Thùy", "Thu", "Minh", "Trung", "Hiếu", "Đức", "Đạt", "Đông", "Hạ", "Thư", "Hoài"); 
        $lastnamelist = array("Linh" ,"Châu","Ân","Khanh","Anh","Chi","Ngọc","Vân","Mai","Thùy","Ngân","Lan","Loan","Minh","Hiếu","Trung","Đức","Đạt","Hào","Toàn","Tiến", "Đông", "Hạ","Hoài"); 
        $gender = array(
            '0' => 'F' ,
            '1' => 'M'
        );
        // 10 Admin
        for($i=0; $i<=9; $i++){
            $firstname = $firstnamelist[rand(0, count($firstnamelist)-1)];
            $middlename = $middlenamelist[rand(0, count($middlenamelist)-1)];
            $lastname = $lastnamelist[rand(0, count($lastnamelist)-1)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            DB::table('users')->insert([
                'id' => 'a_000000'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 'a_000000'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "19".rand(7,8).rand(0,9)."-".rand(1,12)."-".rand(1,28),
                'role' => '0',
                'gender' => $sex,
            ]);
            $apiKey = Chrisbjr\ApiGuard\Models\ApiKey::make('a_000000'.$i);
        }

        //25 Teacher
        for($i=0;$i<=24;$i++){
            $firstname = $firstnamelist[rand(0, count($firstnamelist)-1)];
            $middlename = $middlenamelist[rand(0, count($middlenamelist)-1)];
            $lastname = $lastnamelist[rand(0, count($lastnamelist)-1)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            $offset = 9-strlen($i);
            $id = substr('t_0000000', 0,$offset);
            $id = $id.$i;
            DB::table('users')->insert([
                'id' => $id,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => $id.'@schoolm.com',
                'dateofbirth' => "19".rand(7,8).rand(0,9)."-".rand(1,12)."-".rand(1,28),
                'password' => bcrypt('1234'),
                'role' => '1',
                'gender' => $sex,
            ]);
            $apiKey = Chrisbjr\ApiGuard\Models\ApiKey::make($id);
        }

        //500 Student
        for($i=0;$i<=499;$i++){
            $firstname = $firstnamelist[rand(0, count($firstnamelist)-1)];
            $middlename = $middlenamelist[rand(0, count($middlenamelist)-1)];
            $lastname = $lastnamelist[rand(0, count($lastnamelist)-1)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            $offset = 9-strlen($i);
            $id = substr('s_0000000', 0,$offset);
            $id = $id.$i;
            DB::table('users')->insert([
                'id' => $id,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => $id.'@schoolm.com',
                'dateofbirth' => "200".rand(0,4)."-".rand(1,12)."-".rand(1,28),
                'password' => bcrypt('1234'),
                'role' => '2',
                'gender' => $sex,
            ]);
            $apiKey = Chrisbjr\ApiGuard\Models\ApiKey::make($id);
        }

        // 450 Parents
        for($i=0;$i<=449;$i++){
            $firstname = $firstnamelist[rand(0, count($firstnamelist)-1)];
            $middlename = $middlenamelist[rand(0, count($middlenamelist)-1)];
            $lastname = $lastnamelist[rand(0, count($lastnamelist)-1)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            $offset = 9-strlen($i);
            $id = substr('p_0000000', 0,$offset);
            $id = $id.$i;
            DB::table('users')->insert([
                'id' => $id,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => $id.'@schoolm.com',
                'dateofbirth' => "19".rand(7,9).rand(0,9)."-".rand(1,12)."-".rand(1,28),
                'password' => bcrypt('1234'),
                'role' => '3',
                'gender' => $sex,
            ]);
            $apiKey = Chrisbjr\ApiGuard\Models\ApiKey::make($id);
        }
    }
}
