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
      $st=$conexion->prepare("SELECT * FROM tbl_colaboradores WHERE ID=:id");
      $st->bindParam(":id",$id,PDO::PARAM_INT);
      $st->execute();
      $row=$st->fetch(PDO::FETCH_ASSOC);
      if(!$row) respond(["ok"=>false,"message"=>"Colaborador no encontrado"],404);
      respond(["ok"=>true,"data"=>$row],200);
    }
    $st=$conexion->prepare("SELECT * FROM tbl_colaboradores ORDER BY ID DESC");
    $st->execute();
    $rows=$st->fetchAll(PDO::FETCH_ASSOC);
    respond(["ok"=>true,"count"=>count($rows),"data"=>$rows],200);
  }

  if ($method==="POST"){
    $b=getJsonBody();
    $titulo=trim($b["titulo"]??"");
    $descripcion=trim($b["descripcion"]??"");
    $linkfacebook=trim($b["linkfacebook"]??"");
    $linkinstagram=trim($b["linkinstagram"]??"");
    $linklinkedin=trim($b["linklinkedin"]??"");
    $foto=trim($b["foto"]??"");

    if($titulo===""||$descripcion==="") respond(["ok"=>false,"message"=>"Faltan campos: titulo, descripcion"],400);

    $st=$conexion->prepare("
      INSERT INTO tbl_colaboradores (titulo, descripcion, linkfacebook, linkinstagram, linklinkedin, foto)
      VALUES (:t,:d,:fb,:ig,:in,:f)
    ");
    $st->bindParam(":t",$titulo);
    $st->bindParam(":d",$descripcion);
    $st->bindParam(":fb",$linkfacebook);
    $st->bindParam(":ig",$linkinstagram);
    $st->bindParam(":in",$linklinkedin);
    $st->bindParam(":f",$foto);
    $st->execute();

    respond(["ok"=>true,"message"=>"Colaborador creado","id"=>$conexion->lastInsertId()],201);
  }

  if ($method==="PUT"){
    if($id<=0) respond(["ok"=>false,"message"=>"Debes enviar ?id=ID"],400);
    $b=getJsonBody();

    $fields=[]; $params=[":id"=>$id];
    if(isset($b["titulo"])) { $fields[]="titulo=:t"; $params[":t"]=trim($b["titulo"]); }
    if(isset($b["descripcion"])) { $fields[]="descripcion=:d"; $params[":d"]=trim($b["descripcion"]); }
    if(isset($b["linkfacebook"])) { $fields[]="linkfacebook=:fb"; $params[":fb"]=trim($b["linkfacebook"]); }
    if(isset($b["linkinstagram"])) { $fields[]="linkinstagram=:ig"; $params[":ig"]=trim($b["linkinstagram"]); }
    if(isset($b["linklinkedin"])) { $fields[]="linklinkedin=:in"; $params[":in"]=trim($b["linklinkedin"]); }
    if(isset($b["foto"])) { $fields[]="foto=:f"; $params[":f"]=trim($b["foto"]); }

    if(!$fields) respond(["ok"=>false,"message"=>"No enviaste campos para actualizar"],400);

    $sql="UPDATE tbl_colaboradores SET ".implode(",",$fields)." WHERE ID=:id";
    $st=$conexion->prepare($sql);
    foreach($params as $k=>$v) $st->bindValue($k,$v);
    $st->execute();

    respond(["ok"=>true,"message"=>"Colaborador actualizado"],200);
  }

  if ($method==="DELETE"){
    if($id<=0) respond(["ok"=>false,"message"=>"Debes enviar ?id=ID"],400);
    $st=$conexion->prepare("DELETE FROM tbl_colaboradores WHERE ID=:id");
    $st->bindParam(":id",$id,PDO::PARAM_INT);
    $st->execute();
    if($st->rowCount()==0) respond(["ok"=>false,"message"=>"Colaborador no encontrado"],404);
    respond(["ok"=>true,"message"=>"Colaborador eliminado"],200);
  }

  respond(["ok"=>false,"message"=>"Método no permitido"],405);

} catch(Exception $e){
  respond(["ok"=>false,"message"=>"Error del servidor","error"=>$e->getMessage()],500);
}