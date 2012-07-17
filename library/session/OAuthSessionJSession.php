<?php

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/OAuthSessionAbstract.class.php';

class OAuthSessionJSession extends OAuthSessionAbstract
{
  protected $store = null;

  public function __construct( $options = array() )
  {
    $this->store = JFactory::getSession();
  }

  /**
   * Gets a variable value
   * 
   * @param string $key
   * @return The value or null if not set.
   */
  public function get ( $key ) 
  {
    return $this->store->get($key, null);
  }
  
  /**
   * Sets a variable value
   * 
   * @param string $key The key
   * @param any $data The data 
   */
  public function set ( $key, $data ) 
  {
    $this->store->set($key, $data);
  }
}