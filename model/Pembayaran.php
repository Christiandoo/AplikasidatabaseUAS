<?php
namespace model;
require_once './model/BaseClass.php';
require_once './model/Pesanan.php';

class Pembayaran extends BaseClass {

    public $conn;
    public $userId;

    public function __construct($conn, $userId = null)
    {
        $this->conn = $conn;        
        $this->userId = $userId;
    }

    public function store($id_pesanan, $metode_pembayaran)
    {
        $query = "INSERT INTO pembayaran (id_pesanan, metode_pembayaran) 
                                    VALUES ($id_pesanan, '$metode_pembayaran')";

        $result = mysqli_query($this->conn, $query);

        if(!$result) {
            $this->error = true;
            $this->errorMessage = "Error: " . mysqli_error($this->conn);    
        }
        return;
    }

    public function update($id_pesanan, $path)
    {
        $this->conn->begin_transaction();

        try {
            $query = "UPDATE pembayaran SET bukti_pembayaran = '$path' where id_pesanan = '$id_pesanan'";
    
            mysqli_query($this->conn, $query);
            
                            $pesanan = new Pesanan($this->conn);
            if($this->userId) {
                $pesanan = new Pesanan($this->conn, $this->userId);
            }
            $pesanan->updateStatus($id_pesanan, 'Dibayar');

            $this->conn->commit();
        } catch (\Throwable $th) {
            $this->error = true;
            $this->errorMessage = 'Gagal upload bukti pembayaran, Error : ' . $th->getMessage();
            $this->conn->rollback();
            return;
        }
        return;
    }

    public function getPembayaran($id_pesanan)
    {
        $query = "SELECT * FROM pembayaran WHERE id_pesanan = '$id_pesanan'";
        $result = mysqli_query($this->conn, $query);
        $penbayaran = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        return $penbayaran;
    }
}