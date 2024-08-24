<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\LeaveRequestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveRequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveRequestType::create([
            'name' => 'Falta'
        ]);

        // LeaveRequest::create([
        //     'typeId' => '1',
        //     'startDate' => '2024-08-12',
        //     'endDate' => '2024-08-12',
        //     'reason' => 'Sin motivo',
        //     'requesterName' => 'Israel Aguilar',
        //     'ci' => '6519450',
        //     'kinship' => 'Tio(a)'
        // ]);
    }
}
