<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            ['title'=>'Complete Project Proposal', 'is_completed'=>0, 'created_at'=>NOW(), 'updated_at'=>NOW()],
            ['title'=>'Organize Team Meeting', 'is_completed'=>1, 'created_at'=>NOW(), 'updated_at'=>NOW()],
            ['title'=>'Prepare Budget Report', 'is_completed'=>0, 'created_at'=>NOW(), 'updated_at'=>NOW()],
        ]);
        DB::table('subtasks')->insert([
            ['task_id'=>1, 'title'=>'Research project requirements', 'is_completed'=>0, 'created_at'=>NOW(), 'updated_at'=>NOW()],
            ['task_id'=>1, 'title'=>'Draft the proposal document', 'is_completed'=>0, 'created_at'=>NOW(), 'updated_at'=>NOW()],
            ['task_id'=>2, 'title'=>'Send meeting invites', 'is_completed'=>1, 'created_at'=>NOW(), 'updated_at'=>NOW()],
            ['task_id'=>2, 'title'=>'Prepare agenda for meeting', 'is_completed'=>0, 'created_at'=>NOW(), 'updated_at'=>NOW()],
            ['task_id'=>3, 'title'=>'Collect expense data', 'is_completed'=>0, 'created_at'=>NOW(), 'updated_at'=>NOW()],
            ['task_id'=>3, 'title'=>'Draft initial report', 'is_completed'=>0, 'created_at'=>NOW(), 'updated_at'=>NOW()],
        ]);
    }
}
