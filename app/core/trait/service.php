
<?php
trait service
{
    public function input($databaseobject, $query, $binds = [])
    {
        $databaseobject->query($query);
        if (!empty($binds)) {
            foreach ($binds as $bind => $val) {
                $databaseobject->bind($bind, $val);
            }
        }
        $databaseobject->execute();
    }
}
