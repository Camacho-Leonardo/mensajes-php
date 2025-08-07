<h3>Agregar nuevo usuario</h3>
<form action="../procesar_usuario.php" method="POST">
    <input type="hidden" name="accion" value="agregar">
    Usuario: <input type="text" name="usuario" required><br>
    Pass: <input type="password" name="pass" required><br>
    Rol:
    <select name="rol">
        <option value="1">Administrador</option>
        <option value="2">Usuario</option>
    </select><br>
    <button type="submit">Guardar</button>
</form>
<a href="gestionar_usuarios.php">Volver</a>
