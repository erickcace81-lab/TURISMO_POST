<?php
function e($s) {
  return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

$nombreArchivo = "";
$mensajeImagen = "";

// Crear carpeta 'uploads' si no existe
if (!is_dir("uploads")) {
  mkdir("uploads", 0777, true);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Procesar la imagen si se subió
  if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    $nombreArchivo = "uploads/" . basename($_FILES["imagen"]["name"]);

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreArchivo)) {
      $mensajeImagen = "Imagen subida correctamente ✅";
    } else {
      $mensajeImagen = "Error al subir la imagen ❌";
    }
  } else {
    $mensajeImagen = "No se recibió ninguna imagen.";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Datos Recibidos (POST)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f7ff;
      color: #333;
      padding: 40px;
    }
    h1 {
      color: #0077b6;
    }
    .card {
      background: #fff;
      border-radius: 10px;
      padding: 25px;
      max-width: 700px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    p strong {
      color: #0077b6;
    }
    img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h1>Datos del Sitio Turístico (Método POST)</h1>
  <div class="card">
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
      <p><strong>Nombre:</strong> <?= e($_POST['nombre']) ?></p>
      <p><strong>Descripción:</strong> <?= e($_POST['descripcion']) ?></p>
      <p><strong>Provincia:</strong> <?= e($_POST['provincia']) ?></p>
      <p><strong>Tipo de turismo:</strong> <?= e($_POST['tipo']) ?></p>
      <p><strong>Servicios:</strong> 
        <?php
          $servicios = $_POST['servicios'] ?? [];
          echo !empty($servicios) ? e(implode(", ", $servicios)) : "Ninguno";
        ?>
      </p>
      <p><strong>Correo:</strong> <?= e($_POST['email']) ?></p>
      <p><strong>Fecha de registro:</strong> <?= e($_POST['fecha']) ?></p>
      <p><strong>Estado de imagen:</strong> <?= e($mensajeImagen) ?></p>

      <?php if ($nombreArchivo && file_exists($nombreArchivo)): ?>
        <p><strong>Vista previa de la imagen:</strong></p>
        <img src="<?= e($nombreArchivo) ?>" alt="Imagen del sitio turístico">
      <?php endif; ?>
    <?php else: ?>
      <p>No se recibieron datos del formulario.</p>
    <?php endif; ?>
  </div>
</body>
</html>
