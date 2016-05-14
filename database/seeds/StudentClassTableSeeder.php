<?php

use Illuminate\Database\Seeder;
use App\Model\Classes;

class StudentClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add Student => 14_6
        $classes = Classes::where('id','like','14_6_%')->get();
        $offset = 240;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+30); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = rand(0,2);
                $ispass = 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => rand(5,10)
                ]);
            }
            $offset += 30;
        }

        // Add Student => 14_7
        $classes = Classes::where('id','like','14_7_%')->get();
        $offset = 140;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+25); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = rand(0,2);
                $ispass = 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => rand(5,10)
                ]);
            }
            $offset += 25;
        }

        // Add Student => 14_8
        $classes = Classes::where('id','like','14_8_%')->get();
        $offset = 60;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+20); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = rand(0,2);
                $ispass = 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => rand(5,10)
                ]);
            }
            $offset += 20;
        }

        // Add Student => 14_9
        $classes = Classes::where('id','like','14_9_%')->get();
        $offset = 0;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+15); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = rand(0,2);
                $ispass = 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => rand(5,10)
                ]);
            }
            $offset += 15;
        }

        // Add Student => 15_6
        $classes = Classes::where('id','like','15_6_%')->get();
        $offset = 360;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+35); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = 0;
                $gpa = rand(0,10);
                $ispass = ($gpa < 5) ? 0 : 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => $gpa
                ]);
            }
            $offset += 35;
        }

        // Add Student => 15_7
        $classes = Classes::where('id','like','15_7_%')->get();
        $offset = 240;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+30); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = 0;
                $gpa = rand(0,10);
                $ispass = ($gpa < 5) ? 0 : 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => $gpa
                ]);
            }
            $offset += 30;
        }

        // Add Student => 15_8
        $classes = Classes::where('id','like','15_8_%')->get();
        $offset = 140;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+25); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = 0;
                $gpa = rand(0,10);
                $ispass = ($gpa < 5) ? 0 : 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => $gpa
                ]);
            }
            $offset += 25;
        }

        // Add Student => 15_9
        $classes = Classes::where('id','like','15_9_%')->get();
        $offset = 60;
        foreach ($classes as $key => $class) {
            for($i = $offset; $i < ($offset+20); $i++){
                $temp = 9-strlen($i);
                $id = substr('s_0000000', 0,$temp);
                $id = $id.$i;
                $conduct = 0;
                $gpa = rand(0,10);
                $ispass = ($gpa < 5) ? 0 : 1;
                $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
                DB::table('studentclass')->insert([
                    'class_id'      =>  $class->id,
                    'student_id'    => $id,
                    'conduct'       => $conducttype[$conduct],
                    'ispassed'      => $ispass,
                    'GPA'           => $gpa
                ]);
            }
            $offset += 20;
        }
    }
}
