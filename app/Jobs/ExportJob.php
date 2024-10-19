<?php

namespace App\Jobs;

use App\Exports\ProductsExport;
use App\Mail\ExportReadyMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path;

    /**
     * Create a new job instance.
     */
    public function __construct(public $filters, public $userId, $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info("herekdnaklsdhfafsiashfoia---0000");
        try {
            Excel::store(export: new ProductsExport($this->filters), filePath: $this->path, disk: 'public');
            // TODO: send email and notify user
            // Mail::to(User::find($this->userId)->email)->send(new ExportReadyMail($this->path));
        } catch (\Exception $e) {
            info('Export error: ' . $e->getMessage());
            throw $e;
        }
    }
}
