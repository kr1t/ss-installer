<script>
    function showPoint() {

        if(document.getElementById("redeem-detail").style.display == "block"){
            document.getElementById("redeem-detail").style.display = "none";
            document.getElementById("point-detail").style.display = "block";
        }else{
            document.getElementById("redeem-detail").style.display = "block";
            document.getElementById("point-detail").style.display = "none";
        }

        window.scrollTo(0, 0);
    }


</script>
<script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
