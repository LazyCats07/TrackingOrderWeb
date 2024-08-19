<?php
    include 'connect.php';
    function add_data($data, $files){
        $id_cust = $data['id_cust'];
        $nama_cust = $data['nama_cust'];
        $gender = $data['gender'];
        $alamat = $data['alamat'];
        echo $files['ktp']['name']."<br>";
        $split = explode('.', $files['ktp']['name']);
        // mengambil index terakhir atau format data ".jpg"
        $ekstensi = $split[count($split)-1];
        $ktp = $id_cust.'.'.$ekstensi;
        $kk = $id_cust.'.'.$ekstensi;
        $jenis_pinjaman = $data['jenis_pinjaman'];
        $status_order = $data['status_order'];

        // Cek apakah id_cust sudah ada di database
        $queryCheck = "SELECT * FROM data_order WHERE id_cust = '$id_cust'";
        $sqlCheck = mysqli_query($GLOBALS['conn'], $queryCheck);

        // Jika data ditemukan, maka hentikan proses penambahan dan berikan pesan kesalahan
        if(mysqli_num_rows($sqlCheck) > 0) {
            echo "Data dengan ID Customer tersebut sudah ada!";
            return false;
        }

        // --Menyimpan data di Directory yang kita inginkan--
        $dir_ktp = "img/data_image/ktp/";
        $tmpFile_ktp = $files['ktp']['tmp_name'];
        move_uploaded_file($tmpFile_ktp, $dir_ktp.$ktp);

        // --Menyimpan data di Directory yang kita inginkan--
        $dir_kk = "img/data_image/kk/";
        $tmpFile_kk = $files['kartu_keluarga']['tmp_name'];
        move_uploaded_file($tmpFile_kk, $dir_kk.$kk);

        $query = "INSERT INTO data_order VALUES(null, '$id_cust', '$nama_cust', '$gender', '$alamat', '$ktp', '$kk', '$jenis_pinjaman', '$status_order', null)";
        $sql = mysqli_query($GLOBALS['conn'], $query);

        return true;
    }

    function change_data($data, $files){

        $no = $data["no"];
        $id_cust = $data['id_cust'];
        $nama_cust = $data['nama_cust'];
        $gender = $data['gender'];
        $alamat = $data['alamat'];
        $jenis_pinjaman = $data['jenis_pinjaman'];
        $status_order = $data['status_order'];

        // Query edit image dari file image ktp setelah click delete data 
        $queryShow_Ktp = "SELECT * FROM data_order WHERE id_cust = '$id_cust' ";
        $sqlShow_Ktp = mysqli_query($GLOBALS['conn'], $queryShow_Ktp);
        $result = mysqli_fetch_assoc($sqlShow_Ktp);
        
        $queryShow_kk = "SELECT * FROM data_order WHERE id_cust = '$id_cust' ";
        $sqlShow_kk = mysqli_query($GLOBALS['conn'], $queryShow_kk);
        $result = mysqli_fetch_assoc($sqlShow_kk);

        if($files['ktp']['name'] == ""){
            $ktp = $result['ktp'];   
        }else{
            // mengambil index terakhir atau format data ".jpg"
            $split = explode('.', $files['ktp']['name']);
            $ekstensi = $split[count($split)-1];

            $ktp = $result['id_cust'].'.'.$ekstensi;
            unlink("img/data_image/ktp/".$result['ktp']);
            move_uploaded_file($files['ktp']['tmp_name'], "img/data_image/ktp/".$ktp);
        }
        
        // Query edit image dari file image kk setelah click delete data 
        $queryShow_kk = "SELECT * FROM data_order WHERE id_cust = '$id_cust' ";
        $sqlShow_kk = mysqli_query($GLOBALS['conn'], $queryShow_kk);
        $result = mysqli_fetch_assoc($sqlShow_kk);

        if($files['kartu_keluarga']['name'] == ""){
            $kartu_keluarga = $result['kartu_keluarga'];    
        }else{
            // mengambil index terakhir atau format data ".jpg"
            $split = explode('.', $files['kartu_keluarga']['name']);
            $ekstensi = $split[count($split)-1];

            $kartu_keluarga = $result['id_cust'].'.'.$ekstensi;
            unlink("img/data_image/kk/".$result['kartu_keluarga']);
            move_uploaded_file($files['kartu_keluarga']['tmp_name'], "img/data_image/kk/".$kartu_keluarga);
        } 

        $query = "UPDATE data_order SET id_cust='$id_cust', nama_cust='$nama_cust', gender='$gender', alamat='$alamat', jenis_pinjaman='$jenis_pinjaman', status_order='$status_order', ktp = '$ktp', kartu_keluarga = '$kartu_keluarga' WHERE no='$no';";
        
        $sql = mysqli_query($GLOBALS['conn'], $query);

        return true;
    }

    function erase_data($data){
        $id_cust = $_GET['hapus'];
    
        // Query hapus image dari file image ktp setelah click delete data 
        $queryShow_Ktp = "SELECT * FROM data_order WHERE id_cust = '$id_cust' ";
        $sqlShow_Ktp = mysqli_query($GLOBALS['conn'], $queryShow_Ktp);
        $result = mysqli_fetch_assoc($sqlShow_Ktp);
        
        unlink("img/data_image/ktp/".$result['ktp']);
    
        // Query hapus image dari file image kk setelah click delete data 
        $queryShow_kk = "SELECT * FROM data_order WHERE id_cust = '$id_cust' ";
        $sqlShow_kk = mysqli_query($GLOBALS['conn'], $queryShow_kk);
        $result = mysqli_fetch_assoc($sqlShow_kk);
        
        unlink("img/data_image/kk/".$result['kartu_keluarga']);
    
    
        // Query Hapus Data berdasarkan id_cust
        $query = "DELETE FROM data_order WHERE id_cust = '$id_cust';";
        $sql = mysqli_query($GLOBALS['conn'], $query);

        return true;    
    }

?>