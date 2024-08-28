<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    return redirect()->to('/');
});
Route::get('/reset_pwd','login_controller@show_reset_pwd')->name('reset');
Route::get('/reset/{email}/{confirmation_code}/{reset}','login_controller@show_set_pwd');
Route::post('/reset_pwd/{email}','login_controller@reset_pwd');
Route::get('/logout','login_controller@logout')->name('logout');
Route::get('/','home_controller@index');
Route::get('/register','registration_controller@create');
Route::post('/register','registration_controller@save');
Route::get('/login/{email}/{confirmation_code}','login_controller@show_set_pwd');
Route::get('/login','login_controller@show_login')->name('login');
Route::post('/login','login_controller@login');
Route::post('/set_pwd','login_controller@set_pwd');
Route::post('/email_exists/{email}','user_controller@email_exists');
Route::post('/mobile_exists/{mobile}','user_controller@mobile_exists');


Route::group(['middleware'=>'roles','roles'=>['admin']],function(){
    Route::post('/get_user_roles/{user_id}','user_controller@user_roles');
    Route::post('/set_user_roles/{user_id}/{role_id}/{enabled}','user_controller@set_role');
    Route::get('/roles','role_controller@show');
    Route::get('/users','user_controller@show_all');
    Route::get('/conf','user_controller@show_config');
    Route::post('/save_config','user_controller@save_config');
    Route::post("/emptying/{id}","apartment_controller@emptying");
});

Route::group(['middleware'=>'roles','roles'=>['admin','employee']],function(){
    Route::get('/new_users','user_controller@show_new');
    Route::post('/set_active/{user_id}/{enable}','user_controller@set_active');
    Route::get("/balance" , "transaction_controller@show_balnce");
    Route::post("/get_balance/{user}" , "transaction_controller@get_balance");
    //add building
    Route::get("/add_building","building_controller@show_add");
    Route::post("/add_building","building_controller@add");
    //add amount
    Route::get("/add_amount/contract/{id}", "transaction_controller@show_add_amount");
    Route::post("/add_amount", "transaction_controller@add_amount");
    //add apartment
    Route::get("/add_apartment","apartment_controller@show_add");
    Route::post("/add_apartment","apartment_controller@add");
    //RENTER PAGE ROUTE
    //add renter
    Route::get("/add_renter","renter_controller@show_add");
    Route::post("/add_renter","renter_controller@add");
    Route::post("/renterExists/{id_number}" , "renter_controller@renter_exists");
    //all renter
    Route::post("/all_renter", "renter_controller@all");
    //CONTRACT PAGE ROUTE
    //add contract
    Route::get("/contract/renter_id_number/{id}" , "contract_controller@show");
    Route::get("/contract/{renter_id}/{apartment_id}" , "contract_controller@show");
    Route::post("/get_avialable_apartments/{building_id}" , "contract_controller@get_avialable_apartments");
    Route::post("/add_contract" , "contract_controller@add");
    //pay contract
    Route::get("/pay-contract/{id}" , "contract_controller@show_pay");
    Route::post("/pay-contract/{id}" , "transaction_controller@add_transaction");
    //show contract
    Route::get("/contract" , "contract_controller@show_contracts");
    Route::get("/contract/{id}" , "contract_controller@show_contract");
    //update contract dates
    Route::post("/upd_contract_date", "contract_controller@upd_contract_date");
    //TRANSACTIONS PAGE
    //add transaction
    Route::get('/add_transaction','transaction_controller@show_add');
    Route::get('/add_transaction/contract/{id}','transaction_controller@show_add');
    Route::post('/add_transaction','transaction_controller@add_transaction');
    //change apartment_remnter
    Route::post("/change_apartment_renter/{contract_id}/{renter_id}", "contract_controller@change_apartment_renter");
    Route::post("/get_renter_apartments/{renter_id}" , "renter_controller@get_renter_apartments");
    //update Pay Repeat
    Route::post("/update_pay_repeat/{id}/{pay_repeat}", "contract_controller@upd_pay_rep");
    //route update building
    Route::post("/update_building/{id}" , "building_controller@update_building");
    //

    //route update apartment
    Route::post("/update_apartment/{id}" , "apartment_controller@update_apartment");
    //route for all renters
    Route::get("/renters", "renter_controller@show_all");
    //route for renter informations
    Route::get("/renter/{id}", "renter_controller@show_renter");

    Route::post("/del_file/{id}","apartment_controller@del_file");
    //route for update renter
    Route::post("/update_renter/{id}", "renter_controller@upd_renter");
    //search renter
    Route::post("/serach_renter", "renter_controller@search");

    Route::get("/add_offer","offer_controller@add");
    Route::post("/add_offer","offer_controller@add_offer");
});
//CONTRACT PAGE ROUTE
//add contract
Route::get("/contract/renter_id_number/{id}" , "contract_controller@show");
Route::get("/contract/{renter_id}/{apartment_id}" , "contract_controller@show");
Route::post("/get_avialable_apartments/{building_id}" , "contract_controller@get_avialable_apartments");
Route::post("/add_contract" , "contract_controller@add");
//pay contract
Route::get("/pay-contract/{id}" , "contract_controller@show_pay");
Route::post("/pay-contract/{id}" , "transaction_controller@add_transaction");
//show contract
Route::get("/contract" , "contract_controller@show_contracts");
Route::get("/contract/{id}" , "contract_controller@show_contract");
Route::get("/show_summary", "contract_controller@show_summary");
//route for summary-contract
Route::get("/summary/contract/{contract_id}", "contract_controller@show_summary_contract");
Route::get("/request/apartment/{id}","RequestController@show_request");
Route::post("/request/apartment/{id}","RequestController@save");
Route::post("/complate_request/{id}","RequestController@complate");
Route::get("/requests","RequestController@show_requests");

