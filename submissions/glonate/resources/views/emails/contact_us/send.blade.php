@component('mail::message')

A contact query has been placed by {{$name}}

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
