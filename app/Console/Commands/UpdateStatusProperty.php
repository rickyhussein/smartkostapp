<?php

namespace App\Console\Commands;

use App\Models\PropertyRoom;
use App\Models\UserProperty;
use Illuminate\Console\Command;

class UpdateStatusProperty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:updatestatusproperty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic Update Status';

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
        $up = UserProperty::find(1);
        $up->update([
            'is_active' => null,
            'status' => 'Non Aktif',
        ]);

        $room = PropertyRoom::find($up->id);
        $room->update([
            'is_available' => null,
        ]);
    }
}
