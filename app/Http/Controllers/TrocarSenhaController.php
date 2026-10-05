<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TrocarSenhaController extends Controller
{
    use PasswordValidationRules;

    // Tela de troca obrigatória da senha padrão
    public function show(Request $request)
    {
        if (!$request->user()->trocar_senha) {
            return redirect()->route('dashboard');
        }

        return view('auth.trocar-senha');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'password' => array_merge($this->passwordRules(), [
                function ($attribute, $value, $fail) use ($user) {
                    if ($user->senhaEhCpf($value)) {
                        $fail('A nova senha não pode ser o seu CPF.');
                    }
                },
            ]),
        ], [
            'password.required' => 'Informe a nova senha.',
            'password.confirmed' => 'A confirmação não confere com a nova senha.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ]);

        $user->forceFill([
            'password' => Hash::make($request->input('password')),
            'trocar_senha' => false,
        ])->save();

        return redirect()->route('dashboard')->with('msg', 'Senha alterada com sucesso!');
    }
}
