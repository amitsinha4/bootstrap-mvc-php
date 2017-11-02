<?php

class Mysql
{

    protected $conn = false;

    protected $sql;

    public function __construct($config = array())
    {
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        
        $user = isset($config['user']) ? $config['user'] : 'root';
        
        $password = isset($config['password']) ? $config['password'] : '';
        
        $dbname = isset($config['dbname']) ? $config['dbname'] : 'test';
        
        $port = isset($config['port']) ? $config['port'] : '3306';
        
        $charset = isset($config['charset']) ? $config['charset'] : '3306';
        
        $this->conn = new MySQLi("$host:$port", $user, $password, $dbname);
        
        if ($this->conn->connect_error) {
            die('Connection Failed:' . $this->conn->connect_error);
        }
        
        // $this->setChar($charset);
    }

    private function setChar($charest)
    {
        $sql = 'set names ' . $charest;
        
        $this->query($sql);
    }

    public function query($sql)
    {
        $this->sql = $sql;
        
        $str = $sql . "  [" . date("Y-m-d H:i:s") . "]" . PHP_EOL;
        
        file_put_contents("log.txt", $str, FILE_APPEND);
        
        $result = $this->conn->query($this->sql);
        
        if (! $result) {
            
            die($this->errno() . ':' . $this->error() . '<br />Error SQL statement is ' . $this->sql . '<br />');
        }
        
        return $result;
    }

    public function getOne($sql)
    {
        $result = $this->query($sql);
        
        $row = $result->fetch_assoc();
        
        if ($row) {
            return $row[0];
        } else {
            
            return false;
        }
    }

    /**
     *
     * Get one record
     *
     * @access public
     *        
     * @param $sql SQL
     *            query statement
     *            
     * @return array associative array
     *        
     */
    public function getRow($sql)
    {
        if ($result = $this->query($sql)) {
            
            $row = mysql_fetch_assoc($result);
            
            return $row;
        } else {
            
            return false;
        }
    }

    /**
     *
     * Get all records
     *
     * @access public
     *        
     * @param $sql SQL
     *            query statement
     *            
     * @return $list an 2D array containing all result records
     *        
     */
    public function getAll($sql)
    {
        $result = $this->query($sql);
        
        $list = array();
        
        while ($row = $result->fetch_assoc()) {
            
            $list[] = $row;
        }
        
        return $list;
    }

    /**
     *
     * Get the value of a column
     *
     * @access public
     *        
     * @param $sql string
     *            SQL query statement
     *            
     * @return $list array an array of the value of this column
     *        
     */
    public function getCol($sql)
    {
        $result = $this->query($sql);
        
        $list = array();
        
        $row = $result->fetch_assoc();
         
        $list = array_keys($row);
    
        return $list;
    }

    /**
     * Get last insert id
     */
    public function getInsertId()
    {
        return mysql_insert_id($this->conn);
    }

    /**
     *
     * Get error number
     *
     * @access private
     *        
     * @return error number
     *        
     */
    public function errno()
    {
        return $this->conn->errno;
    }

    /**
     *
     * Get error message
     *
     * @access private
     *        
     * @return error message
     *        
     */
    public function error()
    {
        return $this->conn->error;
    }
}