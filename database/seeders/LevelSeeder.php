<?php

namespace Database\Seeders;

use App\Models\EducationSystem;
use App\Models\EduSt;
use App\Models\EduStYear;
use App\Models\Level;
use App\Models\Section;
use App\Models\Stage;
use App\Models\Year;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = [
            ['Primary', 'الابتدائية'],
            ['Preparatory', 'الاعدادية'],
            ['Secondary', 'الثانوية'],
        ];

        $years = [
            ['First', 'الاول'],
            ['Second', 'الثانى'],
            ['Third', 'الثالث'],
            ['Fourth', 'الرابع'],
            ['Fifth', 'الخامس'],
            ['Sixth', 'السادس'],
        ];

        $education_systems = [
            ['Arabic', 'عربى'],
            ['Languages', 'لغات'],
        ];

        $sections = [
            ['General', 'عام'],
            ['Literary', 'ادبى'],
            ['Scientific', 'علمى'],
            ['Scientific Science', 'علمى علوم'],
            ['scientific math', 'علمى رياضة'],
        ];

        $subjects = [
            [1, 2, 3, 4, 5, 11, 19],
            [1, 2, 3, 4, 5, 11, 19],
            [1, 2, 3, 4, 5, 11, 19],
            [1, 2, 3, 4, 5, 6, 11, 14, 19, 22],
            [1, 2, 3, 4, 5, 6, 11, 14, 19, 22],
            [1, 2, 3, 4, 5, 6, 11, 14, 19, 22],
            [1, 2, 3, 4, 5, 6, 11, 14, 19, 22],
            [1, 2, 3, 4, 5, 6, 11, 14, 19, 22],
            [1, 2, 3, 4, 5, 6, 11, 14, 19, 22],
            [1, 2, 3, 4, 5, 7, 8, 9, 12, 15, 16, 17, 19, 22, 23],
            [1, 2, 3, 4, 5, 12, 15, 16, 17, 18, 19, 22, 23],
            [1, 2, 3, 4, 5, 7, 8, 9, 12, 13, 19, 22, 23],
            [1, 2, 3, 4, 5, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 7, 8, 9, 10, 12, 13, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 7, 8, 9, 10, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 7, 8, 12, 13, 19, 20, 21, 22, 23],
        ];

        foreach ($education_systems as $education_system){
            $data = [
                'en' => ['name' => $education_system[0]],
                'ar' => ['name' => $education_system[1]],
            ];
            $data = EducationSystem::create($data);
        }

        foreach ($stages as $stage){
            $data = [
                'en' => ['name' => $stage[0]],
                'ar' => ['name' => $stage[1]],
            ];
            $data = Stage::create($data);
        }

        foreach ($years as $year){
            $data = [
                'en' => ['name' => $year[0]],
                'ar' => ['name' => $year[1]],
            ];
            $data = Year::create($data);
        }

        foreach ($sections as $section){
            $data = [
                'en' => ['name' => $section[0]],
                'ar' => ['name' => $section[1]],
            ];
            $data = Section::create($data);
        }

        $count = 0;
        for ($i = 1; $i < 3; $i++){
            for ($j = 1; $j < 7; $j++){
                $level = Level::create([
                    'education_system_id' => $i,
                    'stage_id' => 1,
                    'year_id' => $j,
                    'section_id' => 1,
                ]);
                $level->subjects()->attach($subjects[$count++]);
            }

            for ($j = 1; $j < 4; $j++){
                $level = Level::create([
                    'education_system_id' => $i,
                    'stage_id' => 2,
                    'year_id' => $j,
                    'section_id' => 1,
                ]);
                $level->subjects()->attach($subjects[$count++]);
            }

            for ($j = 1; $j < 4; $j++){
                if ($j == 3){
                    $level = Level::create([
                        'education_system_id' => $i,
                        'stage_id' => 3,
                        'year_id' => $j,
                        'section_id' => 2,
                    ]);
                    $level->subjects()->attach($subjects[$count++]);
                }
                for ($k = 1; $k < $j + 1; $k++){
                    $level = Level::create([
                        'education_system_id' => $i,
                        'stage_id' => 3,
                        'year_id' => $j,
                        'section_id' => $j + $k - 1,
                    ]);
                    $level->subjects()->attach($subjects[$count++]);
                }
            }
            $count = 0;
        }


        /* Stage Table
        foreach ($stage as $st){
            $data = [
                'en' => ['name' => $st[0]],
                'ar' => ['name' => $st[1]],
            ];
            $data = Stage::create($data);
        }
        /* End Stage Table

        /* Education System Table
        foreach ($education_system as $edu){
            $data = [
                'en' => ['name' => $edu[0]],
                'ar' => ['name' => $edu[1]],
            ];
            $data = EducationSystem::create($data);
            $data->stages()->attach([1, 2, 3]);
        }
        /* End Education System Table */

        /* Year Table
        foreach ($year as $yr){
            $data = [
                'en' => ['name' => $yr[0]],
                'ar' => ['name' => $yr[1]],
            ];
            $data = Year::create($data);
        }

        for ($i = 1; $i < 7; $i++){
            $edu_st = EduSt::find($i);
            if ($i % 3 == 1){
                $edu_st->years()->attach([1, 2, 3, 4, 5, 6]);
            }else{
                $edu_st->years()->attach([1, 2, 3]);
            }
        }
        /* End Year Table

        /* Section Table
        $j = 1;
        foreach ($section as $sec){
            $data = [
                'en' => ['name' => $sec[0]],
                'ar' => ['name' => $sec[1]],
            ];
            $data = Section::create($data);
        }

        for ($i = 1; $i < 25; $i++){
            $edu_st_year = EduStYear::find($i);
            if ($i < 11 or ($i > 12 and $i < 23)){
                $edu_st_year->sections()->attach(1);
            }elseif ($i == 11 or $i == 23){
                $edu_st_year->sections()->attach([2, 3]);
            }else{
                $edu_st_year->sections()->attach([2, 3, 4, 5]);
            }
        }
        /* End Section Table

        /* Subjects
        $levels = Level::all();
        $i = 1;
        foreach ($levels as $level){
            $level->subjects()->attach($subjects[$i++]);
            if ($i > 15){
                $i = 1;
            }
        }*/
        /* End Subjects */


        /* Primary Stage
        for ($i = 0; $i < 6; $i++){
            $data = [
                'en' => ['year' => $year[$i][0], 'stage' => $stage[0][0], 'education_system' => $education_system[0][0], 'section' => $section[0][0]],
                'ar' => ['year' => $year[$i][1], 'stage' => $stage[0][1], 'education_system' => $education_system[0][1], 'section' => $section[0][1]],
            ];
            $data = Level::create($data);
            $data->subjects()->attach($subjects[$i]);
        }

        for ($i = 0; $i < 6; $i++){
            $data = [
                'en' => ['year' => $year[$i][0], 'stage' => $stage[0][0], 'education_system' => $education_system[1][0], 'section' => $section[0][0]],
                'ar' => ['year' => $year[$i][1], 'stage' => $stage[0][1], 'education_system' => $education_system[1][1], 'section' => $section[0][1]],
            ];
            $data = Level::create($data);
            $data->subjects()->attach($subjects[$i]);
        }
        /* End Primary Stage


        /*
        for ($i = 0; $i < 3; $i++){
            $data = [
                'en' => ['year' => $year[$i][0], 'stage' => $stage[1][0], 'education_system' => $education_system[0][0], 'section' => $section[0][0]],
                'ar' => ['year' => $year[$i][1], 'stage' => $stage[1][1], 'education_system' => $education_system[0][1], 'section' => $section[0][1]],
            ];
            $data = Level::create($data);
            $data->subjects()->attach($subjects[$i + 6]);
        }

        for ($i = 0; $i < 3; $i++){
            $data = [
                'en' => ['year' => $year[$i][0], 'stage' => $stage[1][0], 'education_system' => $education_system[1][0], 'section' => $section[0][0]],
                'ar' => ['year' => $year[$i][1], 'stage' => $stage[1][1], 'education_system' => $education_system[1][1], 'section' => $section[0][1]],
            ];
            $data = Level::create($data);
            $data->subjects()->attach($subjects[$i + 6]);
        }
        /* End Preparatory Stage

        /* Secondary Stage
        $k = 9;
        for ($i = 0; $i < 3; $i++){
            if ($i == 2){
                $data = [
                    'en' => ['year' => $year[$i][0], 'stage' => $stage[2][0], 'education_system' => $education_system[0][0], 'section' => $section[1][0]],
                    'ar' => ['year' => $year[$i][1], 'stage' => $stage[2][1], 'education_system' => $education_system[0][1], 'section' => $section[1][1]],
                ];
                $data = Level::create($data);
                $data->subjects()->attach($subjects[$k++]);
            }
            for ($j = 0; $j <= $i; $j++){
                $data = [
                    'en' => ['year' => $year[$i][0], 'stage' => $stage[2][0], 'education_system' => $education_system[0][0], 'section' => $section[$i + $j][0]],
                    'ar' => ['year' => $year[$i][1], 'stage' => $stage[2][1], 'education_system' => $education_system[0][1], 'section' => $section[$i + $j][1]],
                ];
                $data = Level::create($data);
                $data->subjects()->attach($subjects[$k++]);
            }
        }

        $k = 9;
        for ($i = 0; $i < 3; $i++){
            if ($i == 2){
                $data = [
                    'en' => ['year' => $year[$i][0], 'stage' => $stage[2][0], 'education_system' => $education_system[1][0], 'section' => $section[1][0]],
                    'ar' => ['year' => $year[$i][1], 'stage' => $stage[2][1], 'education_system' => $education_system[1][1], 'section' => $section[1][1]],
                ];
                $data = Level::create($data);
                $data->subjects()->attach($subjects[$k++]);
            }
            for ($j = 0; $j <= $i; $j++){
                $data = [
                    'en' => ['year' => $year[$i][0], 'stage' => $stage[2][0], 'education_system' => $education_system[1][0], 'section' => $section[$i + $j][0]],
                    'ar' => ['year' => $year[$i][1], 'stage' => $stage[2][1], 'education_system' => $education_system[1][1], 'section' => $section[$i + $j][1]],
                ];
                $data = Level::create($data);
                $data->subjects()->attach($subjects[$k++]);
            }
        }
        /* End Secondary Stage */

        /*foreach ($levels as $level){
            $data = [
                'en' => ['name' => $level[0]],
                'ar' => ['name' => $level[1]],
            ];
            $data = Level::create($data);
            $data->subjects()->attach($level[2]);
        }*/
        $this->command->info('Levels Added Successfully');
    }
}
