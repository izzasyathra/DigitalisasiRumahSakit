@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Obat Baru</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.medicines.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Obat</label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Paracetamol">
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Jenis Obat</label>
                        <select name="type" class="form-control">
                        <option value="Tablet">Tablet</option>
                        <option value="Sirup">Sirup</option>
                        <option value="Kapsul">Kapsul</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Stok Awal</label>
                        <input type="number" name="stock" class="form-control" required value="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" required value="0">
                    </div>
                </div>
                <div class="mb-3">
                    <label>Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Obat</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection