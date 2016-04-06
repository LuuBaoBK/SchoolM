<?php

use Illuminate\Database\Seeder;

class SysVarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sysvar')->insert([
    			'id' =>	'a_next_id',
	            'value' => '19',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	't_next_id',
	            'value' => '19',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	's_next_id',
	            'value' => '19',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	'p_next_id',
	            'value' => '9',            	  
    	]);
        DB::table('sysvar')->insert([
                'id' => 'sub_next_id',
                'value' => '9',
        ]);
        DB::table('sysvar')->insert([
                'id' => 'tkb_date',
                'value' => '0',
        ]);
        // for($i=0;$i<10;$i++){
        //     DB::table('sysvar')->insert([
        //         'id' => 'boar_rector_'.$i,
        //         'value' => null,
        //     ]);
        // }
        // for($i=0;$i<10;$i++){
        //     DB::table('sysvar')->insert([
        //         'id' => 'custome_content'.$i,
        //             'value' => null,
        //     ]);
        // }
        // for($i=0;$i<10;$i++){
        //     DB::table('sysvar')->insert([
        //         'id' => 'custome_content_title'.$i,
        //             'value' => null,
        //     ]);
        // }
    }
}
