<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Imports\RucsImport;
use ZipArchive;

class ImportDataSunat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $import;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (file_exists(public_path('/admins/zip/padron_reducido_ruc.txt'))) {
            $this->import=true;
        } else {
            $this->import=false;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->import) {
            try {
                // Excel::import(new RucsImport, public_path('/admins/zip/padron_reducido_ruc.txt'), null, \Maatwebsite\Excel\Excel::CSV);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        } else {
            $zip=new ZipArchive;

            if ($zip->open(public_path('/admins/zip/padron_reducido_ruc.zip'))===true) {
                $zip->extractTo(public_path('/admins/zip/'));
                $zip->close();

                try {
                    // Excel::import(new RucsImport, public_path('/admins/zip/padron_reducido_ruc.txt'), null, \Maatwebsite\Excel\Excel::CSV);
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            } else {
                Log::error('No se encuentra el archivo');
            }
        }
    }
}
