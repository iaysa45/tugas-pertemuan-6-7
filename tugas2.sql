-- =========================
-- 1. DATABASE
-- =========================
CREATE DATABASE perpustakaan;
USE perpustakaan;

-- =========================
-- 2. TABEL KATEGORI
-- =========================
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

-- =========================
-- 3. TABEL PENERBIT
-- =========================
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT
);

-- =========================
-- 4. TABEL BUKU (VERSI TUGAS 2 LENGKAP)
-- =========================
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(20) UNIQUE NOT NULL,
    judul VARCHAR(200) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL, -- versi teks (sesuai tugas)
    tahun_terbit INT NOT NULL,
    isbn VARCHAR(20),
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    id_kategori INT,
    id_penerbit INT,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
);

-- KATEGORI
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Programming','Buku coding'),
('Database','Buku basis data'),
('AI','Kecerdasan buatan'),
('Jaringan','Networking'),
('Desain','Desain grafis');

-- PENERBIT
INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Informatika','Bandung','0811111111','info@informatika.com'),
('Elex Media','Jakarta','0822222222','info@elex.com'),
('Gramedia','Jakarta','0833333333','info@gramedia.com'),
('Andi','Yogyakarta','0844444444','info@andi.com'),
('Deepublish','Yogyakarta','0855555555','info@deepublish.com');

-- BUKU (15 DATA)
INSERT INTO buku (judul, pengarang, tahun_terbit, harga, stok, id_kategori, id_penerbit) VALUES
('Belajar PHP','Budi Raharjo',2024,90000,10,1,1),
('Mastering MySQL','Andi',2023,120000,5,2,2),
('Dasar AI','Siti Aminah',2024,150000,7,3,3),
('Jaringan Komputer','Rudi',2022,80000,12,4,4),
('Desain Grafis','Ani',2021,70000,8,5,5),
('Laravel Guide','Budi Raharjo',2024,95000,6,1,2),
('Python AI','Dewi',2023,140000,4,3,1),
('Cisco Networking','Agus',2022,110000,9,4,3),
('UI UX Design','Rina',2023,85000,3,5,4),
('SQL Advanced','Andi',2024,130000,5,2,5),
('Machine Learning','Siti Aminah',2023,160000,2,3,1),
('HTML CSS','Budi Raharjo',2022,60000,11,1,2),
('Database Design','Rudi',2021,100000,7,2,3),
('Photoshop Basic','Ani',2022,75000,6,5,4),
('Network Security','Agus',2024,125000,4,4,5);

-- =========================
-- 8. QUERY RELASI (BIAR KELIHATAN KEREN PAS DEMO)
-- =========================
SELECT 
    buku.kode_buku,
    buku.judul,
    buku.pengarang,
    buku.penerbit,
    kategori.nama_kategori,
    penerbit.nama_penerbit
FROM buku
JOIN kategori ON buku.id_kategori = kategori.id_kategori
JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit;

-- Jumlah buku per kategori
SELECT k.nama_kategori, COUNT(*) AS jumlah_buku
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
GROUP BY k.nama_kategori;

-- Jumlah buku per penerbit
SELECT p.nama_penerbit, COUNT(*) AS jumlah_buku
FROM buku b
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
GROUP BY p.nama_penerbit;

-- Detail lengkap buku
SELECT 
    b.*,
    k.nama_kategori,
    p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;