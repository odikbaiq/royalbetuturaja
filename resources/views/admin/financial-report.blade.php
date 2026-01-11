@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="row mb-4 d-print-none">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1 text-royal"><i class="fas fa-file-invoice-dollar me-2"></i>Laporan Keuangan</h3>
                        <p class="text-muted mb-0">Ringkasan performa bisnis Royal Betutu Raja.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-dark rounded-pill px-4" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Cetak PDF
                        </button>
                        <button class="btn btn-royal rounded-pill px-4 text-white" onclick="exportToExcel()">
                            <i class="fas fa-file-excel me-2"></i>Export Excel Professional
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none d-print-block text-center mb-5">
        <h1 class="fw-bold" style="color: #700505;">ROYAL BETUTU RAJA</h1>
        <h4 class="mt-4 text-uppercase border-bottom pb-2">Laporan Pendapatan Tahunan - {{ request('year', date('Y')) }}</h4>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 stat-card-custom">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Total Pendapatan</p>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                        </div>
                        <div class="icon-box bg-success-light text-success"><i class="fas fa-wallet"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 stat-card-custom">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Rata-rata Bulanan</p>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($rataRata, 0, ',', '.') }}</h2>
                        </div>
                        <div class="icon-box bg-royal-light text-royal"><i class="fas fa-chart-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 stat-card-custom">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        @php
                            $best = $monthlyData->sortByDesc('revenue')->first();
                            $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        @endphp
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Bulan Terbaik</p>
                            <h2 class="fw-bold mb-0">{{ $best && $best->revenue > 0 ? $months[$best->month - 1] : 'N/A' }}</h2>
                        </div>
                        <div class="icon-box bg-gold-light text-gold"><i class="fas fa-trophy"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Tren Grafik</h5>
                    <div class="d-print-none">
                        <select class="form-select rounded-pill" id="yearSelect">
                            @for($y = date('Y'); $y >= date('Y')-4; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="revenueChart" style="height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0" id="financialTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0">BULAN</th>
                                <th class="text-end pe-4 py-3 border-0">PENDAPATAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 12; $i++)
                                @php
                                    $data = $monthlyData->where('month', $i)->first();
                                    $val = $data ? $data->revenue : 0;
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-semibold text-muted">{{ $months[$i-1] }}</td>
                                    <td class="text-end pe-4 fw-bold {{ $val > 0 ? 'text-dark' : 'text-light' }}">
                                        Rp {{ number_format($val, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f4f7f6; font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-royal { color: #700505 !important; }
    .btn-royal { background-color: #700505; color: white; }
    .btn-royal:hover { background-color: #5a0404; color: white; }

    .icon-box {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }

    .bg-success-light { background: rgba(40, 167, 69, 0.1); }
    .bg-royal-light { background: rgba(112, 5, 5, 0.1); }
    .bg-gold-light { background: rgba(197, 160, 89, 0.1); text-color: #c5a059; }
    .text-gold { color: #c5a059 !important; }

    .stat-card-custom { border-bottom: 4px solid #700505; transition: 0.3s; }
    .stat-card-custom:hover { transform: translateY(-5px); }

    @media print {
        .d-print-none { display: none !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        .container-fluid { width: 100% !important; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. FILTER TAHUN
    document.getElementById('yearSelect').addEventListener('change', function() {
        window.location.href = "?year=" + this.value;
    });

    // 2. CHART JS
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const rawData = @json($monthlyData);
    const dataPoints = new Array(12).fill(0);
    rawData.forEach(item => { dataPoints[item.month - 1] = item.revenue; });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Pendapatan Bulanan',
                data: dataPoints,
                backgroundColor: '#700505',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
            }
        }
    });
});

// 3. EXCEL EXPORT (PROFESSIONAL VERSION)
function exportToExcel() {
    const table = document.getElementById("financialTable");
    const year = document.getElementById("yearSelect").value;

    // Inisialisasi workbook
    const wb = XLSX.utils.book_new();

    // Buat data array untuk Excel agar rapi (tidak langsung dari tabel agar bisa kita atur formatnya)
    const data = [
        ["LAPORAN KEUANGAN ROYAL BETUTU RAJA"],
        ["Tahun:", year],
        [""],
        ["Bulan", "Pendapatan (IDR)"]
    ];

    // Ambil baris dari tabel HTML
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach(row => {
        const bulan = row.cells[0].innerText;
        // Hapus "Rp" dan "." agar Excel mengenali sebagai Angka/Number
        const nominal = parseInt(row.cells[1].innerText.replace(/[^0-9]/g, "")) || 0;
        data.push([bulan, nominal]);
    });

    // Buat Sheet
    const ws = XLSX.utils.aoa_to_sheet(data);

    // Styling Kolom (Lebar Kolom)
    ws['!cols'] = [{ wch: 20 }, { wch: 25 }];

    // Tambah ke Workbook
    XLSX.utils.book_append_sheet(wb, ws, "Financial Report");

    // Download file
    XLSX.writeFile(wb, `Laporan_Keuangan_RoyalBetutu_${year}.xlsx`);
}
</script>
@endsection
