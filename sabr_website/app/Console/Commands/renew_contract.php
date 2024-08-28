<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\contract;
use Carbon\Carbon;

class renew_contract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'renew contract atomaticlly when End of contract comes';

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
        $contracts = contract::where("end_date" , Carbon::now("Asia/Riyadh")->format("d-m-Y"))
            ->where("active","1")->get();
        foreach ($contracts as $contract) {
            $contract->active = 0;
            $contract->save();
            $new_con = new contract();
            $new_con->apartment_id=$contract->apartment_id;
            $new_con->renter_id=$contract->renter_id;
            $new_con->start_date=Carbon::parse($contract->end_date)->addDays(1)->format("d-m-Y");

            $uri = "http://api.aladhan.com/v1/hToG/$new_con->start_date?date=$new_con->start_date&adjustment=0";
            // $uri = "http://api.aladhan.com/v1/gToH?date=$new_con->start_date&adjustment=0";
            $response = \Httpful\Request::get($uri)->send();
            $hijri_date=$response->body->data->hijri->date;
            $new_con->hijri_start_date=$hijri_date;
            $hijri_end_date;
            if($contract->rent_unit=="سنة"){
                $hijri_end_date=Carbon::parse($hijri_date)->addYears($contract->rent_duration)->format("d-m-Y");
            }
            if($contract->rent_unit=="شهر"){
                $hijri_end_date=Carbon::parse($hijri_date)->addMonths($contract->rent_duration)->format("d-m-Y");
            }
            $new_con->hijri_end_date=$hijri_end_date;
            $uri = "http://api.aladhan.com/v1/hToG/$new_con->hijri_end_date?date=$new_con->hijri_end_date&adjustment=0";
            // $uri = "http://api.aladhan.com/v1/hToG?date=$new_con->hijri_end_date&adjustment=0";
            $response = \Httpful\Request::get($uri)->send();
            $new_con->end_date=$response->body->data->gregorian->date;
            $new_con->rent_duration=$contract->rent_duration;
            $new_con->rent_unit=$contract->rent_unit;
            $new_con->rent_amount=$contract->rent_amount;
            $new_con->pay_repeat=$contract->pay_repeat;
            $new_con->active=1;
            $new_con->user_id = $contract->user_id;
            $new_con->save();
            $new_con->add_payable_payments();
        }
    }
}
