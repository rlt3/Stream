<?php
require_once('config.php');

class Database
{
   private $_con;
   private $msg;
   protected $_database;

   function __construct($database=DB_NAME)
   {
      $this->connect(); 
      $this->_database = $database;
   }

   function __destruct()
   {
      $this->_con = null;
   }

   private function _connect()
   {
      try
      {
         $this->_con = new PDO("mysql:host=".DB_HOST.";dbname=$database", DB_USER, DB_PASS);
      }
      catch ( PDOException $error )
      {
         echo $error->getMessage();
      }
   }

   public function get($count=3, $table=DB_TABLE)
   {
      return $this->query("SELECT * FROM $table ORDER BY date DESC LIMIT $count");
   }

   public function getBy($column, $value, $table=DB_TABLE) 
   {
      
      $sql  = "SELECT * FROM $table ";
      $sql .= "WHERE $column='$value' ";
      $sql .= "LIMIT 1";
      return $this->query($sql);
   }

   public function getAll($table=DB_TABLE)
   {
      return $this->query("SELECT * FROM $table ");
   }

   public function search($words, $table=DB_TABLE)
   {
      $sql  = "SELECT * FROM $table ";
      $sql .= "WHERE body LIKE '%$words%' ";
      $sql .= "OR title LIKE '%$words%'";
      $stmt = $this->_con->prepare($sql);
      $stmt->execute();
      if($stmt->rowCount() == 0)
         return 0;
      return $stmt->fetchAll();
   }

   public function query($sql)
   {
      $stmt = $this->_con->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
   }

   public function execute($sql)
   {
      $stmt = $this->_con->prepare($sql);
      $stmt->execute();
   }
}
$db = new Database();
?>
