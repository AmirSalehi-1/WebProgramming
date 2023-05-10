<?php
require_once('abstractDAO.php');
require_once('./model/employee.php');

class employeeDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getEmployee($employeeId){
        $query = 'SELECT * FROM employees WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $employeeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $employee = new Employee($temp['id'], $temp['number'], $temp['text'], $temp['date'], $temp['image']); // Fixed the order of parameters
    
            $result->free();
            return $employee;
        }
        $result->free();
        return false;
    }
    


    public function getEmployees(){
        $result = $this->mysqli->query('SELECT * FROM employees');
        if (!$result) {
           
            echo "Error: " . $this->mysqli->error . "<br>";
        }
        $employees = Array();
        
        if($result !== false && $result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                $employee = new Employee($row['id'], $row['number'], $row['text'], $row['date'], $row['image']);
                $employees[] = $employee;
            }
            $result->free();
            return $employees;
        }
        if ($result) {
            $result->free();
        }
        return false;
    } 
    
    public function addEmployee($employee){
        
        if(!$this->mysqli->connect_errno){
            $query = 'INSERT INTO employees (number, date, text, image) VALUES (?, ?, ?, ?)';
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                $number = $employee->getNumber();
                $date = $employee->getDate();
                $text = $employee->getText();
               
                $image = $employee->getImage();
                      
                $stmt->bind_param('isss', 
                    $number,
                    $date,
                    $text,
                    $image
                );    
                $stmt->execute();         
                        
                if($stmt->error){
                    return $stmt->error;
                } else {
                    return 'Record added successfully!';
                } 
            } else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
           
        } else {
            return 'Could not connect to Database.';
        }
    }
    

    public function updateEmployee($employee){
        
    if(!$this->mysqli->connect_errno){
        $query = "UPDATE employees SET number=?, text=?, date=?, image=? WHERE id=?";
        $stmt = $this->mysqli->prepare($query);
        if($stmt){
            $id = $employee->getId();
            $number = $employee->getNumber();
            $text = $employee->getText();
            $date = $employee->getDate();
            $image = $employee->getImage();
              
            $stmt->bind_param('isssi', 
            $number,
            $text,
            $date,
            $image,
            $id,
        );
        
            $stmt->execute();         
                
            if($stmt->error){
                return $stmt->error;
            } else {
                return 'Record updated successfully!';
            } 
        } else {
            $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
            echo $error; 
            return $error;
        }
   
    } else {
        return 'Could not connect to Database.';
    }
}  

    public function deleteEmployee($employeeId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM employees WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $employeeId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>