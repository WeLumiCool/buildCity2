@component('mail::message')
    #Активация

    Ваш стол {{ $details['desk'] }} был активирован!


    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
