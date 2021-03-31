@extends('layouts.admin')

@section('title')
    Import รายชื่อระดับ gold
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                @if(session()->has('success'))

                    @if(count(session()->get('success')))
                        <div class="alert alert-success mt-2">
                            Import สำเร็จ

                            <ul>
                                @foreach(session()->get('success') as $msg)
                                    <li>{{ $msg['engineer_code'] }}</li>
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
                                    <li>{{ $msg['engineer_code'] }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                @endif

                <div class="card">
                    <div class="card-header">Import </div>
                    <div class="card-body">
                        <form action="{{ route('importGold') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control">
                            <br>
                            <button class="btn btn-primary">Import User List</button>
                        </form>

                        @if(count($permissions))

                            <form action="{{ url('/admin/permission/gold-import') }}" method="POST">
                                @csrf

                                <input type="hidden" name="permissions" value="{{ json_encode($permissions) }}">

                                <table class="table mt-3 table-strip table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Engineer Code</th>
                                        {{--                                    <th>Push</th>--}}


                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission['engineer_code'] }}</td>

                                            {{--                                    <td><input type="checkbox" name="import[{{ $point }}]" id="" checked></td>--}}

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
