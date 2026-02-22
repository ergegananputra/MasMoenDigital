<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Honeypot check - if filled, it's likely a bot
        if (!empty($input['website'])) {
            abort(422, 'Registration failed.');
        }

        // reCAPTCHA verification
        if (config('services.recaptcha.secret_key')) {
            $recaptchaResponse = $input['g-recaptcha-response'] ?? '';
            
            if (empty($recaptchaResponse)) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => ['Please complete the reCAPTCHA verification.'],
                ]);
            }

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $recaptchaResponse,
                'remoteip' => request()->ip(),
            ]);

            if (!$response->json('success')) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.'],
                ]);
            }
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
