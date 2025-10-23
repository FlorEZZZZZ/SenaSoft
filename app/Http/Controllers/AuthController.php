<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('flights.search')->with('success', '¡Bienvenido!');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        \Log::info('=== INICIANDO PROCESO DE REGISTRO ===');
        \Log::info('Datos recibidos del formulario:', $request->all());

        try {
            \Log::info('Validando datos...');
            
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'phone' => 'nullable|string',
                'password' => 'required|min:8|confirmed'
            ]);

            \Log::info('✅ Datos validados correctamente:', $validated);

            \Log::info('Creando usuario en la base de datos...');
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password'])
            ]);

            \Log::info('✅ Usuario creado exitosamente. ID: ' . $user->id);
            \Log::info('Usuario creado:', $user->toArray());

            \Log::info('Iniciando sesión del usuario...');
            Auth::login($user);
            \Log::info('✅ Sesión iniciada correctamente');

            \Log::info('=== REGISTRO COMPLETADO EXITOSAMENTE ===');
            return redirect()->route('flights.search')->with('success', '¡Cuenta creada exitosamente!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ ERROR de validación:', $e->errors());
            \Log::error('Datos que fallaron:', $request->all());
            throw $e;

        } catch (\Exception $e) {
            \Log::error('❌ ERROR en registro: ' . $e->getMessage());
            \Log::error('Archivo: ' . $e->getFile());
            \Log::error('Línea: ' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Error al crear la cuenta: ' . $e->getMessage())
                         ->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}