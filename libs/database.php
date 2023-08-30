<?php

$connection = mysqli_connect(
  "localhost",
  "root",
  "",
  "training"
);

if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}


function insert_data($connection, $table, $data)
{
  $columns = implode_column_names(array_keys($data));
  $values  = implode_values($data);

  $query = "INSERT INTO {$table} ($columns) VALUES ($values)";

  $result = mysqli_query($connection, $query);

  return $result;
}

function implode_column_names($columns)
{
  $columns = array_map(function ($column) {
    return "`{$column}`";
  }, $columns);

  return implode(",", $columns);
}

function implode_values($values)
{
  $values = array_map(function ($value) {
    return "'{$value}'";
  }, $values);

  return implode(",", $values);
}
