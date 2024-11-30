@component('mail::message')

Hi {{$name}},

We've received your message and let us thanks to you for contacting with us. Please find your information you have send.

##Name

{{$name}}

##Subject

{{$subject}}

## Message

{{$message}}

##Check Mark

@if(!empty($project_owner)) {{$project_owner}}, @endif @if(!empty($project_backer)) {{$project_backer}}, @endif @if(!empty($other)) {{$other}}, @endif


Thanks,<br>
{{ get_option('site_name') }}
@endcomponent
