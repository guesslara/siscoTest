    <?php

    $target_path = "uploads/";
    $target_path = $target_path . basename( $_FILES['archivo_foto']['name']);
    move_uploaded_file($_FILES['archivo_foto']['tmp_name'],$target_path);
          //echo "El archivo se grabo correctamente.<br>";
          $nombre=$_FILES['archivo_foto']['name'];
          //echo "<img src=\"$nombre\">";
             echo "<center><img src='uploads/$nombre' width=150 height=165></center>";
    ?>
        <input type ="text" name = "nbre" id = "nbre"  value="<?="$nombre";?>" style="border:none"/>
    