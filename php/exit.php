<?php
  setcookie('user', $user['name'], time() - 3600 * 24 * 30 * 12, "/");
  header('location: /school');
?>