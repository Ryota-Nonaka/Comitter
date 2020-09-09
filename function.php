<?php

function h($s)
{

  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function goHome()
{
  header('Location:http://localhost/portforio/index.php');
  exit;
}
