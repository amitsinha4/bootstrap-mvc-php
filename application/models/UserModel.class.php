<?php

class UserModel extends Model
{

    public function getUsers()
    {
        $sql = "select * from $this->table";
        $users = $this->db->getAll($sql);
        return $users;
    }
    
    public function getUserCol(){
        $sql = "select * from $this->table";
        $users_col = $this->db->getCol($sql);
        return $users_col;
    }
   
}
?>