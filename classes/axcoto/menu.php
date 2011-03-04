<?php

/*
 * A project from Axcoto.Com
 * by kureikain
 */

abstract class Axcoto_Menu {
    private static  $_configMenu = array();
    private $_menu = array();
    private $_name = null;
    private static $_instance = array();

    private function __construct($name, $menu=array()) {
        $this->_menu = $menu;
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
        self::$_configMenu = Kohana::config('menu');
        if (empty(self::$_instance[$name])) {
            self::$_instance[$name] = new Menu($name, empty(self::$_configMenu[$name])?  array():self::$_configMenu[$name]) ;
        }
        return self::$_instance[$name];
    }

    /**
     *  Render a menu! We must calculate current menu item at this point because after creating a menu, other menu items can be added to!
     * @param <type> $attr attribute of menu(class, id)
     * @return <type> html text of menu
     */
    public function render($attr=array()) {
        $_attr = array(
            'class' => '',
            'id' => 'menu_' . $this->_name
        );
        
        $_attr = Arr::overwrite($_attr, $attr);

        $currentUri = Request::current()->uri() . '/';
        $currentUri = Text::reduce_slashes($currentUri);
        foreach ($this->_menu as $key=>$item) {
            $menuUri = Text::reduce_slashes($item['uri'] . '/');
            $menuDefaultUri = Text::reduce_slashes($item['uri'] . '/index/');
            if ($menuDefaultUri==$currentUri || $menuUri==$currentUri || strpos($currentUri, $menuUri)===0) {
                $this->_menu[$key]['current'] = true;
            }
        }

        $template = View::factory('menu/menu')
                        ->set('menu', $this->_menu)
                        ->set('attr', $_attr)
                        ->set('currentUri', $currentUri)
        ;
        return $template->render();
    }

}

?>
