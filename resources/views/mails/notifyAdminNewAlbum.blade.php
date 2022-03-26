@component('mail::message')
    Hello {{$admin->name}}
# New Album {{$album->album_name}} created!

Visit

@component('mail::button', ['url' => route('albums.show', $album->id)])
    {{$album->album_name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
