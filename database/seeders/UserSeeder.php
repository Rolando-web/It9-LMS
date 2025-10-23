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
    // Create Super Admin Account
    User::create([
      'firstName' => 'Rolando',
      'lastName' => 'Luayon',
      'email' => 'Rolandoluayon@library.com',
      'contact' => '09123456789',
      'password' => Hash::make('Luayon123'),
      'role' => 'super_admin',
    ]);

    // Create Admin Account
    User::create([
      'firstName' => 'Tiffany',
      'lastName' => 'Ocon',
      'email' => 'Tiffany@library.com',
      'contact' => '09234567890',
      'password' => Hash::make('Luayon123'),
      'role' => 'admin',
    ]);

    // Create Regular User Account
    User::create([
      'firstName' => 'test',
      'lastName' => 'user',
      'email' => 'user@library.com',
      'contact' => '09345678901',
      'password' => Hash::make('Luayon123'),
      'role' => 'user',
    ]);

    echo "✅ Users seeded successfully!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Super Admin:\n";
    echo "  Email: superadmin@library.com\n";
    echo "  Password: superadmin123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Admin:\n";
    echo "  Email: admin@library.com\n";
    echo "  Password: admin123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "User:\n";
    echo "  Email: user@library.com\n";
    echo "  Password: user123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
  }
}
