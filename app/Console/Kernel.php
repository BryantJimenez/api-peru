<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ImportDataUbigeo;
use App\Jobs\ImportDataSunat;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            if (file_exists(public_path("admins/excel/UBIGEODISTRITOS.XLSX"))) {
                unlink(public_path("admins/excel/UBIGEODISTRITOS.XLSX"));
            }
        })->dailyAt('23:50');

        $schedule->exec("wget -P ".public_path("admins/excel/")." https://www.datosabiertos.gob.pe/sites/default/files/UBIGEODISTRITOS.XLSX")->dailyAt('23:53');

        $schedule->job(new ImportDataUbigeo, 'high')->dailyAt('23:58');

        $schedule->call(function () {
            if (file_exists(public_path("admins/zip/padron_reducido_ruc.zip"))) {
                unlink(public_path("admins/zip/padron_reducido_ruc.zip"));
            }

            if (file_exists(public_path("admins/zip/padron_reducido_ruc.txt"))) {
                unlink(public_path("admins/zip/padron_reducido_ruc.txt"));
            }
        })->dailyAt('03:50');

        $schedule->exec("wget -P ".public_path("admins/zip/")." http://www2.sunat.gob.pe/padron_reducido_ruc.zip")->dailyAt('04:00');

        $schedule->exec("unzip -o ".public_path("admins/zip/padron_reducido_ruc.zip")." -d ".public_path("admins/zip/"))->dailyAt('05:15');

        // $schedule->job(new ImportDataSunat, 'high')->dailyAt('05:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
