<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $courses = [
            ['name' => 'BSIT', 'created_at' => $now, 'updated_at' => $now ],
            ['name' => 'BEED', 'created_at' => $now, 'updated_at' => $now ],
            ['name' => 'BSED', 'created_at' => $now, 'updated_at' => $now ],
            ['name' => 'BSED-Math', 'created_at' => $now, 'updated_at' => $now ] 
        ];
        DB::table('courses')->insert($courses);
    }

}
