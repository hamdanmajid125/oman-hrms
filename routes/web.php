    <?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    PermissionsController,
    RolesController,
    AttendanceController
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

    Route::resource('permissions', PermissionsController::class);
    Route::post('get-permission', [PermissionsController::class, 'getPermissions'])->name('permission.get');

    Route::resource('roles', RolesController::class);
    Route::post('get-roles', [RolesController::class, 'getRoles'])->name('role.get');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'attendance','as'=>'attendance.'], function (){
    Route::get('/{id}',[AttendanceController::class,'index'])->name('index');
    Route::post('/timein', [AttendanceController::class, 'timeIn'])->name('timeIn');
    Route::post('/timeout/{id}', [AttendanceController::class, 'timeOut'])->name('timeOut');
});


require __DIR__.'/auth.php';
