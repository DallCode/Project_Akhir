<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/"><img src="{{ asset('bkk/dist/assets/images/logo/ks.jpg')}}" alt="Logo" srcset="" style="width: 180px; height:auto"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item ">
                    <a href="{{ route('chartalumni') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="{{ route('dashboardalumni') }}" class='sidebar-link'>
                        <i class="bi bi-search"></i>
                        <span>Cari lowongan</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="{{ route('lamaransaya') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span>Lamaran Saya</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="{{ route('profile') }}" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="#" class='sidebar-link' data-bs-toggle="modal" data-bs-target="#editKegiatanSekarangModal">
                        <i class="bi bi-calendar-event"></i>
                        <span>Kegiatan Sekarang</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class='sidebar-link' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

<!-- Modal Edit Kegiatan Sekarang -->
<div class="modal fade" id="editKegiatanSekarangModal" tabindex="-1" aria-labelledby="editKegiatanSekarangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKegiatanSekarangModalLabel">Edit Kegiatan Sekarang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateKegiatanSekarang') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kegiatanSekarang" class="form-label">Pilih Kegiatan Sekarang</label>
                        <select class="form-select" id="kegiatanSekarang" name="kegiatanSekarang" required>
                            <option value="" disabled selected>Pilih kegiatan</option>
                            <option value="Bekerja">Bekerja</option>
                            <option value="Belum Bekerja">Tidak Bekerja</option>
                            <option value="Kuliah">Kuliah</option>
                            <option value="Wirausaha">Wirausaha</option>
                        </select>
                    </div>

                    <!-- Textarea untuk alasan -->
                    <div class="mb-3 d-none" id="alasanContainer">
                        <label for="alasan" class="form-label">Alasan</label>
                        <textarea class="form-control" id="alasan" name="alasan" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk menampilkan textarea saat option dipilih -->
<script>
    document.getElementById('kegiatanSekarang').addEventListener('change', function() {
        const alasanContainer = document.getElementById('alasanContainer');
        if (this.value !== "") {
            alasanContainer.classList.remove('d-none');
        } else {
            alasanContainer.classList.add('d-none');
        }
    });
</script>

