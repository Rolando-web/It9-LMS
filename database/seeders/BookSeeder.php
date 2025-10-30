<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $books = [
      [
        'title' => 'One Piece',
        'author' => 'Eiichiro Oda',
        'category' => 'Fiction',
        'isbn' => '111-111-111',
        'publish_date' => Carbon::create(1997, 7, 22)->toDateString(),
        'copies' => 5,
        'image' => 'image/onepiece.jpg',
      ],
      [
        'title' => 'Solo Leveling',
        'author' => 'Chugong',
        'category' => 'Fiction',
        'isbn' => '222-222-222',
        'publish_date' => Carbon::create(2016, 7, 1)->toDateString(),
        'copies' => 4,
        'image' => 'image/solo.jpg',
      ],
      [
        'title' => 'Steel Ball Run',
        'author' => 'Hirohiko Araki',
        'category' => 'Fiction',
        'isbn' => '333-333-333',
        'publish_date' => Carbon::create(2004, 4, 3)->toDateString(),
        'copies' => 3,
        'image' => 'image/stell.jpg',
      ],
      [
        'title' => 'Demon Slayer',
        'author' => 'Koyoharu Gotouge',
        'category' => 'Arts',
        'isbn' => '444-444-444',
        'publish_date' => Carbon::create(2016, 2, 15)->toDateString(),
        'copies' => 6,
        'image' => 'image/Demons.jpg',
      ],
      [
        'title' => 'Kaiju No. 8',
        'author' => 'Naoya Matsumoto',
        'category' => 'Fiction',
        'isbn' => '555-555-555',
        'publish_date' => Carbon::create(2020, 4, 3)->toDateString(),
        'copies' => 2,
        'image' => 'image/kaiju.jpg',
      ],
      [
        'title' => 'Dr. Stone',
        'author' => 'Riichiro Inagaki',
        'category' => 'Science',
        'isbn' => '666-666-666',
        'publish_date' => Carbon::create(2017, 3, 1)->toDateString(),
        'copies' => 4,
        'image' => 'image/dr.jpg',
      ],
      [
        'title' => 'One Piece',
        'author' => 'Eiichiro Oda',
        'category' => 'History',
        'isbn' => '777-777-777',
        'publish_date' => Carbon::create(1999, 9, 21)->toDateString(),
        'copies' => 7,
        'image' => 'image/onepiece.jpg',
      ],
      [
        'title' => 'Attack on Titan',
        'author' => 'Hajime Isayama',
        'category' => 'Biology',
        'isbn' => '888-888-888',
        'publish_date' => Carbon::create(2009, 9, 9)->toDateString(),
        'copies' => 5,
        'image' => 'image/aot.png',
      ],
    ];

    // Attach books to an existing user if available (avoids FK errors)
    $user = User::first();
    $userId = $user ? $user->id : null;

    foreach ($books as $b) {
      Book::updateOrCreate(
        ['isbn' => $b['isbn']],
        $b + ['user_id' => $userId]
      );
    }
  }
}
