<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-700 text-white p-6 space-y-6">
            <h1 class="text-2xl font-bold">Admin Panel</h1>
            <nav class="space-y-3">
                <a href="/admin/dashboard" class="block p-3 bg-blue-900 rounded-lg">Dashboard</a>
                <a href="#" class="block p-3 hover:bg-blue-900 rounded-lg">Users</a>
                <a href="#" class="block p-3 hover:bg-blue-900 rounded-lg">Data Obat</a>
                <a href="#" class="block p-3 hover:bg-blue-900 rounded-lg">Poli</a>
                <a href="#" class="block p-3 hover:bg-blue-900 rounded-lg">Jadwal</a>
                <a href="#" class="block p-3 hover:bg-blue-900 rounded-lg">Janji Temu</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10">
            <h2 class="text-3xl font-bold mb-6">Dashboard Admin</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                    <h3 class="text-xl font-semibold">Total Pengguna</h3>
                    <p class="text-3xl font-bold mt-2">128</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                    <h3 class="text-xl font-semibold">Total Dokter</h3>
                    <p class="text-3xl font-bold mt-2">32</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                    <h3 class="text-xl font-semibold">Janji Hari Ini</h3>
                    <p class="text-3xl font-bold mt-2">14</p>
                </div>
            </div>

            <div class="mt-10 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h3 class="text-2xl font-semibold mb-4">Aktivitas Terbaru</h3>
                <ul class="space-y-3 text-gray-700">
                    <li>- User baru mendaftar</li>
                    <li>- Dokter menambahkan jadwal baru</li>
                    <li>- Sistem memperbarui data poli</li>
                    <li>- Pasien membuat janji temu baru</li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>
