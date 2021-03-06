@extends('layouts.admin')

@section('title')
    Export Redeem List
@endsection
@section('content')
    <div class="container-fluid">

        <div>
            <div class="card w-100">
                <div class="card-body">
                    <p>เลือกวันที่ต้องการดูข้อมูล</p>

                    <input type="text" class="daterange form-control" name="daterange" placeholder="กรุณาเลือกวันที่">
                    <div class=" mt-3">
                        <button class="btn btn-primary download-export">Download</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        $(function () {
            $('.daterange').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });

            $('.download-export').click(function (e) {
                e.preventDefault();

                let url = '{{url('/redeem/export')}}';
                let dateVal = $('.daterange').val();

                window.location.href = `${url}?dates=${dateVal}`;
            })
        });
    </script>
@endsection
