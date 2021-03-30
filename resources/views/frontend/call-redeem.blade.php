<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชมรมช่างแอร์ซัมซุง</title>
</head>

<body>

</body>

</html>
@php
$config['redeem']= url('/redeem');
$config['checkRedeemStatus']= url('/redeem/check');

@endphp

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
<script src="https://unpkg.com/jquery-easy-loading@2.0.0-rc.2/dist/jquery.loading.min.js"></script>
<script>
    let lConfig = @json($config);

    function liffInit(liffId) {
        $('body').loading();

        liff.init({
            liffId
        })
            .then(() => {
                if (liff.isLoggedIn()) {
                    liff
                        .getProfile()
                        .then(profile => {

                            if (!liff.isInClient()) {
                                window.location.href = "https://line.me/R/ti/p/@samsungacinstaller"
                            }

                            window.location.href = `${lConfig['redeem']}?line_uid=${profile.userId}`

                        })
                        .catch(err => console.error(err));
                } else {
                    liff.login();
                }
            })
            .catch(err => {
                console.log(err.code, err.message);
            });
    }


    function checkRegister(uid) {
        var settings = {
            "url": lConfig['checkRedeemStatus'] + `?line_uid=${uid}`,

            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json",
            },
        };

        $.ajax(settings).done(function (response) {

            if (!response.registered) {
                window.location.href = 'https://liff.line.me/1655673420-lYR3d0Bj'
            }
            if (!response.hasId) {
                alert('ขออภัยคุณยังไม่สามารถใช้งานระบบนี้ได้')
                liff.closeWindow()
            }


        });
    }


    liffInit('1655673420-45oGwWDX')

</script>
