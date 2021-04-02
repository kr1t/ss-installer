@extends('layouts.admin')

@section('title')
Export Installer Lists
@endsection
@section('content')
<div class="container-fluid">

        <div>
            <div class="card w-100">
                <div class="card-body">


                    <h1>Export รายชื่อช่างที่ลงทะเบียนเข้ามา </h1>

                    <p>เลือกวันที่ต้องการดูข้อมูล</p>

                    <input type="text" class="daterange form-control" name="daterange" placeholder="กรุณาเลือกวันที่">

                    <div class="form-group pt-2">
                        <input type="radio" class="radio" checked name="type" value="1"> ยังไม่ได้รับ notification
                        <input type="radio" class="radio" name="type" value="2"> รับ notification แล้ว
                        <input type="radio" class="radio" name="type" value="3"> ทั้งหมด
                    </div>


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

            let typeActive = $('.radio:checked').val()

            let url = '{{url('/installer/export')}}';
            let dateVal = $('.daterange').val()
            window.location.href = `${url}?dates=${dateVal}&type=${typeActive}`;
        })
    });
</script>
@endsection
