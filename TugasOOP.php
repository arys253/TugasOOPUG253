<?php

class Buku {
    private $judul;
    private $idBuku;
    private $penulis;
    private $stok;

    public function __construct($judul, $idBuku, $penulis, $stok) {
        $this->judul = $judul;
        $this->idBuku = $idBuku;
        $this->penulis = $penulis;
        $this->stok = $stok;
    }

    public function getJudul() {
        return $this->judul;
    }
    public function getIdBuku() {
        return $this->idBuku;
    }
    public function getPenulis() {
        return $this->penulis;
    }
    public function getStok() {
        return $this->stok;
    }

    public function kurangiStok() {
        if ($this->stok > 0) {
            $this->stok--;
            return true;
        }
        return false;
    }

    public function tambahStok() {
        $this->stok++;
    }

    public function tampilkanInfo() {
        echo "Judul : {$this->judul} <br>";
        echo "ID Buku : {$this->idBuku} <br>";
        echo "Penulis : {$this->penulis} <br>";
        echo "Stok : {$this->stok} <br>";
    }
}

class Anggota {
    private $nama;
    private $nim;

    public function __construct($nama, $nim) {
        $this->nama = $nama;
        $this->nim = $nim;
    }

    public function getNama() {
        return $this->nama;
    }
    public function getNim() {
        return $this->nim;
    }

    public function tampilkanInfo() {
        echo "Nama : {$this->nama} <br>";
        echo "NIM : {$this->nim} <br>";
    }
}

class Peminjaman {
    private $anggota;
    private $buku;
    private $tglPinjam;
    private $tglKembalikan = null;
    private $status = "belum diproses";

    public function __construct(Anggota $anggota, Buku $buku, $tglPinjam) {
        $this->anggota = $anggota;
        $this->buku = $buku;
        $this->tglPinjam = $tglPinjam;
    }

    public function pinjam() {
        if ($this->buku->kurangiStok()) {
            $this->status = "dipinjam";
            echo "{$this->anggota->getNama()} berhasil meminjam buku \"{$this->buku->getJudul()}\".<br>";
        } else {
            echo "Peminjaman gagal: stok buku \"{$this->buku->getJudul()}\" habis.<br>";
        }
    }

    public function kembalikan($tglKembalikan) {
        if ($this->status === "dipinjam") {
            $this->buku->tambahStok();
            $this->tglKembalikan = $tglKembalikan;
            $this->status = "dikembalikan";
            echo "Buku \"{$this->buku->getJudul()}\" telah dikembalikan.<br>";
        } else {
            echo "Pengembalian gagal: buku belum dipinjam.<br>";
        }
    }

    public function tampilkanInfo() {
        $this->anggota->tampilkanInfo();
        echo "Buku : {$this->buku->getJudul()} <br>";
        echo "Tanggal pinjam : {$this->tglPinjam} <br>";
        echo "Tanggal kembali : " . ($this->tglKembalikan ?? "-") . "<br>";
        echo "Status : {$this->status} <br>";
    }
}

// Uji coba
$buku = new Buku("Pemrograman PHP", "B001", "Andi", 1);
$anggota = new Anggota("Arys", "250030639");

$p1 = new Peminjaman($anggota, $buku, "2026-10-24");
$p1->pinjam();
$p1->tampilkanInfo();

echo "<br>";

$p2 = new Peminjaman($anggota, $buku, "2026-10-24");
$p2->pinjam();

echo "<br>";

$p1->kembalikan("2026-10-31");
$p1->tampilkanInfo();