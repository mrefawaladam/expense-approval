<?php

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\Approver;
use App\Models\ApprovalStage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Status
        $waiting = Status::create(['name' => 'Menunggu Persetujuan']);
        $approved = Status::create(['name' => 'Disetujui']);

        // Seed Approvers
        $ana = Approver::create(['name' => 'Ana']);
        $ani = Approver::create(['name' => 'Ani']);
        $ina = Approver::create(['name' => 'Ina']);

        // Seed Approval Stages
        ApprovalStage::create(['approver_id' => $ana->id]);
        ApprovalStage::create(['approver_id' => $ani->id]);
        ApprovalStage::create(['approver_id' => $ina->id]);
    }
}
