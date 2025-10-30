<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
<<<<<<< HEAD
    // Create or update Super Admin Account
    User::updateOrCreate(
      ['email' => 'Rolandoluayon@gmail.com'],
      [
        'firstName' => 'Rolando',
        'lastName' => 'Luayon',
        'contact' => '09123456789',
        'password' => Hash::make('Luayon123'),
        'role' => 'super_admin',
      ]
    );

    // Create or update Admin Account
    User::updateOrCreate(
      ['email' => 'Tiffany@gmail.com'],
      [
        'firstName' => 'Tiffany',
        'lastName' => 'Ocon',
        'contact' => '09234567890',
        'password' => Hash::make('Luayon123'),
        'role' => 'admin',
      ]
    );

    // Create or update Regular User Account
    User::updateOrCreate(
      ['email' => 'user@gmail.com'],
      [
        'firstName' => 'test',
        'lastName' => 'user',
        'contact' => '09345678901',
        'password' => Hash::make('Luayon123'),
        'role' => 'user',
      ]
    );

    echo "User Seeded";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Super Admin:\n";
    echo "  Email: superadmin@gmail.com\n";
    echo "  Password: superadmin123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Admin:\n";
    echo "  Email: admin@gmail.com\n";
    echo "  Password: admin123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "User:\n";
    echo "  Email: user@gmail.com\n";
    echo "  Password: user123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
=======
    // Super_Admin
    User::create([
      'firstName' => 'Rolando',
      'lastName' => 'Luayon',
      'email' => 'Rolandoluayon@library.com',
      'contact' => '09123456789',
      'password' => Hash::make('Luayon123'),
      'role' => 'super_admin',
    ]);

    // Admin
    User::create([
      'firstName' => 'Tiffany',
      'lastName' => 'Ocon',
      'email' => 'Tiffany@library.com',
      'contact' => '09234567890',
      'password' => Hash::make('Luayon123'),
      'role' => 'admin',
    ]);

    // User
    User::create([
      'firstName' => 'test',
      'lastName' => 'user',
      'email' => 'user@library.com',
      'contact' => '09345678901',
      'password' => Hash::make('Luayon123'),
      'role' => 'user',
    ]);

    echo "Users seeded successfully Added Boss!\n";
    echo "━\n";
    echo "Super Admin:\n";
    echo "  Email: Rolandoluayon@library.com\n";
    echo "  Password: Luayon123\n";
    echo "━\n";
    echo "Admin:\n";
    echo "  Email: admin@library.com\n";
    echo "  Password: Luayon123\n";
    echo "━\n";
    echo "User:\n";
    echo "  Email: user@library.com\n";
    echo "  Password: Luayon123\n";
    echo "━\n";
>>>>>>> 5914c00c664c18bf9f07a7a2fa030cf11853badd
  }
}
