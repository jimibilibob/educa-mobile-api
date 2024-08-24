<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Log;

class RemoveNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $server;
    protected $bearerToken;
    protected $notificationsIdToRemove;

    /**
     * Create a new job instance.
     */
    public function __construct(array $notificationsIdToRemove, string $bearerToken)
    {
        $this->server = env('LEGACY_SERVER', '');
        $this->bearerToken = $bearerToken;
        $this->notificationsIdToRemove = $notificationsIdToRemove;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $server = $this->server;
        $bearerToken = $this->bearerToken;
        $notificationsIdToRemove = $this->notificationsIdToRemove;

        Log::debug('notifications to remove: ', $notificationsIdToRemove);

        $response = Http::pool(function (Pool $pool) use ($server, $notificationsIdToRemove, $bearerToken) {
            $notificationsUrl = "{$server}/api/edu_elimina_notif";
            return collect($notificationsIdToRemove)
                ->map(fn ($val) => $pool->retry(3, 100)->withToken($bearerToken)->post($notificationsUrl, [
                    'idnotificacion' => $val,
                ])
            );
        });

        Log::debug('RESPONSES RemoveNotificationsJob IN Background', $response);
    }
}
