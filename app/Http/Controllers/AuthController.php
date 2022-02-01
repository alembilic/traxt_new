<?php

namespace App\Http\Controllers;

use App\Core\EntityManagerFresher;
use App\Entities\User;
use App\Notifications\AnonymousNotifiable;
use App\Notifications\Auth\ResetPassword;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Session;
use Auth;

class AuthController extends BaseController
{
    use EntityManagerFresher;

    public function login(): View
    {
        return view('app.login');
    }

    /**
     * Authorize user on the site.
     *
     * @param Request $request Credentials
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

    /**
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     *
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function signup(Request $request)
    {
        $rules = [
            'username' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'company' => ['required', 'string'],
            'vat_number' => ['required', 'string'],
            'vat_valid' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'land' => ['required', 'string'],

            'terms' => ['required', 'boolean'],

            'email' => ['required', 'email'],
            'conf_email' => ['required', 'email'],
            'password' => ['required', 'max:100', 'min:8'],
            'conf_password' => ['required', 'max:100', 'min:8'],
            'plan' => ['string'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $user = new User($validator->validated());
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            Auth::attempt($request->only('username', 'password'), true);
            return redirect('/app/dashboard');
        }

        return view('app.signup', [
            'formData' => $request->all(),
            'formSubmitted' => true,
            'validationErrors' => $validator->errors() ? $validator->errors()->all() : [],
        ]);
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
