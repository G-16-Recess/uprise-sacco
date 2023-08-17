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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

Route::post('/member', function () {
	DB::disableQueryLog();
	DB::connection()->unsetEventDispatcher();
    $csv = \League\Csv\Reader::createFromPath(request()->file('csv_file')->getRealPath());
    $csv->setHeaderoffset(0);

	$members = [];

    foreach ($csv as $record) {
		$members[] = [
			'member_number' => $record['member number'],
			'username' => $record['username'],
			'password' => $record['password'],
			'phone_number' => $record['phone number'],
			'account_balance' => floatval($record['account balance']),
			'loan_balance' =>floatval($record['loan balance']),
			'created_at' => now(),
			'updated_at' => now()
        ];
		
		if (count($members) >= 20 ) {
			\App\Models\Member::insert($members);
			$members = [];
		} else {
			\App\Models\Member::insert($members);
			$members =[];
		}
    }
	return redirect()->back()->with('success', 'All member records imported sucessfully');
});

Route::post('/deposit', function () {
	DB::disableQueryLog();
	DB::connection()->unsetEventDispatcher();
    $csv = \League\Csv\Reader::createFromPath(request()->file('csv_file')->getRealPath());
    $csv->setHeaderoffset(0);

	$deposits = [];

    foreach ($csv as $record) {
		$deposits[] = [
			'receipt_number' => $record['receipt number'],
			'amount' => floatval($record['amount']),
			'date' =>\Carbon\Carbon::parse($record['date']),
			'status'=>'pending',
			'member_number'=>$record['member number'],
			'created_at' => now(),
			'updated_at' => now()
        ];
		
		if (count($deposits) >= 20 ) {
			\App\Models\Deposit::insert($deposits);
			$deposits = [];
		} else {
			\App\Models\Deposit::insert($deposits);
			$deposits =[];
		}
    }
	return redirect()->back()->with('success', 'All deposit records imported sucessfully');
});

Route::post('/loan_repayment', function () {
	DB::disableQueryLog();
	DB::connection()->unsetEventDispatcher();
    $csv = \League\Csv\Reader::createFromPath(request()->file('csv_file')->getRealPath());
    $csv->setHeaderoffset(0);

	$repayments = [];

    foreach ($csv as $record) {
		$repayments[] = [
			'receipt_number' => $record['receipt number'],
			'amount' => floatval($record['amount']),
			'date' =>\Carbon\Carbon::parse($record['date']),
			'status'=>'pending',
			'member_number'=>$record['member number'],
			'created_at' => now(),
			'updated_at' => now()
        ];
		
		if (count($repayments) >= 20 ) {
			\App\Models\Loan_repayment::insert($repayments);
			$repayments = [];
		} else {
			\App\Models\Loan_repayment::insert($repayments);
			$repayments =[];
		}
    }
	return redirect()->back()->with('success', 'All loan repayment records imported sucessfully');
});
