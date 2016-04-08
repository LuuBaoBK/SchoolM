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
            $firstnamelist = array(
                '0' => 'Lưu' ,
                '1' => 'Nguyễn',
                '2' => 'Trần',
                '3' => 'Lê',
                '4' => 'Đinh',
                '5' => 'Lý',
                '6' => 'Trịnh',
                '7' => 'Hoàng',
                '8' => 'Triệu',
                '9' => 'Võ' 
            );

            $middlenamelist = array(
                '0' => 'Quốc' ,
                '1' => 'Quang',
                '2' => 'Xuân',
                '3' => 'Bảo',
                '4' => 'Anh',
                '5' => 'Tiến',
                '6' => 'Ngọc',
                '7' => 'Vân',
                '8' => 'Mai',
                '9' => 'Thùy' 
            );

            $lastnamelist = array(
                '0' => 'Linh' ,
                '1' => 'Châu',
                '2' => 'Ân',
                '3' => 'Khanh',
                '4' => 'Anh',
                '5' => 'Chi',
                '6' => 'Ngọc',
                '7' => 'Vân',
                '8' => 'Mai',
                '9' => 'Thùy' 
            );

            $gender = array(
                '0' => 'F' ,
                '1' => 'M'
            );
    	for($i=0; $i<=9; $i++){
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
    		DB::table('users')->insert([
    			'id' =>	'a_000000'.$i,
	            'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
	            'email' => 'a_000000'.$i.'@schoolm.com',
	            'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-1".$i,
                'role' => '0',
                'gender' => $sex,
        	]);
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            DB::table('users')->insert([
                'id' => 't_000000'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 't_000000'.$i.'@schoolm.com',
                'dateofbirth' => "2014-11-1".$i,
                'password' => bcrypt('1234'),
                'role' => '1',
                'gender' => $sex,
            ]);
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            DB::table('users')->insert([
                'id' => 's_000000'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 's_000000'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-1".$i,
                'role' => '2',
                'gender' => $sex,
            ]);
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            DB::table('users')->insert([
                'id' => 'p_000000'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 'p_000000'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-1".$i,
                'role' => '3',
                'gender' => $sex,
            ]);
    	}
        for($i=0; $i<=9; $i++){
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            DB::table('users')->insert([
                'id' => 'a_000001'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 'a_000001'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-1".$i,
                'role' => '0',
                'gender' => $sex,
            ]);
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            DB::table('users')->insert([
                'id' => 't_000001'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 't_000001'.$i.'@schoolm.com',
                'dateofbirth' => "2014-11-1".$i,
                'password' => bcrypt('1234'),
                'role' => '1',
                'gender' => $sex,
            ]);
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            DB::table('users')->insert([
                'id' => 's_000001'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 's_000001'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-1".$i,
                'role' => '2',
                'gender' => $sex,
            ]);
            // $firstname = $firstnamelist[rand(0, 9)];
            // $middlename = $middlenamelist[rand(0, 9)];
            // $lastname = $lastnamelist[rand(0, 9)];
            // DB::table('users')->insert([
            //     'id' => 'p_000001'.$i,
            //     'firstname' => $firstname,
            //     'middlename' => $middlename,
            //     'lastname' => $lastname,
            //     'email' => 'p_000001'.$i.'@schoolm.com',
            //     'password' => bcrypt('1234'),
            //     'dateofbirth' => "2015-11-1".$i,
            //     'role' => '2',
            //     'gender' => $sex,
            // ]);
        }


        for($i=0; $i<4; $i++){
            $firstname = $firstnamelist[rand(0, 9)];
            $middlename = $middlenamelist[rand(0, 9)];
            $lastname = $lastnamelist[rand(0, 9)];
            $fullname = $firstname." ".$middlename." ".$lastname;
            $sex = $gender[rand(0,1)];
            DB::table('users')->insert([
                'id' => 't_000002'.$i,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'fullname' => $fullname,
                'email' => 't_000002'.$i.'@schoolm.com',
                'dateofbirth' => "2014-11-1".$i,
                'password' => bcrypt('1234'),
                'role' => '1',
                'gender' => $sex,
            ]);
            
            
        }
    }
}
