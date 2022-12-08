<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Validation;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function index()
    {
        return view('Auth/login');
    }
    /**
     * Redirecciona al usuario a la página de Facebook para autenticarse
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    /**
     * Obtiene la información de Facebook
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderFacebookCallback()
    {
        try {
            $auth_user = Socialite::driver('facebook')->user(); // Fetch authenticated user
            //dd($auth_user);

            $facebookId = User::where('facebook_id', $user->id)->first();
            if ($facebookId) {
                Auth::login($facebookId);
                return redirect('/candidato');
            } else {
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => $user->password,
                ]);
                Auth::login($createUser);
                return redirect('/candidato');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
