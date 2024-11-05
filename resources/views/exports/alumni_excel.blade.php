<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Perusahaan</th>
            <th>Jabatan</th>
            <th>Tahun Lulus</th>
            <th>Tracer Study</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $alumni)
            <tr>
                <td>{{ $alumni->nama }}</td>
                <td>{{ $alumni->perusahaan->nama }}</td>
                <td>{{ $alumni->jabatan }}</td>
                <td>{{ $alumni->tahun_lulus }}</td>
                <td>{{ $alumni->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
