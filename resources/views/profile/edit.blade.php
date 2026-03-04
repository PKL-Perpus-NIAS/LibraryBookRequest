<x-app-layout>
    <style>
        /* Gaya untuk Label */
        .modern-modal label {
            display: block; font-weight: 600; color: #475569; font-size: 14px; margin-bottom: 5px;
        }
        
        /* Gaya untuk Input Text, Email, Password */
        .modern-modal input[type="text"],
        .modern-modal input[type="email"],
        .modern-modal input[type="password"] {
            width: 100%; padding: 12px 16px; margin-bottom: 20px;
            border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #334155;
            box-sizing: border-box; transition: all 0.3s ease; background-color: #fff;
        }
        
        /* Efek saat form diklik (Focus) */
        .modern-modal input:focus {
            border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Gaya Tombol Utama (Save) */
        .modern-modal button {
            background-color: #1e40af; color: white; padding: 10px 24px; border: none;
            border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px;
            transition: background-color 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .modern-modal button:hover {
            background-color: #1e3a8a;
        }

        /* Gaya khusus Tombol Delete Account */
        .modern-modal section:last-child button,
        .modern-modal button[type="submit"][class*="red"], /* Menangkap tombol merah bawaan breeze */
        .modern-modal form[action*="destroy"] button {
            background-color: #dc2626 !important;
        }
        .modern-modal form[action*="destroy"] button:hover {
            background-color: #b91c1c !important;
        }

        /* Gaya Judul & Deskripsi di dalam form bawaan Breeze */
        .modern-modal header h2 { font-size: 18px; font-weight: bold; color: #1e293b; margin-bottom: 4px; }
        .modern-modal header p { font-size: 14px; color: #64748b; margin-bottom: 24px; }
    </style>

    <div style="filter: blur(4px); pointer-events: none; opacity: 0.6;">
        <div class="header-page" style="padding: 20px 20px 0 20px;">
            <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px; border-bottom: 2px solid #1e40af; padding-bottom: 10px; display: inline-block;">Profil</h1>
        </div>
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin: 0 20px 20px 20px; display: flex; gap: 40px; flex-wrap: wrap;">
            <div style="width: 250px; flex-shrink: 0;">
                <div style="width: 100%; height: 320px; background-color: #e2e8f0; border: 1px solid #cbd5e1; border-radius: 6px;"></div>
            </div>
            <div style="flex: 1; min-width: 300px;">
                <div style="width: 100%; height: 300px; background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 6px;"></div>
            </div>
        </div>
    </div>

    <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.65); z-index: 999; display: flex; align-items: center; justify-content: center;">
        
        <div class="modern-modal" style="background-color: white; width: 60vw; min-width: 500px; max-height: 85vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); position: relative; padding: 40px; box-sizing: border-box;">
            
            <a href="{{ route('profile') }}" style="position: absolute; top: 20px; right: 25px; font-size: 28px; font-weight: bold; color: #94a3b8; text-decoration: none; cursor: pointer; transition: color 0.2s;">&times;</a>

            <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px;">
                Pengaturan Akun
            </h2>

            <div style="display: flex; flex-direction: column; gap: 35px;">
                
                <div style="padding: 25px; border: 1px solid #e2e8f0; border-radius: 10px; background-color: #f8fafc;">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div style="padding: 25px; border: 1px solid #e2e8f0; border-radius: 10px; background-color: #f8fafc;">
                    @include('profile.partials.update-password-form')
                </div>

                <div style="padding: 25px; border: 1px solid #fecaca; border-radius: 10px; background-color: #fef2f2;">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
        </div>
    </div>
</x-app-layout>