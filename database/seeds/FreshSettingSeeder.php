<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Sysvar;
use App\Model\Admin;
use App\Model\User;

class FreshSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
            'id' => 'a_0000000',
            'firstname' => "admin_fristname",
            'middlename' => "admin_middlname",
            'lastname' => "admin_lastname",
            'fullname' => "admin_fristname admin_middlname admin_lastname",
            'email' => 'a_0000000@schoolm.com',
            'password' => bcrypt('1234'),
            'dateofbirth' => "19".rand(7,8).rand(0,9)."-".rand(1,12)."-".rand(1,28),
            'role' => '0',
            'gender' => "A",
        ]);
        
    	DB::table('admin')->insert([
			'id' =>	'a_0000000',
	        'create_by' => 'a_0000000',
	        'mobilephone' => ''
		]);

    	
        $apiKey = Chrisbjr\ApiGuard\Models\ApiKey::make('a_0000000');

        Model::unguard();

        // $this->call(UserTableSeeder::class);
        // $this->call(AdminTableSeeder::class);
        // $this->call(TeacherTableSeeder::class);
        // $this->call(ParentsTableSeeder::class);
        // $this->call(StudentsTableSeeder::class);
        // $this->call(ClassTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        // $this->call(StudentClassTableSeeder::class);
        $this->call(ScoretypeTableSeeder::class);
        // // $this->call(TranscriptTableSeeder::class);
        // $this->call(MessagesTableSeeder::class);
        // $this->call(MsgRecvTableSeeder::class);
        // $this->call(MsgSendTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        // $this->call(PhancongTableSeeder::class);
        // $this->call(LectureregisterSeeder::class);
        // $this->call(SysVarSeeder::class);

        Model::reguard();

        DB::table('sysvar')->insert([
    			'id' =>	'a_next_id',
	            'value' => '0',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	't_next_id',
	            'value' => '-1',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	's_next_id',
	            'value' => '-1',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	'p_next_id',
	            'value' => '-1',            	  
    	]);
        DB::table('sysvar')->insert([
                'id' => 'sub_next_id',
                'value' => '0',
        ]);
        DB::table('sysvar')->insert([
                'id' => 'tkb_date',
                'value' => '0',
        ]);
    }
}
