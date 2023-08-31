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
  $colums = implode_column_names(array_keys($data));
  
  $bindingStatement = make_binding_statement($data);
  
  $valuesType = get_values_type_binding($data);
  
  $query  = "INSERT INTO `{$table}` ({$colums}) VALUES ({$bindingStatement})";

  $preparedStatement = mysqli_prepare($connection, $query);

  mysqli_stmt_bind_param($preparedStatement, $valuesType, ...array_values($data));

  $result = mysqli_stmt_execute($preparedStatement);

  return $result;
}

function implode_column_names($columns)
{
  $columns = array_map(function ($column) {
    return "`{$column}`";
  }, $columns);

  return implode(",", $columns);
}

function get_values_type_binding($values) {
  $valuesType = array_map(function ($value) {
    return gettype($value)[0];
  }, $values);

  return implode("", $valuesType);
}

function make_binding_statement(array $data) {
  $bindingStatement = array_map(function ($value) {
    return "?";
  }, $data);

  return implode(",", $bindingStatement);
}