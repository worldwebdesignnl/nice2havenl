<?php

use App\Mail\ContactFormSubmitted;
use App\Models\ContactSubmission;
use App\Models\Store;
use Illuminate\Support\Facades\Mail;

test('the contact page loads', function () {
    $response = $this->get('/contact');

    $response->assertStatus(200);
});

test('the contact form requires the privacy checkbox to be accepted', function () {
    $response = $this->post('/contact', [
        'first_name' => 'Test Klant',
        'message' => 'Hallo, ik heb een vraag.',
    ]);

    $response->assertSessionHasErrors('privacy_accepted');
    expect(ContactSubmission::count())->toBe(0);
});

test('a valid contact form submission is stored and emailed', function () {
    Mail::fake();

    $store = Store::factory()->create(['email' => 'winkel@nice-2-have.nl']);

    $response = $this->post('/contact', [
        'first_name' => 'Test Klant',
        'phone' => '0612345678',
        'store_id' => $store->id,
        'subject' => 'Vraag over openingstijden',
        'message' => 'Hallo, ik heb een vraag.',
        'privacy_accepted' => '1',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status');

    expect(ContactSubmission::count())->toBe(1);

    $submission = ContactSubmission::first();
    expect($submission->store_id)->toBe($store->id);

    Mail::assertQueued(ContactFormSubmitted::class, fn ($mail) => $mail->submission->is($submission));
});
