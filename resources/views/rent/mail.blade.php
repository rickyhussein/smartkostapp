<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent SmartKost</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            background-color: #ffffff;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            background-color: rgb(236, 236, 236);
            padding: 20px;
            color: white;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }

            .header {
                padding: 10px;
            }
        }

        .btn-blue {
            display: inline-block;
            background-color: #19008a;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-blue:hover {
            background-color: #00538a;
        }

  .btn-blue:active {
    background-color: #3182b5;
  }
    </style>

</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://smartkos.clustermadridmgc.com/assets/img/kos.png" alt="Smart Kost">
        </div>
        <br><br>

        Ini adalah pesan otomatis dari sistem layanan Smart Kost
        <br><br>
        Salam sejahtera Bapak/Ibu, Kami informasikan data dibawah ini melakukan pengajuan sewa terhadap properti anda:
        <br><br>

        <b>Informasi Penyewa</b>
        <br>
        Nama Penyewa: {{ $rent->user->name ?? '-' }}
        <br>
        Nomor HP : {{ $rent->user->phone_number ?? '-' }}
        <br>
        Pekerjaan : {{ $rent->user->job ?? '-' }}
        <br><br>

        <b>Properti yang disewa</b>
        <br>
        Nama Properti : {{ $rent->property && $rent->property->name ? ucwords(strtolower($rent->property->name)) : '' }} {{ $rent->property && $rent->property->village && $rent->property->village->name ? ucwords(strtolower($rent->property->village->name)) : '' }}
        <br>
        Nama Kamar : Kamar {{ $rent->room && $rent->room->room_name ? ucwords(strtolower($rent->room->room_name)) : '' }}
        <br>
        Tipe Kamar : Tipe {{ $rent->room && $rent->room->room_type ? ucwords(strtolower($rent->room->room_type)) : '' }}
        <br>
        Ukuran Kamar : {{ $rent->room->room_height ?? '-' }} x {{ $rent->room->room_width ?? '-' }} Meter
        <br>
        Periode Sewa : {{ $rent->period }} Bulan
        <br>
        Tanggal Mulai Sewa : 
        @php
            if ($rent->start_date) {
                Carbon\Carbon::setLocale('id');
                $start_date = Carbon\Carbon::createFromFormat('Y-m-d', $rent->start_date);
                $new_start_date = $start_date->translatedFormat('d F Y');
            } else {
                $new_start_date = '-';
            }
        @endphp
        {{ $new_start_date  }}
        <br>
        Tanggal Selesai Sewa : 
        @php
            if ($rent->end_date) {
                Carbon\Carbon::setLocale('id');
                $end_date = Carbon\Carbon::createFromFormat('Y-m-d', $rent->end_date);
                $new_end_date = $end_date->translatedFormat('d F Y');
            } else {
                $new_end_date = '-';
            }
        @endphp
        {{ $new_end_date  }}
        <br><br>

        <b>Rincian Harga</b>
        <br>
        Biaya Sewa: Rp {{ number_format($rent->amount) }}
        <br>
        Biaya Deposit: Rp {{ number_format($rent->deposit_price) }}
        <br>
        <b>Total : Rp {{ number_format($rent->total_amount) }}</b>
        <br><br>
        
        Approval Melalui Link Dibawah Ini
        <br><br><br>

        <center>
            <a href="{{ url('/rent/owner/show/'.$rent->id) }}" class="btn-blue">Link Approval</a>
        </center>


        <br><br><br>

        <div style="background-color: #dddee1; text-align: center; padding: 10px;margin-top:10px; font-size: 14px; border-top: 1px solid #e5e7eb;">
            <p style="margin: 0;">&copy; {{ date('Y') }} Smart Kost. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
