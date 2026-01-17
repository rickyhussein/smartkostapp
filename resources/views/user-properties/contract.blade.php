<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $filename }}</title>
    <style>
        @page {
            margin-top: 150px ;
            margin-bottom: 20px ;
            margin-left: 65px ;
            margin-right: 65px ;
        }
        #header { position: fixed; top: -105px; left: 0px; right: 0px; }
        p { page-break-after: always; }
        p:last-child { page-break-after: never; }

        .circled-number {
            display: inline-block;
            border: 2px solid #000;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            text-align: center;
            line-height: 22px;
            margin-right: 5px;
        }

        .number {
            display: inline-block;
            width: 24px;
            height: 24px;
            text-align: center;
            line-height: 22px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    @php
        function terbilang($angka)
        {
            $angka = abs((int) $angka);
            $huruf = [
                'nol', 'satu', 'dua', 'tiga', 'empat', 'lima',
                'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
            ];
            $temp = '';

            if ($angka < 12) {
                $temp = $huruf[$angka];
            } elseif ($angka < 20) {
                $temp = terbilang($angka - 10) . ' belas';
            } elseif ($angka < 100) {
                $puluh = intval($angka / 10);
                $sisa = $angka % 10;
                $temp = terbilang($puluh) . ' puluh' . ($sisa ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 200) {
                $temp = 'seratus' . ($angka > 100 ? ' ' . terbilang($angka - 100) : '');
            } elseif ($angka < 1000) {
                $ratus = intval($angka / 100);
                $sisa = $angka % 100;
                $temp = terbilang($ratus) . ' ratus' . ($sisa ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 2000) {
                $temp = 'seribu' . ($angka > 1000 ? ' ' . terbilang($angka - 1000) : '');
            } elseif ($angka < 1000000) {
                $ribu = intval($angka / 1000);
                $sisa = $angka % 1000;
                $temp = terbilang($ribu) . ' ribu' . ($sisa ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 1000000000) {
                $juta = intval($angka / 1000000);
                $sisa = $angka % 1000000;
                $temp = terbilang($juta) . ' juta' . ($sisa ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 1000000000000) {
                $milyar = intval($angka / 1000000000);
                $sisa = $angka % 1000000000;
                $temp = terbilang($milyar) . ' milyar' . ($sisa ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 1000000000000000) {
                $trilyun = intval($angka / 1000000000000);
                $sisa = $angka % 1000000000000;
                $temp = terbilang($trilyun) . ' triliun' . ($sisa ? ' ' . terbilang($sisa) : '');
            } else {
                $temp = 'terlalu besar';
            }

            return trim(preg_replace('/\s+/', ' ', $temp));
        }
    @endphp
    <div id="header">
        <table  style="width: 100%; font-size:16px; font-family: 'Open Sans', sans-serif; color:rgb(0, 0, 0);">
            <tbody>
                <tr>
                    <td style="text-align:center; font-weight:bold; text-transform: uppercase; ">
                        Kontrak Sewa {{ $up->property->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-weight:bold; font-size: 12px;">
                        Tanggal : {{ $up->signature_date ? \Carbon\Carbon::parse($up->signature_date)->translatedFormat('d F Y') : '' }}
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td style="border-top:2px solid #111;  "></td>
                </tr>
            </tbody>
        </table>
    </div>

    <table style="width: 100%; font-size:12px; font-family: 'Open Sans', sans-serif; color:rgb(0, 0, 0);">
        <tbody>
            <tr>
                <td colspan="3" style="font-weight:bold;">Pemilik (Data Sesuai KTP)</td>
            </tr>
            <tr>
                <td style="width: 10%; vertical-align:top;">Nama</td>
                <td style="width: 3%; vertical-align:top;">:</td>
                <td style="width: 82%; vertical-align:top;">{{ $up->owner->name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="width: 10%%; vertical-align:top;">Alamat</td>
                <td style="width: 3%; vertical-align:top;">:</td>
                <td style="width: 87%; vertical-align:top;">{{ $up->owner->address ?? '-' }}</td>
            </tr>
            <tr>
                <td style="width: 10%%; vertical-align:top;">Telepon</td>
                <td style="width: 3%; vertical-align:top;">:</td>
                <td style="width: 87%; vertical-align:top;">{{ $up->owner->phone_number ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; font-size:12px; font-family: 'Open Sans', sans-serif; color:rgb(0, 0, 0); padding-top: 20px;">
        <tbody>
            <tr>
                <td colspan="3" style="font-weight:bold;">Penyewa (Data Sesuai KTP)</td>
            </tr>
            <tr>
                <td style="width: 10%; vertical-align:top;">Nama</td>
                <td style="width: 3%; vertical-align:top;">:</td>
                <td style="width: 82%; vertical-align:top;">{{ $up->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="width: 10%%; vertical-align:top;">Alamat</td>
                <td style="width: 3%; vertical-align:top;">:</td>
                <td style="width: 87%; vertical-align:top;">{{ $up->user->address ?? '-' }}</td>
            </tr>
            <tr>
                <td style="width: 10%%; vertical-align:top;">Telepon</td>
                <td style="width: 3%; vertical-align:top;">:</td>
                <td style="width: 87%; vertical-align:top;">{{ $up->user->phone_number ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; font-size:12px; font-family: 'Open Sans', sans-serif; color:rgb(0, 0, 0); padding-top: 20px;">
        <tbody>
            @if ($up->contract)
                {!! $up->contract !!}
            @else
                <tr>
                    <td style="font-weight:bold; width: 3%;">1.</td>
                    <td style="font-weight:bold; width: 97%;">Objek Sewa</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%;"></td>
                    <td>Pemilik menyewakan kepada penghuni kamar yang terletak di <span style="font-weight: bold;">{{ $up->property && $up->property->name ? ucwords(strtolower($up->property->name)) : '' }} kamar {{ $up->room->room_name ?? '' }}</span>.</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%; padding-top: 10px;">2.</td>
                    <td style="font-weight:bold; width: 97%; padding-top: 10px;">Durasi Sewa</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%;"></td>
                    <td>Kontrak ini berlaku selama <span style="font-weight: bold;">{{ $up->period ?? '' }} bulan</span> mulai dari <span style="font-weight: bold;">{{ $up->start_date ? \Carbon\Carbon::parse($up->start_date)->translatedFormat('d F Y') : '' }}</span> hingga <span style="font-weight: bold;">{{ $up->end_date ? \Carbon\Carbon::parse($up->end_date)->translatedFormat('d F Y') : '' }}</span>.</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%; padding-top: 10px;">3.</td>
                    <td style="font-weight:bold; width: 97%; padding-top: 10px;">Biaya Sewa</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%;"></td>
                    <td>Penghuni setuju untuk membayar biaya sewa sebesar <span style="font-weight: bold;">Rp {{ number_format($up->rent->amount) }} ({{ terbilang($up->rent->amount) }} rupiah) per {{ $up->period ?? '' }} bulan</span>, yang harus dibayar paling lambat tanggal 5 setiap {{ $up->period ?? '' }} bulannya.</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%; padding-top: 10px;">4.</td>
                    <td style="font-weight:bold; width: 97%; padding-top: 10px;">Deposit</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%;"></td>
                    <td>Penghuni wajib deposit sebesar <span style="font-weight: bold;">Rp {{ number_format($up->rent->deposit_price) }} ({{ terbilang($up->rent->deposit_price) }} rupiah)</span> yang akan dikembalikan setelah penghuni meninggalkan kamar, dengan syarat tidak ada kerusakan.</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%; padding-top: 10px;">5.</td>
                    <td style="font-weight:bold; width: 97%; padding-top: 10px;">Kewajiban Penghuni</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%;"></td>
                    <td>Penghuni wajib menjaga kebersihan dan keamanan kamar dan lingkungan Rumah Cemara, serta mematuhi semua peraturan yang berlaku. Bersedia melaporkan diri ke ketua RT dan mengikuti peraturan dan kewajiban RT setempat.</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%; padding-top: 10px;">6.</td>
                    <td style="font-weight:bold; width: 97%; padding-top: 10px;">Pemutusan Kontrak</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%;"></td>
                    <td>Jika salah satu pihak ingin mengakhiri kontrak sebelum waktu yang disepakati, harus memberikan pemberitahuan tertulis minimal 30 hari sebelumnya.</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%; padding-top: 10px;">7.</td>
                    <td style="font-weight:bold; width: 97%; padding-top: 10px;">Tanda Tangan</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; width: 3%;"></td>
                    <td>Dengan ini, kedua belah pihak setuju untuk mematuhi semua ketentuan dalam kontrak ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <table style="width: 100%; font-size:12px; font-family: 'Open Sans', sans-serif; color:rgb(0, 0, 0); padding-top: 40px;">
        <tbody>
            <tr>
                <td style="width:50%;">
                    <strong>Pemilik</strong>
                </td>
                <td style="width:50%; text-align:right;">
                    <strong>Penyewa</strong>
                </td>
            </tr>
            <br>
            <br>
            <br>
            <tr>
                <td style="width:50%;">
                </td>
                <td style="width:50%;">
                    @if ($up->signature)
                        <span style="float:right;">
                            <div style="position: relative; top: -2%;left: 50%; transform: translate(-50%, -50%);">
                                <img src="{{ asset('storage/'.$up->signature) }}" style="width: 100px;">
                            </div>
                        </span>
                    @endif
                </td>
            </tr>
            <br>
            <br>
            <tr>
                <td style="width:50%;">
                    {{ $up->owner->name ?? '-' }}
                </td>
                <td style="width:50%; text-align:right;">
                    {{ $up->user->name ?? '-' }}
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>
