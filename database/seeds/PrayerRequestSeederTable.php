<?php

use App\Entities\PrayerRequest;
use Illuminate\Database\Seeder;

class PrayerRequestSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prayers = [
            [
                'organization_id' => 2,
                'member_id' => 1,
                'prayer_point' => 'Bless the name of the Lord. thank Him for making you see this, bless the Alpha and the Omega, give Him glory and adoration'
            ],
            [
                'organization_id' => 2,
                'member_id' => 5,
                'prayer_point' => 'Father, destroy any form of sickness in my body and grant me divine health for the rest of my life'
            ],
            [
                'organization_id' => 2,
                'member_id' => 11,
                'prayer_point' => 'Father, You said You would supply all my needs according to Your riches in glory; Lord, please fulfil Your promise and meet all my needs'
            ],
            [
                'organization_id' => 2,
                'member_id' =>39,
                'prayer_point' => 'Father, help me to know you more, to love You more and to serve You better than ever before'
            ],
            [
                'organization_id' => 2,
                'member_id' => 40,
                'prayer_point' => 'Father, empower me to perform great miracles and win souls to Your kingdom more than ever before'
            ],
            [
                'organization_id' => 2,
                'member_id' => 43,
                'prayer_point' => 'Father, open great doors for me, order my steps and help me to access all You have prepared for me'
            ],
            [
                'organization_id' => 2,
                'member_id' => 4,
                'prayer_point' => 'Father, please keep evil far away from all my loved ones. Hide us in You at all times'
            ],
            [
                'organization_id' => 2,
                'member_id' => 42,
                'prayer_point' => 'Father, as You ordered in the case of Haman and Mordecai, let my enemies fall into their own traps'
            ],
            [
                'organization_id' => 2,
                'member_id' => 4,
                'prayer_point' => 'Father, smile on me today and let me see and enjoy Your favour everyday of my life'
            ],
            [
                'organization_id' => 2,
                'member_id' => 11,
                'prayer_point' => 'Father, every time i call on You, please answer me by fire'
            ],
            [
                'organization_id' => 12,
                'member_id' => 1,
                'prayer_point' => 'Lord, like prayed for Peter, please pray for me'
            ],
        ];

        foreach ($prayers as $key => $value) {
            PrayerRequest::create($value);
        }
    }
}
