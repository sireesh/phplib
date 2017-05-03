<?php
/**
 * Created by PhpStorm.
 * User: sireesh
 * Date: 20/07/16
 *
 * php_pagination class:
 * - Class to handle pagination in grid/tabular displays
 * 
 * 
 */
class php_pagination {
	
	public function __construct() {
		//Default
	}

       /**
	* set log file (path and name)
	*
	* @param $total_rows  total number of rows/records
	* @param $rows_per_page  Number of rows/records per page
	* @param $page_num  present page number
	* 
	* @access  public
	* @return array of page numbers
	*
	*/

	public function calculate_pages($total_rows, $rows_per_page, $page_num) {
		try{		
			$arr = array();
			// calculate last page
			$last_page = ceil($total_rows / $rows_per_page);
			// make sure we are within limits
			$page_num = (int) $page_num;
			if ($page_num < 1) {
				$page_num = 1;
			} 
			elseif ($page_num > $last_page) {
				$page_num = $last_page;
			}
			$upto = ($page_num - 1) * $rows_per_page;
			$arr['limit'] = 'LIMIT '.$upto.',' .$rows_per_page;
			$arr['first'] = 1;
			$arr['current'] = $page_num;
			if ($page_num == 1) {
				$arr['previous'] = $page_num;
			} else { 
				$arr['previous'] = $page_num - 1;
			}
			if ($page_num == $last_page) {
				$arr['next'] = $last_page;
			} else {
				$arr['next'] = $page_num + 1;
			}
			$arr['last'] = $last_page;
			$arr['info'] = 'Page ('.$page_num.' of '.$last_page.')';
			$arr['pages'] = $this->get_surrounding_pages($page_num, $last_page, $arr['next']);
			return $arr;
		} catch (Exception $e) {
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

	private function get_surrounding_pages($page_num, $last_page, $next) {
		try{
			$arr = array();
			$show = 5; // how many boxes
			// at first
			if ($page_num == 1) {
				// case of 1 page only
				if ($next == $page_num) { return array(1); }
				for ($i = 0; $i < $show; $i++) {
					if ($i == $last_page) break;
					array_push($arr, $i + 1);
				}
				return $arr;
			}
			// at last
			if ($page_num == $last_page) {
				$start = $last_page - $show;
				if ($start < 1) { $start = 0; }
				for ($i = $start; $i < $last_page; $i++) {
					array_push($arr, $i + 1);
				}
				return $arr;
			}
			// at middle
			$start = $page_num - $show;
			if ($start < 1) { $start = 0; }
			for ($i = $start; $i < $page_num; $i++) {
				array_push($arr, $i + 1);
			}
			for ($i = ($page_num + 1); $i < ($page_num + $show); $i++) {
				if ($i == ($last_page + 1)) { break; }
				array_push($arr, $i);
			}
			return $arr;
		} catch (Exception $e) {
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
		
}
