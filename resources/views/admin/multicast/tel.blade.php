@extends('layouts.admin')

@section('title')
Multicast By Tel No.
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- @include('admin.sidebar') -->

        <div>

            @if(session()->has('success'))

            @if(count(session()->get('success')))
            <div class="alert alert-success mt-2">
                Import สำเร็จทำการ Push Message สำเร็จ

                <ul>
                    @foreach(session()->get('success') as $msg)
                    <li>{{ $msg['first_name_th'] }} {{ $msg['last_name_th'] }} ({{ $msg['installer_id'] }}) | email: {{
                        $msg['email'] }} phone: {{
                        $msg['tel'] }}</li>
                    @endforeach
                </ul>

            </div>
            @endif
            @endif

            @if(session()->has('fail'))
            @if(count(session()->get('fail')))

            <div class="alert alert-danger mt-2">
                ทำการ Push Message รายการดังกล่าวไม่สำเร็จ

                <ul>
                    @foreach(session()->get('fail') as $msg)
                    <li>{{ $msg['first_name_th'] }} {{ $msg['last_name_th'] }} ({{ $msg['installer_id'] }}) | email: {{
                        $msg['email'] }} phone: {{
                        $msg['tel'] }}</li>
                    @endforeach
                </ul>

            </div>
            @endif
            @endif

            dqwpiwqd0
        </div>


    </div>
</div>
@endsection
