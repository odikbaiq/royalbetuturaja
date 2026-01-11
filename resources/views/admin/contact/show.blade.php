@extends('layouts.admin')

@section('title', 'Detail Contact Message')

@section('content')
<div class="container-fluid">
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title text-bold m-0">Detail Pesan dari: {{ $contactMessage->nama }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr><th width="150">ID Pesan</th><td>: {{ $contactMessage->id }}</td></tr>
                                <tr><th>Nama Pengirim</th><td>: {{ $contactMessage->nama }}</td></tr>
                                <tr><th>Email</th><td>: {{ $contactMessage->email }}</td></tr>
                                <tr><th>Subject</th><td>: {{ $contactMessage->subject }}</td></tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:
                                        @if($contactMessage->status == 'replied')
                                            <span class="badge badge-success">Sudah Dibalas</span>
                                        @else
                                            <span class="badge badge-warning">Menunggu Balasan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 text-md-right mt-2">
                            {{-- Tombol diperbaiki dengan data-toggle dan data-bs-toggle agar kompatibel semua versi --}}
                            <button class="btn btn-primary shadow-sm" type="button"
                                    data-toggle="collapse" data-target="#replyFormArea"
                                    data-bs-toggle="collapse" data-bs-target="#replyFormArea">
                                <i class="fas fa-reply mr-1"></i> Balas via Email
                            </button>
                            <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>

                    {{-- Form Balasan (Collapse Area) --}}
                    <div class="collapse {{ $errors->has('reply_content') ? 'show' : '' }}" id="replyFormArea">
                        <div class="card border-primary mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0 text-white"><i class="fas fa-edit mr-2"></i>Tulis Balasan</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.contact.reply', $contactMessage->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="reply_content" class="font-weight-bold">Pesan Balasan:</label>
                                        <textarea class="form-control @error('reply_content') is-invalid @enderror"
                                                  id="reply_content" name="reply_content" rows="6"
                                                  placeholder="Tulis pesan balasan di sini..." required>{{ old('reply_content') }}</textarea>
                                        @error('reply_content')
                                            <span class="invalid-feedback d-block">{{ $errors->first('reply_content') }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-paper-plane mr-1"></i> Kirim Sekarang
                                        </button>
                                        <button type="button" class="btn btn-light border ml-2"
                                                data-toggle="collapse" data-target="#replyFormArea"
                                                data-bs-toggle="collapse" data-bs-target="#replyFormArea">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="text-bold mb-3 text-primary"><i class="fas fa-envelope-open-text mr-2"></i>Isi Pesan Asli:</h5>
                            <div class="bg-light p-4 rounded border shadow-sm">
                                <p style="white-space: pre-line; color: #333; line-height: 1.6;">{{ $contactMessage->pesan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
