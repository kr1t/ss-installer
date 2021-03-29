{{--@if(session('message'))--}}
{{--    ...--}}
{{--    {{ session('message') }}--}}
{{--@endif--}}

@if($message != null)
    {{ $message }}
@endif
