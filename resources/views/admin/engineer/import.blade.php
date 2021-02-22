@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">

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
                <div class="card-header">Import </div>
                <div class="card-body">

                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-success">Import User Data</button>
                    </form>


                    @if(count($engineers))

                    <form action="{{ url('/admin/installer/import') }}" method="POST">
                        @csrf

                        <input type="hidden" name="engineers" value="{{ json_encode($engineers) }}">

                        <table class="table mt-3 table-strip table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>Email</th>
                                    <th>เบอร์โทร</th>
                                    <th class="bg-success text-white">หมายเลขช่าง</th>
                                    <th class="bg-success text-white">คะแนน</th>
                                    <th>จำนวน notification ที่เคยยิง</th>
                                    <th>Push</th>


                                </tr>
                            </thead>
                            <tbody>

                                @foreach($engineers as $engineer)
                                <tr>
                                    <td scope="row">{{ $engineer->id }}</td>
                                    <td>{{ $engineer->first_name_th }}</td>
                                    <td>{{ $engineer->last_name_th }}</td>
                                    <td>{{ $engineer->email }}</td>
                                    <td>{{ $engineer->tel }}</td>
                                    <td class="bg-success text-white">{{ $engineer->import['installer_id'] }}</td>
                                    <td class="bg-success text-white">{{ $engineer->import['point'] }}</td>
                                    <td>{{ $engineer->notification_count }}</td>

                                    <td><input type="checkbox" name="import[{{ $engineer->id }}]" id="" checked></td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <div class="mt-2 text-center">

                            <hr>
                            <button class="btn btn-primary ">Push</button>
                            <button class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>


    </div>
</div>
@endsection
