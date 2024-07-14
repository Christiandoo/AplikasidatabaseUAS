<?php
namespace model;
require_once './model/BaseClass.php';
use mysqli;


class Cart extends BaseClass {
    public $id;
    public $id_product;
    public $qty;
    public $id_session;
    public $conn;
    public $productInCart = [];
    public $userId;

    public function __construct($conn,$userId, $id_product = null)
    {   
        if($id_product) {
            $this->id_product = $id_product;
        }
        $this->conn = $conn;
        $this->id_session = session_id();
        $this->userId = $userId;
    }

    public function addOrUpdate()
    {
        $query = "SELECT * FROM keranjang WHERE id_produk='$this->id_product' AND user_id='$this->userId'";
        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            // Jika sudah ada, update jumlahnya
            $this->update();
        } else {
            // Jika belum ada, tambahkan produk ke keranjang
            $this->store();
        }    
        $this->message = "Berhasil menambahkan produk ke dalam cart";
    }

    public function update()
    {
        $query = "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_produk='$this->id_product' AND user_id='$this->userId'";
        $result = mysqli_query($this->conn, $query);

        if(!$result) {
            $this->error = "Gagal memasukan produk ke cart";
            return;
        }
        return;
    }

    public function store()
    {
        $query = "INSERT INTO keranjang (id_produk, jumlah, session_id, user_id) VALUES ('$this->id_product', 1, '$this->id_session', '$this->userId')";
        $result =mysqli_query($this->conn, $query);
        if(!$result) {
            $this->error = "Gagal memasukan produk ke cart";
            return;
        }
        return;
    }

    public function get()
    {
        $sql = "SELECT post_produk.*, keranjang.jumlah FROM keranjang 
                JOIN post_produk ON keranjang.id_produk = post_produk.id 
                WHERE keranjang.user_id = '$this->userId'";
        $result = mysqli_query($this->conn, $sql);
        while ($row = $result->fetch_assoc()) { 
            $this->productInCart = [...$this->productInCart, $row];
        }

        return $this->productInCart;
    }

    public function decrease()
    {
        $cart = $this->getByIdProduct();
        if ($cart['jumlah'] == 1 ) {
            $this->delete();
        }
        $query = "UPDATE keranjang SET jumlah = jumlah - 1 WHERE id_produk='$this->id_product' AND user_id='$this->userId'";
        $result = mysqli_query($this->conn, $query);

        if(!$result) {
            $this->error = "Gagal mengurangi produk ke cart";
            return;
        }
        return;
    }

    public function getByIdProduct()
    {
        $q = "SELECT * FROM keranjang WHERE id_produk = '$this->id_product' AND user_id = '$this->userId'";
        
        $result = mysqli_query($this->conn, $q);
        
        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function delete()
    {
        $q = "DELETE FROM keranjang WHERE id_produk = '$this->id_product' AND user_id = '$this->userId'";
        $result = mysqli_query($this->conn, $q);
        
        if ($result) {
            return true; // Mengembalikan true jika query berhasil
        } else {
            return false; // Mengembalikan false jika query gagal
        }
    }
        
}