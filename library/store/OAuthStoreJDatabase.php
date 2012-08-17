<?php

require_once dirname(__FILE__) . '/OAuthStoreJSQL.php';

class OAuthStoreJDatabase extends OAuthStoreJSQL
{
  /**
   * The MySQL connection 
   */
  protected $db;

  public function __construct($options) 
  {
    $this->db = JFactory::getDBO();
  }
  
  public function install() {}
  
  /* ** Some simple helper functions for querying the mysql db ** */

  /**
   * Perform a query, ignore the results
   * 
   * @param string sql
   * @param vararg arguments (for sprintf)
   */
  protected function query($sql)
  {
    $sql = $this->sql_printf(func_get_args());
    $this->db->setQuery($sql);
    $this->db->query();
  }

  /**
   * Perform a query, ignore the results
   * 
   * @param string sql
   * @param vararg arguments (for sprintf)
   * @return array
   */
  protected function query_all_assoc($sql)
  {
    $sql = $this->sql_printf(func_get_args());
    $this->db->setQuery($sql);
    $rs = $this->db->loadAssocList();

    if($this->db->getErrorNum())
      $this->sql_errcheck($sql);
    
    return $rs;
  }
  
  /**
   * Perform a query, return the first row
   * 
   * @param string sql
   * @param vararg arguments (for sprintf)
   * @return array
   */
  protected function query_row_assoc($sql)
  {
    $sql = $this->sql_printf(func_get_args());
    $this->db->setQuery($sql);
    $rs = $this->db->loadAssoc();
    
    if($this->db->getErrorNum())
      $this->sql_errcheck($sql);

    return $rs;
  }
  
  /**
   * Perform a query, return the first row
   * 
   * @param string sql
   * @param vararg arguments (for sprintf)
   * @return array
   */
  protected function query_row($sql)
  {
    $sql = $this->sql_printf(func_get_args());
    $this->db->setQuery($sql);
    $rs = $this->db->loadRow();
    
    if($this->db->getErrorNum())
      $this->sql_errcheck($sql);

    return $rs;
  }
    
  /**
   * Perform a query, return the first column of the first row
   * 
   * @param string sql
   * @param vararg arguments (for sprintf)
   * @return mixed
   */
  protected function query_one($sql)
  {
    $sql = $this->sql_printf(func_get_args());
    $this->db->setQuery($sql);
    $val = $this->db->loadResult();
    
    if($this->db->getErrorNum())
      $this->sql_errcheck($sql);

    return $val;
  }
  
  /**
   * Return the number of rows affected in the last query
   */
  protected function query_affected_rows()
  {
    return $this->db->getAffectedRows();
  }

  /**
   * Return the id of the last inserted row
   * 
   * @return int
   */
  protected function query_insert_id()
  {
    return $this->db->insertid();
  }
  
  protected function sql_printf($args)
  {
    $sql  = array_shift($args);
    if(count($args) == 1 && is_array($args[0]))
      $args = $args[0];

    $args = array_map(array($this, 'sql_escape_string'), $args);

    return vsprintf($sql, $args);
  }
  
  protected function sql_escape_string($s)
  {
    return $this->db->escape($s);
  }
  
  protected function sql_errcheck($sql)
  {
    if($this->db->getErrorNum())
    {
      $msg = "SQL Error in OAuthStoreMySQL: ".$this->db->getErrorMsg()."\n\n" . $sql;
      throw new OAuthException2($msg);
    }
  }
}