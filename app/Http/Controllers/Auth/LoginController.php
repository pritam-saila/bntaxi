<?php

namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
  
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  
    use AuthenticatesUsers;
  
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {   
        $input = $request->all();
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
        if ($input['type'] == 1) {
            if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'],'type' => 1))){
                    return redirect()->route('admin.home');
            }else{
                return redirect()->back()
                    ->with('error','Email-Address And Password Are Wrong.');
            }
        } else if ($input['type'] == 2) {
            if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'],'type' => 2))){
                $driver = auth()->user();

                if ((int) $driver->status === 1) {
                    return redirect()->route('manager.home');
                }

                // Registered but not yet activated: allowed in, but only to their documents.
                if ($driver->isPendingDriverApplicant()) {
                    return redirect()->route('driver.docs.index');
                }

                // Deactivated / declined / legacy inactive drivers stay locked out, with the
                // same generic message as a wrong password.
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return redirect()->back()
                ->with('error','Email-Address And Password Are Wrong.');
        } else if ($input['type'] == 0) {
            if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'],'type' => 0))){
                return redirect()->route('home');
            }else{
                return redirect()->back()
                    ->with('error','Email-Address And Password Are Wrong.');
            }
        } else {
            return redirect('/user-login')->with('error','Email-Address And Password Are Wrong.');
        }
        
          
    }
}