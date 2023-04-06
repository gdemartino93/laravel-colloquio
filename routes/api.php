<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("users", function(Request $request) {
	$search = $request->get("query");
	$searchWords = preg_split('/\s+/', $search);

	return User::where(function ($q) use ($searchWords) {
		foreach ($searchWords as $word) {
			$q->where(function ($q) use ($word) {
				$q->where('name', 'like', '%' . $word . '%');
			});
		}
	})
		->orWhere('city', 'like', '%' . $search . '%')
		->orWhere('email', 'like', '%' . $search . '%')
		// la ricerca nei tag non funziona come dovrebbe
		// ora seleziona solo i tag che contengono tutte le parole della ricerca al loro interno
		// ma io voglio trovare gli utenti che hanno ciascuno dei tag che cerco
		// prova a digitare "sint vero": non comparirà nessuno ora, anche se esistono utenti
		// con entrambi i tag
		->orWhereHas('tags', function ($q) use ($searchWords) {
			$q->where(function ($q) use ($searchWords) {
				foreach ($searchWords as $word) {
					$q->orWhere('name', 'like', '%' . $word . '%');
				}
			});
		}, '>=', count($searchWords))
		->with("tags")
		->paginate(20);
})->name('api.users');
