<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-wrap">
        <div class="login-left"></div>
        <div class="login-main">
            <p class="login-eyebrow">Bienvenue</p>
            <h1 class="login-title">Se connecter<span>.</span></h1>
            <div class="divider"></div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <x-input-label for="phone" :value="__('Téléphone')" />
                    <x-text-input id="phone" type="text" name="phone"
                                  :value="old('phone')" required autofocus autocomplete="tel"
                                  placeholder="01 02 03 04 05" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="field mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" type="password" name="password"
                                  required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="remember-row mt-4">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">{{ __('Se souvenir de moi') }}</label>
                </div>

                <div class="login-actions mt-6">
                    @if (Route::has('password.request'))
                        <a class="forgot" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                        <a class="register" href="{{ route('register') }}">
                            {{ __('Créer un compte') }}
                        </a>
                    @endif
                    <x-primary-button>{{ __('Se connecter') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
