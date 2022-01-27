<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\SignupRequest;
use App\Notifications\AnonymousNotifiable;
use App\Notifications\Auth\ResetPassword;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;
use Session;
use Auth;

class AuthController extends BaseController
{
    public function login(): View
    {
        return view('app.login');
    }

    /**
     * Authorize user on the site.
     *
     * @param AuthRequest $request Credentials
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function authorize(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => ['required', 'min:3'],
                'password' => ['required', 'max:100', 'min:8'],
            ]);
        } catch (\Throwable $exception) {
            return view('app.login', ['authFailed' => true]);
        }

        $fieldType = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (Auth::attempt([$fieldType => $credentials['username'], 'password' => $credentials['password']], true)) {
            return redirect('/app/dashboard');
        }

        return view('app.login', ['authFailed' => true]);
    }

    public function signupForm(): View
    {
        return view('app.signup');
    }

    public function signup(SignupRequest $request)
    {
        $validated = $request->validate($request->rules());

        return view('app.signup', ['formData' => $validated, 'formSubmitted' => true]);
    }

    public function resetPwdForm(): View
    {
        return view('app.reset_pwd', [
            'displayEmail' => '',
            'success' => false,
            'hasEmail' => true,
        ]);
    }

    public function resetPwd(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::exists(User::class, 'email')],
        ]);

        $notifiable = new AnonymousNotifiable();
        $notifiable->route('mail', $validated['email']);
        $notifiable->notify(new ResetPassword(''));

        return view('app.reset_pwd', [
            'displayEmail' => $validated['email'] ?? '',
            'success' => (bool)$validated['email'],
            'hasEmail' => (bool)$validated['email'],
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('app.dashboard');
        }

        return redirect('/app/login');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/app/login');
    }
}