Route::get("/book_appointment/apartment/{id}","apartment_controller@show_book_appointment");
Route::post("/book_appointment/apartment/{id}","apartment_controller@book_appointment");
Route::get("/appointments","apartment_controller@show_appointments");

Route::get('/show_transactions/{id}','transaction_controller@show_transaction');
Route::get('/show_transactions','transaction_controller@show_transaction');
Route::post('/change_transaction','transaction_controller@change_transaction');
Route::post('/get_transactions','transaction_controller@get_transactions');
Route::post('/get_unapproved_transactions','transaction_controller@get_unapproved_transactions');

Route::post('/get_my_transactions','transaction_controller@get_my_transactions');
Route::get('/my_balance','transaction_controller@show_my_balance');
Route::post('/check_pwd','login_controller@check_pwd');
Route::post('/make_as_read/{id}','notification_controller@make_as_read');
Route::get('/user_conf','user_controller@show_user_conf');


Route::post("/search_apartments","apartment_controller@search");
//show building
// Route::get("/buildings" , "building_controller@show_buildings");
// Route::get("/building/{id}" , "building_controller@show_building");
Route::get("/buildings" , function(){
    $buildings=App\building::orderBy('name')->get();
    return view("buildings.show" , compact("buildings"));
});
Route::get("/building/{id}",function($id){
    $building=App\building::find($id);
    $distracts = DB::table("distracts")->get();
    return view("buildings.show_building" , compact("building","distracts"));
});

//show apartment
// Route::get("/apartments" , "apartment_controller@show_apartments");
Route::get("/apartments" , function(){
    $distracts = DB::table('distracts')->get();
    $availables = App\building::whereRaw("
        id in(select building_id from apartments where id not in ( select apartment_id from contracts where active is true ))")->get();
    return view("apartments.available", compact("availables","distracts"));
});
Route::get("/apartment/{id}" , "apartment_controller@show_apartment");
Route::get("/my_apartments","apartment_controller@my_apartments");
Route::get("/apartment/{id}",function($id){
    $apartment=App\apartment::find($id);
    $path = public_path("files\apartments\\".$apartment->id);
    $files =[];
    if(is_dir($path)){
        $files = File::allFiles($path);
    }
    $files = collect($files);
    $files = $files->map(function ($file){
        return $file = explode("public",$file)[1];
    });
    return view("apartments.show_apartment" , compact("apartment","files"));
});
//route for summary-renter
Route::get("/summary/renter/{renter_id}", "contract_controller@show_summary_renter");

//print transaction
Route::get('/print-transaction/{transaction_id}/{print}', 'transaction_controller@print_preview_transaction');
Route::get('/print-transaction/{transaction_id}', 'transaction_controller@print_transaction');
