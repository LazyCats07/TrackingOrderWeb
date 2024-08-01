<?php

use PHPUnit\Framework\TestCase;

// Class yang mau di test
require_once "track.php";

// class untuk run testing
class TrackOrderTest extends TestCase {
    private $conn;

    public function setUp(): void {
        
        // // Kita pakai class yang mau kita test
        // $tr = new track();

        // Create a mock database connection
        $this->conn = $this->createMock(mysqli::class);

        // Create a mock statement
        $stmt = $this->createMock(mysqli_stmt::class);

        // Create a mock result set
        $result = $this->createMock(mysqli_result::class);

        // Configure the mock result set
        $result->method('fetch_assoc')->willReturn([
            'id_cust' => '0001-1250',
            'nama_cust' => 'Ahmad Fauzan',
            'jenis_pinjaman' => 'NMC',
            'status_order' => 'New Order',
            'created' => '2024-07-15 15:15:19'
        ]);

        // Configure the mock statement
        $stmt->method('get_result')->willReturn($result);

        // Configure the mock connection
        $this->conn->method('prepare')->willReturn($stmt);
    }

    public function testSearchExistingOrder() {
        // Include the file that contains the search logic
        include '../track.php/';

        $_POST['tombolsearch'] = true;
        $_POST['cari'] = '0001-1250';

        // Call the code that performs the search
        ob_start();
        include '../track.php/';
        $output = ob_get_clean();

        // Assert the expected output is present
        $this->assertStringContainsString('Ahmad Fauzan', $output);
        $this->assertStringContainsString('NMC', $output);
        $this->assertStringContainsString('New Order', $output);
        $this->assertStringContainsString('2024-07-15 15:15:19', $output);
    }

    public function testSearchNonExistingOrder() {
        // Modify the result set to return no rows
        $result = $this->createMock(mysqli_result::class);
        $result->method('fetch_assoc')->willReturn(null);

        // Modify the statement to return the modified result set
        $stmt = $this->createMock(mysqli_stmt::class);
        $stmt->method('get_result')->willReturn($result);

        // Configure the connection to return the modified statement
        $this->conn->method('prepare')->willReturn($stmt);

        // Include the file that contains the search logic
        include '../track.php/';

        $_POST['tombolsearch'] = true;
        $_POST['cari'] = '9999-9999';

        // Call the code that performs the search
        ob_start();
        include '../track.php/';
        $output = ob_get_clean();

        // Assert the expected output is present
        $this->assertStringContainsString('Data tidak ditemukan.', $output);
    }
}
