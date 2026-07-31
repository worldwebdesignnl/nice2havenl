<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MakeAdminUser extends Command
{
    protected $signature = 'app:make-admin-user';

    protected $description = 'Create a new admin user for the Filament panel';

    public function handle(): int
    {
        $name = $this->ask('Naam');

        $email = $this->ask('E-mailadres');

        $validator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email', 'unique:users,email']],
            [
                'email.required' => 'Vul een e-mailadres in.',
                'email.email' => 'Dit is geen geldig e-mailadres.',
                'email.unique' => 'Er bestaat al een gebruiker met dit e-mailadres.',
            ],
        );

        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'));

            return self::FAILURE;
        }

        $password = $this->secret('Wachtwoord (minimaal 8 tekens, niet zichtbaar tijdens typen)');
        $passwordConfirm = $this->secret('Herhaal wachtwoord');

        if ($password !== $passwordConfirm) {
            $this->error('De wachtwoorden komen niet overeen.');

            return self::FAILURE;
        }

        if (strlen($password) < 8) {
            $this->error('Het wachtwoord moet minimaal 8 tekens lang zijn.');

            return self::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("Admin-gebruiker '{$user->name}' ({$user->email}) is aangemaakt.");

        return self::SUCCESS;
    }
}
