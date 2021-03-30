<div class="redeem-head">

    <div class="name item">
        <P>{{ $engineer->first_name_th.' '.$engineer->last_name_th }}</P>
    </div>
    <div class="head-point item text-right">
        <span><strong>แต้มสะสม</strong></span>
    </div>
    <div class="mail item">
        <span>{{ $engineer->email }}</span>
    </div>
    <div class="point item text-right">
        <span>{{ $engineer->total }} <small>คะแนน</small> </span>
    </div>
    <div class="id item" >
        <p>{{ $engineer->installer_id }}</p>
    </div>
    <div class="tag item text-right">
        <div onclick="showPoint()">
            <span>ประวัติคะแนน</span>
        </div>
    </div>

</div>
