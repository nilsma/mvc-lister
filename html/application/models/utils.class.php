<?php
if(!class_exists('Utils')) {

  class Utils {

    private static $initialized = false;

    private static function initialize() {
      if(self::initialized) {
	return;
      }
      self::$initialized = true;
    }

    /**
     * A function to handle replacing of parameters for the htmlspecialchars function
     * Credits to Mike Robinson [http://php.net/htmlspecialchars]
     * @param string $string - the string to wash
     * @return string - the washed string
     */
    public static function html($string) {
      return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
    }


  }

}
?>