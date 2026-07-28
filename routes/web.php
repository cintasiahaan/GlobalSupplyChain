<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\Country;
use App\Models\Weather;
use App\Models\RiskAssessment;
use App\Models\Watchlist;
use App\Models\News;
use App\Models\Port;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\RiskAssessmentController;
use App\Http\Controllers\CurrencyImpactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\CountryComparisonController;
use App\Http\Controllers\Admin\UserLogController;
use App\Http\Controllers\Admin\ArticleManagementController;



/*
|--------------------------------------------------------------------------
| DEBUG
|--------------------------------------------------------------------------
*/
Route::get('/env-dump', function () {
    return response()->json([
        'server' => $_SERVER,
        'env' => $_ENV,
    ]);
});


/*
|--------------------------------------------------------------------------
| PUBLIC / GLOBAL DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [DashboardController::class, 'index']
)
->middleware('auth')
->name('dashboard');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// LOGIN

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)
->middleware('guest')
->name('login');


Route::post(
    '/login',
    [AuthController::class, 'login']
)
->middleware('guest')
->name('login.process');


// REGISTER

Route::get(
    '/register',
    [AuthController::class, 'showRegister']
)
->middleware('guest')
->name('register');


Route::post(
    '/register',
    [AuthController::class, 'register']
)
->middleware('guest')
->name('register.process');


// LOGOUT

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)
->middleware('auth')
->name('logout');


/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get(
    '/user/dashboard',
    function () {

        return view(
            'user.dashboard'
        );

    }
)
->middleware([
    'auth',
    'role:user',
])
->name('user.dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/dashboard',
    function () {

        return view(
            'admin.dashboard'
        );

    }
)
->middleware([
    'auth',
    'role:admin',
])
->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| COUNTRY MONITORING
|--------------------------------------------------------------------------
| Admin dan User dapat mengakses.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // COUNTRY INDEX (search, filter region/risk, pagination)

    Route::get(
        '/countries',
        [CountryController::class, 'index']
    )
    ->name('countries.index');


    // COUNTRY DETAIL

    Route::get(
        '/countries/{country}',
        [CountryController::class, 'show']
    )
    ->name('countries.show');


    // COUNTRY COMPARISON ENGINE (Feature #8 in Spec)

    Route::get(
        '/compare',
        [CountryComparisonController::class, 'index']
    )
    ->name('countries.compare');

});



/*
|--------------------------------------------------------------------------
| WEATHER MONITORING
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/weather',
        [WeatherController::class, 'index']
    )
    ->name('weather.index');


    Route::get(
        '/weather/{country}',
        [WeatherController::class, 'show']
    )
    ->name('weather.show');

});


/*
|--------------------------------------------------------------------------
| CURRENCY IMPACT
|--------------------------------------------------------------------------
| Admin dan User dapat mengakses.
|
| PENTING:
| Route ini hanya didefinisikan SATU KALI.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/currency-impact',
        [CurrencyImpactController::class, 'index']
    )
    ->name('currency-impact.index');


    Route::get(
        '/currency-impact/{country}',
        [CurrencyImpactController::class, 'show']
    )
    ->name('currency-impact.show');

});


/*
|--------------------------------------------------------------------------
| ADMIN - RISK ASSESSMENT MANAGEMENT
|--------------------------------------------------------------------------
| KHUSUS ADMIN.
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin',
])
->prefix('admin')
->name('admin.')
->group(function () {

    // RISK ASSESSMENT INDEX

    Route::get(
        '/risk-assessments',
        [
            RiskAssessmentController::class,
            'index'
        ]
    )
    ->name('risk-assessments.index');


    // CREATE

    Route::get(
        '/risk-assessments/create/{country}',
        [
            RiskAssessmentController::class,
            'create'
        ]
    )
    ->name('risk-assessments.create');


    // STORE

    Route::post(
        '/risk-assessments/store/{country}',
        [
            RiskAssessmentController::class,
            'store'
        ]
    )
    ->name('risk-assessments.store');


    // EDIT

    Route::get(
        '/risk-assessments/{riskAssessment}/edit',
        [
            RiskAssessmentController::class,
            'edit'
        ]
    )
    ->name('risk-assessments.edit');


    // UPDATE

    Route::put(
        '/risk-assessments/{riskAssessment}',
        [
            RiskAssessmentController::class,
            'update'
        ]
    )
    ->name('risk-assessments.update');


    // DELETE

    Route::delete(
        '/risk-assessments/{riskAssessment}',
        [
            RiskAssessmentController::class,
            'destroy'
        ]
    )
    ->name('risk-assessments.destroy');


    // SETTINGS

    Route::get(
        '/settings',
        function () {

            return view('settings.index');

        }
    )
    ->name('settings.index');


    // USER LOGIN ACTIVITY LOGS (Feature requested by user)

    Route::get(
        '/user-logs',
        [UserLogController::class, 'index']
    )
    ->name('user-logs.index');


    // ARTICLES ANALYSIS MANAGEMENT (Feature #10 in Spec)

    Route::get('/articles', [ArticleManagementController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleManagementController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleManagementController::class, 'store'])->name('articles.store');
    Route::delete('/articles/{article}', [ArticleManagementController::class, 'destroy'])->name('articles.destroy');

});



/*
|--------------------------------------------------------------------------
| NEWS INTELLIGENCE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/news-intelligence',
        function () {

            $news = News::latest(
                'published_at'
            )
            ->get();

            return view(
                'news.index',
                compact('news')
            );

        }
    )
    ->name('news.index');

});


/*
|--------------------------------------------------------------------------
| PORT MONITORING
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/ports', [PortController::class, 'index'])->name('ports.index');
    Route::get('/port-monitoring', [PortController::class, 'index']);

});



/*
|--------------------------------------------------------------------------
| ANALYTICS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/analytics',
        function () {

            // Total Countries

            $totalCountries =
                Country::count();


            // Total Risk Assessments

            $totalRiskAssessments =
                RiskAssessment::count();


            // High Risk Countries

            $highRiskCountries =
                Country::where(
                    'risk_level',
                    'High'
                )
                ->count();


            // Medium Risk Countries

            $mediumRiskCountries =
                Country::where(
                    'risk_level',
                    'Medium'
                )
                ->count();


            // Low Risk Countries

            $lowRiskCountries =
                Country::where(
                    'risk_level',
                    'Low'
                )
                ->count();


            // High Risk Currency Impact

            $highCurrencyImpact =
                \App\Models\CurrencyImpact::where(
                    'risk_level',
                    'HIGH'
                )
                ->count();


            // Weather Monitoring

            $totalWeather =
                Weather::count();


            // News Intelligence

            $highImpactNews =
                News::where(
                    'impact_level',
                    'High'
                )
                ->count();


            // Port Monitoring

            $highRiskPorts =
                Port::where(
                    'risk_level',
                    'High'
                )
                ->count();


            // Port Delays

            $delayedPorts =
                Port::where(
                    'status',
                    'Delayed'
                )
                ->count();


            return view(
                'analytics.index',
                compact(
                    'totalCountries',
                    'totalRiskAssessments',
                    'highRiskCountries',
                    'mediumRiskCountries',
                    'lowRiskCountries',
                    'highCurrencyImpact',
                    'totalWeather',
                    'highImpactNews',
                    'highRiskPorts',
                    'delayedPorts'
                )
            );

        }
    )
    ->name('analytics.index');

});


/*
|--------------------------------------------------------------------------
| WATCHLIST
|--------------------------------------------------------------------------
| Admin dan User dapat menggunakan Watchlist.
| Setiap user hanya melihat Watchlist miliknya sendiri.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // WATCHLIST INDEX

    Route::get(
        '/watchlist',
        function () {

            $watchlists = Watchlist::with(
                'country'
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->get();

            return view(
                'watchlist.index',
                compact('watchlists')
            );

        }
    )
    ->name('watchlist.index');


    // ADD TO WATCHLIST

    Route::post(
        '/watchlist/{country}',
        function (
            Country $country
        ) {

            Watchlist::firstOrCreate([

                'user_id' =>
                    Auth::id(),

                'country_id' =>
                    $country->id,

            ]);


            return redirect()
                ->back()
                ->with(
                    'success',
                    $country->name .
                    ' berhasil ditambahkan ke Watchlist.'
                );

        }
    )
    ->name('watchlist.store');


    // REMOVE FROM WATCHLIST

    Route::delete(
        '/watchlist/{watchlist}',
        function (
            Watchlist $watchlist
        ) {

            if (
                $watchlist->user_id
                !== Auth::id()
            ) {

                abort(403);

            }


            $watchlist->delete();


            return redirect()
                ->route(
                    'watchlist.index'
                )
                ->with(
                    'success',
                    'Negara berhasil dihapus dari Watchlist.'
                );

        }
    )
    ->name('watchlist.destroy');

});