<?php

namespace Bithoven\LLMProviderOllama\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class OllamaSettingsController
{
    /**
     * Show Ollama settings page
     */
    public function index()
    {
        $settings = \config('ollama');
        
        return \view('ollama::settings.index', \compact('settings'));
    }

    /**
     * Update Ollama settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'api_endpoint' => 'required|url',
            'default_model' => 'required|string',
            'temperature' => 'required|numeric|min:0|max:2',
            'max_tokens' => 'required|integer|min:1',
        ]);

        // Update configuration (in a real scenario, save to database or .env)
        \config(['ollama.api_endpoint' => $validated['api_endpoint']]);
        \config(['ollama.default_model' => $validated['default_model']]);
        \config(['ollama.defaults.temperature' => $validated['temperature']]);
        \config(['ollama.defaults.max_tokens' => $validated['max_tokens']]);

        return Redirect::route('admin.ollama.settings')
            ->with('success', 'Ollama settings updated successfully.');
    }

    /**
     * Show user preferences
     */
    public function preferences()
    {
        $preferences = DB::table('ollama_user_preferences')
            ->where('user_id', Auth::id())
            ->first();

        return \view('ollama::settings.preferences', \compact('preferences'));
    }

    /**
     * Update user preferences
     */
    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'preferred_model' => 'nullable|string',
            'api_endpoint' => 'nullable|url',
            'auto_sync' => 'boolean',
        ]);

        DB::table('ollama_user_preferences')->updateOrInsert(
            ['user_id' => Auth::id()],
            [
                'preferred_model' => $validated['preferred_model'] ?? null,
                'api_endpoint' => $validated['api_endpoint'] ?? null,
                'auto_sync' => $validated['auto_sync'] ?? true,
                'updated_at' => Carbon::now(),
            ]
        );

        return Redirect::route('admin.ollama.preferences')
            ->with('success', 'Preferences updated successfully.');
    }

    /**
     * Show connection logs
     */
    public function logs()
    {
        $logs = DB::table('ollama_connection_logs')
            ->where('user_id', Auth::id())
            ->orderBy('connected_at', 'desc')
            ->paginate(20);

        return \view('ollama::settings.logs', \compact('logs'));
    }

    /**
     * Delete a connection log
     */
    public function deleteLog($id)
    {
        DB::table('ollama_connection_logs')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return Redirect::route('admin.ollama.logs')
            ->with('success', 'Log deleted successfully.');
    }
}
