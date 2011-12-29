<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Model extends CI_Model {
 
        var $table = "";
 
        function __construct()
        {
                parent::__construct();
                log_message('debug', 'MY_Model Initialized');
        }
 
        function insert($data)
        {
                $this->db->insert($this->table, $data);
                return $this->db->insert_id();
        }
        
        function find_where($whereArray){
            if ( is_array($whereArray)){
                $this->db->select('*');
                $this->db->from($this->table);
                $this->db->where($whereArray);
                $query = $this->db->get();
                return $query->num_rows() > 0 ? $query->result_array() : FALSE;
            } else {
                return FALSE;
            }
        }
 
        function find_id($id)
        {
                if ($id == NULL)
                {
                        return NULL;
                }
 
                $this->db->where('id', $id);
                $query = $this->db->get($this->table);
 
                $result = $query->result_array();
                return (count($result) > 0 ? $result[0] : FALSE);
        }
 
        function find_all($sort = 'id', $order = 'asc')
        {
                $this->db->order_by($sort, $order);
                $query = $this->db->get($this->table);
                return $query->num_rows > 0 ? $query->result_array(): FALSE;
        }
 
        function update($id, $data)
        {
                $this->db->where('id', $id);
                $this->db->update($this->table, $data);
        }
        
        function update_where($where, $data){
            if ( ! is_array($where) || ! is_array($data) ){
                return FALSE;
            }
            $this->db->where($where);
            $this->db->update($this->table, $data);
        }
 
        function delete($id)
        {
                if ($id != NULL)
                {
                        $this->db->where('id', $id);                    
                        $this->db->delete($this->table);                        
                }
        }       
}
 
/* End of file MY_Model.php */
/* Location: ./system/application/libraries/MY_Model.php */