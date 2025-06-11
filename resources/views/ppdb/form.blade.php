<!DOCTYPE html>
<html lang="id" x-data="app">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB 2025/2026 - SKB DINAS PENDIDIKAN KOTA PALEMBANG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#1d4ed8',
                        accent: '#f59e0b',
                        success: '#10b981',
                        darkblue: '#1e3a8a',
                        lightblue: '#93c5fd',
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .form-section {
            transition: all 0.3s ease;
        }
        .gradient-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .input-focus {
            transition: all 0.3s;
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
            border-color: #2563eb;
        }
        .radio-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .file-upload-label:hover {
            background-color: #e5e7eb;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100">
<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="gradient-header text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="bg-white rounded-xl p-3 mr-4">
                    <div class="w-16 h-16 bg-white flex items-center justify-center rounded-lg">
                            <img src="https://dinaspendidikankotapalembang.com/image/logo.png" alt="Logo" class="w-full h-full object-contain">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold tracking-tight">SKB DINAS PENDIDIKAN KOTA PALEMBANG</h1>
                        <p class="text-blue-100 text-sm md:text-base mt-1">Penerimaan Peserta Didik Baru Tahun 2025/2026</p>
                    </div>
                    </div>
                <div class="bg-white text-primary px-6 py-3 rounded-xl shadow-lg">
                    <p class="font-bold text-sm md:text-base">Formulir Pendaftaran Online</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Progress Indicator -->
    <div class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex flex-col items-center relative">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center relative z-10 transform hover:scale-110 transition" 
                         x-bind:class="{'bg-accent': currentStep > 1}">
                        <span x-show="currentStep === 1" class="font-bold">1</span>
                        <i x-show="currentStep > 1" class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-xs mt-2 font-medium" 
                          x-bind:class="{'text-primary font-bold': currentStep === 1, 'text-gray-500': currentStep !== 1}">Data Diri & Pendidikan</span>
                </div>
                <div class="flex-1 h-1 mx-2 bg-gray-200 relative">
                    <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-primary to-accent transition-all duration-500 ease-in-out" 
                         x-bind:style="'width: ' + (currentStep >= 2 ? '100%' : '0%')"></div>
                </div>
                <div class="flex flex-col items-center relative">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center relative z-10 transform hover:scale-110 transition" 
                         x-bind:class="{'bg-primary text-white': currentStep === 2, 'bg-gray-200 text-gray-600': currentStep < 2, 'bg-accent text-white': currentStep > 2}">
                        <span x-show="currentStep <= 2" class="font-bold">2</span>
                        <i x-show="currentStep > 2" class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-xs mt-2 font-medium" 
                          x-bind:class="{'text-primary font-bold': currentStep === 2, 'text-gray-500': currentStep !== 2}">Data Orang Tua</span>
                </div>
                <div class="flex-1 h-1 mx-2 bg-gray-200 relative">
                    <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-primary to-accent transition-all duration-500 ease-in-out" 
                         x-bind:style="'width: ' + (currentStep >= 3 ? '100%' : '0%')"></div>
                </div>
                <div class="flex flex-col items-center relative">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center relative z-10 transform hover:scale-110 transition" 
                         x-bind:class="{'bg-primary text-white': currentStep === 3, 'bg-gray-200 text-gray-600': currentStep < 3}">
                        <span class="font-bold">3</span>
                    </div>
                    <span class="text-xs mt-2 font-medium" 
                          x-bind:class="{'text-primary font-bold': currentStep === 3, 'text-gray-500': currentStep !== 3}">Upload Dokumen</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Form Header -->
            <div class="gradient-header px-8 py-6">
                <h2 class="text-2xl font-bold text-white">Formulir Pendaftaran PPDB</h2>
                <p class="text-blue-100 text-sm md:text-base">Isi data dengan lengkap dan benar</p>
            </div>

            <!-- Form Content -->
            <form class="px-8 py-6" action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <!-- Step 1: Data Diri & Pendidikan -->
                <div x-show="currentStep === 1" class="form-section space-y-6">
                    <h3 class="text-xl font-bold mb-6 text-primary border-b-2 border-primary pb-3 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-circle text-primary"></i>
                        </div>
                        Data Pribadi Calon Siswa
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" x-model="formData.nama_lengkap" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="L" x-model="formData.jenis_kelamin" required
                                        class="h-5 w-5 text-primary focus:ring-primary border-2 border-gray-300">
                                    <span class="ml-3 text-gray-700 font-medium">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="P" x-model="formData.jenis_kelamin"
                                        class="h-5 w-5 text-primary focus:ring-primary border-2 border-gray-300">
                                    <span class="ml-3 text-gray-700 font-medium">Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir" x-model="formData.tempat_lahir" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" x-model="formData.tanggal_lahir" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition text-gray-700">
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Agama <span class="text-red-500">*</span></label>
                            <select name="agama" x-model="formData.agama" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition text-gray-700">
                                <option value="" class="text-gray-400">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katholik">Katholik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
                        </div>
                        <!-- Pekerjaan -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                            <input type="text" name="pekerjaan" x-model="formData.pekerjaan" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400" 
                                   placeholder="Siswa/Mahasiswa/Pelajar">
                        </div>
                        <!-- Kebangsaan -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kebangsaan <span class="text-red-500">*</span></label>
                            <input type="text" name="kebangsaan" x-model="formData.kebangsaan" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-600" 
                                   value="WNI" readonly>
                        </div>
                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat" x-model="formData.alamat" rows="3" required
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400"></textarea>
                        </div>
                        <!-- Kontak -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">No. HP/WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp" x-model="formData.no_hp" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" x-model="formData.email" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                        </div>
                        <!-- Jenjang Asal -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Paket Belajar <span class="text-red-500">*</span></label>
                            <select name="paket" x-model="formData.paket" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition text-gray-700">
                                <option value="" class="text-gray-400">Pilih Paket Belajar</option>
                                <option value="A">Paket A</option>
                                <option value="B">Paket B</option>
                                <option value="C">Paket C</option>
                            </select>
                        </div>
                        <!-- Nama Lembaga -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lembaga (SMP/MTs) <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lembaga" x-model="formData.nama_lembaga" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                        </div>
                        <!-- Alamat Lembaga -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lembaga <span class="text-red-500">*</span></label>
                            <textarea name="alamat_lembaga" x-model="formData.alamat_lembaga" rows="3" required
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400"></textarea>
                        </div>
                    </div>
                </div>
            
                <!-- Step 2: Data Orang Tua -->
                <div x-show="currentStep === 2" class="form-section space-y-6">
                    <h3 class="text-xl font-bold mb-6 text-primary border-b-2 border-primary pb-3 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        Data Orang Tua/Wali
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data Ayah -->
                        <div class="md:col-span-2 bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                            <h4 class="font-bold text-lg text-primary mb-4 flex items-center">
                                <i class="fas fa-male mr-2"></i> Data Ayah Kandung
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_ayah" x-model="formData.nama_ayah" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                                    <input type="text" name="pekerjaan_ayah" x-model="formData.pekerjaan_ayah" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400"
                                        placeholder="Masukkan pekerjaan ayah">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Data Ibu -->
                        <div class="md:col-span-2 bg-gradient-to-r from-pink-50 to-pink-100 p-6 rounded-xl border border-pink-200">
                            <h4 class="font-bold text-lg text-pink-700 mb-4 flex items-center">
                                <i class="fas fa-female mr-2"></i> Data Ibu Kandung
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_ibu" x-model="formData.nama_ibu" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                                    <input type="text" name="pekerjaan_ibu" x-model="formData.pekerjaan_ibu" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400"
                                        placeholder="Masukkan pekerjaan ibu">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kontak Orang Tua -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">No. HP Orang Tua <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp_ortu" x-model="formData.no_hp_ortu" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl input-focus transition placeholder-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Step 3: Upload Dokumen -->
                <div x-show="currentStep === 3" class="form-section space-y-6">
                    <h3 class="text-xl font-bold mb-6 text-primary border-b-2 border-primary pb-3 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-file-upload text-primary"></i>
                        </div>
                        Upload Persyaratan Dokumen
                    </h3>
                    
                    <div class="space-y-6">
                       <!-- Kartu Keluarga -->
                        <div class="bg-white p-6 rounded-xl border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Upload Kartu Keluarga (KK)</label>
                            <div class="flex items-center">
                                <!-- Input File dan Label -->
                                <div x-data="{ fileName: '' }" class="flex-grow">
                                    <input type="file" name="kk" id="kk" accept=".pdf"
                            @change="fileName = $event.target.files[0]?.name; formData.kk = $event.target.files[0]" required
                            class="hidden">
                                    <label for="kk" class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-4 py-3 rounded-lg border border-gray-300 flex items-center justify-between transition file-upload-label">
                                        <span x-text="fileName || 'Pilih file PDF'" class="text-gray-700 truncate"></span>
                                        <i class="fas fa-cloud-upload-alt text-gray-500 ml-3"></i>
                                    </label>

                                    <!-- Tombol hapus file -->
                                    <div x-show="fileName" class="mt-2 text-right">
                                        <button type="button"
                                                @click="fileName = ''; formData.kk = null; document.getElementById('kk').value = ''"
                                                class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Format: PDF (Maksimal 2MB)</p>
                        </div>

                        <!-- Akta Kelahiran -->
                        <div class="bg-white p-6 rounded-xl border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Upload Akta Kelahiran</label>
                            <div class="flex items-center">
                                <div x-data="{ fileName: '' }" class="flex-grow">
                                    <input type="file" name="akta" id="akta" accept=".pdf" @change="fileName = $event.target.files[0]?.name; formData.akta = $event.target.files[0]" required
                                           class="hidden">
                                    <label for="akta" class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-4 py-3 rounded-lg border border-gray-300 flex items-center justify-between transition file-upload-label">
                                        <span x-text="fileName || 'Pilih file PDF'" class="text-gray-700 truncate"></span>
                                        <i class="fas fa-cloud-upload-alt text-gray-500 ml-3"></i>
                                    </label>
                                </div>
                                 <!-- Tombol hapus file -->
                                 <div x-show="fileName" class="mt-2 text-right">
                                        <button type="button"
                                                @click="fileName = ''; formData.akta = null; document.getElementById('akta').value = ''"
                                                class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Hapus
                                        </button>
                                    </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Format: PDF (Maksimal 2MB)</p>
                        </div>
                        
                        <!-- Ijazah/SKHUN -->
                        <div class="bg-white p-6 rounded-xl border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Upload Ijazah/SKHUN</label>
                            <div class="flex items-center">
                                <div x-data="{ fileName: '' }" class="flex-grow">
                                    <input type="file" name="ijazah" id="ijazah" accept=".pdf" @change="fileName = $event.target.files[0]?.name; formData.ijazah = $event.target.files[0]"
                                           class="hidden">
                                    <label for="ijazah" class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-4 py-3 rounded-lg border border-gray-300 flex items-center justify-between transition file-upload-label">
                                        <span x-text="fileName || 'Pilih file PDF'" class="text-gray-700 truncate"></span>
                                        <i class="fas fa-cloud-upload-alt text-gray-500 ml-3"></i>
                                    </label>
                                </div>
                                <!-- Tombol hapus file -->
                                <div x-show="fileName" class="mt-2 text-right">
                                        <button type="button"
                                                @click="fileName = ''; formData.ijazah = null; document.getElementById('ijazah').value = ''"
                                                class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Hapus
                                        </button>
                                    </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Format: PDF (Maksimal 2MB)</p>
                        </div>
                        
                        <!-- Pas Foto -->
                        <div class="bg-white p-6 rounded-xl border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Upload Pas Foto 3x4</label>
                            <div class="flex items-center">
                                <div x-data="{ fileName: '' }" class="flex-grow">
                                    <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png" @change="fileName = $event.target.files[0]?.name; formData.foto = $event.target.files[0]" required
                                           class="hidden">
                                    <label for="foto" class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-4 py-3 rounded-lg border border-gray-300 flex items-center justify-between transition file-upload-label">
                                        <span x-text="fileName || 'Pilih file (PDF/JPG/PNG)'" class="text-gray-700 truncate"></span>
                                        <i class="fas fa-cloud-upload-alt text-gray-500 ml-3"></i>
                                    </label>
                                </div>
                                 <!-- Tombol hapus file -->
                                 <div x-show="fileName" class="mt-2 text-right">
                                        <button type="button"
                                                @click="fileName = ''; formData.foto = null; document.getElementById('foto').value = ''"
                                                class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Hapus
                                        </button>
                                    </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Format: PDF/JPG/PNG (Maksimal 2MB)</p>
                        </div>
                        
                        <!-- Pernyataan -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-5 rounded-lg border border-gray-200">
                            <div class="flex items-start">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="pernyataan" name="pernyataan" type="checkbox" x-model="formData.pernyataan" value="1" required
                                           class="h-5 w-5 text-primary focus:ring-primary border-2 border-gray-300 rounded">
                                </div>
                                <div class="ml-4">
                                    <label for="pernyataan" class="font-bold text-gray-700">Dengan ini saya menyatakan bahwa semua data dan dokumen yang saya upload adalah benar dan asli.</label>
                                    <p class="text-sm text-gray-600 mt-1">Data dan dokumen yang sudah dikirim tidak dapat diubah kembali. Pastikan semua data dan dokumen yang Anda upload sudah benar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-10 border-t pt-8">
                    <button type="button" @click="prevStep" x-show="currentStep > 1" 
                            class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 font-bold">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </button>
                    <button type="button" @click="nextStep" x-show="currentStep < 3" 
                            class="ml-auto px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-darkblue hover:to-primary focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 font-bold shadow-md hover:shadow-lg">
                        Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                    <button type="submit" x-show="currentStep === 3" 
                            class="ml-auto px-6 py-3 bg-gradient-to-r from-success to-green-600 text-white rounded-xl hover:from-green-600 hover:to-success focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-300 font-bold shadow-md hover:shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="gradient-header text-white py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-lg font-bold">SKB Dinas Pendidikan Kota Palembang</h3>
                    <p class="text-blue-100 text-sm">Jl. Pendidikan No. 123, Palembang - Sumatera Selatan</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-blue-400 mt-4 pt-4 text-center text-sm text-blue-100">
                © 2025 SKB Dinas Pendidikan Kota Palembang. All rights reserved.
            </div>
        </div>
    </footer>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            currentStep: 1,
            formData: {
                // Data Pribadi
                nama_lengkap: '',
                jenis_kelamin: '',
                tempat_lahir: '',
                tanggal_lahir: '',
                agama: '',
                pekerjaan: '',
                kebangsaan: 'WNI',
                alamat: '',
                no_hp: '',
                email: '',
                
                // Data Pendidikan
                asal_sekolah: '',
                nama_lembaga: '',
                alamat_lembaga: '',
                
                // Data Orang Tua
                nama_ayah: '',
                pekerjaan_ayah: '',
                nama_ibu: '',
                pekerjaan_ibu: '',
                no_hp_ortu: '',
                
                // Upload Dokumen
                kk: null,
                akta: null,
                ijazah: null,
                foto: null,
                
                // Pernyataan
                pernyataan: false
            },
            
            nextStep() {
                if (this.validateStep()) {
                    this.currentStep++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            
            prevStep() {
                this.currentStep--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            
            validateStep() {
                if (this.currentStep === 1) {
                    if (!this.formData.nama_lengkap || 
                        !this.formData.jenis_kelamin || 
                        !this.formData.tempat_lahir || 
                        !this.formData.tanggal_lahir || 
                        !this.formData.agama || 
                        !this.formData.pekerjaan || 
                        !this.formData.alamat || 
                        !this.formData.no_hp || 
                        !this.formData.email || 
                        !this.formData.paket || 
                        !this.formData.nama_lembaga || 
                        !this.formData.alamat_lembaga) {
                        alert('Harap lengkapi semua data pribadi dan pendidikan!');
                        return false;
                    }
                } else if (this.currentStep === 2) {
                    if (!this.formData.nama_ayah || 
                        !this.formData.pekerjaan_ayah || 
                        !this.formData.nama_ibu || 
                        !this.formData.pekerjaan_ibu || 
                        !this.formData.no_hp_ortu) {
                        alert('Harap lengkapi semua data orang tua!');
                        return false;
                    }
                }
                return true;
            },
            
            async submitForm() {
                // Validasi final sebelum submit
                if (!this.formData.kk || 
                    !this.formData.akta || 
                    !this.formData.ijazah || 
                    !this.formData.foto || 
                    !this.formData.pernyataan) {
                    alert('Harap lengkapi semua dokumen dan centang pernyataan!');
                    return;
                }

                // Buat FormData untuk mengirim file
                const formData = new FormData();
                
                // Tambahkan semua data form
                Object.keys(this.formData).forEach(key => {
                    if (key !== 'pernyataan') { // Skip pernyataan karena akan dihandle terpisah
                        formData.append(key, this.formData[key]);
                    }
                });
                
                // Tambahkan pernyataan sebagai boolean
                formData.append('pernyataan', this.formData.pernyataan ? '1' : '0');

                try {
                    // Kirim data ke server
                    const response = await fetch('{{ route("ppdb.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert('Pendaftaran berhasil dikirim!');
                        this.resetForm();
                        window.location.href = '{{ route("ppdb.create") }}';
                    } else {
                        // Tampilkan pesan error dari server
                        const errorMessage = result.message || 'Terjadi kesalahan saat mengirim data';
                        throw new Error(errorMessage);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                }
            },
            
            resetForm() {
                this.formData = {
                    nama_lengkap: '',
                    jenis_kelamin: '',
                    tempat_lahir: '',
                    tanggal_lahir: '',
                    agama: '',
                    pekerjaan: '',
                    kebangsaan: 'WNI',
                    alamat: '',
                    no_hp: '',
                    email: '',
                    paket: '',
                    nama_lembaga: '',
                    alamat_lembaga: '',
                    nama_ayah: '',
                    pekerjaan_ayah: '',
                    nama_ibu: '',
                    pekerjaan_ibu: '',
                    no_hp_ortu: '',
                    kk: null,
                    akta: null,
                    ijazah: null,
                    foto: null,
                    pernyataan: false
                };
                this.currentStep = 1;
            }
        }));
    });
</script>
</body>
</html>