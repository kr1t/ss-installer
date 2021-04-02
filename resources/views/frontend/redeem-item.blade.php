@extends('frontend.layouts.app')
@section('content')
    <div class="samsung-form-redeem">
        <div class="container  ">
            @include('frontend.include.engineer-info')
            <div id="redeem-detail" class="container detail-a">
                <h2 class="">แลกของรางวัล</h2>
                <h1>{{ $item->name }} <br> ({{ $item->redeem_point }} คะแนน)</h1>
                <div class="ssw">
                    <div class="imgs">
                        <img src="../{{ $item->image }}" alt="{{ $item->name }}">
                    </div>
                </div>
                <form class="form-horizontal" id="redeem-form" method="post" action="{{ route('store.redeem') }}">
                    @csrf
                    <input type="text" name="line_uid" value="{{ $line_uid }}" hidden>
                    <input type="number" value="{{ $engineer->id }}" name="engineer_id" hidden>
                    <input type="number" value="{{ $item->id }}" name="redeem_item_id" hidden>
                    <input type="number" value="{{ $item->redeem_point*(-1) }}" name="point" hidden>
                    <div class="form-content">
                        <h4 class="heading">ชื่อ</h4>
                        <div class="form-group">
                            <div class="col-12">
                                <input
                                    class="form-control"
                                    id="InputName"
                                    placeholder="กรอกชื่อ-นามสกุลของคุณ"
                                    type="text"
                                    name="name"
                                    value="{{old('name', $engineer->first_name_th.' '.$engineer->last_name_th)}}"
                                />
                            </div>
                        </div>
                        <h4 class="heading">ที่อยู่</h4>
                        <div class="form-group">
                            <div class="col-12">
                                <input
                                    class="form-control"
                                    id="InputName2"
                                    placeholder="กรอกที่อยู่ของคุณ"
                                    type="text"
                                    name="address"
                                    value="{{old('address', ($engineer->lastest_redeem_address))}}"
                                />
                            </div>
                        </div>
                        <h4 class="heading">เบอร์โทรศัพท์</h4>
                        <div class="form-group">
                            <div class="row">

                                <div class="col-12">
                                    <input
                                        class="form-control"
                                        id="Inputphone"
                                        placeholder="กรอกเบอร์โทรศัพท์ของคุณ"
                                        type="text"
                                        name="tel"
                                        value="{{old('tel', ($engineer->tel))}}"
                                        pattern="{0-9}[10]"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="clearfix mt-40">
                            <button class="btn btn-default" onclick="popup()" type="button">
                                ยืนยันการแลก
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @include('frontend.include.history')

        </div>
        <div class="hover_bkgr_fricc" id="pp">
            <span class="helper"></span>
            <div class="wrapper">
                <p>แลกของรางวัลสำเร็จ!</p>
                <div class="popupCloseButton" id="closebutt" onclick="closebutt()" >
                    ตกลง
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-js')
    <script>
        function popup(){
            document.getElementById("pp").style.display = "block";
            console.log('sss');
        }

        function closebutt(){
            document.getElementById("redeem-form").submit();
            document.getElementById("pp").style.display = "none";
        }
    </script>
@endsection
