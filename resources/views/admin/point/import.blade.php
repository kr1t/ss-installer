@extends('layouts.admin')

@section('title')
Import รายการคะแนน
@endsection
@section('content')
<div class="container-fluid">

    <div>
        @if(session()->has('success'))

        @if(count(session()->get('success')))
        <div class="alert alert-success mt-2">
            Import สำเร็จ

            <ul>
                @foreach(session()->get('success') as $msg)
                <li>{{ $msg['engineer_code'] }} ({{ $msg['point'] }} point) | {{
                    $msg['job_source_create'] }}</li>
                @endforeach
            </ul>

        </div>
        @endif
        @endif

        @if(session()->has('fail'))
        @if(count(session()->get('fail')))

        <div class="alert alert-danger mt-2">
            เพิ่มรายการดังกล่าวไม่สำเร็จ ไม่พบ Engineer Code

            <ul>
                @foreach(session()->get('fail') as $msg)
                <li>{{ $msg['engineer_code'] }} ({{ $msg['point'] }} point) | {{
                    $msg['job_source_create'] }}</li>
                @endforeach
            </ul>

        </div>
        @endif
        @endif

        <div class="card">
            <div class="card-header">Import </div>
            <div class="card-body">

                <h1 class="mb-4">Import รายการคะแนน </h1>
                <form action="{{ route('importPoint') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-primary">Import Point</button>
                </form>

                @if(count($points))

                <form action="{{ url('/admin/point/import') }}" method="POST">
                    @csrf

                    <input type="hidden" name="points" value="{{ json_encode($points) }}">

                    <table class="table mt-3 table-strip table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Engineer Code</th>
                                <th>Point</th>
                                <th>Job Source Create</th>
                                <th>Job Source Update</th>
                                {{-- <th>Push</th>--}}


                            </tr>
                        </thead>
                        <tbody>

                            @foreach($points as $key=>$point)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $point['engineer_code'] }}</td>
                                <td>{{ $point['point'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($point['job_source_create'])->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($point['job_source_update'])->format('d/m/Y') }}</td>

                                {{-- <td><input type="checkbox" name="import[{{ $point }}]" id="" checked></td>--}}

                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-2 text-center">

                        <hr>
                        <button class="btn btn-primary " type="submit">Push</button>
                        <a class="btn btn-secondary" href="{{ url('/admin/point/import') }}">Cancel</a>
                    </div>
                </form>
                @endif

            </div>
        </div>


        {{-- @if(session()->has('success'))--}}
        {{-- <div class="card my-4">--}}
            {{-- <div class="card-body">--}}
                {{-- <li></li>--}}
                {{-- </div>--}}
            {{-- </div>--}}
        {{-- @endif--}}

    </div>


</div>
@endsection
