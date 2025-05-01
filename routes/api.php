use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\TransaksiPenjualanDetail;

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

// Check if a product has sales transactions
Route::get('/check-sales-transactions/{barangId}', function ($barangId) {
    $hasTransactions = TransaksiPenjualanDetail::where('barang_id', $barangId)->exists();
    return response()->json([
        'has_transactions' => $hasTransactions
    ]);
}); 