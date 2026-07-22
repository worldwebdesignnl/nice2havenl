<x-mail::message>
# Nieuw bericht via het contactformulier

**Naam:** {{ $submission->first_name }}
@if ($submission->phone)
**Telefoon:** {{ $submission->phone }}
@endif
@if ($submission->subject)
**Onderwerp:** {{ $submission->subject }}
@endif
@if ($submission->store)
**Winkel:** {{ $submission->store->name }}
@endif

**Bericht:**

{{ $submission->message }}
</x-mail::message>
