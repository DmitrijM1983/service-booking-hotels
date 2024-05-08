<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function register(): View
    {
        return view('auth.register');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function registration(Request $request): RedirectResponse
    {
        $userData = $request->validate([
            'full_name' => 'required|min:3|max:20',
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        User::addUser($userData);
        $link = 'http//:service-booking-hotels/login';
        mail($request->get('email'), 'Подтверждение электронной почты',
            'Для продолжения перейдите по ссылке ' . $link);

        return Redirect::route('verify.email', ['email'=>$request->get('email')]);
    }

    /**
     * @param string $email
     * @return View
     */
    public function verifyEmail(string $email): View
    {
        return view('auth.verify-email', ['email' => $email]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function verification(Request $request): RedirectResponse
    {
        $link = 'http//:service-booking-hotels/login';
        mail($request->get('email'), 'Подтверждение электронной почты',
            'Для продолжения перейдите по ссылке ' . $link);

        return Redirect::route('verify.email', ['email'=>$request->get('email')]);
    }

    /**
     * @return View
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function signIn(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * @return View
     */
    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function resetPassword(Request $request): Response
    {
        $email = $request->get('email');
        $user = User::getUserByEmail($email);
        $link = 'http://service-booking-hotels/set-new-password';
        if ($user) {
            mail($email, 'Сброс пароля', 'Для изманения пароля перейдите по ссылке ' . $link .
            ' Если вы не меняли пароль, проигнорируйте данное сообщение');
        }

        return response('Ссылка для изменения пароля отправлена на ваш email');
    }

    /**
     * @return View
     */
    public function setNewPassword(): View
    {
        return view('auth.reset-password');
    }

    /**
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function updatePassword(Request $request): View|RedirectResponse
    {
        $password = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed'
        ]);

        $user = User::getUserByEmail($request->get('email'));

        if($user) {
            User::setPassword($password['password'], $request->get('email'));

            return Redirect::route('sign_in');
        }
        return view('auth.reset-password', ['error' => 'User not exist']);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
