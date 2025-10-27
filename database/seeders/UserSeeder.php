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
  }
}
