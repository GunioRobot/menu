<?php

/*
 * A project from Axcoto.Com
 * by kureikain
 */

abstract class Axcoto_Menu {

    private $_menu = array();
    private $_name = null;
    private static $_instance = array();

    private function __construct($name) {
        $this->_name = $name;
    }

    /**
     *  Add a menu item
     * @param <type> $menu item to add
     * @return Axcoto_Menu
     */
    public function addMenu($menu) {
        $this->_menu = Arr::merge($this->_menu, $menu);
        return $this;
    }

    /**
     *  Clear/Reset whole of menu
     * @return Axcoto_Menu for chaining
     */
    public function clearMenu() {
        $this->_menu = array();
        return $this;
    }

    /**
     * Get a instance of corresponding menu
     * @param <type> $name Name of menu. Example: home, footer, sidebar
     * @return Axcoto_Menu an instance of menu class for a specify menu
     */
    public static function factory($name) {
        if (is_null(self::$_instance)) {
            self::$_instance[$name] = new Menu($name);
        }
        return self::$_instance;
    }

    public function render($name, $attr=null) {
        $_attr = array(
            'class' => '',
            'id' => 'menu_' . time(),
        );
        $_attr = Arr::merge($_attr, $attr);
        $currentUri = Request::current()->uri();
        $template = View::factory('menu/menu')
                        ->set('menu' . $this->_menu)
                        ->set('attr', $_attr)
                        ->set('currentUri', $currentUri)
        ;
        return $template->render();
    }

}

?>
