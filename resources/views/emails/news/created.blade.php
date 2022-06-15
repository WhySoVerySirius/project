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

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
