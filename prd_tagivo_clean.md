# Product Requirement Document (PRD)
**Project Name:** Tagivo (Simple Invoice Generator)  
**Version:** 1.0 (MVP)  
**Tech Stack:** Laravel 11, Tailwind CSS v3, MySQL 8.0

---

## 1. Executive Summary & Product Vision

### 1.1 Product Purpose
Tagivo adalah platform berbasis web (*Simple Invoice Generator*) yang dirancang khusus untuk mempermudah freelancer, pemilik UMKM, dan bisnis skala kecil dalam membuat, mengelola, dan mendistribusikan invoice profesional secara cepat langsung dari perangkat seluler maupun desktop. Fokus utama Tagivo adalah kecepatan tanpa hambatan registrasi di awal, kemudahan pengisian data, serta optimasi tampilan yang sangat responsif di layar ponsel (*Mobile-First Approach*).

### 1.2 Problem Statement
Sebagian besar pelaku usaha mikro berpindah dari laptop ke *smartphone* untuk mengelola operasional bisnis harian mereka. Namun, aplikasi pembuat invoice yang ada saat ini sering kali memiliki antarmuka formulir yang rumit, padat, dan tidak ramah layar sentuh kecil, atau mewajibkan proses *onboarding* berbelit-belit sebelum pengguna bisa mengunduh selembar invoice.

### 1.3 Value Proposition
* **Instant & No Sign-Up:** Buka situs Tagivo, isi formulir, langsung simpan. Tanpa hambatan login di awal penggunaan.
* **Mobile-First Responsiveness:** Antarmuka formulir dan pratinjau didesain secara adaptif dengan optimasi khusus pada navigasi dan kenyamanan ketuk di layar ponsel pintar.
* **Persistent Shareable Links:** Setiap invoice yang disimpan menghasilkan tautan unik yang aman untuk dibagikan langsung kepada klien via WhatsApp atau platform pesan lainnya.

---

## 2. User Roles & Personas

Dalam fase MVP ini, sistem mendefinisikan dua peran pengguna utama yang berinteraksi dengan aplikasi:

| Peran Pengguna | Deskripsi | Hubungan dengan Sistem |
| :--- | :--- | :--- |
| **Issuer (Pembuat Invoice)** | Freelancer atau pemilik UMKM yang bermobilisasi tinggi dan membutuhkan dokumen penagihan pembayaran instan. | Mengisi form penagihan via HP/Desktop, menyimpan data ke sistem, mengunduh PDF, dan menyebarkan tautan invoice. |
| **Client (Penerima Invoice)** | Pihak ketiga (perusahaan atau individu) yang menerima dokumen penagihan. | Mengakses tautan unik invoice secara publik, melihat detail tagihan (*Web View* adaptif), dan mengunduh berkas PDF melalui perangkat mereka sendiri. |

---

## 3. System Architecture & Database Design

### 3.1 Technical Stack Choice
* **Backend:** Laravel 11 (Routing, Validasi Data, dan Blade Templating).
* **Frontend:** Tailwind CSS (Styling responsif dengan pendekatan *Mobile-First* dan utilitas cetak `print:`).
* **Database:** MySQL 8.0 (Penyimpanan data relasional invoice).

### 3.2 Database Schema Plan
Sistem menggunakan skema relasional *one-to-many* antara tabel induk `invoices` dan tabel detail `invoice_items`.

#### 3.2.1 Atribut Tabel: `invoices`
Mencatat informasi utama dokumen penagihan beserta nominal akumulasinya.
* `id` (Primary Key)
* `invoice_number` (Unik)
* `view_slug` (String acak unik untuk keamanan URL)
* `sender_name`, `sender_email`, `sender_address`
* `client_name`, `client_email`, `client_address`
* `invoice_date`, `due_date`
* `tax_percentage`, `discount_amount`
* `subtotal`, `grand_total`
* `status` (Unpaid, Paid, Overdue)

#### 3.2.2 Atribut Tabel: `invoice_items`
Mencatat setiap baris komoditas barang atau jasa yang ditagihkan.
* `id` (Primary Key)
* `invoice_id` (Foreign Key terhubung ke tabel invoices)
* `item_name`
* `quantity`
* `unit_price`
* `total_price`

---

## 4. Functional Requirements (Kebutuhan Fungsional)

