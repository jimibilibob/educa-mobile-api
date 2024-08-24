<?php

namespace App\Jobs;

use App\Models\LeaveRequestTeacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Log;

class SendNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $teachersId;
    protected $leaveRequestId;
    protected $server;
    protected $bearerToken;

    /**
     * Create a new job instance.
     */
    public function __construct(array $teachersId, string $leaveRequestId, string $bearerToken)
    {
        $this->teachersId = $teachersId;
        $this->leaveRequestId = $leaveRequestId;
        $this->server = env('LEGACY_SERVER', '');
        $this->bearerToken = $bearerToken;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if(empty($this->leaveRequestId)) return;

        $server = $this->server;
        $bearerToken = $this->bearerToken;
        $teachersId = $this->teachersId;

        $notificationsUrl = "{$server}/api/maestros/notificaciones";

        $responseTeachers = Http::pool(function (Pool $pool) use ($server, $teachersId, $bearerToken) {
            $notificationsUrl = "{$server}/api/maestros/notificaciones";
            return collect($teachersId)
                ->map(fn ($id) => $pool->retry(3, 100)->withToken($bearerToken)->post($notificationsUrl, [
                    'mensaje' => 'Licencia para el estudiante ...',
                    'titulo' => 'Licencia',
                    'idtipo_notificacion' => 4,
                    'idmaestro' => 158
                ])
            );
        });

        $responseParents = Http::retry(3, 100)->withToken($bearerToken)->post($notificationsUrl, [
            'mensaje' => 'Licencia para el estudiante ...',
            'titulo' => 'Licencia',
            'idtipo_notificacion' => 4,
            'idmaestro' => 158
        ]);

        $idnotificacion = $responseTeachers;

        LeaveRequestTeacher::where('leave_request_id', $this->leaveRequestId)
              ->update(['idnotificacion' => true]);

        Log::debug('RESPONSES IN Background', $responseTeachers);
    }
}
