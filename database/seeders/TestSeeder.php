<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;

class TestSeeder extends Seeder
{
    public function run()
    {
        Test::create([
            'title' => 'اختبار PHP الأساسي',
            'description' => 'اختبار يقيس مهاراتك في PHP',
            'duration' => 30, // مدة الاختبار 30 دقيقة
        ]);
    }
}

