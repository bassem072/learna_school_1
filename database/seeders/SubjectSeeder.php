<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $subjects = [
            ['Arabic Language', 'اللغة العربية'],
            ['English Language', 'اللغة الانجليزية'],
            ['French Language', 'اللغة الفرنسية'],
            ['Italian Language', 'اللغة الايطالية'],
            ['Spanish Language', 'اللغة الاسبانية'],
            ['Science', 'العلوم'],
            ['Chemistry', 'الكمياء'],
            ['Physics', 'الفيزياء'],
            ['Biology', 'الاحياء'],
            ['Geology', 'الجيولوجيا'],
            ['Mathematics', 'الرياضيات'],
            ['Pure Mathematics', 'الرياضيات البحتة'],
            ['Applied Mathematics', 'الرياضيات التطبيقية'],
            ['Social Studies', 'الدراسات الاجتماعية'],
            ['Geography', 'الجغرافيا'],
            ['History', 'التاريج'],
            ['Philosophy and Logic', 'الفلسفة و المنطق'],
            ['Psychology and sociology', 'علم النفس و الاجتماع'],
            ['Religious Education', 'التربية الدينية'],
            ['Statistics', 'الاحصاء'],
            ['Economy', 'الاقتصاد'],
            ['Computer', 'الحاسب الآلى'],
            ['Civic Education', 'التربية الوطنية'],
        ];
        foreach ($subjects as $subject){
            $data = [
                'en' => ['name' => $subject[0]],
                'ar' => ['name' => $subject[1]],
            ];
            $data = Subject::create($data);

        }
        $this->command->info('Subjects Added Successfully');
    }
}
