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

Route::post('/update-amount/{applicationNumber}', 'App\Http\Controllers\PageController@updateAmount');

Route::post('/approve-application/{applicationNumber}', 'App\Http\Controllers\PageController@approveApplication');

Route::post('/reject-application/{applicationNumber}', 'App\Http\Controllers\PageController@rejectApplication');

Route::post('/loan-balance/{loan_id}', 'App\Http\Controllers\PageController@loanBalances');

Route::post('/loan-repayment/{loan_id}', 'App\Http\Controllers\PageController@loanrepayments');

Route::delete('/delete-application/{applicationNumber}', 'App\Http\Controllers\PageController@loanDelete');

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

Route::get('/users', [MemberController::class, 'list']); // Corrected semicolon

Route::post('/import_user', [MemberController::class, 'import_user'])->name('import_user');
Route::get('/export_user', [MemberController::class, 'export_user'])->name('export_user');
Route::get('/export_user_pdf', [MemberController::class, 'export_user_pdf'])->name('export_user_pdf');

Route::get('/table_members', function () {
    $users = Member::all();
    return view('exports.users', ['users' => $users]); // Corrected variable name
})->name('memberroute');


Route::get('/deposits', [DepositController::class, 'list']); // Corrected semicolon

Route::post('/import_deposit', [DepositController::class, 'import_deposit'])->name('import_deposit');
Route::get('/export_deposit', [DepositController::class, 'export_deposit'])->name('export_deposit');
Route::get('/export_deposit_pdf', [DepositController::class, 'export_deposit_pdf'])->name('export_deposit_pdf');

Route::get('/table_deposits', function () {
    $deposits = Deposit::all();
    return view('exports.deposits', ['deposits' => $deposits]); // Corrected variable name
})->name('depositroute');


Route::get('/LoanRequests', [LoanRequestController::class, 'list']); // Corrected semicolon

Route::post('/import_LoanRequest', [LoanRequestController::class, 'import_LoanRequest'])->name('import_LoanRequest');
Route::get('/export_LoanRequest', [LoanRequestController::class, 'export_LoanRequest'])->name('export_LoanRequest');
Route::get('/export_LoanRequest_pdf', [LoanRequestController::class, 'export_LoanRequest_pdf'])->name('export_LoanRequest_pdf');


Route::get('/request_loans', function () {
    $LoanRequests = RequestLoan::all();
    return view('exports.LoanRequests', ['LoanRequests' => $LoanRequests]); // Corrected variable name
})->name('loanroute');
// My route
//Route::get('/loanroute', [LoanRequestController::class, 'index'])->name('loanroute');
Route::get('/Loans', [LoansController::class, 'list']); 

Route::post('/import_Loan', [LoansController::class, 'import_Loan'])->name('import_Loan');
Route::get('/export_Loan', [LoansController::class, 'export_Loan'])->name('export_Loan');
Route::get('/export_Loans_pdf', [LoansController::class, 'export_Loans_pdf'])->name('export_Loans_pdf');

Route::get('/loans', function () {
    $Loans = Loans::all();
    return view('exports.Loans', ['Loans' => $Loans]);
})->name('Loansroute');