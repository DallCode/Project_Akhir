@extends('layout.main')

@section('content')
<section class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Mulai dari sini -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center mb-5">
                            <div class="col-lg-8 mb-4 mb-lg-0">
                                <div class="d-flex align-items-center">
                                    <div class="border p-2 d-inline-block mr-3 rounded">
                                        <img src="{{ asset('BKK3/images/logo-kabayan-group.png') }}" alt="Logo" style="height: 100px; width:auto">
                                    </div>
                                    <div>
                                        <h2>{{ $loker->jabatan }}</h2>
                                        <div>
                                            <span class="ml-0 mr-2 mb-2">
                                                <span class="icon-briefcase mr-2"></span>{{ $loker->perusahaan->nama }}
                                            </span>
                                            <span class="m-2">
                                                <span class="icon-clock-o mr-2"></span>
                                                <span class="text-primary">{{ $loker->jenis_waktu_pekerjaan }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-5">
                                    <h3 class="h5 text-primary">Deskripsi Pekerjaan</h3>
                                    <p>{{ $loker->deskripsi }}</p>
                                </div>

                                <div class="mb-5">
                                    <h3 class="h5 text-primary">Tanggal Akhir</h3>
                                    <p>{{ $loker->tanggal_akhir }}</p>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-6">
                                        <a href="{{ route('dashboardalumni') }}" class="btn btn-outline-primary ml-6">Kembali</a>
                                    </div>
                                    {{-- <div class="col-6">
                                        <a href="#" class="btn btn-block btn-primary btn-md">Lamar</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card background selesai -->
            </div>
        </div>
    </div>
</section>
@endsection
