<?php
namespace model;
require_once './model/BaseClass.php';
class Pesanan extends BaseClass {
    public $conn;
    public $id_session;
    public $id_pesanan;
    public $pesanan = [];
    public $nomor_pesanan;
    public $user_id;
    public function __construct($conn, $user_id = null)
    {
        $this->conn = $conn;
        $this->id_session = session_id();
        $timestamp = time();
        // Memformat tanggal
        $formatted_date = date("YmdHis", $timestamp);
        $this->nomor_pesanan = "order-".$formatted_date;
        $this->user_id = $user_id;
    }

    public function store($total_harga, $nama_penerima, $alamat, $kode_pos, $kota)
    {
        $query = "INSERT INTO pesanan (total_harga, session_id, nama_penerima, alamat, kota, kode_pos, nomor_pesanan, user_id) 
                                    VALUES ($total_harga, '$this->id_session', '$nama_penerima', '$alamat', '$kota', '$kode_pos', '$this->nomor_pesanan', '$this->user_id')";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            $this->error = true;
            $this->message = 'Error: ' . mysqli_error($this->conn);
            return;
        }
        $this->id_pesanan = mysqli_insert_id($this->conn);
        return;
    }

    public function selectBy($id)
    {
        $query = "SELECT * FROM pesanan where id = '$id'";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            $this->error = true;
            $this->errorMessage = 'Error: ' . mysqli_error($this->conn);
            return;
        }

        $this->pesanan = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $this->pesanan;
    }

    public function selectByOrderNumber($nomor_pesanan)
    {
        $query = "SELECT * FROM pesanan WHERE nomor_pesanan = '$nomor_pesanan'";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            $this->error = true;
            $this->errorMessage = 'Error: ' . mysqli_error($this->conn);
            return;
        }

        $this->pesanan = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $this->pesanan;   
    }

    public function updateStatus($id_pesanan, $status)
    {
        $query = "UPDATE pesanan set status_pesanan = '$status' where id = '$id_pesanan'";
        $result = mysqli_query($this->conn, $query);

        if ( !$result ) {
            $this->error = true;
            $this->errorMessage = 'Error: ' . mysqli_error($this->conn);
        }
        return;
    }

    public function getAllPesanan()
    {
        $query = "SELECT * FROM pesanan";
        $result = mysqli_query($this->conn, $query);
        while ($row = $result->fetch_assoc()) {
            $this->pesanan[] = $row;
        }
        return $this->pesanan;
    }

    public function getByUserId()
    {
        $query = "SELECT * FROM pesanan WHERE user_id = '$this->user_id'";
        $result = mysqli_query($this->conn, $query);
        while ($row = $result->fetch_assoc()) {
            $this->pesanan[] = $row;
        }
        return $this->pesanan;
    }

    public function getByStatus($status)
    {
        $query = "SELECT * FROM pesanan where status_pesanan = '$status'";
        $result = mysqli_query($this->conn, $query);
        while ($row = $result->fetch_assoc()) {
            $this->pesanan[] = $row;
        }
        return $this->pesanan;
    }

    public function deletePesanan($id_pesanan)
    {
        $q = "DELETE FROM pesanan WHERE id = '$id_pesanan'";
        $result = mysqli_query($this->conn, $q);
        if($result) {
            $this->error = true;
            $this->errorMessage = 'Gagal menghapus pesanan';
        }
        $this->error = false;
        return;
    }

    public function getIdPesanan()
    {
        return $this->id_pesanan;
    }    
}