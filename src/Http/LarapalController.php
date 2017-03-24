
<?php
namespace vimuths123\larapal\Http;

use App\Http\Controllers\Controller;

class LarapalController extends Controller {
    public function viewPaypal() {
        return view('larapal::paypal');
    }
}
