<?php

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

function goHome()
{
  header('Location: http://' . $_SERVER['HTTP_HOST']);
}
