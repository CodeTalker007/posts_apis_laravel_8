<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteFilesOlderThan15Days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-old-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to delete all files older than 15 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        collect(Storage::disk(config('filesystems.default'))->listContents('userUploads', true))
            ->each(function($file) {
                if ($file['type'] == 'file' && $file['timestamp'] < now()->subDays(15)->getTimestamp()) {
                    Storage::disk(config('filesystems.default'))->delete($file['path']);
                }
            });
    }
}
