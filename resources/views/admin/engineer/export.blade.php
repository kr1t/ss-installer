@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Export Installer Lists</div>
                <div class="card-body">


                    <h1>Lorem</h1>

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates consequuntur, repudiandae
                        veniam dicta delectus voluptatem voluptatibus laborum vero illo error nihil molestiae ea,
                        architecto itaque illum! Ipsam pariatur minus blanditiis!</p>

                    <input type="text" class="daterange form-control" name="daterange" placeholder="กรุณาเลือกวันที่">

                    <div class="text-right mt-3">
                        <button class="btn btn-primary download-export">Download</button>

                    </div>

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

            let url = '{{url('/installer/export')}}';
            let dateVal = $('.daterange').val()
            window.location.href =   `${url}?dates=${dateVal}`;
    })
    });
</script>
@endsection
