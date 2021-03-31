@extends('layouts.admin')

@section('title')
    Export Result Exam
@endsection
@section('content')
    <div class="container-fluid">

        <div>
            <div class="card w-100">
                <div class="card-body">


                    <h1>Export คะแนนสอบ </h1>

                    <p>เลือกวันที่ต้องการดูข้อมูล</p>

                    <input type="text" class="daterange form-control" name="daterange" placeholder="กรุณาเลือกวันที่">

                    <p class="pt-4" id="level">เลือกระดับที่ต้องการดูข้อมูล</p>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input
                                class="form-check-input" type="radio"
                                id="silver"
                                value="silver"
                                name="level"
                                @if(old('level') == 'silver') checked @endif
                            >
                            Silver
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input
                                class="form-check-input" type="radio"
                                id="gold"
                                value="gold"
                                name="level"
                                @if(old('level') == 'gold') checked @endif
                            >
                            Gold
                        </label>
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

            $("input[name='level']").click(function () {
                $("#level").removeClass('text-danger');
            });

            $('.download-export').click(function (e) {
                e.preventDefault();

                let url = '{{url('/score/export')}}';
                let dateVal = $('.daterange').val();
                let level = $("input[name='level']:checked:enabled").val();

                if(level){
                    window.location.href = `${url}?dates=${dateVal}&level=${level}`;
                } else {
                    $("#level").addClass('text-danger');
                }
            })
        });
    </script>
@endsection
