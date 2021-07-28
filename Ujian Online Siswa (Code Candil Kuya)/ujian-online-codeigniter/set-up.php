<?php
ini_set('max_execution_time', 300); 
class import_db
{
    protected $db;
    protected $message;
    public function __construct($config)
    {    
        $this->db= $config;
        $this->check_db_variable();
    }
    protected function check_db_variable()
    {
        $this->message .= empty($this->db['host']) ? 'host undefined ' : FALSE ;
        $this->message .= empty($this->db['user']) ? ', user undefined ' : FALSE ;
        $this->message .= empty($this->db['pass']) ? null : FALSE ;
        $this->message .= empty($this->db['dbname']) ? ', database name undefined ' : FALSE ;
        $this->message .= empty($this->db['sqldump']) ? ', file .sql undefined ' : FALSE ;
        if ( empty( $this->message ) ) {
            $this->conn = @new mysqli($this->db['host'], $this->db['user'], $this->db['pass'], $this->db['dbname']);
            // Check connection
            if ($this->conn->connect_errno) {
                echo "Failed to connect to MySQL: " . $this->conn->connect_errno;
                echo "<br/>Error: " . $this->conn->connect_error;
            }
        }
        // print_r($this->db);
    }
    protected function drop_table_from_db()
    {
        $this->conn->query('SET foreign_key_checks = 0');
        if ($result = $this->conn->query("SHOW TABLES"))
        {
            while($row = $result->fetch_array(MYSQLI_NUM))
            {
                $this->conn->query('DROP TABLE IF EXISTS '.$row[0]);
            }
        }

        $this->conn->query('SET foreign_key_checks = 1');
        // $this->conn->close();
        return TRUE;
    }
    public function imports()
    {
        $tes;
        $this->drop_table_from_db();
        // Connect to MySQL server
        
        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($this->db['sqldump']);
        // Loop through each line
        foreach ($lines as $line) {
        // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

        // Add this line to the current segment
            $templine .= $line;
        // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $tes= $this->conn->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . $this->conn->error() . '<br /><br />');
                // Reset temp variable to empty
                $templine = '';
            }
        }
        // echo "Tables imported successfully";
        // $this->conn->close($this->conn);
        return TRUE;
    }

}

// config import
$import = new import_db([
    'host'=> 'localhost',
    'user'=> 'root',
    'pass'=> '',
    'dbname'=> 'prio_ta',
    'sqldump'=> 'sql_dump/prio_ta.sql', 
]);

echo "<pre>";
print_r( $import->imports() );
echo "</pre>";
// echo "<pre>";
// print_r( $import );
// echo "</pre>";



