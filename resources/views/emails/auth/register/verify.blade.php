@component('mail::message')

<h1>Email Confirmation</h1>

<p>Please refer to the following link:</p>


<a href='{{ route('verify', ['token' => $user->verify_token]) }}'> Verify Email </a>


<p>Thanks,</p><br>
<p> {{ config('app.name') }} </p>

@endcomponent

