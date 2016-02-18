<?php

use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('position')->insert([
                'position_name' => 'N/A',                 
        ]);
        DB::table('position')->insert([
	            'position_name' => 'Hiệu Trưởng',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Phó Hiệu Trưởng',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Giáo Viên',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Giám Thị',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Bảo Mẫu',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Custome',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Custome',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Custome',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Custome',            	  
    	]);
    	DB::table('position')->insert([
	            'position_name' => 'Custome',            	  
    	]);
    }
}
