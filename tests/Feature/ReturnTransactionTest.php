<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Book;
use App\Models\BookTransaction;
use Carbon\Carbon;

class ReturnTransactionTest extends TestCase
{
  use RefreshDatabase;

  protected function makeUser(string $role = 'user'): User
  {
    return User::factory()->create([
      'firstName' => 'Test',
      'lastName' => ucfirst($role),
      'role' => $role,
    ]);
  }

  protected function makeBorrowedTransaction(User $user, int $daysOverdue = 0): BookTransaction
  {
    $book = Book::create([
      'title' => 'Sample Book',
      'author' => 'Sample Author',
      'description' => 'Desc',
      'publisher' => 'Pub',
      'year' => 2024,
      'isbn' => 'ISBN123',
      'copies' => 5,
      'category' => 'General',
    ]);

    $dueDate = Carbon::now()->subDays($daysOverdue)->startOfDay();
    $borrowedAt = (clone $dueDate)->subDays(3);

    return BookTransaction::create([
      'user_id' => $user->id,
      'book_id' => $book->id,
      'borrowed_at' => $borrowedAt,
      'due_date' => $dueDate,
      'status' => 'borrowed',
    ]);
  }

  public function test_user_can_request_return_and_fee_freezes()
  {
    $user = $this->makeUser('user');
    $tx = $this->makeBorrowedTransaction($user, 2); // 2 days overdue

    $this->actingAs($user)
      ->post(route('transactions.return.request', ['id' => $tx->id]))
      ->assertStatus(200)
      ->assertJsonFragment([
        'fee' => 100, // 2 * 50
        'days_overdue' => 2,
      ]);

    $tx->refresh();
    $this->assertEquals('return_pending', $tx->status);
    $this->assertEquals(2, $tx->days_overdue);
    $this->assertEquals(100, $tx->fee);
  }

  public function test_admin_approves_return_fee_does_not_escalate()
  {
    $user = $this->makeUser('user');
    $admin = $this->makeUser('admin');
    $tx = $this->makeBorrowedTransaction($user, 2);

    // User requests return (fee frozen at 100)
    $this->actingAs($user)->post(route('transactions.return.request', ['id' => $tx->id]))->assertStatus(200);
    $tx->refresh();
    $this->assertEquals(100, $tx->fee);

    // Artificially push due date further back to simulate more potential overdue days (should NOT increase)
    $tx->due_date = Carbon::now()->subDays(5)->toDateString();
    $tx->save();

    $this->actingAs($admin)
      ->post('/admin/transactions/' . $tx->id . '/approve-return')
      ->assertStatus(200)
      ->assertJsonFragment(['message' => 'Return approved']);

    $tx->refresh();
    $this->assertEquals(100, $tx->fee, 'Fee should remain frozen');
    $this->assertEquals('overdue', $tx->status);
  }

  public function test_admin_marks_return_damaged_damage_fee_added_to_frozen_overdue()
  {
    $user = $this->makeUser('user');
    $admin = $this->makeUser('admin');
    $tx = $this->makeBorrowedTransaction($user, 2);

    $this->actingAs($user)->post(route('transactions.return.request', ['id' => $tx->id]))->assertStatus(200);
    $tx->refresh();
    $this->assertEquals(100, $tx->fee);

    $payload = [
      'reason' => 'Cover torn',
      'damage_fee' => 50,
    ];

    $this->actingAs($admin)
      ->post('/admin/transactions/' . $tx->id . '/reject-return', $payload)
      ->assertStatus(200)
      ->assertJsonFragment(['message' => 'Return rejected - damage fee applied']);

    $tx->refresh();
    $this->assertEquals('damaged', $tx->status);
    $this->assertEquals(150, $tx->fee, 'Damage fee should be added to frozen overdue fee');
  }
}
