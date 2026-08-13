<x-mail::message>
# Bedankt voor je bericht, {{ $submission->first_name }}!

We hebben je bericht in goede orde ontvangen en reageren binnen één werkdag.

<x-mail::panel>
@if ($submission->subject)
**Onderwerp:** {{ $submission->subject }}<br>
@endif
**Bericht:**<br>
{{ $submission->message }}
</x-mail::panel>

@if ($submission->store)
Je vraag is gericht aan onze winkel in **{{ $submission->store->name }}**.
@if ($submission->store->phone)
Liever meteen bellen? Dat kan naar <a href="tel:{{ $submission->store->phone }}">{{ $submission->store->phone }}</a>.
@endif

<x-mail::button :url="route('store.show', $submission->store->slug)">
Bekijk de winkel
</x-mail::button>
@else
<x-mail::button :url="route('home')">
Naar Nice2Have
</x-mail::button>
@endif

Tot snel,<br>
Team Nice2Have
</x-mail::message>
