<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Citizens
        User::updateOrCreate(
            ['email' => 'juan.citizen@example.com'],
            [
                'name' => 'Juan Dela Cruz',
                'password' => 'juanmangjuanpass123!',
                'role' => 'citizen',
            ]
        );

        User::updateOrCreate(
            ['email' => 'maria.citizen@example.com'],
            [
                'name' => 'Maria Santos',
                'password' => 'mariagokongweipass123!',
                'role' => 'citizen',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pedro.citizen@example.com'],
            [
                'name' => 'Pedro Reyes',
                'password' => 'pedropendukopass123!',
                'role' => 'citizen',
            ]
        );

        // Personnel
        User::updateOrCreate(
            ['email' => 'ana.personnel@example.com'],
            [
                'name' => 'Ana Garcia',
                'password' => 'anabatumbakalpass123!',
                'role' => 'personnel',
            ]
        );

        User::updateOrCreate(
            ['email' => 'carlo.personnel@example.com'],
            [
                'name' => 'Carlo Mendoza',
                'password' => 'carlombaipass123!',
                'role' => 'personnel',
            ]
        );

        User::updateOrCreate(
            ['email' => 'rosa.personnel@example.com'],
            [
                'name' => 'Rosa Bautista',
                'password' => 'rosabatodelapass123!',
                'role' => 'personnel',
            ]
        );
    }
}
