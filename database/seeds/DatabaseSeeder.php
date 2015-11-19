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
        $this->call(SysVarSeeder::class);
        $this->call(SchedulesTableSeeder::class);
        $this->call(StudentClassTableSeeder::class);
        Model::reguard();
    }
}
