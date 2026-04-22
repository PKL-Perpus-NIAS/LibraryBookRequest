    <x-app-layout>
        <style>
            .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
            .stat-card { background: white; border-radius: 8px; display: flex; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
            .stat-icon { width: 80px; display: flex; align-items: center; justify-content: center; color: white; }
            .stat-icon svg { widht: 32px; height: 32px; }
            .stat-info { padding: 15px; flex: 1; }
            .stat-value { font-size: 28px; font-weight: bold; color: #003366; }
            .stat-label { font-size: 14px; color: #64748B; font-weight: 500; }

            .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px; }
            .chart-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
            
            .full-chart-wrapper { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
            .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
            .chart-title { margin: 0; color: #003366; font-weight: bold; font-size: 18px; }
            .see-more-link { text-decoration: none; color: #3B82F6; font-weight: 600; font-size: 14px; display: flex; align-items: center; transition: color 0.2s;}
            .see-more-link:hover { color: #1d4ed8; }
            .see-more-link svg { width: 16px; height: 16px; margin-left: 5px; }

            .table-wrapper { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; overflow-x: auto; }
            table { width: 100%; border-collapse: collapse; text-align: left; }
            th { background-color: #f8fafc; color: #64748b; font-weight: 600; padding: 12px 15px; border-bottom: 2px solid #edf2f7; font-size: 13px; text-transform: uppercase; }
            td { padding: 12px 15px; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #334155; }
            tr:hover { background-color: #f1f5f9; }
            .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
            .badge-process { background: #fef3c7; color: #92400e; }
            .badge-success { background: #dcfce7; color: #166534; }

            .hc-spinner { width: 40px; height: 40px; border: 4px solid #e2e8f0; border-top: 4px solid #003566; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 10px auto; }
            @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
            .hc-loading-text { font-weight: 600; color: #003566; font-size: 14px; font-family: 'Inter', sans-serif; }
        </style>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #003566;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Permintaan</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #F59E0B;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                    <div class="stat-info">
                    <div class="stat-value">{{ $stats['processing'] }}</div>
                    <div class="stat-label">Dalam Proses</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #EF4444;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                    <div class="stat-info">
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">Menunggu Pembelian</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #10B981;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                    <div class="stat-info">
                    <div class="stat-value">{{ $stats['available'] }}</div>
                    <div class="stat-label">Buku Sudah Tersedia</div>
                </div>
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-container" id="chartTahunan" style="min-height: 350px;"></div>
            <div class="chart-container" id="chartJenisBuku" style="min-height: 350px;"></div>
        </div>

        <div class="full-chart-wrapper">
            <div class="chart-header">
                <h3 class="chart-title" id="fakultasTitle">Top 5 Fakultas Teraktif</h3>
                <a href="#" class="see-more-link" id="toggleFakultasBtn">
                    <span id="toggleFakultasText">Selengkapnya</span>
                    <svg id="toggleFakultasIcon" style="transition: transform 0.3s ease;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
            <div id="chartFakultas" style="height: 300px; transition: height 0.4s ease;"></div>
        </div>

        <div class="table-wrapper">
            <div class="chart-header">
                <h3 class="chart-title">Daftar Permintaan Terbaru</h3>
                <a href="{{ route('permintaan.index') }}" class="see-more-link">Lihat Semua Data</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No. Request</th>
                        <th>Nama Buku</th>
                        <th>Nama Peminta</th>
                        <th>Fakultas</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="latestRequestsTableBody">
                    <tr><td colspan="6" style="text-align: center; padding: 20px;">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.0/highcharts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.0/modules/drilldown.js"></script>

        <script>
            Highcharts.setOptions({
                colors: ['#003366', '#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
                chart: { style: { fontFamily: 'Inter, sans-serif' }, animation: { duration: 500 } },
                title: { style: { color: '#003366', fontWeight: 'bold' } },
                lang: { loading: '<div class="hc-spinner"></div><div class="hc-loading-text">Loading...</div>' },
                loading: { labelStyle: { display: 'block', textAlign: 'center' }, style: { backgroundColor: '#ffffff', opacity: 0.9 } }
            });

            const chartTahunan = Highcharts.chart('chartTahunan', {
                chart: { type: 'column' },
                title: { text: 'Permintaan Buku Per-Tahun', align: 'left' },
                yAxis: { min: 0, title: { text: 'Jumlah Judul' } },
                tooltip: { shared: true, useHTML: true },
                plotOptions: { column: { pointPadding: 0.2, borderWidth: 0, borderRadius: 5 } },
                legend: { enabled: false },
                series: []
            });

            const chartJenisBuku = Highcharts.chart('chartJenisBuku', {
                chart: { type: 'pie' },
                title: { text: 'Jenis Buku', align: 'left' },
                tooltip: { pointFormat: '{series.name}: <b>{point.y} Buku</b> ({point.percentage:.1f}%)' },
                plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.y}' }, showInLegend: true } },
                series: [] 
            });

            const chartFakultas = Highcharts.chart('chartFakultas', {
                chart: { type: 'bar' },
                title: { text: null },
                yAxis: { min: 0, title: { text: 'Total Permintaan' }, gridLineWidth: 0 },
                plotOptions: { bar: { borderRadius: '50%', dataLabels: { enabled: true } } }, 
                legend: { enabled: false },
                credits: { enabled: false },
                series: [] 
            });

            chartTahunan.showLoading();
            chartJenisBuku.showLoading();
            chartFakultas.showLoading();

            fetch('/api/statistik-permintaan')
                .then(response => response.json())
                .then(res => {
                    const data = res.data; 
                    const categoriesTahun = data.tahunan.map(item => item.year);
                    const countTahun = data.tahunan.map(item => parseFloat(item.count));
                    chartTahunan.update({ xAxis: { categories: categoriesTahun } });
                    chartTahunan.addSeries({ name: 'Request Masuk', data: countTahun, color: '#3B82F6' });
                    chartTahunan.hideLoading();

                    let rawJenis = data.jenis_buku.map(item => ({ 
                        name: item.name || item.type_of_material, 
                        y: parseFloat(item.y || item.total || item.count) 
                    }));
                    rawJenis.sort((a, b) => b.y - a.y); 
                    let formattedJenis = [];
                    let drilldownData = [];
                    if (rawJenis.length > 5) {
                        formattedJenis = rawJenis.slice(0, 4); 
                        let sisaBuku = rawJenis.slice(4); 
                        let totalSisa = sisaBuku.reduce((sum, item) => sum + item.y, 0);
                        formattedJenis.push({
                            name: 'Lainnya',
                            y: totalSisa,
                            drilldown: 'lainnya-detail' 
                        });
                        drilldownData = sisaBuku.map(item => [item.name, item.y]);
                    } else {
                        formattedJenis = rawJenis; 
                    }
                    chartJenisBuku.addSeries({ name: 'Jumlah', colorByPoint: true, data: formattedJenis });
                    if (drilldownData.length > 0) {
                        chartJenisBuku.update({
                            drilldown: {
                                series: [{
                                    name: 'Detail Lainnya',
                                    id: 'lainnya-detail',
                                    data: drilldownData
                                }]
                            }
                        });
                    }
                    chartJenisBuku.hideLoading();

                    const top5Fakultas = data.fakultas.slice(0, 5);
                    const catFakultas = top5Fakultas.map(item => item.faculty);
                    const countFakultas = top5Fakultas.map(item => parseFloat(item.total));
                    chartFakultas.update({ xAxis: { categories: catFakultas } });
                    chartFakultas.addSeries({ name: 'Jumlah Request', data: countFakultas, color: '#003366' });
                    chartFakultas.hideLoading();

                    window.allFakultasCategories = data.fakultas.map(item => item.faculty);
                    window.allFakultasTotals = data.fakultas.map(item => parseFloat(item.total));
                    window.top5FakultasCategories = catFakultas;
                    window.top5FakultasTotals = countFakultas;

                    const tbody = document.getElementById('latestRequestsTableBody');
                    if (data.latest_requests && data.latest_requests.length > 0) {
                        tbody.innerHTML = ''; 

                        data.latest_requests.forEach(req => {
                            // 2. KITA PANGGIL LANGSUNG DARI DATABASE BIAR KEREN
                            // Kalau request_number kosong (data lama), baru pakai id biasa
                            const formattedId = req.request_number ? req.request_number : 'REQ-' + String(req.id).padStart(3, '0');
                            
                            // Tentukan Badge Status
                            let badgeHtml = '';
                            if (req.status === 'processing') {
                                badgeHtml = '<span class="badge badge-process">Dalam Proses</span>';
                            } else if (req.status === 'pending_purchase') {
                                badgeHtml = '<span class="badge" style="background: #fee2e2; color: #991b1b;">Menunggu Beli</span>';
                            } else {
                                badgeHtml = '<span class="badge badge-success">Tersedia</span>';
                            }

                            // Buat baris tabel baru
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td><strong>${formattedId}</strong></td>
                                <td>${req.book_title}</td>
                                <td>${req.requester_name}</td>
                                <td>${req.faculty}</td>
                                <td>${req.email}</td>
                                <td>${badgeHtml}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada data permintaan.</td></tr>';
                    }

                }) 
                .catch(error => {
                    console.error('Waduh gagal narik API:', error);
                    chartTahunan.hideLoading(); chartJenisBuku.hideLoading(); chartFakultas.hideLoading();
                });

            let isShowingAll = false;
            const toggleBtn = document.getElementById('toggleFakultasBtn');
            const titleEl = document.getElementById('fakultasTitle');
            const toggleText = document.getElementById('toggleFakultasText');
            const toggleIcon = document.getElementById('toggleFakultasIcon');
            const containerFakultas = document.getElementById('chartFakultas');

            if(toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if(!window.allFakultasCategories) return; 

                    isShowingAll = !isShowingAll;
                    if (isShowingAll) {
                        titleEl.textContent = 'Distribusi Seluruh Fakultas';
                        toggleText.textContent = 'Tampilkan Lebih Sedikit';
                        toggleIcon.style.transform = 'rotate(180deg)';                
                        const newHeight = Math.max(300, window.allFakultasCategories.length * 40);
                        containerFakultas.style.height = newHeight + 'px';
                        chartFakultas.setSize(null, newHeight, {duration: 400});
                        chartFakultas.update({ xAxis: { categories: window.allFakultasCategories }, series: [{ data: window.allFakultasTotals }] });
                    } else {
                        titleEl.textContent = 'Top 5 Fakultas Teraktif';
                        toggleText.textContent = 'Selengkapnya';
                        toggleIcon.style.transform = 'rotate(0deg)'; 
                        containerFakultas.style.height = '300px';
                        chartFakultas.setSize(null, 300, {duration: 400});
                        chartFakultas.update({ xAxis: { categories: window.top5FakultasCategories }, series: [{ data: window.top5FakultasTotals }] });
                    }
                });
            }
        </script>
    </x-app-layout>