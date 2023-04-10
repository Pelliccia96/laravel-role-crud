<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definisco i dati degli utenti
        $users = [
            [
                'name' => 'Supremo',
                'email' => 'supremo@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'super-admin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        ];

        // La password è criptata utilizzando la funzione Hash::make.

        // Ciclo sugli utenti e li inserisco nella tabella "users"
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
