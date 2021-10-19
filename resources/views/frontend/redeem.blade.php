@extends('frontend.layouts.app')
@section('content')
    <div class="samsung-form-redeem">
        <div class="container  ">
            @include('frontend.include.engineer-info')
            <div id="redeem-detail" class="container">
                <h2>ของรางวัล</h2>
                <div class="row">
                    @forelse($redeemItems as $redeemItem)
                        <div class="col-6 item">
                            <div class="img">
                                <img src="{{ $redeemItem->image }}" alt="{{ $redeemItem->name }}">
                            </div>
                            <div class="text">
                                <h3>{{ $redeemItem->name }}</h3>
                                <p>มูลค่า {{ $redeemItem->value }} บาท</p>
                                <span>{{ $redeemItem->redeem_point }} <small>คะแนน</small> </span>
                                <button
                                    class="btn button-ss "
                                    @if($engineer->total < $redeemItem->redeem_point) disabled @endif
                                    onclick="{{$engineer->total >= $redeemItem->redeem_point ? 'window.location=\''.route("create.redeem", [$engineer, $redeemItem, $redeemItem->name]).'?line_uid='.$line_uid.'\'' : 'popup()'}}"
                                    type="button"
                                >
                                    <span>{{$engineer->total >= $redeemItem->redeem_point ? 'แลกของรางวัล' : 'คะแนนไม่พอ'}}</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="text">
                                <p>No redeem item(s).</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            @include('frontend.include.history')

        </div>
        <div class="hover_bkgr_fricc" id="pp">
            <span class="helper"></span>
            <div class="wrapper">
                <p>คะแนนของคุณไม่เพียงพอ</p>
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
            document.getElementById("pp").style.display = "none";
        }
    </script>
@endsection
