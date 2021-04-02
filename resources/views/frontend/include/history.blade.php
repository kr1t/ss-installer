<div id="point-detail" class="">
    <div class="container">
        <h2>ประวัติคะแนน</h2>
    </div>
    <div class="wraperp">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th scope="col">วันที่</th>
                    <th scope="col">รายละเอียด</th>
                    <th class="right">คะแนน</th>
                    <th class="right">คงเหลือ</th>
                </tr>
            </thead>
            <tbody>
                <div style="display: none;">{{ $total = $engineer->total }}</div>
                @forelse(($engineer->points) as $key=>$point)
                    <div style="display: none;">{{ $isRedeem = ($point->redeem_item_id != null) }}</div>
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($point->created_at)) }}</td>
                        <td>{{ $isRedeem ? $point->redeem_item->name : 'ได้รับคะแนน' }}</td>
                        <td class="{{ $isRedeem ? 'del' : 'plus' }}">{{ $isRedeem ? $point->point : '+'.$point->point }}</td>
                        <td>{{$total}}</td>
                    </tr>
                    <div style="display: none;">{{ $total -= $point->point }}</div>
                @empty
                    <tr>
                        <td>ไม่มีประวัติคะแนน</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="button-ss" onclick="showPoint()">
            <span>กลับ</span>
        </div>
    </div>
</div>
