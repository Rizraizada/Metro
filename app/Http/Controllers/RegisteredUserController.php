<?php

// app/Http/Controllers/RegisteredUserController.php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisteredUserController extends Controller
{
    use PasswordValidationRules;

    protected $createNewUser;

    public function __construct(CreatesNewUsers $createNewUser)
    {
        $this->createNewUser = $createNewUser;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ]);

        $user = $this->createNewUser->create($request->all());

        // You can customize the response or redirect here
        return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
    }
}
