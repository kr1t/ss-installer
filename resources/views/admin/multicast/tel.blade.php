@extends('layouts.admin')

@section('title')
Multicast By Tel No.
@endsection
@section('content')
<div class="container-fluid">
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

        <div class="card">
            <div class="card-header">
                ส่งข้อความให้ผู้ใช้ด้วยเบอร์โทร
            </div>
            <div class="card-body">
                <form action="{{ url('admin/installer/multicast/tel') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">เบอร์โทร ex. 0900000000,0911111111</label>
                        <input type="text" class="form-control" name="tels" placeholder="09xxxxxxxxx,08xxxxxxxx,......">
                    </div>
                    <div class="form-group">
                        <label for="">ข้อความ</label>
                        <textarea class="form-control" placeholder="Message ...." name="message" maxlength="4000"
                            style="height: 450px;"></textarea>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-primary ">Push</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection
