<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::factory()->count(4)->create();
        // Student::create([
        //     'name' => 'm',
        //     'age' => '22',
        // ]);
    }
}
