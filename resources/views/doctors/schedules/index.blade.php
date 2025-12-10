@extends('layouts.doctor') 

@section('content')
    <div class="container">
        <h2>📅 Jadwal Praktik Saya</h2>
        
        <a href="{{ route('doctor.schedules.create') }}" style="background-color: blue; color: white; padding: 10px; text-decoration: none;">+ Tambah Jadwal Baru</a>
        
        <h3>Daftar Jadwal Praktik</h3>
        <table>
            <tbody>
                @forelse ($schedules as $schedule)
                    <tr>
                        <td>
                            <a href="{{ route('doctor.schedules.edit', $schedule) }}">Edit</a>
                            
                            <form action="{{ route('doctor.schedules.destroy', $schedule) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin menghapus jadwal ini? Jika sudah ada janji temu, mungkin perlu penanganan khusus.')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Anda belum mengatur jadwal praktik.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection