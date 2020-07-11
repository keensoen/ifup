<?php

namespace App\Imports;

use Str;
use App\Entities\Member;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class MembersImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     $this->validate($row, [
    //         'tel'       => ['unique:members', 'required'],
    //         'code'      => ['unique:members'],
    //         'firstname' => ['alpha'],
    //         'surname'   =>  ['alpha'],
    //         'birthday'  =>  ['date:Y-m-d']
    //     ]);

    //     return new Member([ 
    //         'code'          => $row['code'],
    //         'organization_id' => $row[1], //not null
    //         'salutation_id' => $row[2],
    //         'first_name'    => $row[3],   //not null     
    //         'middle_name'   => $row[4],
    //         'surname'       => $row[5],     //not null
    //         'birthday'      => $row[6],     //not null
    //         'tel'           => $row[7],     //not null
    //         'email'         => $row[8],
    //         'address'       => $row[9],     //not null
    //     ]);
    // }

    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
            '*.0'       => 'unique:members|required',
            '*.1'      => 'unique:members',
            '*.2'   => 'alpha',
            '*.3'   =>  'alpha',
            '*.4'  =>  'date:Y-m-d'
         ])->validate();

        foreach ($rows as $row) {
            User::create([
                'code'          => $row['code'],
                'organization_id' => $row[1], //not null
                'salutation_id' => $row[2],
                'first_name'    => $row[3],   //not null     
                'middle_name'   => $row[4],
                'surname'       => $row[5],     //not null
                'birthday'      => $row[6],     //not null
                'tel'           => $row[7],     //not null
                'email'         => $row[8],
                'address'       => $row[9],     //not null
            ]);
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
