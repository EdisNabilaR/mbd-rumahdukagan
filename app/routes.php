<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    // Endpoint untuk Menambahkan Keluarga Baru
    $app->post('/AddNewKeluarga', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL AddNewKeluarga(?, ?, ?)');
            $query->execute([$data['Nama_Keluarga'], $data['Alamat'], $data['No_Telpon']]);
            
            $response->getBody()->write(json_encode(['message' => 'Keluarga berhasil ditambahkan.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Memperbarui Informasi Keluarga
    $app->put('/UpdateKeluarga/{ID_Keluarga}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $data['ID_Keluarga'] = $args['ID_Keluarga'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL UpdateKeluarga(?, ?, ?, ?)');
            $query->execute([$data['ID_Keluarga'], $data['Nama_Keluarga'], $data['Alamat'], $data['No_Telpon']]);
            
            $response->getBody()->write(json_encode(['message' => 'Informasi Keluarga berhasil diperbarui.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Menghapus Keluarga
    $app->delete('/DeleteKeluarga/{ID_Keluarga}', function (Request $request, Response $response, $args) {
        $data['ID_Keluarga'] = $args['ID_Keluarga'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeleteKeluarga(?)');
            $query->execute([$data['ID_Keluarga']]);
            
            $response->getBody()->write(json_encode(['message' => 'Keluarga berhasil dihapus.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Mendapatkan Informasi Keluarga dan Jenazah Terkait
    $app->get('/GetKeluargaInfo/{ID_Keluarga}', function (Request $request, Response $response, $args) {
        $data['ID_Keluarga'] = $args['ID_Keluarga'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL GetKeluargaInfo(?)');
            $query->execute([$data['ID_Keluarga']]);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($results));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

//=========================================================================================================================================================//


    // Endpoint untuk Menambahkan Jenazah Baru
    $app->post('/AddNewJenazah', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL AddNewJenazah(?, ?, ?, ?, ?)');
            $query->execute([$data['ID_Keluarga'], $data['Nama_Jenazah'], $data['Tgl_Lahir'], $data['Tgl_Meninggal'], $data['Lokasi_Meninggal']]);
            
            $response->getBody()->write(json_encode(['message' => 'Jenazah berhasil ditambahkan.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Memperbarui Informasi Jenazah
    $app->put('/UpdateJenazah/{ID_Jenazah}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $data['ID_Jenazah'] = $args['ID_Jenazah'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL UpdateJenazah(?, ?, ?, ?, ?)');
            $query->execute([$data['ID_Jenazah'], $data['Nama_Jenazah'], $data['Tgl_Lahir'], $data['Tgl_Meninggal'], $data['Lokasi_Meninggal']]);
            
            $response->getBody()->write(json_encode(['message' => 'Informasi Jenazah berhasil diperbarui.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Menghapus Jenazah dan Pelayanan Terkait
    $app->delete('/DeleteJenazah/{ID_Jenazah}', function (Request $request, Response $response, $args) {
        $data['ID_Jenazah'] = $args['ID_Jenazah'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeleteJenazah(?)');
            $query->execute([$data['ID_Jenazah']]);
            
            $response->getBody()->write(json_encode(['message' => 'Jenazah dan pelayanan terkait berhasil dihapus.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Mendapatkan Informasi Jenazah dan Pelayanan Terkait
    $app->get('/GetJenazahInfo/{ID_Jenazah}', function (Request $request, Response $response, $args) {
        $data['ID_Jenazah'] = $args['ID_Jenazah'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL GetJenazahInfo(?)');
            $query->execute([$data['ID_Jenazah']]);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($results));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Mendapatkan Pelayanan Berdasarkan ID Jenazah
    $app->get('/GetPelayananByJenazahID/{ID_Jenazah}', function (Request $request, Response $response, $args) {
        $data['ID_Jenazah'] = $args['ID_Jenazah'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL GetPelayananByJenazahID(?)');
            $query->execute([$data['ID_Jenazah']]);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($results));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

//=========================================================================================================================================================//

    // Endpoint untuk Menambahkan Pelayanan Baru
    $app->post('/AddNewPelayanan', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL AddNewPelayanan(?, ?, ?)');
            $query->execute([$data['ID_Jenazah'], $data['Tgl_Pelayanan'], $data['Jenis_Pelayanan']]);
            
            $response->getBody()->write(json_encode(['message' => 'Pelayanan berhasil ditambahkan.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Memperbarui Informasi Pelayanan
    $app->put('/UpdatePelayanan/{ID_Pelayanan}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $data['ID_Pelayanan'] = $args['ID_Pelayanan'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL UpdatePelayanan(?, ?, ?)');
            $query->execute([$data['ID_Pelayanan'], $data['Tgl_Pelayanan'], $data['Jenis_Pelayanan']]);
            
            $response->getBody()->write(json_encode(['message' => 'Informasi Pelayanan berhasil diperbarui.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Menghapus Pelayanan
    $app->delete('/DeletePelayanan/{ID_Pelayanan}', function (Request $request, Response $response, $args) {
        $data['ID_Pelayanan'] = $args['ID_Pelayanan'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeletePelayanan(?)');
            $query->execute([$data['ID_Pelayanan']]);
            
            $response->getBody()->write(json_encode(['message' => 'Pelayanan berhasil dihapus.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Mendapatkan Informasi Pelayanan dan Petugas Terkait
    $app->get('/GetPelayananInfo/{ID_Pelayanan}', function (Request $request, Response $response, $args) {
        $data['ID_Pelayanan'] = $args['ID_Pelayanan'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL GetPelayananInfo(?)');
            $query->execute([$data['ID_Pelayanan']]);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($results));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Mendapatkan Pelayanan Berdasarkan ID Jenazah
    $app->get('/GetPelayananByJenazahID/{ID_Jenazah}', function (Request $request, Response $response, $args) {
        $data['ID_Jenazah'] = $args['ID_Jenazah'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL GetPelayananByJenazahID(?)');
            $query->execute([$data['ID_Jenazah']]);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($results));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });


//=========================================================================================================================================================//

    // Endpoint untuk Menambahkan Petugas Baru
    $app->post('/AddNewPetugas', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL AddNewPetugas(?, ?, ?)');
            $query->execute([$data['ID_Pelayanan'], $data['Nama_Petugas'], $data['Jabatan']]);
            
            $response->getBody()->write(json_encode(['message' => 'Petugas berhasil ditambahkan.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Memperbarui Informasi Petugas
    $app->put('/UpdatePetugas/{ID_Petugas}', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $data['ID_Petugas'] = $args['ID_Petugas'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL UpdatePetugas(?, ?, ?)');
            $query->execute([$data['ID_Petugas'], $data['Nama_Petugas'], $data['Jabatan']]);
            
            $response->getBody()->write(json_encode(['message' => 'Informasi Petugas berhasil diperbarui.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Menghapus Petugas
    $app->delete('/DeletePetugas/{ID_Petugas}', function (Request $request, Response $response, $args) {
        $data['ID_Petugas'] = $args['ID_Petugas'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL DeletePetugas(?)');
            $query->execute([$data['ID_Petugas']]);
            
            $response->getBody()->write(json_encode(['message' => 'Petugas berhasil dihapus.']));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Mendapatkan Informasi Petugas Berdasarkan ID Pelayanan
    $app->get('/GetPetugasByPelayananID/{ID_Pelayanan}', function (Request $request, Response $response, $args) {
        $data['ID_Pelayanan'] = $args['ID_Pelayanan'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL GetPetugasByPelayananID(?)');
            $query->execute([$data['ID_Pelayanan']]);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($results));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // Endpoint untuk Mendapatkan Informasi Petugas Berdasarkan Nama
    $app->get('/GetPetugasByNama/{Nama_Petugas}', function (Request $request, Response $response, $args) {
        $data['Nama_Petugas'] = $args['Nama_Petugas'];
        $db = $this->get(PDO::class);

        try {
            $query = $db->prepare('CALL GetPetugasByNama(?)');
            $query->execute([$data['Nama_Petugas']]);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($results));
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['message' => 'Database error: ' . $e->getMessage()]));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

};