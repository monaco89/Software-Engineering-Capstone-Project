<?php
class DB
{
    private static $_instance = null;
    private $_pdo,
    $_query,
    $_error = false,
    $_results,
    $_count = 0;
    
    public function update($table, $id, $fields=array())
    {
        $set = '';
        $x = 1;

        foreach($fields as $name => $value)
        {
            $set .= "{$name} = ?";
            if($x < count($fields))
            {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error())
        {
            return true;
        }
        return false;
    }

    public function insert($table, $fields = array())
    {
        if(count($fields))
        {
            $keys = array_keys($fields);
            $values = null;
            $x = 1;

            foreach($fields as $field)
            {
                $values .= '?';
                if($x < count($fields))
                {
                    $values .= ', ';
                }
                $x++;
            }

            $sql = "INSERT INTO {$table} (`". implode('`,`', $keys )."`) VALUES ({$values})";

            if(!$this->query($sql, $fields)->error())
            {
                return true;
            }
        }
        return false;
    }

    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }

    public function results()
    {
        return $this->_results;
    }

    public function error()
    {
        return $this->_error;
    }

    public function count()
    {
        return $this->_count;
    }

    public function first()
    {
        return $this->_results[0];
    }
}
?>