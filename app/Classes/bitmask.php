<?php namespace App\Classes;
class bitmask
{
    
    public $permissions = array(
                                "v"=>false, // view = 1
                                "a"=>false, // add = 2
                                "e"=>false, // edit =4
                                "d"=>false  //delete =8
                                );
    public function getPermissions($bitMask =0)
    {
        $i =0;
        foreach($this->permissions as $key => $value)
        {
            $this->permissions[$key]=(($bitMask & pow(2, $i))!=0)?true:false;
            //uncomment the next line if you would like to see what is happening.
            //echo $key . " i= ".strval($i)." power=" . strval(pow(2,$i)). "bitwise & = " . strval($bitMask & pow(2,$i))."<br>";
            $i++;
        }
        return $this->permissions;
    }

    
    function toBitmask()
    {
        $bitmask = 0;
        $i =0;
        foreach($this->permissions as $key => $value)
        {

            if($value)
            {
                $bitmask += pow(2, $i);
            }
            $i++;
        }
        return $bitmask;
    }
}