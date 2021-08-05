<?php

namespace App\Imports;

use App\Ruc;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class RucsImport implements ToCollection, WithCustomCsvSettings, WithBatchInserts, WithChunkReading, ShouldQueue
{
    public function collection(Collection $rows)
    {
        DB::connection()->disableQueryLog();

        // dd($rows);

        foreach ($rows as $row) 
        {
            $ruc=Ruc::where('ruc', $row[0])->first();
            if (is_null($ruc) && $row[0]!="RUC" && $row[1]!="NOMBRE O RAZÓN SOCIAL") {
                DB::table('rucs')->insert([
                    'ruc' => ($row[0]!="-" && $row[0]!="----") ? $row[0] : NULL,
                    'name' => ($row[1]!="-" && $row[1]!="----") ? $row[1] : NULL,
                    'state' => ($row[2]!="-" && $row[2]!="----") ? $row[2] : NULL,
                    'condition_' => ($row[3]!="-" && $row[3]!="----") ? $row[3] : NULL,
                    'ubigeo' => ($row[4]!="-" && $row[4]!="----") ? $row[4] : NULL,
                    'type_way' => ($row[5]!="-" && $row[5]!="----") ? $row[5] : NULL,
                    'name_way' => ($row[6]!="-" && $row[6]!="----") ? $row[6] : NULL,
                    'zone_code' => ($row[7]!="-" && $row[7]!="----") ? $row[7] : NULL,
                    'type_zone' => ($row[8]!="-" && $row[8]!="----") ? $row[8] : NULL,
                    'number' => ($row[9]!="-" && $row[9]!="----") ? $row[9] : NULL,
                    'inside' => ($row[10]!="-" && $row[10]!="----") ? $row[10] : NULL,
                    'lot' => ($row[11]!="-" && $row[11]!="----") ? $row[11] : NULL,
                    'department' => ($row[12]!="-" && $row[12]!="----") ? $row[12] : NULL,
                    'block' => ($row[13]!="-" && $row[13]!="----") ? $row[13] : NULL,
                    'km' => ($row[14]!="-" && $row[14]!="----") ? $row[14] : NULL
                ]);
            }
        }
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => "|"
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
