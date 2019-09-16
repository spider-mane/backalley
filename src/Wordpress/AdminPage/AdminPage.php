<?php

namespace Backalley\Wordpress\AdminPage;

use Backalley\Wordpress\Traits\UsesTemplateTrait;

/**
 * @package Backalley-Core
 */
class AdminPage
{
    use UsesTemplateTrait;

    /**
     * @var string
     */
    protected $pageTitle = '';

    /**
     * @var string
     */
    protected $menuTitle = '';

    /**
     * @var string
     */
    protected $menuSlug;

    /**
     * @var string
     */
    protected $capability = 'manage_options';

    /**
     * @var callable
     */
    protected $function;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var string
     */
    protected $parentSlug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $showInMenu = true;

    /**
     * The name that will be shown if the page has submenu items
     *
     * @var string
     */
    protected $subMenuName;

    /**
     * @var callable
     */
    protected $alertLoader;

    /**
     * @var callable
     */
    protected $layout;

    /**
     * @var string
     */
    protected $template = 'admin-page-template';

    /**
     *
     */
    public function __construct(string $menuSlug, ?string $capability = null)
    {
        $this->menuSlug = $menuSlug;

        if (isset($capability)) {
            $this->capability = $capability;
        }
    }

    /**
     * Get capability
     *
     * @return  array
     */
    public function getCapability()
    {
        return $this->capability;
    }

    /**
     * Get menu_slug
     *
     * @return  string
     */
    public function getMenuSlug()
    {
        return $this->menuSlug;
    }

    /**
     * Get settings
     *
     * @return  string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set settings
     *
     * @param   string  $pageTitle  settings
     *
     * @return  self
     */
    public function setPageTitle(string $pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get menu_title
     *
     * @return  string
     */
    public function getMenuTitle()
    {
        return $this->menuTitle;
    }

    /**
     * Set settings
     *
     * @param   string  $menu_title  settings
     *
     * @return  self
     */
    public function setMenuTitle(string $menuTitle)
    {
        $this->menuTitle = $menuTitle;

        return $this;
    }

    /**
     * Get function
     *
     * @return callable
     */
    public function getFunction(): callable
    {
        return $this->function;
    }

    /**
     * Set function
     *
     * @param callable $function  function
     *
     * @return  self
     */
    public function setFunction(callable $function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param int  $position  position
     *
     * @return  self
     */
    public function setPosition(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get parent_slug
     *
     * @return  string
     */
    public function getParentSlug()
    {
        return $this->parentSlug;
    }

    /**
     * Set parent_slug
     *
     * @param   string  $parent_slug  parent_slug
     *
     * @return  self
     */
    public function SetParentSlug(string $parentSlug)
    {
        $this->parentSlug = $parentSlug;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Set icon
     *
     * @param string $icon icon
     *
     * @return self
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get show_in_menu
     *
     * @return bool
     */
    public function isShownInMenu(): bool
    {
        return $this->showInMenu;
    }

    /**
     * Set show_in_menu
     *
     * @param bool $showInMenu show_in_menu
     *
     * @return self
     */
    public function setShowInMenu(bool $showInMenu)
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description description
     *
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the name that will be shown it the page has submenu items
     *
     * @return string
     */
    public function getSubMenuName(): string
    {
        return $this->subMenuName;
    }

    /**
     * Set the name that will be shown it the page has submenu items
     *
     * @param string $subMenuName
     *
     * @return self
     */
    public function setSubMenuName(string $subMenuName)
    {
        $this->subMenuName = $subMenuName;

        return $this;
    }

    /**
     * Get the value of alertLoader
     *
     * @return callable
     */
    public function getAlertLoader(): callable
    {
        return $this->alertLoader;
    }

    /**
     * Set the value of alertLoader
     *
     * @param callable $alertLoader
     *
     * @return self
     */
    public function setAlertLoader(callable $alertLoader)
    {
        $this->alertLoader = $alertLoader;

        return $this;
    }

    /**
     *
     */
    public function hook()
    {
        add_action('admin_menu', [$this, 'register']);

        return $this;
    }

    /**
     *
     */
    public function register()
    {
        if (isset($this->parentSlug)) {
            $this->addSubmenuPage()->configurePage('submenu');
        } else {
            $this->addMenuPage()->configurePage('menu');
        }

        return $this;
    }

    /**
     *
     */
    final protected function addSubmenuPage()
    {
        add_submenu_page(
            $this->parentSlug,
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            [$this, 'render']
        );

        return $this;
    }

    /**
     *
     */
    final protected function addMenuPage()
    {
        add_menu_page(
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            [$this, 'render'],
            $this->icon,
            $this->position
        );

        return $this;
    }

    /**
     *
     */
    protected function configurePage(string $level)
    {
        if (false === $this->showInMenu) {
            call_user_func([$this, "remove{$level}page"]);
        }

        return $this;
    }

    /**
     *
     */
    protected function removeMenuPage()
    {
        remove_menu_page($this->menuSlug);

        return $this;
    }

    /**
     *
     */
    protected function removeSubmenuPage()
    {
        remove_submenu_page($this->parentSlug, $this->menuSlug);

        return $this;
    }

    /**
     *
     */
    public function render($args)
    {
        if (!isset($this->function)) {
            $this->renderDefault();
        } else {
            ($this->function)($args, $this);
        }
    }

    /**
     *
     */
    public function renderDefault()
    {
        echo $this->renderTemplate([
            'title' => $this->pageTitle,
            'page' => $this->menuSlug,
            'layout' => $this->layout,
            'alerts' => $this->alertLoader,
            'description' => $this->description,
        ]);
    }
}
