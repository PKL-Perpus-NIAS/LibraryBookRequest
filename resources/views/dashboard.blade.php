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
        
        /* Baris Baru untuk Chart Fakultas */
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
        <div class="chart-container" id="chartTahunan"></div>
        <div class="chart-container" id="chartJenisBuku"></div>
    </div>

    <div class="full-chart-wrapper">
        <div class="chart-header">
            <h3 class="chart-title">Top 5 Fakultas Teraktif</h3>
            <a href="#" class="see-more-link">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
        <div id="chartFakultas" style="height: 300px;"></div>
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
            <tbody>
                @foreach($latestRequests as $req)
                <tr>
                    <td><strong>REQ-{{ str_pad($req->id, 3, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $req->book_title }}</td>
                    <td>{{ $req->requester_name }}</td>
                    <td>{{ $req->faculty }}</td>
                    <td>{{ $req->email }}</td>
                    <td>
                        @if($req->status == 'processing')
                            <span class="badge badge-process">Dalam Proses</span>
                        @elseif($req->status == 'pending_purchase')
                            <span class="badge" style="background: #fee2e2; color: #991b1b;">Menunggu Beli</span>
                        @else
                            <span class="badge badge-success">Tersedia</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script>

        Highcharts.setOptions({
            colors: ['#003366', '#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
            chart: { style: { fontFamily: 'Inter, sans-serif' } },
            title: { style: { color: '#003366', fontWeight: 'bold' } }
        });

        Highcharts.chart('chartTahunan', {
            chart: { type: 'column' },
            title: { text: 'Permintaan Buku Per-Tahun', align: 'left' },
            xAxis: { categories: @json($yearlyData->pluck('year')) },
            yAxis: { min: 0, title: { text: 'Jumlah Judul' } },
            tooltip: { headerFormat: '<span style="font-size:10px">{point.key}</span><table>', pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y} buku</b></td></tr>', footerFormat: '</table>', shared: true, useHTML: true },
            plotOptions: { column: { pointPadding: 0.2, borderWidth: 0, borderRadius: 5 } },
            series: [{ 
                name: 'Request Masuk', 
                data: @json($yearlyData->pluck('count')), 
                color: '#3B82F6' 
            }], 
            legend: { enabled: false }
        });

        // Chart Jenis Buku (Pie)
        Highcharts.chart('chartJenisBuku', {
            chart: { type: 'pie' },
            title: { text: 'Jenis Buku', align: 'left' },
            subtitle: { text: 'Klik "Lainnya" untuk melihat detail' },
            tooltip: { pointFormat: '{series.name}: <b>{point.y} Buku</b> ({point.percentage:.1f}%)' },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)',
                        style: { fontSize: '11px' }
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: @json($typeData)
            }],
            drilldown: {
                series: [{
                    name: 'Detail Lainnya',
                    id: 'lainnya-detail',
                    data: @json($drilldownData)
                }]
            }
        });

        Highcharts.chart('chartFakultas', {
            chart: { type: 'bar' },
            title: { text: null },
            xAxis: { categories: @json($facultyData->pluck('faculty'))},
            yAxis: { min: 0, title: { text: 'Total Permintaan', align: 'high' }, labels: { overflow: 'justify' }, gridLineWidth: 0 },
            tooltip: { valueSuffix: ' permintaan' },
            plotOptions: { bar: { borderRadius: '50%', dataLabels: { enabled: true } } }, 
            legend: { enabled: false },
            credits: { enabled: false },
            series: [{
                name: 'Jumlah Request',
                data: @json($facultyData->pluck('total')),
                color: '#003366'
            }],
        });
    </script>
</x-app-layout>