<table>
    <thead>
        <tr>
            <th>email</th>
            <th>name</th>
            <th>lastname</th>
            <th>phone</th>
            <th>Shop</th>
            <th>province</th>
            <th>experience</th>
            <th>type of work</th>
            <th>history install samsung air</th>
            <th>MT</th>
            <th>source</th>
            <th>Created At</th>

        </tr>
    </thead>

    <tbody>
        @foreach($enginneers as $engineer)
        <tr>
            <td>{{ isset($engineer->email) ? strval($engineer->email): '' }}</td>
            <td>{{ isset($engineer->first_name_th) ?strval($engineer->first_name_th): '' }}</td>
            <td>{{ isset($engineer->last_name_th) ?strval($engineer->last_name_th): '' }}</td>
            <td>{{ isset($engineer->tel) ?strval($engineer->tel): '' }}</td>
            <td>{{ isset($engineer->shop) ?strval($engineer->shop): '' }}</td>
            <td>{{ isset($engineer->province) ?strval($engineer->province): '' }}</td>
            <td>{{ isset($engineer->history_install) ?strval($engineer->history_install): '' }}</td>
            <td>{{ isset($engineer->type_of_work) ?strval($engineer->type_of_work): '' }}</td>
            <td>{{ isset($engineer->month) ?strval($engineer->month.' ต่อเดือน'): '' }}</td>
            <td>y</td>
            <td>0</td>
            <td>{{ isset($engineer->created_at) ?strval($engineer->created_at): '' }}</td>

        </tr>
        @endforeach
    </tbody>
</table>
