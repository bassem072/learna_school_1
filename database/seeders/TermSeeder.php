<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $terms = [
            ['First Term', 'الفصل الدراسى الاول'],
            ['Second Term', 'الفصل الدراسى الثانى'],
            ['Summer Term', 'الفصل الدراسى الصيفى'],
        ];
        foreach ($terms as $term){
            $data = [
                'en' => ['name' => $term[0]],
                'ar' => ['name' => $term[1]],
            ];
            $data = Term::create($data);
        }
        $this->command->info('Terms Added Successfully');
    }
}
