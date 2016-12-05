<?php

class BauerDB
{
    private $handle;
    private $substituted = array();

    //rasantes Ersetzen
    public function parseQuery($query) {
        if (preg_match_all("@!([a-zA-Z0-9_]*)@", $query, $parts)) {
            $map = getConfig();
            $parts = array_unique($parts[1]);
            foreach ($parts as $part) {
                if (isset($map["data_".$part])) {
                    $query = str_replace("!".$part, "`".$map["data_".$part]."`", $query);
                    $this->substituted[$map["data_".$part]] = "!".$part;
                }
            }
        }
        return $query;
    }

    // ebenso rasantes Rückersetzen
    private function reSubstitute($vars) {
        if (is_array(reset($vars)))
        {
            foreach ($vars as $key => $var) {
                foreach ($this->substituted as $value => $copy)
                    if (isset($var[$value]))
                        $vars[$key][$copy] = $var[$value];
            }
        }
        else {
            foreach ($this->substituted as $value => $copy)
                if (isset($vars[$value]))
                    $vars[$copy] = $vars[$value];
        }
        $this->substituted = array();
        return $vars;
    }

    public function __construct($host, $db, $user, $pass)
    {
        try {
            $this->handle = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $this->handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "<h1>Fehler</h1> " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * @param String $query
     * @param mixed ... Parameters to exchange for the ? in the query
     * @return array
     */
    public function getAll($query, $params = array())
    {
        $query = $this->parseQuery($query);
        if (!is_array($params)) {
            $params = func_get_args();
            array_shift($params);
        }
        $statement = $this->handle->prepare($query);
        $statement->execute($params);
        //var_dump($statement->errorInfo());echo $query;var_dump($params);die();
        return $this->reSubstitute($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    /**
     * @param String $query
     * @param array $filter Parameters to exchange for the ? in the query
     * @return array
     */
    public function getAllFilter($query, $filter = array())
    {
        $query = $this->parseQuery($query);
        if (!empty($filter)) {
            $where = " ";
            $params = array();
            foreach ($filter as $key => $value) {
                if (is_array($value)) {
                    $where .= "($key BETWEEN ? AND ?)";
                    $params[] = $value["from"];
                    $params[] = $value["to"];
                } else {
                    $where .= "$key LIKE ? AND ";
                    $params[] = "%$value%";
                }
            }
            $where = rtrim($where, "AND ");
            $query = rtrim($query, ";");
            $pos = strlen($query);
            if (stripos($query, "order by") !== false) $pos = stripos($query, "order by");
            if (stripos($query, "group by") !== false) $pos = stripos($query, "group by");
            if (stripos($query, "WHERE") === false) $where = " WHERE " . $where;
            $where .= " ";
            $query = substr_replace($query, $where, $pos, 0);
        } else
            $params = array();
        $statement = $this->handle->prepare($query);
        $statement->execute($params);
        //
        return $this->reSubstitute($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    /**
     * @param String $query
     * @param mixed ... Parameters to exchange for the ? in the query
     * @return array
     */
    public function getFirst($query, $params = array())
    {
        $query = $this->parseQuery($query);
        if (!is_array($params)) {
            $params = func_get_args();
            array_shift($params);
        }
        $statement = $this->handle->prepare($query);
        $statement->execute($params);
        return $this->reSubstitute($statement->fetch(PDO::FETCH_ASSOC));
    }
    /**
     * @param String $query
     * @param mixed ... Parameters to exchange for the ? in the query
     * @return int rowCount
     */
    public function query($query, $params = array())
    {
        $query = $this->parseQuery($query);
        $statement = $this->handle->prepare($query);
        if (!is_array($params)) {
            $params = func_get_args();
            array_shift($params);
        }
        $statement->execute($params);
        return $statement->rowCount();
    }

    public function add($table, $values = array(), $whitelist = null)
    {
        if (is_array($whitelist)) {
            $oldvalues = $values;
            $values = array();
            foreach ($whitelist as $element)
                if (isset($oldvalues[$element]))
                    $values[$element] = $oldvalues[$element];
        }
        if (getConfig("data_".$table) != null)
            $table = getConfig("data_".$table);
        $query = "INSERT INTO $table ";
        $columns = array();
        $placeholders = array();
        $vars = array();
        foreach ($values as $key => $value) {
            $columns[] = $key;
            $vars[] = $value;
            $placeholders[] = "?";
        }
        $query .= "(" . implode($columns, ", ") . ")";
        $query .= " VALUES (" . implode($placeholders, ",") . ")";
        $statement = $this->handle->prepare($query);
        $statement->execute($vars);
        return $statement->rowCount();
    }

    public function getByID($table, $id)
    {
        if (getConfig("data_".$table) != null)
            $table = getConfig("data_".$table);
        $statement = $this->handle->prepare("SELECT * FROM $table WHERE id = :id");
        $statement->execute(array('id' => $id));
        return $this->reSubstitute($statement->fetch());
    }

    public function edit($table, $id, $data, $idName = "id")
    {
        $idName = $this->parseQuery($idName);
        if (getConfig("data_".$table) != null)
            $table = getConfig("data_".$table);
        $sql = "UPDATE $table SET ";
        $update = array();
        foreach ($data as $key => $value) {
            $sql .= "`$key`=:$key, ";
            $update[$key] = $value;
        }
        $sql = substr($sql, 0, -2); // remove last ,
        $sql .= " WHERE $idName = :rowid";
        $update["rowid"] = $id;
        $sql = $this->parseQuery($sql);
        $statement = $this->handle->prepare($sql);
        $statement->execute($update);
        return $statement->rowCount();
    }

    public function count($table, $condition = " 1=1")
    {
        if (getConfig("data_".$table) != null)
            $table = getConfig("data_".$table);
        $sql = "SELECT COUNT(*) as count FROM $table WHERE $condition";
        $statement = $this->handle->prepare($sql);
        $statement->execute();
        $x = $statement->fetch();
        return $x["count"];
    }

    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * This is called if the method cannot be found.
     * Pass it to the PDO handle.
     *
     * @param $name
     * @param $arguments
     * @return mixed *
     */
    public function __call($name, $arguments)
    {
        return call_user_func(array($this->handle, $name), $arguments);
    }

}