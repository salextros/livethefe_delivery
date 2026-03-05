<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") { http_response_code(200); exit(); }

require_once __DIR__ . "/../admin/bd.php";

function respond($data, int $code = 200){ http_response_code($code); echo json_encode($data, JSON_UNESCAPED_UNICODE); exit(); }
function getJsonBody(): array { $raw=file_get_contents("php://input"); $d=json_decode($raw,true); return is_array($d)?$d:[]; }

$method=$_SERVER["REQUEST_METHOD"];
$id=isset($_GET["id"])?intval($_GET["id"]):0;

try {
  if ($method==="GET"){
    if($id>0){
      $st=$conexion->prepare("SELECT * FROM tbl_comentarios WHERE ID=:id");
      $st->bindParam(":id",$id,PDO::PARAM_INT);
      $st->execute();
      $row=$st->fetch(PDO::FETCH_ASSOC);
      if(!$row) respond(["ok"=>false,"message"=>"Comentario no encontrado"],404);
      respond(["ok"=>true,"data"=>$row],200);
    }
    $st=$conexion->prepare("SELECT * FROM tbl_comentarios ORDER BY ID DESC");
    $st->execute();
    $rows=$st->fetchAll(PDO::FETCH_ASSOC);
    respond(["ok"=>true,"count"=>count($rows),"data"=>$rows],200);
  }

  if ($method==="POST"){
    $b=getJsonBody();
    $nombre=trim($b["nombre"]??"");
    $correo=trim($b["correo"]??"");
    $mensaje=trim($b["mensaje"]??"");
    if($nombre===""||$correo===""||$mensaje==="") respond(["ok"=>false,"message"=>"Faltan campos: nombre, correo, mensaje"],400);

    $st=$conexion->prepare("INSERT INTO tbl_comentarios (nombre, correo, mensaje) VALUES (:n,:c,:m)");
    $st->bindParam(":n",$nombre);
    $st->bindParam(":c",$correo);
    $st->bindParam(":m",$mensaje);
    $st->bindParam(":m",$mensaje);
    $st->execute();
    respond(["ok"=>true,"message"=>"Comentario creado","id"=>$conexion->lastInsertId()],201);
  }

  if ($method==="DELETE"){
    if($id<=0) respond(["ok"=>false,"message"=>"Debes enviar ?id=ID"],400);
    $st=$conexion->prepare("DELETE FROM tbl_comentarios WHERE ID=:id");
    $st->bindParam(":id",$id,PDO::PARAM_INT);
    $st->execute();
    if($st->rowCount()==0) respond(["ok"=>false,"message"=>"Comentario no encontrado"],404);
    respond(["ok"=>true,"message"=>"Comentario eliminado"],200);
  }

  respond(["ok"=>false,"message"=>"Método no permitido"],405);

} catch(Exception $e){
  respond(["ok"=>false,"message"=>"Error del servidor","error"=>$e->getMessage()],500);
}