<?php

/*
 * A project from Axcoto.Com
 * by kureikain
 */

abstract class Axcoto_Menu {

    private static $_configMenu = array();
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
            self::$_instance[$name] = new Menu($name, empty(self::$_configMenu[$name]) ? array() : self::$_configMenu[$name]);
        }
        return self::$_instance[$name];
    }

    public function isActivedMenu($menu) {
        //static $rendered =
    }

    /**
     *  Render a menu! We must calculate current menu item at this point because after creating a menu, other menu items can be added to!
     * @param <type> $attr attribute of menu(class, id)
     *      You can pass before and after to set a text which will wrap around your li element instead default <ul> tag of template! This is
     *      similar to before. after of wordpress
     *
     * @return <type> html text of menu
     */
    public function render($attr=array(), $sub=false) {
        $_attr = array(
            'class' => '',
            'id' => 'menu_' . $this->_name . ($sub ? '_sub' : ''),
            'before' => FALSE,
            'after' => FALSE,
        );

        $_attr = Arr::overwrite($_attr, $attr);

        $currentUri = Text::reduce_slashes(Request::current()->uri() . '/');
        if (substr($currentUri, -6)=='index/') {
            $currentUriNoIndex = substr($currentUri, 0, strlen($currentUri) - 7 );
        } else {
            $currentUriNoIndex = $currentUri;
        }
        $subMenu = array();

        foreach ($this->_menu as $uri => $item) {
            $this->_menu[$uri]['uri'] = $uri;
            $menuUri = Text::reduce_slashes($this->_menu[$uri]['uri'] . '/');
            $menuDefaultUri = Text::reduce_slashes($this->_menu[$uri]['uri'] . '/index/');

            foreach ($item as $attb => $value) {
                switch ($attb) {
                    case 'text': case 'uri': case 'attribute': case 'current': case 'sub':
                        break;
                    default:
                        $this->_menu[$uri]['attribute'] = (empty($this->_menu[$uri]['attribute']) ? '' : $this->_menu[$uri]['attribute']) . ' ' . sprintf('%s="%s"', $attb, ($value));
                        break;
                }
            }

            if (strpos($currentUri, $menuUri) === 0 || (!empty($item['sub']) && (array_key_exists( $currentUri, $item['sub']) || array_key_exists( $currentUriNoIndex, $item['sub'])))) {
                $this->_menu[$uri]['current'] = true;
                $subMenu = (empty($this->_menu[$uri]['sub']) ? array() : $this->_menu[$uri]['sub']);
                $a = function (&$item, $uri, &$menu)  {
                            $item['uri'] =  $uri;
                            $currentUri = Request::current()->uri() . '/';
                            $currentUri = Text::reduce_slashes($currentUri);

                            $menuUri = Text::reduce_slashes($item['uri'] . '/');
                            $menuDefaultUri = Text::reduce_slashes($item['uri'] . '/index/');
                            if (strpos($currentUri, $menuUri) === 0) {
                                $item['current'] = true;
                            }
                        };
                array_walk($subMenu, $a, $item['sub']);

            }
        }

        $menu = !empty($sub) ? $subMenu : $this->_menu;
        $template = View::factory('menu/menu')
                        ->bind('menu', $menu)
                        ->bind('attr', $_attr)
                        ->bind('currentUri', $currentUri);

        return $template->render();
    }

}

?>
