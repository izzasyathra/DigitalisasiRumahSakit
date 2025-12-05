@extends('layouts.patient')
{{-- Langkah 1: Pilih Poli --}}
@section('content')
    <h2>Buat Janji Temu - Pilih Poli</h2>
    
    @if (session('error')) <div style="color: red;">{{ session('error') }}</div> @endif

    <form id="poliForm">
        @csrf
        <div>
            <label for="poli_id">Pilih Poli:</label>
            <select id="poli_id" name="poli_id" required>
                <option value="">-- Pilih Poli --</option>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id }}">{{ $poli->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
    
    <div id="doctor-selection" style="margin-top: 20px; display:none;">
        <h3>Pilih Dokter dan Jadwal</h3>
        
        <form action="{{ route('patient.appointments.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="poli_id_selected" id="poli_id_selected">
            
            <div>
                <label for="doctor_schedule_id">Pilih Dokter & Jadwal:</label>
                <select id="doctor_schedule_id" name="schedule_id" required>
                    </select>
            </div>
            
            <div>
                <label for="booking_date">Tanggal Booking:</label>
                <input type="date" id="booking_date" name="booking_date" required min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
            
            <div>
                <label for="short_complaint">Keluhan Singkat:</label>
                <textarea id="short_complaint" name="short_complaint" rows="3" required></textarea>
            </div>
            
            <input type="hidden" name="doctor_id" id="doctor_id_hidden">
            
            <button type="submit">Konfirmasi Janji Temu</button>
        </form>
    </div>

    {{-- Script AJAX untuk memuat Dokter/Jadwal --}}
    <script>
        document.getElementById('poli_id').addEventListener('change', function() {
            const poliId = this.value;
            const doctorSelectionDiv = document.getElementById('doctor-selection');
            const doctorScheduleSelect = document.getElementById('doctor_schedule_id');
            const poliIdSelectedInput = document.getElementById('poli_id_selected');
            
            doctorScheduleSelect.innerHTML = '';
            
            if (poliId) {
                poliIdSelectedInput.value = poliId;
                fetch(`{{ route('patient.appointments.doctors.get') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ poli_id: poliId })
                })
                .then(response => response.json())
                .then(doctors => {
                    let options = '<option value="">-- Pilih Dokter dan Waktu --</option>';
                    if (doctors.length > 0) {
                        doctors.forEach(doctor => {
                            doctor.schedules.forEach(schedule => {
                                // Format: [Hari, Jam Mulai] - Nama Dokter
                                options += `<option value="${schedule.id}" data-doctor-id="${doctor.id}">
                                    ${schedule.day}, ${schedule.start_time.substring(0, 5)} - ${doctor.name}
                                </option>`;
                            });
                        });
                        doctorScheduleSelect.innerHTML = options;
                        doctorSelectionDiv.style.display = 'block';
                    } else {
                        doctorScheduleSelect.innerHTML = '<option value="">Tidak ada dokter dengan jadwal tersedia di poli ini.</option>';
                        doctorSelectionDiv.style.display = 'none';
                    }
                });
            } else {
                doctorSelectionDiv.style.display = 'none';
            }
        });
        
        // Update hidden doctor_id saat jadwal dipilih
        document.getElementById('doctor_schedule_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('doctor_id_hidden').value = selectedOption.getAttribute('data-doctor-id');
        });
    </script>
@endsection