<?php
namespace model;

use Exception;

require_once './model/BaseClass.php';

class PesansanItems extends BaseClass {
    public $id_pesanan;
    public $nama_product;
    public $qty;
    public $harga;
    public $total_harga;
    private $conn;
    public $error;
    public $error_message;
    public $items = [];

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function storePesananItems($id_pesanan, $products)
    {
        $this->conn->begin_transaction();
        try {
            foreach($products as $product) {
                $nama_product = $product['produk'];
                $qty = $product['jumlah'];
                $harga = $product['harga'];
    
                $query = "INSERT INTO pesanan_items (id_pesanan, nama_product, qty, harga)
                            Values ('$id_pesanan', '$nama_product', '$qty', '$harga')";
                $result = mysqli_query($this->conn, $query);
        
                if(!$result) {
                    $this->error = true;
                    $this->error_message = "Error: " . mysqli_error($this->conn);
                    throw new Exception("Error Processing Request" . mysqli_error($this->conn));
                    
                    return;
                }        
            }
            $this->conn->commit();
        } catch (\Throwable $th) {
            $this->error = true;
            $this->error_message = "Error: " . $th->getMessage();
            $this->conn->rollback();
            throw new Exception("Error Processing Request" . $th->getMessage());
            return;
        }

        return;
    }

    public function getByIdPesanan($id_pesanan)
    {
        $query = "SELECT * FROM pesanan_items where id_pesanan = '$id_pesanan'";
        $result = mysqli_query($this->conn, $query);
        while ($row = $result->fetch_assoc()) { 
            $this->items[] = $row;
        }

        return $this->items;
    }
}