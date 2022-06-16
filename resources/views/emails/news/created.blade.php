@component('mail::message')
<h2>
    New entry created:
</h2>
<h3>
    Title : {{$data['title']}}
</h3>
<p>
    Creation time : {{$data['created_at']}}
</p>
<p>
    Description : {{$data['description']}}
</p>

@component('mail::button', ['url' => 'http://localhost/news/' . $data['uuid']])
View entry
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
