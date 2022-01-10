<?php include("../template/cabecera.php");?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");


switch($accion){

    case "Agregar":
        // INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'libro de php', 'imagen.jpg');
        $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre,imagen) VALUES (:nombre,:imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);

        $fecha = new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if($tmpImagen!="")
        {
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }


        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();

        // echo "Presionado boton agregar";
        break;

    case "Modificar":
        
        $sentenciaSQL = $conexion->prepare("UPDATE  libros SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        if($txtImagen!="")
        {

            $fecha = new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
           
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); 

            if(isset($libro["imagen"])    &&($libro["imagen"]!="imagen.jpg") ){
            //pregunta si extite la imagen y luego si la imagen es diferente

                if(file_exists("../../img/".$libro["imagen"])){
                    //busca en la carpeta si la imagen existe

                    unlink("../../img/".$libro["imagen"]);
                    //y si existe se borra
                }

            }
            
//actualiza la imagen
        $sentenciaSQL = $conexion->prepare("UPDATE  libros SET imagen=:imagen WHERE id=:id");
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        }
        header("location:productos.php");
        break;

    case "Cancelar":
        header("location:productos.php");
        // echo "Presionado boton Cancelar";
        break;

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); 

        $txtNombre=$libro['nombre'];
        $txtImagen=$libro['imagen'];

        break;


    case "Borrar":

        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); 

        if(isset($libro["imagen"])    &&($libro["imagen"]!="imagen.jpg") ){
        //pregunta si extite la imagen y kluego si la imagen es diferente

            if(file_exists("../../img/".$libro["imagen"])){
                //busca en la carpeta si la imagen existe

                unlink("../../img/".$libro["imagen"]);
                //y si existe se borra
            }

        }
         $sentenciaSQL = $conexion->prepare("DELETE  FROM libros WHERE id=:id");
         $sentenciaSQL->bindParam(':id',$txtID);
         $sentenciaSQL->execute();   
        
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC); 

?>
<br/><br/>

<div class="col-md-5" >  <!--dar clase -->
    <div class="card1" 
    style="-webkit-box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);
box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);
">
        <div class="card-header">
          Datos de  Libro
        </div>
        <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

    <div class = "form-group">
        <label for="txtID">ID</label>
        <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID"  placeholder="ID">
    </div>
    <br/>
    <form>
        <div class = "form-group">
        <label for="txtNombre">Nombre</label>
        <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre"  placeholder="Nombre">
    </div>
    <br/>
        <form>
        <div class = "form-group">
        <label for="txtImagen">Imagen</label>

        <br/>
        <!-- <?php echo $txtImagen; ?>" -->

    <?php if($txtImagen!=""){ ?>

    <img  class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen;?>" width="50 "  alt="" srcset=""> 
    
    <?php }?>
    
    <input type="file" required class="form-control" name="txtImagen" id="txtImagen"  placeholder="Imagen">
    </div>
    <br/>
    <div class="btn-group" role="group" aria-label="">
   
        <button type="submit" style="width:100%; height:100%;" name="accion"  value="Agregar" class="btn btn-success">Agregar</button>
        <br/>
        <button type="submit" style="width:100%; height:100%;" name="accion"  value="Modificar" class="btn btn-warning">Modificar</button>
        <button type="submit" style="width:100%; " name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
    </div>
    </form>
           
        </div>
        
    </div>


   
    
</div>

<div class="col-md-6">
    
 <table class="table table-bordered"
 style="-webkit-box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);
box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);

">   <!--dar clase -->
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody> 
      <?php foreach($listaLibros as $libro) {?>
        <tr>
            <td><?php echo $libro['id']; ?> </td>
            <td><?php echo $libro['nombre']; ?></td>
            <td>
            <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" width="60 "  alt="" srcset="">
            
        </td>
            <td>
        <form method="post">
<!-- 
        <div class="content1"> -->
        <input type="hidden"   name="txtID" id="txtID" value="<?php echo $libro['id']; ?>"/>
        <input type="submit"  name="accion" value="Seleccionar" class="btn btn-info"/>
        <input type="submit"  style="align-items:flex-end;"  name="accion" value="Eliminar" class="btn btn-danger"/>

        <!-- </div> -->
       
        </form>

            </td>

        </tr>
       <?php } ?>
    </tbody>
    </table>

    </div>




    <?php include("../template/pie.php");?>