<x-app-layout>
    <div class="header-page" style="padding: 20px 20px 0 20px;">
        <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px; border-bottom: 2px solid #1e40af; padding-bottom: 10px; display: inline-block;">Profil</h1>
    </div>

    <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px 20px; margin: 0 20px 20px 20px; border-radius: 4px; display: flex; align-items: flex-start; gap: 12px;">
        <svg style="color: #3b82f6; width: 20px; height: 20px; margin-top: 2px; flex-shrink: 0;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div style="font-size: 13px; color: #1e3a8a; line-height: 1.5;">
            <strong>Informasi Terintegrasi:</strong> Data profil (Nama, NIP, Fakultas, dll) di bawah ini ditarik secara otomatis dari sistem pusat (Cybercampus). Jika terdapat ketidaksesuaian data, harap melakukan perubahan melalui portal akademik utama kampus.
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin: 0 20px 20px 20px; display: flex; gap: 40px; flex-wrap: wrap;">
        
        <div style="width: 250px; flex-shrink: 0;">
            
        @php
                $avatarUrl = null;
                $photo = auth()->user()->profile_photo;
                
                if ($photo) {
                    if (Str::startsWith($photo, ['http://', 'https://'])) {
                        $avatarUrl = $photo;
                    } else {
                        $avatarUrl = asset('storage/' . $photo);
                    }
                } else {
                    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=1e40af&background=eff6ff&size=300&font-size=0.33';
                }
            @endphp

            <div style="width: 100%; height: 320px; background-color: #f8fafc; border-radius: 8px; overflow: hidden; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <img src="{{ $avatarUrl }}" alt="Foto Profil {{ auth()->user()->name }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </div>

            <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 12px;">
                <a href="{{ route('profile.edit') }}" style="display: block; width: 100%; text-align: center; padding: 10px 0; background-color: white; border: 1px solid #cbd5e1; border-radius: 6px; color: #334155; font-size: 12px; font-weight: bold; text-decoration: none; text-transform: uppercase; box-sizing: border-box;">
                    Edit Password
                </a>
                
                <button style="width: 100%; padding: 10px 0; background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; color: #dc2626; font-size: 12px; font-weight: bold; cursor: pointer; text-transform: uppercase;">
                    Hapus Akun
                </button>
            </div>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; text-align: left;">
                <tbody>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; width: 160px; color: #475569;">Status Anggota</td>
                        <td style="padding: 16px 0; width: 20px;">:</td>
                        <td style="padding: 16px 0;">
                            <span style="background-color: #22c55e; color: white; padding: 5px 12px; border-radius: 4px; font-size: 12px; font-weight: bold;">Aktif</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">NIP</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">{{ auth()->user()->nip ?? '-' }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">Nama</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">{{ auth()->user()->name }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">Tempat Lahir</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">{{ auth()->user()->tempat_lahir ?? '-' }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">Tanggal Lahir</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">
                            {{ auth()->user()->tanggal_lahir ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d F Y') : '-' }}
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">Alamat</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">{{ auth()->user()->alamat ?? '-' }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">Nomor HP</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">{{ auth()->user()->no_hp ?? '-' }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">Strata</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">{{ auth()->user()->strata ?? 'S1' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 16px 0; font-weight: 600; color: #475569;">Email</td>
                        <td style="padding: 16px 0;">:</td>
                        <td style="padding: 16px 0; color: #0f172a;">{{ auth()->user()->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>