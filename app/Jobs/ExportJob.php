<?php

namespace App\Jobs;

use App\Models\Core\User;
use App\Notifications\Shipping\ExportCompleted;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    private $url;

    /**
     * Create a new job instance.
     */
    public function __construct(public $exportable, public $topic, public $fileHash, public $userId, public $locale)
    {
        $this->url = url($this->topic->getFilePath() . '/' . $this->fileHash);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $response = Excel::store(
        //     export: $this->exportable,
        //     filePath: $this->topic->getFilePath() . '/' . $this->fileHash . '.xlsx'
        // );

        // $notification = new ExportCompleted(
        //     topic: $this->topic->name,
        //     url: $this->url,
        //     failed: !$response
        // );

        // $user->notify($notification);

    }
}
