<?php
include 'func.php';
session_start();

if(isset($_POST['aksi'])){
    if($_POST['aksi'] == "add"){
        $berhasil = add_data($_POST, $_FILES);
        if($berhasil){
            $_SESSION['eksekusi'] = "Data Berhasil Ditambahkan";
            header("location: masterAdmin");
        }else{
            echo $berhasil;
        }


    }elseif($_POST['aksi'] == "edit"){
        $berhasil = change_data($_POST, $_FILES);
        if($berhasil){
            $_SESSION['edit'] = "Data Berhasil Diedit";
            header("location: masterAdmin");
        }else{
            echo $berhasil;
        }
    }
} 

if(isset($_GET['hapus'])){
    $berhasil = erase_data($_GET);
    if($berhasil){
        $_SESSION['hapus'] = "Data Berhasil Dihapus";
        // echo $_SESSION['hapus'];
        // die();
        header("location: masterAdmin");
    }else{
        echo $berhasil;
    }
}
?>
