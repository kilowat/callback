<?php

class callbackGeneral{
   /**
    * 
    * @global CDB $DB
    * @param string $by
    * @param string $order
    * @return CDBResult
    */
    public static function getListTheme(&$by=id,&$order='asc'){
        global $DB;
        $list = array();
        $query= $DB->Query("SELECT id,name
                                    FROM alienspro_themelist
                                    ORDER BY $by $order");
        
        return $query;
    }
    /**
     * 
     * @global CDB $DB
     * @param integer $id
     * @return CDBResult
     */
     public static function getTheme($id=null){
        global $DB;
        
        $query= $DB->Query("SELECT id,name
                                    FROM alienspro_themelist 
                                    WHERE id = $id");
        while ($result = $query->getNext()){
            $arResult =array("id"=>$result["id"],"name"=>$result["name"]);
        }
        return $arResult;
    }
    
    /**
     * 
     * @global CDB $DB
     * @param string $name
     * @param string $phone
     * @param string $time_t
     * @param string $theme
     * @param string $email
     * @param integer $status
     * @param string $user_answer
     * @param string $date_answer
     */
    public static function addMsg($name, $phone, $time_t,$theme=null,$email = null, $status=2, $user_answer = null,$date_answer=null){
        
         global $DB;
         $DB->PrepareFields("alienspro_callbackmsg");
         $arFiels = array(
             "name"=>"'".  strip_tags(trim($name))."'",
             "phone"=>"'". strip_tags(trim($phone))."'",
             "theme"=>"'".  strip_tags(trim($theme))."'",
             "time_t"=>"'".  strip_tags(trim($time_t))."'",
             "email"=>"'".  strip_tags(trim($email))."'",
             "status"=>"'".  intval($status)."'",
             "user_answer"=>"'".  strip_tags(trim($user_answer))."'",
             "date_answer"=>"'".  strip_tags(trim($date_answer))."'",
             "date_t"=>$DB->GetNowFunction(),
         );
         
          $DB->Insert("alienspro_callbackmsg", $arFiels);     
    }
    /**
     * 
     * @param string $name
     * return mixed
     */
    public static function addTheme($name){
        global $DB;
  
        $DB->PrepareFields("alienspro_themelist");
        $arFields = array(
            "name"=>"'".  strip_tags(trim($name))."'",
        );
        $result = $DB->Insert("alienspro_themelist", $arFields,'',true);
        
        return $result;
    }
     
    /**
     * 
     * @global CDB $DB
     * @param integer $id
     * @param string $user
     * @return CDBResult
     */
    public static function updateMsg($id,$user){
        
        global $DB;
        $DB->PrepareFields("alienspro_callbackmsg");
        $arFields = array(
            "status"=>1,
            "user_answer"=>"'".$user."'",
            "date_answer"=>$DB->GetNowFunction(),
        );
        $result = $DB->Update("alienspro_callbackmsg", $arFields, "WHERE id='".$id."'");
        return $result;
    }
    /**
     * 
     * @global CDB $DB
     * @param integer $id
     * @param string $name
     * @return CDBResult
     */
    public static function updateTheme($id,$name){
        
        global $DB;
        $DB->PrepareFields("alienspro_themelist");
        $arFields = array(
            "name"=>"'".strip_tags(trim($name))."'",
        );
        $result = $DB->Update("alienspro_themelist", $arFields, "WHERE id='".$id."'");
        return $result;
    }
    /**
     * 
     * @global CDB $DB
     * @param integer $id
     */
    public static function deleteMsg($id){
       
            global $DB;
           
            $id = intval($id);            
            $DB->Query("DELETE FROM alienspro_callbackmsg  WHERE id = $id");
            
    }
    /**
     * 
     * @global CDB $DB
     * @param integer $id
     */
    public static function deleteTheme($id){
       
            global $DB;
           
            $id = intval($id);            
            $DB->Query("DELETE FROM alienspro_themelist  WHERE id = $id");
            
    }
    
}
