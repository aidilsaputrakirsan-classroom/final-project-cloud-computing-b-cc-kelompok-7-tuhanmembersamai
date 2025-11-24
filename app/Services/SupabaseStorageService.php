<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseStorageService
{
    protected $projectUrl;
    protected $apiKey;
    protected $bucket;

    public function __construct()
    {
        $this->projectUrl = env('SUPABASE_URL');
        $this->apiKey = env('SUPABASE_SERVICE_ROLE_KEY');
        $this->bucket = 'artworks';
    }

    public function upload($file, $path)
    {
        $fileContent = file_get_contents($file->getRealPath());

        $response = Http::withOptions([
                'verify' => false // 🔥 FIX SSL ERROR
            ])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => $file->getMimeType(),
                'x-upsert' => 'true',
            ])
            ->withBody($fileContent, $file->getMimeType())
            ->post("{$this->projectUrl}/storage/v1/object/{$this->bucket}/$path");

        if (!$response->successful()) {
            $safeMessage = $response->json('message') ?? "HTTP " . $response->status();
            throw new \Exception("Upload gagal: " . $safeMessage);
        }

        // 🔥 Penting: variabel tidak boleh undefined
        $publicUrl = "{$this->projectUrl}/storage/v1/object/public/{$this->bucket}/$path";

        return $publicUrl;
    }
}
