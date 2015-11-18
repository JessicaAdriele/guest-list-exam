<?php
class TaskService {
    
    public static function listTasks() {
        $db = ConnectionFactory::getDB();
        $guests =  array();
        
        foreach($db->guests() as $guests) {
           $guests[] = array (
               'id' => $guests['id'],
               'name' => $guests['name'],
               'email' => $guests['email']
           ); 
        }
        
        return $guests;
    }
    
    public static function add($newTask) {
        $db = ConnectionFactory::getDB();
        $guests = $db->guests->insert($newTask);
        return $guests;
    }
    
    public static function update($updatedTask) {
        $db = ConnectionFactory::getDB();
        $guests = $db->guests[$updatedTask['id']];
        
        if($guests) {
            $guests['name'] = $updatedTask['name'];
            $guests['email'] = $updatedTask['email'];
            $guests->update();
            return true;
        }
        
        return false;
    }
    
    public static function delete($id) {
        $db = ConnectionFactory::getDB();
        $guests = $db->guests[$id];
        if($guests) {
            $guests->delete();
            return true;
        }
        return false;
    }
}
?>