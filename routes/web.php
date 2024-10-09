    <?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    PermissionsController,
    RolesController,
    AttendanceController,
    ShiftController,
    DepartmentController,
    HolidayController,
    LeaveTypeController,
    LeaveController,
    TeamController,
    TaxController,
    DiscrepancyController,
    JobController,
    PayrollController
};


// use App\Models\Department;
// Route::get('create-dept', function(){
//     Department::create([
//         'name' => 'Production',
//         'desc' => 'test'
//     ]);
// });


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Auth::user()->assignRole('admin');
    return view('welcome');
});

Route::get('/dashboard', function () {
    $attendance = App\Models\Attendance::where('user_id', auth()->id())->first();
    return view('dashboard', compact('attendance'));
    })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);

    Route::post('/save-employee', [UserController::class, 'saveEmployeeForm'])->name('user.save.form');
    Route::post('/user-delete-repeater', [UserController::class, 'deleteRepeater'])->name('user.delete.repeater');

    Route::resource('permissions', PermissionsController::class);
    Route::post('get-permission', [PermissionsController::class, 'getPermissions'])->name('permission.get');

    Route::resource('roles', RolesController::class);
    Route::post('get-roles', [RolesController::class, 'getRoles'])->name('role.get');

    Route::resource('shifts', ShiftController::class);
    Route::post('get-shifts', [ShiftController::class, 'getShifts'])->name('shift.get');

    Route::resource('departments', DepartmentController::class);
    Route::post('get-departments', [DepartmentController::class, 'getDepartments'])->name('department.get');

    Route::resource('holidays', HolidayController::class);
    Route::post('get-holidays', [HolidayController::class, 'getHolidays'])->name('holiday.get');

    Route::resource('leavetypes', LeaveTypeController::class);
    Route::post('get-leavetypes', [LeaveTypeController::class, 'getLeaveTypes'])->name('leavetype.get');

    Route::resource('teams', TeamController::class);
    Route::post('get-teams', [TeamController::class, 'getTeams'])->name('teams.get');

    Route::resource('taxes', TaxController::class);
    Route::post('get-taxes', [TaxController::class, 'getTaxes'])->name('taxes.get');

    Route::resource('jobs', JobController::class);
    Route::post('get-jobs', [JobController::class, 'getJobs'])->name('jobs.get');

    Route::get('payrolls',[PayrollController::class,'payroll'])->name('payroll');

    Route::resource('jobs', JobController::class);
    Route::post('get-jobs', [JobController::class, 'getJobs'])->name('jobs.get');

});

Route::group(['middleware' => ['auth'], 'prefix' => 'leaves','as'=>'leaves.'], function (){
    Route::get('all-leaves',[LeaveController::class,'allLeaves'])->name('allLeaves');
    Route::post('approveLeave', [LeaveController::class, 'approve'])->name('approveLeave');
    Route::post('rejectLeave', [LeaveController::class, 'reject'])->name('rejectLeave');
    Route::get('/',[LeaveController::class,'leave'])->name('leave');
    Route::get('leave-request',[LeaveController::class,'leaveRequest'])->name('leaveRequest');
    Route::post('apply-leave',[LeaveController::class,'appliedLeave'])->name('appliedLeave');
    Route::post('requestLeaveajax', [LeaveController::class, 'leaverequestajax'])->name('requestLeaveajax');

});

Route::group(['middleware' => ['auth'], 'prefix' => 'attendance','as'=>'attendance.'], function (){
    Route::get('/user/{id}/{month?}/{year?}',[AttendanceController::class,'attendance'])->name('userAttendance');
    Route::post('/timein', [AttendanceController::class, 'timeIn'])->name('timeIn');
    Route::post('/timeout/{id}', [AttendanceController::class, 'timeOut'])->name('timeOut');
    Route::get('/usercsv/{id}/{month}/{year}', [AttendanceController::class, 'attendanceCSV'])->name('attendanceCSV');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'discrepancy', 'as' => 'discrepancy.'], function(){
    Route::get('/', [DiscrepancyController::class, 'index'])->name('allDiscrepancy');
    Route::post('/add-discrepancy', [DiscrepancyController::class, 'store'])->name('addDiscrepancy');
    Route::post('approve-discrepancy', [DiscrepancyController::class, 'approveDiscrepancy'])->name('approveDiscrepancy');
    Route::post('reject-discrepancy', [DiscrepancyController::class, 'rejectDiscrepancy'])->name('rejectDiscrepancy');
});


require __DIR__.'/auth.php';