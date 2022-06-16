@component('mail::message')
Mails created today

@foreach($data as $news)
    News id: {{$news['id']}}
    @if($news['description'])
    Description: {{$news['description']}}
    @endif
    Creation time: {{$news['created_at']}}
    @component('mail::button', ['url' => 'http://localhost/news/' . $news['uuid']])
        Show it
    @endcomponent
@endforeach


Thanks,<br>
{{ config('app.name') }}
@endcomponent
