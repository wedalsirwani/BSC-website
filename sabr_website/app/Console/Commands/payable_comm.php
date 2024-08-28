<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\payable_payment;
use CArbon\Carbon;

class payable_comm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active:payable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify payable payment';

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
        $payable_payments=payable_payment::where("payable_date","like" , Carbon::now("Asia/Riyadh")->format("d-m-Y"))->get();
        foreach($payable_payments as $pp){
            $pp->status="payable";
            $pp->save();
        }
    }
}
