CREATE TABLE users (
    id int AUTO_INCREMENT PRIMARY KEY,
    nama varchar(100),
    username varchar(100),
    email varchar(100),
    password varchar(100),
    role varchar(20),
    nomor_telp varchar(20),
    instansi varchar(100),
    created_at date DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pembatasan (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(100),
    tanggal date,
    sampah_sebelum float null,
    sampah_sesudah float null
);

CREATE TABLE pemanfaatan (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(100),
    jenis_sampah ENUM('organik','anorganik'),
    botol_kaca float null,
    kemasan_plastik float null,
    kaleng_alumunium float null,
    kemasan_kaleng_cat float null,
    ban_bekas float null,
    sisa_makanan float null,
    tanggal date,
    bukti varchar(255)
);

CREATE TABLE daur_ulang (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(100),
    jenis_sampah ENUM('organik','anorganik'),
    kertas float null,
    karton float null,
    botol_plastik float null,
    besi float null,
    aluminium float null,
    lainnya_anorganik float null,
    pengomposan float null,
    eco_enzim float null,
    lainnya_organik float null,
    tanggal date,
    bukti varchar(255)
);

CREATE TABLE bank_sampah (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(100),
    jenis_sampah ENUM('organik','anorganik'),
    kertas float null,
    karton float null,
    botol_pet float null,
    besi float null,
    aluminium float null,
    plastik float null,
    lainnya_anorganik float null,
    pengomposan float null,
    eco_enzim float null,
    maggot float null,
    tanggal date,
    bukti varchar(255)
);