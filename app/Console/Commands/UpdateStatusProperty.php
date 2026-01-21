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
        $user_properties = UserProperty::where('is_active', 1)
        ->whereRaw('DATE_ADD(end_date, INTERVAL 3 DAY) <= ?', [date('Y-m-d')])
        ->orderBy('id', 'DESC')
        ->get();
        foreach($user_properties as $up) {
            $up->update([
                'is_active' => null,
                'status' => 'Non Aktif',
            ]);
    
            $room = PropertyRoom::find($up->room_id);
            $room->update([
                'is_available' => null,
            ]);
        }
    }
}
