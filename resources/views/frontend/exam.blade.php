@extends('frontend.layouts.app')
@section('content')
    <div class="py-4 samsung-form-redeem">
        <div class="container">
            <div class="text-center pb-2">
                <h1>ข้อสอบเลื่อนระดับ</h1>
            </div>
            <div class="card samsung-form">
                <div class="card-body">
                    <form class="row" method="post" action="{{ route('store.answer') }}">
                        @csrf
                        <input type="text" name="engineer_id" value="{{ $engineer_id }}" hidden>
                        <input type="text" name="exam_type" value="{{ $type }}" hidden>
                        @foreach($exams as $key=>$exam)
                            <div class="control-group pt-3 pb-3">
                                <p id="title_{{$key+1}}" class="control-label @error('answer_'.($key+1)) text-danger @enderror">{{ ($key+1).'. '.$exam['title'] }}</p>
                                <div class="controls radio-group">
                                    <input type="text" name="answer_{{$key+1}}" hidden value="{{old('answer_'.($key+1))}}"
                                    >
                                    @foreach($exam['choices'] as $key2=>$choice)
                                        <label class="radio col-6 form-control mb-2">
                                            <input
                                                class="form-check-input" type="radio"
                                                id="{{$key+1}}_choice_{{$key2}}"
                                                value="{{$choice}}"
                                                name="{{$key}}_answer"
                                                @if(old('answer_'.($key+1)) == $choice) checked @endif
                                                onclick="setValue( '{{$key+1}}', '{{$key2}}' )"
                                            >
                                            {{ $choice }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <button id="submitButton" class="btn" type="submit">
                                ส่งคำตอบ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-js')
    <script>
        function setValue(key, key2) {
            var choice = key+'_choice_'+key2;
            var final_choice = 'answer_'+key;
            $(document).ready(function() {
                var answer = $("#"+choice).val();
                $("input[name=\'"+final_choice+"\']").val( answer );
                console.log( $("input[name=\'"+final_choice+"\']").val() );
                $("#title_"+key).removeClass('text-danger');
            });
        }
    </script>
@endsection
