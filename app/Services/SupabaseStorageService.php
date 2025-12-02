<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SupabaseStorageService
{
    protected $projectUrl;
    protected $apiKey;
    protected $bucket;

    public function __construct()
    {
        // first try env, then try filesystems config (endpoint contains project URL + storage path)
        $this->projectUrl = \env('SUPABASE_URL') ?: (Config::get('filesystems.disks.supabase.endpoint') ? preg_replace('#/storage/v1.*$#', '', Config::get('filesystems.disks.supabase.endpoint')) : null);
        $this->apiKey = \env('SUPABASE_SERVICE_ROLE_KEY') ?: Config::get('filesystems.disks.supabase.key');
        $this->bucket = \env('SUPABASE_BUCKET') ?: Config::get('filesystems.disks.supabase.bucket') ?: 'artworks';

        // Improve error messaging early — this clarifies why cURL resolves to "storage"
        if (empty($this->projectUrl)) {
            Log::error('SupabaseStorageService misconfigured: SUPABASE_URL missing (or config fallback empty)');
            throw new \InvalidArgumentException('SUPABASE_URL not configured. Please set SUPABASE_URL in your .env file (e.g. https://<project>.supabase.co).');
        }
    }

    public function upload($file, $path)
    {
        $fileContent = file_get_contents($file->getRealPath());

        // build final upload URL
        $uploadUrl = "{$this->projectUrl}/storage/v1/object/{$this->bucket}/$path";
        Log::debug('Supabase upload URL: ' . $uploadUrl);

        $response = Http::withOptions([
                'verify' => false // 🔥 FIX SSL ERROR (dev/testing only; enable CA verify in production)
            ])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => $file->getMimeType(),
                'x-upsert' => 'true',
            ])
            ->withBody($fileContent, $file->getMimeType())
            ->post($uploadUrl);

        if (!$response->successful()) {
            $safeMessage = $response->json('message') ?? "HTTP " . $response->status();
            throw new \Exception("Upload gagal: " . $safeMessage);
        }

        // 🔥 Penting: variabel tidak boleh undefined
        $publicUrl = "{$this->projectUrl}/storage/v1/object/public/{$this->bucket}/$path";

        return $publicUrl;
    }
}
