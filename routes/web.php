<?php

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
Route::get('/', 'LoginController@index');
Route::get('/cache',function()
{
  $exitCode = Artisan::call('cache:clear');	
  $exitCode = Artisan::call('view:clear');
  echo "clear";
});
Route::resource('login','LoginController');

Route::get('sync', function(){
	$miaki_revenue = \App\Content::groupBy('time')
					->get(['time', \DB::raw('sum(miaki_revenue) AS date_rev')])
					->pluck('date_rev', 'time')
					->toArray();
	// dd($miaki_revenue);
	foreach( $miaki_revenue AS $date => $revenue ) {
	    $achieved = \App\Achieved::where('category_id', '=', 1)
	                ->where('date', '=', $date)
	                ->first();
	    if( !$achieved ) {
	        $achieved = new \App\Achieved();
	    }
	    $achieved->category_id = 1;
	    $achieved->date = $date;
	    $achieved->achieved = $revenue;
	    $achieved->save();
	}
});

Route::group(['middleware' => 'CheckLogout'], function()
      {
		Route::resource('user','UserController');
		Route::resource('member','MemberCreateController');
		Route::resource('password','PasswordController');

		// Route::get('/', 'HomeController@index');


		Route::resource('report', 'ReportController');
		Route::resource('shortcode', 'ShortcodeController');
		Route::resource('excelreport', 'ExcelExportController');
		Route::resource('home','HomeController');

		Route::get('homePage','HomeController2@index');

		Route::get('bdapps','BdappsRevenueController@index');
		Route::get('bdapps_batch','BdappsRevenueController@bdapps_batch_upload');
		Route::post('bdapps_batch_submit','BdappsRevenueController@bdapps_batch_submit');
		Route::post('bdapps_data_submit','BdappsRevenueController@bdapps_data_submit');

		Route::get('churn','Intake_churn_controller@index');
		Route::get('bdapps_ussd_hit','Bdapps_hit_count_controller@index');

		Route::get('miaki_revenue','Miaki_apps_revenue_controller@index');
		Route::get('upload_apps_revenue','Miaki_apps_revenue_controller@upload_revenue');
		Route::post('save_apps_revenue','Miaki_apps_revenue_controller@save_revenue');
		Route::post('save_target_revenue','Miaki_apps_revenue_controller@save_target_revenue');
		Route::get('all_target_revenue','Miaki_apps_revenue_controller@all_target_revenue');
		Route::get('detail_miaki_revenue','Miaki_apps_revenue_controller@detail_miaki_revenue');
		Route::get('financial_review','Miaki_apps_revenue_controller@financial_review');


		Route::get('test', function () {
		    return view('test');
		});

   });