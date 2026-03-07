<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateFirebaseCredentials extends Command
{
    protected $signature = 'firebase:create-credentials';

    protected $description = 'Create the Firebase credentials JSON file from config values';

    public function handle(): void
    {
        $projectId = config('firebase-credentials.project_id');

        if (empty($projectId)) {
            $this->error('The firebase-credentials.project_id config value is not set.');

            return;
        }

        $credentials = [
            'type' => 'service_account',
            'project_id' => $projectId,
            'private_key_id' => config('firebase-credentials.private_key_id'),
            'private_key' => str_replace('\\n', "\n", config('firebase-credentials.private_key', '')),
            'client_email' => config('firebase-credentials.client_email'),
            'client_id' => config('firebase-credentials.client_id'),
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => config('firebase-credentials.client_cert_url'),
            'universe_domain' => 'googleapis.com',
        ];

        $path = storage_path('app/firebase-credentials.json');

        File::put($path, json_encode($credentials, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info("Firebase credentials file created at: {$path}");
    }
}
