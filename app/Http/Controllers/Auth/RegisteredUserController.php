<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'family_code' => ['nullable', 'string', 'max:20'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        // Get or create family
        $family = $this->getOrCreateFamily($user, $request->family_code);

        $user->family_id = $family->id;
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Get existing family by code or create a new one.
     */
    private function getOrCreateFamily(User $user, ?string $familyCode): Family
    {
        if (empty($familyCode)) {
            // Create a new family with a generated code
            return Family::create([
                'name' => $user->name.'\'s Family',
                'unique_code' => $this->generateFamilyCode(),
            ]);
        }

        // Check if family exists
        $family = Family::where('code', $familyCode)->first();

        if (! $family) {
            throw ValidationException::withMessages([
                'family_code' => 'Ce code famille n\'existe pas.',
            ]);
        }

        return $family;
    }

    /**
     * Generate a unique family code.
     */
    private function generateFamilyCode(): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        do {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (Family::where('unique_code', $code)->exists());

        return $code;
    }
}
