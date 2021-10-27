<?php

use App\Salary;
use Illuminate\Database\Seeder;

class SalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Salary::create([
            'salary' => '10,000'
        ]);
        Salary::create([
            'salary' => '20,000'
        ]);
        Salary::create([
            'salary' => '30,000'
        ]);
        Salary::create([
            'salary' => '40,000'
        ]);
        Salary::create([
            'salary' => '>50,000'
        ]);
    }
}
