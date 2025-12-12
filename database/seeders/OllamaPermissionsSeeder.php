<?php

namespace Bithoven\LLMProviderOllama\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OllamaPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'ollama.view',
                'guard_name' => 'web',
                'description' => 'View Ollama provider configurations',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ollama.manage',
                'guard_name' => 'web',
                'description' => 'Manage Ollama provider settings and models',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ollama.preferences',
                'guard_name' => 'web',
                'description' => 'Manage personal Ollama preferences',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ollama.logs.view',
                'guard_name' => 'web',
                'description' => 'View Ollama connection and usage logs',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ollama.logs.delete',
                'guard_name' => 'web',
                'description' => 'Delete Ollama connection and usage logs',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']],
                $permission
            );
        }

        $this->command->info('Ollama permissions seeded successfully.');
    }
}
