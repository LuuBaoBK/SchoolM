<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(TeacherTableSeeder::class);
        $this->call(ParentsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(ClassTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        $this->call(StudentClassTableSeeder::class);
        $this->call(ScoretypeTableSeeder::class);
        // $this->call(TranscriptTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(MsgRecvTableSeeder::class);
        $this->call(MsgSendTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(PhancongTableSeeder::class);
        $this->call(LectureregisterSeeder::class);
        $this->call(SysVarSeeder::class);

        Model::reguard();
    }
}
