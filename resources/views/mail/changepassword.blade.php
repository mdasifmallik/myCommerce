@component('mail::message')
# Password Changed

@component('mail::panel')
Your password has been changed!
@endcomponent

@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent

@component('mail::button', ['url' => $u_name, 'color' => 'success'])
Test Button
@endcomponent

Thanks, {{$u_name}}<br>
{{ config('app.name') }}
@endcomponent