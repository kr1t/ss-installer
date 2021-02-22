@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-8">
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

                        <table class="table mt-3 table-strip">
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

                        <div class="mt-2 text-right">

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
