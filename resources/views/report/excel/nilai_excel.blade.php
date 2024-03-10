<table style="border: 1 solid black">
    <thead>
        <tr>
            <th></th>
            <th>NIS</th>
            <th>NISN</th>
            <th>NAMA</th>
            <th>NILAI UJIAN</th>
        </tr>
    </thead>
    <tbody>
        @php $no=1; @endphp
        @foreach($siswa as $s)
        @php $detail = \App\Models\Kehadiran::get($jadwal_id, $s->id); @endphp
        <tr>
            <td>{{$no++}}</td>
            <td>{{$s->nis}}</td>
            <td>{{$s->nip_nik_nisn}}</td>
            <td>{{$s->nama}}</td>
            <td>
                {{\App\Models\BankJawaban::getNilai($detail?->id, $mapel_id, $s->id)}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
