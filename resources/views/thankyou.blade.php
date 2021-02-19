<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no , user-scalable=no" />
    <link rel="stylesheet/less" type="text/css" href="{{ asset('assets/css/web.less') }}" />
    <script type="text/javascript" src="{{ asset('assets/css/less-1.7.0.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <title>ชมรมช่างแอร์ซัมซุง</title>


</head>

<body>

    <div class="samsung-form">
        <div class="container  success">
            <img src="{{ asset('assets/images/check.png') }}" alt="">
            <br>
            <h1>
                ขอบพระคุณที่ร่วมสมัครเป็นส่วนหนึ่งของครอบครัวชมรมช่างแอร์ซัมซุง

            </h1>
            <p class="text-center">
                ทางเราจะส่งข้อมูลให้อีกครั้งผ่านทาง <br> Line : ชมรมช่างแอร์ซัมซุง <br>รอติดตามอัพเดตและสิทธิพิเศษดีๆ
                ได้เลย
            </p>
            <div class="w-100 mt-50">
                <button class="btn btn-light w-100 closeBtn">ปิด</button>
            </div>
        </div>
    </div>
    <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>


        function liffInit(liffId) {
            liff.init({
                liffId
            })
                .then(() => {
                    if (liff.isLoggedIn()) {
                        console.log('user is login')
                    } else {
                        liff.login();
                    }
                })
                .catch(err => {
                    console.log(err.code, err.message);
                });
        }


        $(document).ready(function () {
            liffInit('1655673420-8nAvmbGO')

            $('.closeBtn').click(function () {
                liff.closeWindow()
            })

        })
    </script>
</body>

</html>
