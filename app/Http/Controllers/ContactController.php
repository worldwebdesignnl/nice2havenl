<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactSubmission;
use App\Models\SchemaSetting;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact', [
            'stores' => Store::query()->with('openingHours')->where('is_active', true)->orderBy('sort_order')->get(),
            'organization' => SchemaSetting::get('organization', []),
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $submission = ContactSubmission::create([
            ...$request->safe()->only(['store_id', 'first_name', 'phone', 'subject', 'message']),
            'meta' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->headers->get('referer'),
            ],
        ]);

        $organization = SchemaSetting::get('organization', []);
        $recipient = $submission->store->email ?? $organization['email'] ?? config('mail.from.address');

        Mail::to($recipient)->send(new ContactFormSubmitted($submission));

        return back()->with('status', 'Bedankt voor je bericht! We nemen zo snel mogelijk contact met je op.');
    }
}
