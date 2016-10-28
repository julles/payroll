 <table class="table">
      <tr>
        <td>Name</td>
        <td>Gaji Pokok</td>
        <td>Total Uang Makan</td>
        <td>Total Transport</td>
        <td>Lembur</td>
        <td>tdR</td>
        <td>PPH21</td>
        <td>Total</td>
      </tr>
      @foreach($model->details as $row)  
        <tr>
          <td>{{ $row->employee->nip }} - {{ $row->employee->name }}</td>
          <td>{{ Admin::formatMoney($row->gaji_pokok) }}</td>
          <td>{{ Admin::formatMoney($row->total_uang_makan) }}</td>
          <td>{{ Admin::formatMoney($row->total_transport) }}</td>
          <td>{{ Admin::formatMoney($row->total_lembur) }}</td>
          <td>{{ Admin::formatMoney($row->tdr) }}</td>
          <td>{{ Admin::formatMoney($row->pph21) }}</td>
          <td>{{ Admin::formatMoney($row->total) }}</td>
        </tr>
      @endforeach
</table>