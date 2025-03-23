<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usulan Pembangunan</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 15px;
            width: 100%;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        button {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background 0.3s ease-in-out;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Usulan Pembangunan</h2>
        <form>
            <div class="form-group">
                <label for="namaPelapor">Nama Pelapor</label>
                <input type="text" id="namaPelapor" name="namaPelapor" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label for="noHp">Nomor HP</label>
                <input type="tel" id="noHp" name="noHp" required placeholder="Masukkan nomor HP aktif">
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi Pembangunan</label>
                <input type="text" id="lokasi" name="lokasi" required placeholder="Masukkan lokasi pembangunan">
            </div>

            <div class="form-group">
                <label for="jenis">Jenis Pembangunan</label>
                <select id="jenis" name="jenis" required>
                    <option value="" disabled selected>Pilih jenis pembangunan</option>
                    <option value="Jalan Raya">Jalan Raya</option>
                    <option value="Jembatan">Jembatan</option>
                    <option value="Saluran Air">Saluran Air</option>
                    <option value="Fasilitas Umum">Fasilitas Umum</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Usulan</label>
                <textarea id="deskripsi" name="deskripsi" required placeholder="Jelaskan alasan dan kebutuhan pembangunan"></textarea>
            </div>

            <div class="form-group">
                <label for="estimasi">Estimasi Waktu Pelaksanaan</label>
                <input type="date" id="estimasi" name="estimasi" required>
            </div>

            <button type="submit">Kirim Usulan</button>
        </form>
    </div>
</body>
</html>
