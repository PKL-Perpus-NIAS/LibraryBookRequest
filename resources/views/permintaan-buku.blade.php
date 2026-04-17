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

        .modern-select {
            appearance: none;
            -webkit-appearance: none;
            background-color: white;
            color: #003566;
            padding: 12px 40px 12px 20px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            /* Panah kustom SVG warna biru gelap */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23003566'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            min-width: 180px;
        }
        .modern-select:hover { border-color: #003566; }
        .modern-select:focus { outline: none; box-shadow: 0 0 0 3px rgba(0, 53, 102, 0.1); border-color: #003566; }

        .icon-group { display: flex; gap: 12px; margin-left: auto; align-items: center; }
        .icon-box { 
            background-color: white; border: 3px solid #003566; width: 42px; height: 38px; 
            border-radius: 6px; cursor: pointer; transition: all 0.2s ease;
        }
        .icon-box.active { box-shadow: 0 0 0 4px rgba(0, 53, 102, 0.2); transform: scale(1.05); }

        .sort-header {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: white;
            text-decoration: none;
            transition: color 0.2s;
            white-space: nowrap;
        }
        .sort-header:hover { color: #facc15; } 
        .sort-icon-wrapper {
            display: flex;
            align-items: center;
        }
        .sort-icon { 
            width: 14px; 
            height: 14px; 
            stroke: currentColor; 
        }
        .sort-icon.inactive { opacity: 0.3; }
        .sort-icon.active { color: #facc15; } 

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

        /* --- STYLE UNTUK TOMBOL IKON EDIT & DELETE --- */
        .action-buttons { display: flex; gap: 8px; justify-content: center; align-items: center; }
        .btn-icon { 
            width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; 
            border: none; cursor: pointer; color: white; transition: all 0.2s;
        }
        .btn-icon-edit { background-color: #3B82F6; } 
        .btn-icon-edit:hover { background-color: #2563EB; transform: translateY(-2px); }
        .btn-icon-delete { background-color: #EF4444; } 
        .btn-icon-delete:hover { background-color: #DC2626; transform: translateY(-2px); }

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
        
/* --- TOAST NOTIFICATION --- */
.toast-container { position: fixed; top: 40px; right: 40px; z-index: 9999; }
        .toast-alert {
            background-color: #10B981;
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 14px;
            /* Animasi masuk tetap mantul */
            animation: springIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        @keyframes springIn {
            0% { opacity: 0; transform: translateX(100%) scale(0.9); }
            100% { opacity: 1; transform: translateX(0) scale(1); }
        }
        .toast-close { background: transparent; border: none; color: rgba(255, 255, 255, 0.8); cursor: pointer; margin-left: 10px; padding: 0; display: flex; align-items: center; transition: all 0.2s; }
        .toast-close:hover { color: white; transform: scale(1.2) rotate(90deg); }
    </style>

<div class="page-container" 
        x-data="{ 
            viewMode: 'normal', 
            showRequestModal: false, 
            showDeleteModal: false, /* BARU: Untuk kontrol pop-up delete */
            deleteId: null,         /* BARU: Menyimpan ID buku yang mau dihapus */
            modalTitle: 'Form Usulan Koleksi', 
            modalMode: 'create',
            formData: {
                id: null, requester_name: '', email: '', faculty: '', book_title: '', author: '', publisher: '', publication_city: '', publication_year: '', 
                type_of_material: '', notes: '', status: 'pending_purchase'
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
            openDeleteModal(id) { 
                this.deleteId = id;
                this.showDeleteModal = true;
            },
            resetForm() {
                this.formData = { id: null, requester_name: '', email: '', faculty: '', book_title: '', author: '', publisher: '', publication_city: '', publication_year: '', type_of_material: '', notes: '', status: 'pending_purchase' };
            },
            fillForm(data) {
                this.formData = { ...this.formData, ...data }; 
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
                <select name="faculty" class="modern-select" onchange="this.form.submit()">
                    <option value="">Semua Fakultas</option>
                    @if(isset($faculties))
                        @foreach($faculties as $fakultas)
                            <option value="{{ $fakultas }}" {{ request('faculty') == $fakultas ? 'selected' : '' }}>{{ $fakultas }}</option>
                        @endforeach
                    @endif
                </select>

                <select name="status" class="modern-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    @if(isset($statuses))
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    @endif
                </select>

                <select name="year" class="modern-select" onchange="this.form.submit()">
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
                        @php 
                            $sort = request('sort', 'id'); 
                            $dir = request('dir', 'desc'); 
                        @endphp

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'dir' => ($sort == 'id' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                No Request
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'id' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'id' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'book_title', 'dir' => ($sort == 'book_title' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Judul Buku
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'book_title' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'book_title' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'type_of_material', 'dir' => ($sort == 'type_of_material' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Jenis Bahan
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'type_of_material' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'type_of_material' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'author', 'dir' => ($sort == 'author' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Pengarang
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'author' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'author' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'publisher', 'dir' => ($sort == 'author' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Penerbit
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'publisher' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'publisher' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'publication_city', 'dir' => ($sort == 'author' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Kota Terbit
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'publication_city' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'publication_city' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'publication_year', 'dir' => ($sort == 'author' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Tahun Terbit
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'publication_year' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'publication_year' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'faculty', 'dir' => ($sort == 'author' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Facultas
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'faculty' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'faculty' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'requester_name', 'dir' => ($sort == 'author' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Pengarang
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'requester_name' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'requester_name' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'dir' => ($sort == 'author' && $dir == 'asc') ? 'desc' : 'asc']) }}" class="sort-header">
                                Email
                                <div class="sort-icon-wrapper">
                                    @if($sort == 'email' && $dir == 'asc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                                    @elseif($sort == 'email' && $dir == 'desc')
                                        <svg class="sort-icon active" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    @else
                                        <svg class="sort-icon inactive" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 15 12 20 17 15"></polyline><polyline points="7 9 12 4 17 9"></polyline></svg>
                                    @endif
                                </div>
                            </a>
                        </th>

                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($requests) && $requests->count() > 0)
                        @foreach($requests as $index => $req)
                            <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                                <td><strong>{{ $req->request_number }}</strong></td>
                                <td>{{ $req->book_title }}</td>
                                <td>{{ $req->type_of_material }}</td>
                                <td>{{ $req->author }}</td>
                                <td>{{ $req->publisher }}</td>
                                <td>{{ $req->publication_city }}</td>
                                <td>{{ $req->publication_year }}</td>
                                <td>{{ $req->faculty }}</td>
                                <td style="font-weight: 700;">{{ $req->requester_name }}</td>
                                <td>{{ $req->email }}</td>
                                <td title="{{ $req->notes }}" style="color: #64748b; font-size: 13px;">
                                    {{ $req->notes ? Str::limit($req->notes, 20) : '-' }}
                                </td>
                                <td>
                                    @php
                                        $bgColor = '#eab308'; $statusText = 'Dalam Proses';
                                        if($req->status == 'pending_purchase') { $bgColor = '#ef4444'; $statusText = 'Menunggu'; }
                                        if($req->status == 'available') { $bgColor = '#22c55e'; $statusText = 'Selesai'; }
                                    @endphp
                                    <span class="status-badge" style="background-color: {{ $bgColor }};">{{ $statusText }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-icon-edit" @click='openEditModal(@json($req))' title="Edit Data">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="btn-icon btn-icon-delete" @click='openDeleteModal({{ $req->id }})' title="Hapus Data">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
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
                        <th>Keterangan</th>
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
                                <td title="{{ $req->notes }}" style="font-size: 13px; color: #475569; font-style: italic;">
                                    {{ $req->notes ? Str::limit($req->notes, 40) : '-' }}
                                </td>
                                <td><span class="status-badge" style="background-color: {{ $bgColor }};">{{ $statusText }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-icon-edit" @click='openEditModal(@json($req))' title="Edit Data">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="btn-icon btn-icon-delete" @click='openDeleteModal({{ $req->id }})' title="Hapus Data">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
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
                                @if($req->notes)
                                <div style="margin-top: 12px; padding: 10px; background-color: #f8fafc; border-radius: 6px; border-left: 3px solid #cbd5e1;">
                                    <p style="font-size: 12px; color: #475569; font-style: italic; margin: 0; line-height: 1.4;" title="{{ $req->notes }}">
                                        "{{ Str::limit($req->notes, 70) }}"
                                    </p>
                                </div>
                            @endif
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <button class="btn-edit" style="flex: 1; padding: 10px 0; display: flex; justify-content: center; align-items: center; gap: 6px; background-color: #3B82F6;" @click='openEditModal(@json($req))'>
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Edit
                                </button>
                                <button class="btn-edit" style="padding: 10px 15px; background-color: #EF4444; border: none; display: flex; justify-content: center; align-items: center;" @click='openDeleteModal({{ $req->id ?? 0 }})'>
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
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
                
                <form :action="modalMode === 'create' ? '/permintaan-buku' : '/permintaan-buku/' + formData.id" method="POST" action="/permintaan-buku">
                    @csrf
                    
                    <input type="hidden" name="_method" :value="modalMode === 'update' ? 'PUT' : 'POST'">
                    
                    <div class="modal-content">
                        <p style="font-size: 14px; color: #64748b; margin-bottom: 20px;">Silahkan isi data buku yang ingin diajukan. Bagian dengan tanda <span class="required-star">*</span> wajib diisi.</p>
                        
                        <div class="section-card">
                            <h3 class="section-title">Data Pemohon</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">No. Request</label>
                                    <input type="text" class="form-input read-only" :value="modalMode === 'create' ? 'Dibuat Otomatis' : formData.id" readonly disabled style="background-color: #e2e8f0; color: #64748b; font-weight: 600; cursor: not-allowed; border-style: dashed;">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama Pemohon <span class="required-star">*</span></label>
                                    <input type="text" name="requester_name" class="form-input" x-model="formData.requester_name" placeholder="Masukkan Nama Lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email <span class="required-star">*</span></label>
                                    <input type="email" name="email" class="form-input" x-model="formData.email" placeholder="contoh@unair.ac.id" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Fakultas <span class="required-star">*</span></label>
                                    <select name="faculty" class="form-input" x-model="formData.faculty" required style="cursor: pointer; appearance: auto;">
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
                                        <input type="text" name="book_title" class="form-input" x-model="formData.book_title" placeholder="Input Judul Buku" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Pengarang <span class="required-star">*</span></label>
                                        <input type="text" name="author" class="form-input" x-model="formData.author" placeholder="Input Nama Pengarang" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Penerbit</label>
                                        <input type="text" name="publisher" class="form-input" x-model="formData.publisher" placeholder="Input Nama Penerbit">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Kota Terbit</label>
                                        <input type="text" name="publication_city" class="form-input" x-model="formData.publication_city" placeholder="Input Kota Terbit">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tahun Terbit</label>
                                        <input type="number" name="publication_year" class="form-input" x-model="formData.publication_year" placeholder="Input Tahun Terbit">
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="form-group">
                                        <label class="form-label">Jenis Bahan <span class="required-star">*</span></label>
                                        <select name="type_of_material" class="form-input" x-model="formData.type_of_material" required style="cursor: pointer; appearance: auto;">
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
                                        <select name="status" class="form-input" x-model="formData.status" required style="cursor: pointer; appearance: auto;">
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
                                        <textarea name="notes" class="form-input" x-model="formData.notes" rows="6" placeholder="Masukkan keterangan tambahan jika ada..."></textarea>
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
        <div class="toast-container">
            @if(session('success'))
                <div class="toast-container" 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-init="setTimeout(() => show = false, 4000)"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-8">
                    
                    <div class="toast-alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        
                        <span>{{ session('success') }}</span>

                        <button @click="show = false" class="toast-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <div class="modal-overlay" x-show="showDeleteModal" x-transition.opacity x-cloak>
            <div class="modal-container" @click.away="showDeleteModal = false" style="max-width: 400px; text-align: center; padding: 30px;">
                <div style="background: #fee2e2; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; color: #ef4444;">
                    <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 10px;">Hapus Data Usulan?</h3>
                <p style="font-size: 14px; color: #64748b; margin-bottom: 25px;">Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus data ini dari sistem secara permanen?</p>
                
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" @click="showDeleteModal = false" style="padding: 10px 20px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; font-weight: 600; color: #475569; cursor: pointer;">Batal</button>
                    <form :action="'/permintaan-buku/' + deleteId" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding: 10px 20px; border-radius: 6px; border: none; background: #ef4444; font-weight: 600; color: white; cursor: pointer;">Ya, Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>