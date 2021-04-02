<table>
    <thead>
        <tr>
            <th>Engineer Code</th>
            <th>Name</th>
            <th>Address</th>
            <th>Tel</th>
            <th>Redeem Item</th>
            <th>Date Create</th>
        </tr>
    </thead>

    <tbody>
        @foreach($redeems as $redeem)
        <tr>
            <td>{{ isset($redeem->engineerInfo->installer_id) ? strval($redeem->engineerInfo->installer_id): '' }}</td>
            <td>{{ isset($redeem->name) ? strval($redeem->name): '' }}</td>
            <td>{{ isset($redeem->address) ? strval($redeem->address): '' }}</td>
            <td>{{ isset($redeem->tel) ? strval($redeem->tel): '' }}</td>
            <td>{{ isset($redeem->redeemItem->name) ? strval($redeem->redeemItem->name): '' }}</td>
            <td>{{ isset($redeem->created_at) ? strval($redeem->created_at): '' }}</td>

        </tr>
        @endforeach
    </tbody>
</table>
