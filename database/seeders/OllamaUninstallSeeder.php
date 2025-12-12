<?php

namespace Bithoven\LLMProviderOllama\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OllamaUninstallSeeder extends Seeder
{
    /**
     * Run the database seeds (Uninstall operations).
     */
    public function run(): void
    {
        $this->command->warn('🗑️ Starting Ollama provider uninstallation...');

        // 1. Drop Ollama-specific tables
        $tables = [
            'ollama_usage_snapshots',
            'ollama_connection_logs',
            'ollama_user_preferences',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
                $this->command->info("✅ Dropped table: {$table}");
            }
        }

        // 2. Delete Ollama permissions
        $permissions = [
            'ollama.view',
            'ollama.manage',
            'ollama.preferences',
            'ollama.logs.view',
            'ollama.logs.delete',
        ];

        foreach ($permissions as $permissionName) {
            $deleted = DB::table('permissions')
                ->where('name', $permissionName)
                ->where('guard_name', 'web')
                ->delete();

            if ($deleted) {
                $this->command->info("✅ Deleted permission: {$permissionName}");
            }
        }

        // 3. Delete Ollama LLM configurations
        $deleted = DB::table('llm_provider_configurations')
            ->where('provider', 'ollama')
            ->delete();

        if ($deleted) {
            $this->command->info("✅ Deleted {$deleted} Ollama configuration(s)");
        }

        // 4. Clean up provider settings file
        $settingsPath = \storage_path('app/llm-manager/provider-settings.json');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            
            if (isset($settings['providers']['ollama'])) {
                unset($settings['providers']['ollama']);
                file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT));
                $this->command->info('✅ Removed Ollama from provider-settings.json');
            }
        }

        $this->command->info('🎉 Ollama provider uninstalled successfully.');
    }
}
