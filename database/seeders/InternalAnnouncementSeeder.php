<?php

namespace Database\Seeders;

use App\Models\InternalAnnouncement;
use Illuminate\Database\Seeder;

class InternalAnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        InternalAnnouncement::factory()->count(5)->create();
    }
}
