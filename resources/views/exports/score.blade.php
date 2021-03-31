<table>
    <thead>
        <tr>
            <th>Engineer Code</th>
            <th>Score</th>
            <th>Answer 1</th>
            <th>Answer 2</th>
            <th>Answer 3</th>
            <th>Answer 4</th>
            <th>Answer 5</th>
            <th>Answer 6</th>
            <th>Answer 7</th>
            <th>Answer 8</th>
            <th>Answer 9</th>
            <th>Answer 10</th>
            <th>Answer 11</th>
            <th>Answer 12</th>
            <th>Answer 13</th>
            <th>Answer 14</th>
            <th>Answer 15</th>
            <th>Answer 16</th>
            <th>Answer 17</th>
            <th>Answer 18</th>
            <th>Answer 19</th>
            <th>Answer 20</th>
        </tr>
    </thead>

    <tbody>
        @foreach($scores as $score)
        <tr>
            <td>{{ isset($score->engineerInfo->installer_id) ? strval($score->engineerInfo->installer_id): '' }}</td>
            <td>{{ isset($score->score) ? strval($score->score): '' }}</td>
            <td>{{ isset($score->answer_1) ? strval($score->answer_1): '' }}</td>
            <td>{{ isset($score->answer_2) ? strval($score->answer_2): '' }}</td>
            <td>{{ isset($score->answer_3) ? strval($score->answer_3): '' }}</td>
            <td>{{ isset($score->answer_4) ? strval($score->answer_4): '' }}</td>
            <td>{{ isset($score->answer_5) ? strval($score->answer_5): '' }}</td>
            <td>{{ isset($score->answer_6) ? strval($score->answer_6): '' }}</td>
            <td>{{ isset($score->answer_7) ? strval($score->answer_7): '' }}</td>
            <td>{{ isset($score->answer_8) ? strval($score->answer_8): '' }}</td>
            <td>{{ isset($score->answer_9) ? strval($score->answer_9): '' }}</td>
            <td>{{ isset($score->answer_10) ? strval($score->answer_10): '' }}</td>
            <td>{{ isset($score->answer_11) ? strval($score->answer_11): '' }}</td>
            <td>{{ isset($score->answer_12) ? strval($score->answer_12): '' }}</td>
            <td>{{ isset($score->answer_13) ? strval($score->answer_13): '' }}</td>
            <td>{{ isset($score->answer_14) ? strval($score->answer_14): '' }}</td>
            <td>{{ isset($score->answer_15) ? strval($score->answer_15): '' }}</td>
            <td>{{ isset($score->answer_16) ? strval($score->answer_16): '' }}</td>
            <td>{{ isset($score->answer_17) ? strval($score->answer_17): '' }}</td>
            <td>{{ isset($score->answer_18) ? strval($score->answer_18): '' }}</td>
            <td>{{ isset($score->answer_19) ? strval($score->answer_19): '' }}</td>
            <td>{{ isset($score->answer_20) ? strval($score->answer_20): '' }}</td>

        </tr>
        @endforeach
    </tbody>
</table>
