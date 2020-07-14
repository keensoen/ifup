<?php

namespace App\Imports;

use Str;
use App\Entities\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MembersImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public function mapping(): array
    {
        return [
            'code' => 'A2',
            'organization_id' => 'B2',
            'salutation_id' => 'C2',
            'first_name' => 'D2',
            'surname'   => 'E2',
            'birthday'  => 'F2',
            'tel'   => 'G2',
            'member_group_id'   => 'H2',
            'service_interest_id'   => 'I2',
        ];
    }

    public function model(array $row)
    {
        return new Member([ 
            'code' => $row['code'],
            'organization_id' => $row['organization_id'],
            'salutation_id' => $row['salutation_id'],
            'first_name'    => $row['first_name'],   
            'surname'       => $row['surname'],
            'birthday'      => $row['birthday'] ? $this->transformDate($row['birthday']) : NULL,
            'tel'           => $row['tel'],
            'member_group_id'   => $row['member_group_id'],
            'service_interest_id'   => $row['service_interest_id'],
            'slug'      => Str::slug($row['first_name'].' '.$row['surname'], '-'),
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
