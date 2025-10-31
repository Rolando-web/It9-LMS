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
    // Use idempotent updateOrCreate so rerunning the seeder doesn't cause duplicate key errors
    $super = User::updateOrCreate(
      ['email' => 'rolandoluayon4@gmail.com'],
      [
        'firstName' => 'Rolando',
        'lastName' => 'Luayon',
        'contact' => '09123456789',
        'password' => Hash::make('Luayon123'),
        'role' => 'super_admin',
      ]
    );

    $admin = User::updateOrCreate(
      ['email' => 'tluayon7@gmail.com'],
      [
        'firstName' => 'Tiffany',
        'lastName' => 'Ocon',
        'contact' => '09234567890',
        'password' => Hash::make('Luayon123'),
        'role' => 'admin',
      ]
    );

    $user = User::updateOrCreate(
      ['email' => 'user@gmail.com'],
      [
        'firstName' => 'Test',
        'lastName' => 'User',
        'contact' => '09345678901',
        'password' => Hash::make('Luayon123'),
        'role' => 'user',
      ]
    );

    // Informational output
    echo "Users seeded successfully.\n";
    echo "Super Admin: rolandoluayon4@gmail.com / Luayon123\n";
    echo "Admin: tluayon7@gmail.com / Luayon123\n";
    echo "User: user@gmail.com / Luayon123\n";
  }
}
