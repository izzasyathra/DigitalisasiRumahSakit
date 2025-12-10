<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periksa Pasien - Klinik Sehat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <div class="max-w-4xl mx-auto py-10 px-4">
        
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('doctor.dashboard') }}" class="text-gray-500 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-blue-800">Form Pemeriksaan Medis</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-blue-500">
                    <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-4">Data Pasien</h3>
                    
                    <div class="mb-4">
                        <label class="block text-xs text-gray-400">Nama Pasien</label>
                        <p class="font-bold text-lg text-gray-800">{{ $appointment->patient->name ?? 'Nama Tidak Ditemukan' }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs text-gray-400">Keluhan Awal</label>
                        <p class="text-gray-700 bg-gray-50 p-3 rounded border mt-1">
                            "{{ $appointment->complaint ?? '-' }}"
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs text-gray-400">Tanggal & Jam</label>
                        <p class="text-sm font-medium">
                            <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <form action="{{ route('doctor.medical-records.store', $appointment->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="diagnosis" class="block text-sm font-bold text-gray-700 mb-2">Diagnosa Dokter</label>
                        <textarea name="diagnosis" id="diagnosis" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Infeksi Saluran Pernapasan Akut (ISPA)..." required></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="treatment" class="block text-sm font-bold text-gray-700 mb-2">Tindakan / Saran Medis</label>
                        <textarea name="treatment" id="treatment" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Istirahat total 3 hari, perbanyak minum air putih..." required></textarea>
                    </div>

                    <div class="mb-8">
                        <label for="medicine" class="block text-sm font-bold text-gray-700 mb-2">Resep Obat</label>
                        <input type="text" name="medicine" id="medicine" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Paracetamol 3x1, Amoxicillin 3x1">
                        <p class="text-xs text-gray-500 mt-1">*Pisahkan dengan koma jika lebih dari satu</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Hasil Pemeriksaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>