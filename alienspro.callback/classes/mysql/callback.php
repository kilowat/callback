<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/classes/general/callback.php");
class callback extends callbackGeneral{
   
    public static function getListMsg($by='id',$order='asc',$limit='',$row=array()){
        global $DB;
        
      if(!empty($limit)){
          $limit = "LIMIT ".intval($limit);
      }
           if(empty($row)){
                 $query= $DB->Query("SELECT alienspro_callbackmsg.id as id,
                                            alienspro_callbackmsg.name as name,
                                            alienspro_callbackmsg.email as email,
                                            alienspro_callbackmsg.phone as phone,
                                            alienspro_callbackmsg.time_t as time,
                                            alienspro_callbackmsg.date_t as date, 
                                            alienspro_callbackmsg.theme as theme,
                                            alienspro_callbackmsg.status as status,
                                            alienspro_callbackmsg.user_answer as user_answer,
                                            alienspro_callbackmsg.date_answer as date_answer
                                    FROM alienspro_callbackmsg
                                    ORDER BY $by $order $limit");

                return $query;
           
           } else{
               $sql = 'SELECT ';
               foreach($row as $rowItem){
                   $sql.=strtolower($rowItem).',';
               }
               $sql = substr($sql,0,-1);
               $sql.= " FROM alienspro_callbackmsg ORDER BY $by $order $limit";
               $query= $DB->Query($sql);
               return $query;
           }
   }     
    
    
}
