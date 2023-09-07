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
  // echo "<pre>";
  // var_dump($data);
  // echo "</pre>";
  // die;
  // membuat binding statement
  // contoh: "(?, ?, ?)"
  $bindingStatement = make_binding_statement($data);
  
  // membuat binding type
  // contoh: "sss"
  $valuesType = get_values_type_binding($data);
  
  $query  = "INSERT INTO `{$table}` ({$colums}) VALUES ({$bindingStatement})";

  $preparedStatement = mysqli_prepare($connection, $query);
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
  return implode(",", $columNames);
}

function get_values_type_binding($values) {
  $valuesType = [];
  
  foreach ($values as $index => $value) {
    // $type bisa berisi "string", "integer", "float" dll
    // kita hanya perlu mengambil huruf pertama dari nama type sebuah value
    // misal "string" -> kita hanya butuh "s"
    $type = gettype($value);

    if ($type === "float") {
      $valuesType[$index] = "d";
    } else {
      $valuesType[$index] = $type[0];
    }
  }

  // ubah array dari type2 value [s, s, s, s] menjadi "ssss"
  return implode("", $valuesType);
}

function make_binding_statement(array $data) {
  // ["?", "?", "?", "?"]
  $bindings = array_fill(0, count($data), "?");
  
  // "?", "?", "?", "?"
  return implode(",", $bindings);
}

function get_all_data($table, $columns = "*")
{
  global $connection;

  $query = "SELECT {$columns} FROM `{$table}`";

  $result = mysqli_query($connection, $query);

  $data = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }

  return $data;
}