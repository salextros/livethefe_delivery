<?php
// api/productos.php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
  http_response_code(200);
  exit();
}

require_once __DIR__ . "/../admin/bd.php"; // Ajusta si tu ruta es diferente

function respond($data, int $code = 200) {
  http_response_code($code);
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  exit();
}

function getJsonBody(): array {
  $raw = file_get_contents("php://input");
  if (!$raw) return [];
  $data = json_decode($raw, true);
  return is_array($data) ? $data : [];
}

$method = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

try {

  // =========================
  // GET: listar o por ID
  // =========================
  if ($method === "GET") {
    if ($id > 0) {
      $stmt = $conexion->prepare("SELECT * FROM tbl_productos WHERE ID = :id");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $producto = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$producto) respond(["ok" => false, "message" => "Producto no encontrado"], 404);
      respond(["ok" => true, "data" => $producto], 200);
    }

    $stmt = $conexion->prepare("SELECT * FROM tbl_productos ORDER BY ID DESC");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    respond(["ok" => true, "count" => count($productos), "data" => $productos], 200);
  }

  // =========================
  // POST: crear
  // =========================
  if ($method === "POST") {
    $body = getJsonBody();

    $nombre = trim($body["nombre"] ?? "");
    $ingredientes = trim($body["ingredientes"] ?? "");
    $foto = trim($body["foto"] ?? "");          // aquí normalmente guardas el nombre del archivo
    $precio = trim((string)($body["precio"] ?? ""));

    if ($nombre === "" || $ingredientes === "" || $precio === "") {
      respond(["ok" => false, "message" => "Faltan campos: nombre, ingredientes, precio"], 400);
    }

    $stmt = $conexion->prepare("
      INSERT INTO tbl_productos (nombre, ingredientes, foto, precio)
      VALUES (:nombre, :ingredientes, :foto, :precio)
    ");
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":ingredientes", $ingredientes);
    $stmt->bindParam(":foto", $foto);
    $stmt->bindParam(":precio", $precio);
    $stmt->execute();

    $newId = $conexion->lastInsertId();
    respond(["ok" => true, "message" => "Producto creado", "id" => $newId], 201);
  }

  // =========================
  // PUT: actualizar (requiere ?id=)
  // =========================
  if ($method === "PUT") {
    if ($id <= 0) respond(["ok" => false, "message" => "Debes enviar ?id=ID"], 400);

    $body = getJsonBody();

    // Solo actualizamos lo que venga (campos opcionales)
    $fields = [];
    $params = [":id" => $id];

    if (isset($body["nombre"])) {
      $fields[] = "nombre = :nombre";
      $params[":nombre"] = trim($body["nombre"]);
    }
    if (isset($body["ingredientes"])) {
      $fields[] = "ingredientes = :ingredientes";
      $params[":ingredientes"] = trim($body["ingredientes"]);
    }
    if (isset($body["foto"])) {
      $fields[] = "foto = :foto";
      $params[":foto"] = trim($body["foto"]);
    }
    if (isset($body["precio"])) {
      $fields[] = "precio = :precio";
      $params[":precio"] = trim((string)$body["precio"]);
    }

    if (count($fields) === 0) {
      respond(["ok" => false, "message" => "No enviaste campos para actualizar"], 400);
    }

    $sql = "UPDATE tbl_productos SET " . implode(", ", $fields) . " WHERE ID = :id";
    $stmt = $conexion->prepare($sql);
    foreach ($params as $k => $v) $stmt->bindValue($k, $v);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
      // Puede ser que no exista el ID o que no cambió nada
      respond(["ok" => true, "message" => "Sin cambios (verifica ID o datos)"], 200);
    }

    respond(["ok" => true, "message" => "Producto actualizado"], 200);
  }

  // =========================
  // DELETE: eliminar (requiere ?id=)
  // =========================
  if ($method === "DELETE") {
    if ($id <= 0) respond(["ok" => false, "message" => "Debes enviar ?id=ID"], 400);

    $stmt = $conexion->prepare("DELETE FROM tbl_productos WHERE ID = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) respond(["ok" => false, "message" => "Producto no encontrado"], 404);

    respond(["ok" => true, "message" => "Producto eliminado"], 200);
  }

  // Si llega un método no soportado
  respond(["ok" => false, "message" => "Método no permitido"], 405);

} catch (Exception $e) {
  respond(["ok" => false, "message" => "Error del servidor", "error" => $e->getMessage()], 500);
}