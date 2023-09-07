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


function insert_data($table, $data)
{
  // memasukkan variable konesi ke fungsi
  global $connection;

  // menyatukan nama kolom menjadi string
  // contoh: ['name', 'price', 'description'] menjadi "(`name`, `price`, `description)`"
  $colums = implode_column_names(array_keys($data));
  // membuat binding statement
  // contoh: "(?, ?, ?)"
  $bindingStatement = make_binding_statement($data);
  
  // membuat binding type
  // contoh: "sss"
  $valuesType = get_values_type_binding($data);
  
  $query  = "INSERT INTO `{$table}` ({$colums}) VALUES ({$bindingStatement})";

  $preparedStatement = mysqli_prepare($connection, $query);

  // menggabungkan binding type dengan data menggunakan spread operator
  // contoh: mysqli_stmt_bind_param($preparedStatement, "sss", $data['name'], $data['price'], $data['description']);
  mysqli_stmt_bind_param($preparedStatement, $valuesType, ...array_values($data));

  $result = mysqli_stmt_execute($preparedStatement);

  return $result;
}

function implode_column_names($columns)
{
  $columNames = [];

  foreach ($columns as $index => $column) {
    // mengubah nama kolom menjadi `kolom`
    // misal name menjadi `name`
    $columNames[$index] = "`{$column}`";
  }

  // ubah array ["`name`", "`price`", "`description`", "`image`"]
  // menjadi "`name`, `price`, `description`, `image`"
  return implode(",", $columns);
}

function get_values_type_binding($values) {
  $valuesType = [];
  
  foreach ($values as $index => $value) {
    // $type bisa berisi "string", "integer", "float" dll
    $type = gettype($value);
    // kita hanya perlu mengambil huruf pertama dari nama type sebuah value
    // misal "string" -> kita hanya butuh "s"
    $valuesType[$index] = $type[0];
  }

  // ubah array dari type2 value [s, s, s, s] menjadi "ssss"
  return implode("", $valuesType);
}

function make_binding_statement(array $data) {
  // membuat array yang berisi "?" sebanyak jumlah data
  $bindingStatement = array_fill(0, count($data), "?");

  // mengubah array menjadi string
  // contoh [?, ?, ?, ?] -> "?, ?, ?, ?"
  return implode(",", $bindingStatement);
}

function get_all_data($table, $columns = "*")
{
  global $connection;

  $query = "SELECT {$columns} FROM `{$table}`";

  $result = mysqli_query($connection, $query);

  return $result;
}

function build_select_query($table, $column, $constraints = [])
{
  $query = "SELECT {$column} FROM `{$table}`";

  if (count($constraints) === 0) {
    return $query;
  }

  $query .= " WHERE ";

  // var_dump($constraints);
  // die;

  foreach ($constraints as $constraint) {
    $query .= implode(' ', array_values($constraint)) . " ";
  }

  return $query;

  // contoh constraint
  /**
   * [
   *  [
   *    "column" => "name",
   *    "value"  => "john",
   *    "operator" => "=",
   *    "boolean" => "OR"
   *  ]
   * ]
   *
   */


}

function get_paginated_data($table, $column, $perPage = 10, $page = 1)
{
  global $connection;

  $offset = calculate_pagination_offset($perPage, $page);

  $query = "SELECT {$column} FROM `{$table}` LIMIT {$offset}, {$perPage}";

  $result = mysqli_query($connection, $query);

  return $result;
}

function calculate_pagination_offset($perPage, $page)
{
  return ($page - 1) * $perPage;
}