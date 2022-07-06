<?php

namespace App\Console;

use App\Models\SlaBreachOrder;
use App\Utility\NotificationUtility;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon as Time;
use DB;
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
        /**
         * this routine will set all the orders 
         * which are pending to cancelled and 
         * add the respective charges against 
         * it to the seller account for sla breach
        */
         $schedule->call(function () {  //  
            $sla_activation  = get_setting('sla_activation');
            $sla_charge_type = get_setting('sla_charge_type','flat');
            $sla_charge = get_setting('sla_charge');
            if($sla_activation)
            {
                $sla_time  = get_setting('sla_time',0);
                $time = now('Asia/Kolkata')->timestamp;
                $time_comp = $time-$sla_time*60*60;
                $orders = DB::table('orders')->where('date','<=',$time_comp)->where('delivery_status','pending');
                $pending_orders = $orders->get();
                $orders->update(['sla_breach'=>1,'delivery_status'=>'cancelled']);
                foreach($pending_orders as $key=>$order)
                {
                    $charge =0;
                    if($sla_charge_type == 'per') {
                        $charge = ($order->grand_total*$sla_charge)/100;
                    }
                    else $charge = $sla_charge;
                    DB::table('order_details')->where('order_id',$order->id)->update(array('delivery_status' => 'cancelled')); //where('delivery_status', 'pending')->

                    $test =  SlaBreachOrder::updateOrInsert(['order_id'=>$order->id], // creating a new rable was not needed 
                        ['order_id'=>$order->id,                           //as we coould have one more column in order table only
                    'sla_amount'=>$charge,
                    "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                    "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
                    ]);
                    //NotificationUtility::sendNotification($order,'cancelled'); //TODO: can we enable this

                }
            }
        })->everyMinute()->timezone('Asia/Kolkata')
        ->between('6:00', '23:59'); // we need to run it 24 hours a day
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