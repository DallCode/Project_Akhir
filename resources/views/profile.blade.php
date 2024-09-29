@extends('layout.main')

@section('content')
<div class="card">
    <div class="card-header">
      <h5 class="card-title">Profile</h5>  
      <div class="container mt-5">
          <div class="row">
              <div class="col-md-2 text-center">
                  <img src="{{ asset('bkk/dist/assets/images/faces/1.jpg') }}" class="rounded-circle" alt="Profile Image" style="width: 200px; height: 200px;">
              </div>
              <div class="col-md-8">
                  <h2><strong>MUHAMMAD AFDHAL ADZIKRI</strong> <a href="#" class="text-primary"> <i class="bi bi-pencil-fill"></i> Edit info dasar</a></h2>
                  <div class="row">
                      <div class="col-md-6">
                          <p><strong>WHATSAPP NUMBER</strong></p>
                          <p class="text-muted">+6283100737707</p>
      
                          <p><strong>ALAMAT</strong></p>
                          <p class="text-muted">Bandung, Jawa Barat</p>
      
                          <p><strong>PENDIDIKAN TERAKHIR</strong></p>
                          <p class="text-muted">SMA/SMK</p>
                      </div>
                      <div class="col-md-6">
                          <p><strong>EMAIL <span class="text-danger">(BELUM DIVERIFIKASI)</span></strong></p>
                          <p class="text-muted">mafdhaladzikri@gmail.com</p>
      
                          <p><strong>USIA, JENIS KELAMIN</strong></p>
                          <p class="text-muted">19 tahun, Laki-laki</p>
      
                          <p><strong>PENGALAMAN KERJA</strong></p>
                          <p class="text-muted">Belum ada pengalaman kerja</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Tentang Saya <a href="#" class="text-primary"> <i class="bi bi-pencil-fill"></i> Edit</a></h5>
        <p>sllslsdsdl</p>
    </div>
</div>
@endsection
