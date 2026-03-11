<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }

        .page-container {
            background-color: #f1f5f9; min-height: 100vh; padding: 25px; box-sizing: border-box; position: relative;
        }

        .search-container { background-color: white; border: 1px solid #cbd5e1; border-radius: 4px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 15px; }
        .search-input { border: none; outline: none; width: 100%; font-size: 16px; color: #334155; background: transparent; }
        .filter-container { display: flex; gap: 20px; margin-bottom: 25px; align-items: center; flex-wrap: wrap; }
        .filter-box { background-color: #003566; padding: 12px 20px; border-radius: 4px; font-weight: 600; color: white; font-size: 16px; width: 250px; }

        .icon-group { display: flex; gap: 12px; margin-left: auto; align-items: center; }
        .icon-box { 
            background-color: white; border: 3px solid #003566; width: 42px; height: 38px; 
            border-radius: 6px; cursor: pointer; transition: all 0.2s ease;
        }
        .icon-box.active { box-shadow: 0 0 0 4px rgba(0, 53, 102, 0.2); transform: scale(1.05); }

        .table-container { background-color: white; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-radius: 8px; }
        .req-table { width: 100%; border-collapse: collapse; font-size: 14px; text-align: center; white-space: nowrap; }
        .req-table th { background-color: #003566; padding: 18px 15px; font-weight: 600; color: white; }
        .req-table td { padding: 18px 15px; color: #0f172a; font-weight: 500; border-bottom: 1px solid #f1f5f9; }
        .req-table tr:hover { background-color: #f8fafc; }

        .grid-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
        .card-box { 
            background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); transition: transform 0.2s;
            display: flex; flex-direction: column; height: 100%; box-sizing: border-box;
        }
        .card-box:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.05); }

        .status-badge { padding: 6px 15px; border-radius: 4px; display: inline-flex; justify-content: center; align-items: center; min-width: 90px; text-transform: capitalize; color: white; font-weight: bold; font-size: 12px; text-align: center;}
        .btn-edit { background-color: #003566; padding: 8px 25px; border-radius: 4px; font-weight: bold; color: white; text-decoration: none; cursor: pointer; border: none; }
        .btn-edit:hover { background-color: #002244; }

        .fab-button {
            position: fixed; bottom: 40px; right: 40px; background-color: #003566; color: white;
            width: 70px; height: 70px; border-radius: 50%; display: flex; justify-content: center; 
            align-items: flex-start; padding-top: 6px; font-size: 50px; text-decoration: none; 
            box-shadow: 0 4px 15px rgba(0,53,102,0.4); font-weight: 300; line-height: 1; 
            z-index: 50; transition: transform 0.2s ease; box-sizing: border-box;
        }
        .fab-button:hover { transform: scale(1.05); background-color: #002244; }

        /* GAYA POP-UP MODAL */
        .modal-overlay { position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 100; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .modal-container { background-color: white; width: 100%; max-width: 800px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 2px solid #003566; overflow: hidden; animation: modal-in 0.3s ease; }
        @keyframes modal-in { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        
        .modal-header { padding: 20px 25px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .modal-title { font-size: 18px; font-weight: 700; color: #003566; }
        .modal-close { background: none; border: none; cursor: pointer; color: #94a3b8; font-size: 24px; padding: 0; }
        
        .modal-content { padding: 25px; max-height: 80vh; overflow-y: auto; }
        .section-card { background-color: #f1f5f9; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .section-title { font-size: 16px; font-weight: 700; color: #334155; margin-bottom: 15px; }
        .required-star { color: #ef4444; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; margin-bottom: 15px; }
        .form-label { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-input { 
            padding: 10px 15px; border: 1px solid #cbd5e1; border-radius: 4px; 
            font-size: 14px; color: #1e293b; background-color: white; transition: border-color 0.2s;
        }
        .form-input:focus { border-color: #003566; outline: none; box-shadow: 0 0 0 3px rgba(0, 53, 102, 0.1); }
        .form-input.read-only { background-color: #f8fafc; color: #64748b; font-weight: 600; }
        
        .modal-footer { padding: 15px 25px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px; }
        .btn-cancel { background-color: #f1f5f9; color: #334155; padding: 10px 20px; border-radius: 4px; font-weight: 600; border: none; cursor: pointer; }
        .btn-submit { background-color: #003566; color: white; padding: 10px 20px; border-radius: 4px; font-weight: 600; border: none; cursor: pointer; }
    </style>

    <div class="page-container" 
         x-data="{ 
            viewMode: 'normal', 
            showRequestModal: false, 
            modalTitle: 'Form Usulan Koleksi', 
            modalMode: 'create',
            formData: {
                id: null, 
                member_id: '',
                requester_name: '',
                email: '', 
                faculty: '',
                book_title: '', 
                author: '', 
                publisher: '', 
                publication_city: '', 
                publication_year: '', 
                material_type: '', 
                notes: '', 
                status: 'processing'
            },
            openCreateModal() {
                this.modalTitle = 'Form Usulan Koleksi (Baru)';
                this.modalMode = 'create';
                this.resetForm();
                this.showRequestModal = true;
            },
            openEditModal(requestData) {
                this.modalTitle = 'Form Usulan Koleksi (Edit)';
                this.modalMode = 'update';
                this.fillForm(requestData);
                this.showRequestModal = true;
            },
            resetForm() {
                this.formData = { id: null, member_id: '', requester_name: '', email: '', faculty: '', book_title: '', author: '', publisher: '', publication_city: '', publication_year: '', material_type: '', notes: '', status: 'processing' };
            },
            fillForm(data) {
                this.formData = { ...data };
            }
         }"
    >
        <form action="{{ route('permintaan.index') }}" method="GET">
            <div class="search-container">
                <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari Judul Buku, Pengarang...">
            </div>

            <div class="filter-container">
                <select name="faculty" class="filter-box" onchange="this.form.submit()" style="border: none; outline: none; cursor: pointer; appearance: auto;">
                    <option value="">Semua Fakultas</option>
                    @if(isset($faculties))
                        @foreach($faculties as $fakultas)
                            <option value="{{ $fakultas }}" {{ request('faculty') == $fakultas ? 'selected' : '' }}>{{ $fakultas }}</option>
                        @endforeach
                    @endif
                </select>

                <select name="status" class="filter-box" onchange="this.form.submit()" style="border: none; outline: none; cursor: pointer; appearance: auto;">
                    <option value="">Semua Status</option>
                    @if(isset($statuses))
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    @endif
                </select>

                <select name="year" class="filter-box" onchange="this.form.submit()" style="border: none; outline: none; cursor: pointer; appearance: auto;">
                    <option value="">Semua Tahun</option>
                    @if(isset($years))
                        @foreach($years as $tahun)
                            <option value="{{ $tahun }}" {{ request('year') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    @endif
                </select>

                <div class="icon-group">
                    <div @click="viewMode = 'compact'" :class="{ 'active': viewMode === 'compact' }" class="icon-box" style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 5px;">
                        <div style="width: 20px; height: 4px; background: #003566; border-radius: 2px;"></div>
                        <div style="width: 20px; height: 4px; background: #003566; border-radius: 2px;"></div>
                    </div>
                    
                    <div @click="viewMode = 'normal'" :class="{ 'active': viewMode === 'normal' }" class="icon-box" style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 3px;">
                        <div style="width: 22px; height: 4px; background: #003566; border-radius: 2px;"></div>
                        <div style="width: 22px; height: 4px; background: #003566; border-radius: 2px;"></div>
                        <div style="width: 22px; height: 4px; background: #003566; border-radius: 2px;"></div>
                    </div>
                    
                    <div @click="viewMode = 'grid'" :class="{ 'active': viewMode === 'grid' }" class="icon-box" style="display: grid; grid-template-columns: 1fr 1fr; gap: 3px; padding: 5px; box-sizing: border-box; width: 44px; height: 44px;">
                        <div style="background: #003566; border-radius: 1px;"></div><div style="background: #003566; border-radius: 1px;"></div>
                        <div style="background: #003566; border-radius: 1px;"></div><div style="background: #003566; border-radius: 1px;"></div>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-container" x-show="viewMode === 'normal'" x-cloak>
            <table class="req-table">
                <thead>
                    <tr>
                        <th>No Anggota</th><th>Judul Buku</th><th>Jenis Bahan</th><th>Pengarang</th>
                        <th>Penerbit</th><th>Kota terbit</th><th>Tahun Terbit</th><th>Fakultas</th>
                        <th>Pemohon</th><th>E-mail</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($requests) && $requests->count() > 0)
                        @foreach($requests as $index => $req)
                            <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->book_title }}</td>
                                <td>{{ $req->type_of_material }}</td>
                                <td>{{ $req->author }}</td>
                                <td>{{ $req->publisher }}</td>
                                <td>{{ $req->publication_city }}</td>
                                <td>{{ $req->publication_year }}</td>
                                <td>{{ $req->faculty }}</td>
                                <td style="font-weight: 700;">{{ $req->requester_name }}</td>
                                <td>{{ $req->email }}</td>
                                <td>
                                    @php
                                        $bgColor = '#eab308'; $statusText = 'Dalam Proses';
                                        if($req->status == 'pending_purchase') { $bgColor = '#ef4444'; $statusText = 'Menunggu'; }
                                        if($req->status == 'available') { $bgColor = '#22c55e'; $statusText = 'Selesai'; }
                                    @endphp
                                    <span class="status-badge" style="background-color: {{ $bgColor }};">{{ $statusText }}</span>
                                </td>
                                <td><button class="btn-edit" @click='openEditModal(@json($req))'>Edit</button></td>
                            </tr>
                        @endforeach
                    @else
                        @php
                            $dummyStatuses = [
                                ['bg' => '#facc15', 'text' => 'Dalam Proses'], ['bg' => '#facc15', 'text' => 'Dalam Proses'],
                                ['bg' => '#facc15', 'text' => 'Dalam Proses'], ['bg' => '#ef4444', 'text' => 'Menunggu'],
                                ['bg' => '#22c55e', 'text' => 'Selesai']
                            ];
                        @endphp
                        @foreach($dummyStatuses as $index => $status)
                            <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                                <td>235</td><td>Sastra Nusantara</td><td>Film</td><td>Nada</td><td>Erlangga</td>
                                <td>Surabaya</td><td>2026</td><td>FST</td>
                                <td style="font-weight: 700;">Dr. Isaac Kiehn</td>
                                <td>bdvg@gmail.com</td>
                                <td><span class="status-badge" style="background-color: {{ $status['bg'] }};">{{ $status['text'] }}</span></td>
                                <td><button class="btn-edit">Edit</button></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="table-container" x-show="viewMode === 'compact'" x-cloak>
            <table class="req-table">
                <thead>
                    <tr>
                        <th style="text-align: left; padding-left: 25px;">Informasi Buku</th>
                        <th style="text-align: left;">Pemohon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($requests) && $requests->count() > 0)
                        @foreach($requests as $req)
                            @php
                                $bgColor = '#eab308'; $statusText = 'Dalam Proses';
                                if($req->status == 'pending_purchase') { $bgColor = '#ef4444'; $statusText = 'Menunggu'; }
                                if($req->status == 'available') { $bgColor = '#22c55e'; $statusText = 'Selesai'; }
                            @endphp
                            <tr>
                                <td style="text-align: left; padding-left: 25px;">
                                    <div style="font-weight: 700; font-size: 15px; color: #003566;">{{ $req->book_title }}</div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ $req->author }} • {{ $req->type_of_material }}</div>
                                </td>
                                <td style="text-align: left;">
                                    <div style="font-weight: 600;">{{ $req->requester_name }} - {{ $req->faculty }}</div>
                                    <div style="font-size: 12px; color: #64748b;">{{ $req->email }}</div>
                                </td>
                                <td><span class="status-badge" style="background-color: {{ $bgColor }};">{{ $statusText }}</span></td>
                                <td><button class="btn-edit" @click='openEditModal(@json($req))'>Edit Status</button></td>
                            </tr>
                        @endforeach
                    @else
                        @php
                            $dummyCompact = [
                                ['bg' => '#facc15', 'text' => 'Dalam Proses'], ['bg' => '#ef4444', 'text' => 'Menunggu'], ['bg' => '#22c55e', 'text' => 'Selesai']
                            ];
                        @endphp
                        @foreach($dummyCompact as $status)
                            <tr>
                                <td style="text-align: left; padding-left: 25px;">
                                    <div style="font-weight: 700; font-size: 15px; color: #003566;">Sastra Nusantara</div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Nada • Film</div>
                                </td>
                                <td style="text-align: left;">
                                    <div style="font-weight: 600;">Dr. Isaac Kiehn - FST</div>
                                    <div style="font-size: 12px; color: #64748b;">bdvg@gmail.com</div>
                                </td>
                                <td><span class="status-badge" style="background-color: {{ $status['bg'] }};">{{ $status['text'] }}</span></td>
                                <td><button class="btn-edit">Edit Status</button></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="grid-container" x-show="viewMode === 'grid'" x-cloak>
            @if(isset($requests) && $requests->count() > 0)
                @foreach($requests as $req)
                    @php
                        $bgColor = '#eab308'; $statusText = 'Dalam Proses';
                        if($req->status == 'pending_purchase') { $bgColor = '#ef4444'; $statusText = 'Menunggu'; }
                        if($req->status == 'available') { $bgColor = '#22c55e'; $statusText = 'Selesai'; }
                    @endphp
                    <div class="card-box">
                        <div style="flex-grow: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <span style="font-size: 11px; font-weight: bold; color: #003566; background: #f1f5f9; padding: 4px 8px; border-radius: 4px;">{{ $req->faculty }}</span>
                                <span class="status-badge" style="background-color: {{ $bgColor }};">{{ $statusText }}</span>
                            </div>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 4px; line-height: 1.3;">{{ $req->book_title }}</h3>
                            <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Oleh: <span style="font-weight: 600;">{{ $req->author }}</span></p>
                        </div>
                        
                        <div style="margin-top: auto;">
                            <div style="border-top: 1px dashed #e2e8f0; padding-top: 15px; margin-bottom: 20px;">
                                <p style="font-size: 12px; color: #94a3b8; margin-bottom: 2px;">Diusulkan oleh:</p>
                                <p style="font-size: 14px; font-weight: 600; color: #334155;">{{ $req->requester_name }} - {{ $req->faculty }}</p>
                                <p style="font-size: 12px; color: #64748b;">{{ $req->email }}</p>
                            </div>
                            <button class="btn-edit" style="width: 100%; padding: 10px 0;" @click='openEditModal(@json($req))'>Edit Data Permintaan</button>
                        </div>
                    </div>
                @endforeach
            @else
                @php
                    $dummyGrid = [
                        ['bg' => '#facc15', 'text' => 'Dalam Proses', 'title' => 'Sastra Nusantara'], 
                        ['bg' => '#ef4444', 'text' => 'Menunggu', 'title' => 'Buku dengan Judul Sangat Panjang Sekali Sampai Tiga Baris di Sini'],
                        ['bg' => '#22c55e', 'text' => 'Selesai', 'title' => 'Kalkulus Lanjut'], 
                        ['bg' => '#facc15', 'text' => 'Dalam Proses', 'title' => 'Sistem Basis Data']
                    ];
                @endphp
                @foreach($dummyGrid as $item)
                    <div class="card-box">
                        <div style="flex-grow: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <span style="font-size: 11px; font-weight: bold; color: #003566; background: #f1f5f9; padding: 4px 8px; border-radius: 4px;">FST</span>
                                <span class="status-badge" style="background-color: {{ $item['bg'] }};">{{ $item['text'] }}</span>
                            </div>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 4px; line-height: 1.3;">{{ $item['title'] }}</h3>
                            <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Oleh: <span style="font-weight: 600;">Nada</span></p>
                        </div>
                        
                        <div style="margin-top: auto;">
                            <div style="border-top: 1px dashed #e2e8f0; padding-top: 15px; margin-bottom: 20px;">
                                <p style="font-size: 12px; color: #94a3b8; margin-bottom: 2px;">Diusulkan oleh:</p>
                                <p style="font-size: 14px; font-weight: 600; color: #334155;">Dr. Isaac Kiehn - FST</p>
                                <p style="font-size: 12px; color: #64748b;">bdvg@gmail.com</p>
                            </div>
                            <button class="btn-edit" style="width: 100%; padding: 10px 0;">Edit Data Permintaan</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <a href="#" class="fab-button" @click.prevent="openCreateModal()">+</a>

        <div class="modal-overlay" x-show="showRequestModal" x-transition.opacity x-cloak>
            <div class="modal-container" @click.away="showRequestModal = false">
                
                <div class="modal-header">
                    <h2 class="modal-title" x-text="modalTitle"></h2>
                    <button class="modal-close" @click="showRequestModal = false">×</button>
                </div>
                
                <form action="#" method="POST">
                    <div class="modal-content">
                        
                        <p style="font-size: 14px; color: #64748b; margin-bottom: 20px;">Silahkan isi data buku yang ingin diajukan. Bagian dengan tanda <span class="required-star">*</span> wajib diisi.</p>
                        
                        <div class="section-card">
                            <h3 class="section-title">Data Pemohon</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">No Anggota <span class="required-star">*</span></label>
                                    <input type="text" class="form-input" x-model="formData.member_id" placeholder="Masukkan No. Anggota" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Pemohon <span class="required-star">*</span></label>
                                    <input type="text" class="form-input" x-model="formData.requester_name" placeholder="Masukkan Nama Lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email <span class="required-star">*</span></label>
                                    <input type="email" class="form-input" x-model="formData.email" placeholder="contoh@unair.ac.id" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Fakultas <span class="required-star">*</span></label>
                                    <select class="form-input" x-model="formData.faculty" required style="cursor: pointer; appearance: auto;">
                                        <option value="" disabled>Pilih Fakultas</option>
                                        @if(isset($faculties))
                                            @foreach($faculties as $fakultas)
                                                <option value="{{ $fakultas }}">{{ $fakultas }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="section-card">
                            <h3 class="section-title">Data Buku</h3>
                            <div class="form-grid">
                                <div>
                                    <div class="form-group">
                                        <label class="form-label">Judul Buku <span class="required-star">*</span></label>
                                        <input type="text" class="form-input" x-model="formData.book_title" placeholder="Input Judul Buku" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Pengarang <span class="required-star">*</span></label>
                                        <input type="text" class="form-input" x-model="formData.author" placeholder="Input Nama Pengarang" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Penerbit</label>
                                        <input type="text" class="form-input" x-model="formData.publisher" placeholder="Input Nama Penerbit">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Kota Terbit</label>
                                        <input type="text" class="form-input" x-model="formData.publication_city" placeholder="Input Kota Terbit">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tahun Terbit</label>
                                        <input type="text" class="form-input" x-model="formData.publication_year" placeholder="Input Tahun Terbit">
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="form-group">
                                        <label class="form-label">Jenis Bahan <span class="required-star">*</span></label>
                                        <select class="form-input" x-model="formData.material_type" required style="cursor: pointer; appearance: auto;">
                                            <option value="" disabled>Pilih Jenis Bahan</option>
                                            @if(isset($materialTypes))
                                                @foreach($materialTypes as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="required-star">*</span></label>
                                        <select class="form-input" x-model="formData.status" required style="cursor: pointer; appearance: auto;">
                                            <option value="" disabled>Pilih Status</option>
                                            @if(isset($statuses))
                                                @foreach($statuses as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">Keterangan</label>
                                        <textarea class="form-input" x-model="formData.notes" rows="6" placeholder="Masukkan keterangan tambahan jika ada..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" @click="showRequestModal = false">Batal</button>
                        <button type="submit" class="btn-submit">
                            <span x-show="modalMode === 'create'">Kirim Permintaan</span>
                            <span x-show="modalMode === 'update'">Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>