<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-request-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once 'conexion.php';
$conexionDB = new DatabasePDO();
$conn = $conexionDB->conn();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['login'])) {
        getUsers();
    } elseif (isset($_GET['servers'])) {
        getServers();
    } elseif (isset($_GET['domains'])) {
        getDomains();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['login'])) {
        postUsers();
    } elseif (isset($_GET['servers'])) {
        postServers();
    } elseif (isset($_GET['domains'])) {
        postDomains();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($_GET['login'])) {
        putUsers();
    } elseif (isset($_GET['servers'])) {
        putServers();
    } elseif (isset($_GET['domains'])) {
        putDomains();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['login'])) {
        deleteUsers();
    } elseif (isset($_GET['servers'])) {
        deleteServers();
    } elseif (isset($_GET['domains'])) {
        deleteDomains();
    }
}

#=================GET===================
function getUsers()
{
    global $conn;

    $query = "SELECT * FROM users";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo json_encode($users);
    } else {
        echo json_encode(['message' => 'No se encontraron usuarios.']);
    }
}


#=================GET===================
function getServers()
{
    global $conn;

    $query = "SELECT * FROM servers";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo json_encode($users);
    } else {
        echo json_encode(['message' => 'No se encontraron usuarios.']);
    }
}


function getDomains()
{
    global $conn;

    $query = "SELECT * FROM domains";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo json_encode($users);
    } else {
        echo json_encode(['message' => 'No se encontraron usuarios.']);
    }
}



#=================POST===================
function postUsers()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));

    $user = $data->user;
    $pass = $data->pass;

    $query = "INSERT INTO users (user, pass) VALUES (:user, :pass)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':pass', $pass);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Usuario creado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al crear usuario.']);
    }
}

function postServers()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));

    $name = $data->name;
    $user = $data->user;
    $pass = $data->pass;
    $port = $data->port;

    $query = "INSERT INTO servers (name, user, pass, port) VALUES (:name, :user, :pass, :port)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':port', $port);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Servidor creado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al crear servidor.']);
    }
}

function postDomains()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));

    $url = $data->url;
    $server = $data->server;

    $query = "INSERT INTO domains (url, server) VALUES (:url, :server)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':server', $server);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Dominio creado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al crear dominio.']);
    }
}


#=================PUT===================
function putUsers()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $user = $data->user;
    $pass = $data->pass;

    $query = "UPDATE users SET user = :user, pass = :pass WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Usuario actualizado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al actualizar usuario.']);
    }
}


function putServers()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $name = $data->name;
    $user = $data->user;
    $pass = $data->pass;
    $port = $data->port;

    $query = "UPDATE servers SET name = :name, user = :user, pass = :pass, port = :port WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':port', $port);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Servidor actualizado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al actualizar servidor.']);
    }
}

function putDomains()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));

    $id = $data->id;
    $url = $data->url;
    $server = $data->server;

    $query = "UPDATE domains SET url = :url, server = :server WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':server', $server);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Dominio actualizado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al actualizar dominio.']);
    }
}


#=================DELETE===================
function deleteUsers()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;

    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Usuario eliminado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al eliminar usuario.']);
    }
}

function deleteServers()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;

    $query = "DELETE FROM servers WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Servidor eliminado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al eliminar servidor.']);
    }
}

function deleteDomains()
{
    global $conn;

    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;

    $query = "DELETE FROM domains WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Dominio eliminado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al eliminar dominio.']);
    }
}
