<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Todolist extends Model
{
    protected $table = 'todolist';
    protected $primaryKey = 'id';
    public $timestamps = false;

   	public static function todolist(){
        try {
            $todolist = Todolist::all();

            if($todolist) {
            	return $todolist;
            } else {
				return false;            	
            }
        } catch (Exception $e) {
			return false;
        }
    }

   	public static function saveTodo($params){
        DB::beginTransaction();
        
        try {
            $todolist = new Todolist;
            $todolist->list_name = $params->todolist;
            $todolist->created_at = date('Y-m-d H:i:s');

            if($todolist->save()) {
	            DB::commit();
            	return true;
            } else {
				DB::rollBack();
				return false;            	
            }
        } catch (Exception $e) {
            DB::rollBack();
			return false;
        }
    }

   	public static function deleteTodo($id){
        DB::beginTransaction();
        
        try {
            $todolist = Todolist::destroy($id);

            if($todolist) {
	            DB::commit();
            	return true;
            } else {
				DB::rollBack();
				return false;            	
            }
        } catch (Exception $e) {
            DB::rollBack();
			return false;
        }
    }
}
