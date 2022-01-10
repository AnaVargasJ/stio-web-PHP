
 <?php   
  session_start();

 if($_POST){

   if(($_POST["usuario"]=="anavargas")&&($_POST["contrasenia"]=="sistema"))
    {
      $_SESSION['usuario']="ok";
      $_SESSION['nombreUsuario']="anavargas";
          header('location:inicio.php'); //aqu se meodific la l
   }else{
     $mensaje="Error: el usuario o contraseña son incorrectos";
      }

  }
?> 


<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
  </head>
  <body>
      
  <div class="container"  >
      <div class="row "  >

      <div class="col-md-4 ">
      
      </div>

          <div class="col-md-4    ">
          <br/><br/><br/><br/><br/><br/><br/>

          <div class="card"  style="-webkit-box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);
                                    -moz-box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);
                                    box-shadow: 0px 4px 11px -4px rgba(0,0,0,0.75);">
              <div class="card-header bg-dark" style="color: white;">
                  Login
              </div>
              <div class="card-body ">
              <br/>

              
        

              <form method="POST">

              <div class = "form-group">
              <label >Usuario</label>
              <input type="text" class="form-control" name="usuario"  placeholder="Ingrese su email">

              <br/>

              <div class="form-group">
              <label >Contraseña</label>
              <input type="password" class="form-control" name="contrasenia" placeholder="Ingrese su contraseña">
              </div>
              <br/>

              <button type="submit" class="btn btn-outline-dark">Acceder al sistema</button>
              </form>
              
              
                 
              </div>
             
          </div>
              
          </div>
          
      </div>
      
  </div>
 
  </body>
</html>