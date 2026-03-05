<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
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
      $st=$conexion->prepare("SELECT * FROM tbl_banners WHERE ID=:id");
      $st->bindParam(":id",$id,PDO::PARAM_INT);
      $st->execute();
      $row=$st->fetch(PDO::FETCH_ASSOC);
      if(!$row) respond(["ok"=>false,"message"=>"Banner no encontrado"],404);
      respond(["ok"=>true,"data"=>$row],200);
    }
    $st=$conexion->prepare("SELECT * FROM tbl_banners ORDER BY ID DESC");
    $st->execute();
    $rows=$st->fetchAll(PDO::FETCH_ASSOC);
    respond(["ok"=>true,"count"=>count($rows),"data"=>$rows],200);
  }

  if ($method==="POST"){
    $b=getJsonBody();
    $titulo=trim($b["titulo"]??"");
    $descripcion=trim($b["descripcion"]??"");
    $link=trim($b["link"]??"");
    if($titulo===""||$descripcion===""||$link==="") respond(["ok"=>false,"message"=>"Faltan campos: titulo, descripcion, link"],400);

    $st=$conexion->prepare("INSERT INTO tbl_banners (titulo, descripcion, link) VALUES (:t,:d,:l)");
    $st->bindParam(":t",$titulo);
    $st->bindParam(":d",$descripcion);
    $st->bindParam(":l",$link);
    $st->execute();
    respond(["ok"=>true,"message"=>"Banner creado","id"=>$conexion->lastInsertId()],201);
  }

  if ($method==="PUT"){
    if($id<=0) respond(["ok"=>false,"message"=>"Debes enviar ?id=ID"],400);
    $b=getJsonBody();

    $fields=[]; $params=[":id"=>$id];
    if(isset($b["titulo"])) { $fields[]="titulo=:t"; $params[":t"]=trim($b["titulo"]); }
    if(isset($b["descripcion"])) { $fields[]="descripcion=:d"; $params[":d"]=trim($b["descripcion"]); }
    if(isset($b["link"])) { $fields[]="link=:l"; $params[":l"]=trim($b["link"]); }
    if(!$fields) respond(["ok"=>false,"message"=>"No enviaste campos para actualizar"],400);

    $sql="UPDATE tbl_banners SET ".implode(",",$fields)." WHERE ID=:id";
    $st=$conexion->prepare($sql);
    foreach($params as $k=>$v) $st->bindValue($k,$v);
    $st->execute();
    respond(["ok"=>true,"message"=>"Banner actualizado"],200);
  }

  if ($method==="DELETE"){
    if($id<=0) respond(["ok"=>false,"message"=>"Debes enviar ?id=ID"],400);
    $st=$conexion->prepare("DELETE FROM tbl_banners WHERE ID=:id");
    $st->bindParam(":id",$id,PDO::PARAM_INT);
    $st->execute();
    if($st->rowCount()==0) respond(["ok"=>false,"message"=>"Banner no encontrado"],404);
    respond(["ok"=>true,"message"=>"Banner eliminado"],200);
  }

  respond(["ok"=>false,"message"=>"Método no permitido"],405);

} catch(Exception $e){
  respond(["ok"=>false,"message"=>"Error del servidor","error"=>$e->getMessage()],500);
}