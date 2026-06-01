<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-wrap">
        <div class="login-left"></div>
        <div class="login-main">
            <p class="login-eyebrow">Bienvenue</p>
            <h1 class="login-title">S'inscrire<span>.</span></h1>
            <div class="divider"></div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <x-input-label for="name" :value="__('Nom')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Prénom Nom" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="field mt-4">
                    <x-input-label for="phone" :value="__('Téléphone')" />
                    <x-text-input id="phone" type="text" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="01 02 03 04 05" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="field mt-4">
                    <x-input-label for="family_code" :value="__('Code famille (optionnel)')" />
                    <x-text-input id="family_code" type="text" name="family_code" :value="old('family_code')" autocomplete="off" placeholder="Laissez vide pour créer une nouvelle famille" />
                    <x-input-error :messages="$errors->get('family_code')" class="mt-2" />
                </div>

                <div class="field mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="field mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="login-actions mt-6">
                    <a class="forgot" href="{{ route('login') }}">
                        {{ __('Déjà inscrit ?') }}
                    </a>
                    <x-primary-button>{{ __('S\'inscrire') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