### 4.1 Modul Pembuatan Invoice (Mobile-First Layout)
* **FR-01 (Nomor Invoice Otomatis):** Sistem wajib memuat kode string unik sebagai nomor invoice bawaan saat halaman dibuka, namun tetap mengizinkan pengguna mengubahnya secara manual jika diperlukan.
* **FR-02 (Baris Item Dinamis Ramah Mobile):** Pengguna dapat menambah baris item baru atau menghapus baris item yang sudah ada tanpa memicu muat ulang halaman. Pada layar mobile, input item diatur bertumpuk vertikal dengan area ketuk (*tap target*) yang cukup besar untuk kenyamanan jari tangan.
* **FR-03 (Kalkulasi Otomatis Sisi Klien):** Sistem secara dinamis menghitung akumulasi total secara langsung sewaktu angka kuantitas atau harga diketik oleh pengguna tanpa perlu menekan tombol hitung.

### 4.2 Modul Penyimpanan & Distribusi
* **FR-04 (Generasi Tautan Unik Terproteksi):** Setelah menekan tombol simpan, sistem membuat string acak sepanjang 32 karakter kriptografi aman (`view_slug`) untuk mengamankan URL invoice dari serangan tebak ID (IDOR).

### 4.3 Modul Web View & Export (Tailwind Responsif & Print)
* **FR-05 (Web View Adaptif Klien):** Saat klien mengakses tautan invoice, sistem menampilkan halaman statis invoice profesional yang bersih. Di layar ponsel, tabel item bertransisi menjadi format kartu (*card layout*) agar teks tidak terpotong ke samping. Semua tombol input formulir disembunyikan.
* **FR-06 (Cetak Browser Ramah Cetak):** Menggunakan utilitas cetak dari Tailwind CSS untuk otomatis menyembunyikan elemen hiasan seperti tombol cetak, tombol navigasi, atau footer web saat aksi cetak browser (`Ctrl + P`) dipicu.
* **FR-07 (Ekspor PDF Sisi Server):** Menyediakan tombol khusus "Download PDF" yang memicu sistem backend untuk merender dokumen menjadi berkas PDF murni agar bisa disimpan secara luring.

---

## 5. Non-Functional Requirements (Kebutuhan Non-Fungsional)

### 5.1 Kinerja, Aksesibilitas, & Mobile Optimization
* **Responsivitas Antarmuka Maksimal:** Tampilan web wajib lolos pengujian responsivitas seluler dengan teks yang mudah dibaca tanpa perlu memperbesar layar (*pinch-to-zoom*).
* **Tanpa Registrasi Awal:** User tidak perlu mendaftar akun untuk langsung mengoperasikan alat ini demi meminimalkan hambatan penggunaan.

### 5.2 Keamanan & Integritas Data
* **Proteksi CSRF & Sanitasi Input:** Seluruh pengiriman data formulir ke backend wajib dilindungi token keamanan untuk mencegah eksploitasi siber, dan kueri database wajib disanitasi penuh untuk menutup celah serangan SQL Injection.

---

## 6. User Flow Diagram

```
[Mulai] 
   │
   ▼
Akses Landing Page Tagivo via Browser HP / Laptop
   │
   ▼
Isi Informasi Bisnis, Klien, & Tanggal Tagihan
   │
   ▼
Tambah Item Jasa/Barang ───► (Sistem Hitung Otomatis Subtotal & Grand Total)
   │
   ▼
Klik Tombol "Simpan & Buat Tautan"
   │
   ├───► Gagal Validasi ───► Tampilkan Pesan Error Spesifik di Atas Form
   │
   ▼ Berhasil Validasi
Simpan ke MySQL & Generate Objek 'view_slug'
   │
   ▼
Sistem Mengalihkan ke Halaman Preview Sukses (/invoice/{view_slug})
   │
   ├───────────────────────────────┐
   ▼                               ▼
Tombol "Download PDF"       Salin Tautan (Share Link) 
(Mengunduh File)            Kirim ke Klien via WhatsApp/Email
   │                               │
   └───────────────┬───────────────┘
                   ▼
                [Selesai]
```

---

## 7. Rencana Pengembangan Masa Depan (Future Backlog)
1. **Multi-Currency Support:** Menambahkan opsi pemilihan mata uang internasional disertai konversi atau simbol otomatis.
2. **User Authentication (Sistem Akun):** Fitur registrasi opsional bagi pengguna yang ingin menyimpan histori riwayat invoice terdahulu dan manajemen database klien tetap.
3. **Direct Email Dispatcher:** Mengirimkan notifikasi tagihan berupa PDF langsung dari sistem server ke alamat surel klien.