<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class M_profile extends CI_Model 
	{
		public $table = 'master_users';

		public function __construct() 
		{
			parent::__construct();
		}

		public function get($order_by) 
		{
			$this->db->order_by($order_by);
			$query = $this->db->get($this->table);
			return $query;
		}

		public function get_where($where) 
		{
			$this->db->where($where);
			$query = $this->db->get($this->table);
			return $query;
		}

		public function insert($data) 
		{
			// Execute the query
			$query = $this->db->insert($this->table, $data);

			// Return the result
			return (bool)$query;
		}

		public function update($id, $data) 
		{
			// Execute the query
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);

			// Return the result
			return (bool)$query;
		}

		public function delete($id) {
			// Execute the query
			$this->db->where('id', $id);
			$query = $this->db->delete($this->table);
			
			// Return the result
			return (bool)$query;
		}

		public function countGrid($columns, $like)
		{
			$table = $this->table;
			
			foreach($columns as $column) {
				$this->db->or_like($column, $like);
			}
			
			$total = $this->db->get($table)->num_rows();
			return $total;
		}

		public function getGrid()
		{
			$table = $this->table;
			$columns = array('id', 'name', 'description');

            $current = $this->input->get('current');
            $limit = $this->input->get('rowCount');
            $sort = key($this->input->get('sort'));
            $sortMode = $this->input->get('sort')[$sort];
            $like = $this->input->get('searchPhrase');		
			$total = $this->db->count_all_results($table);

			if (!empty($like)) {
				
				$total = $this->countGrid($columns, $like);
				
				foreach($columns as $column) {

					$this->db->or_like($column, $like);

				}
			}

			if ($limit > 0) {
				$this->db->limit($limit);
			}

			$rows = $this->db
				->select($columns)
				->order_by($sort, $sortMode)
				->offset(($current - 1) * $limit)
				->get($table);
			
			$response = array(
				'current' => (int)$current,
				'rowCount' => (int)$limit,
				'rows' => $rows->result(),
				'total' => $total
			);
			
			return $response;
		}
	}
