<?php

namespace AgileBundle;

use AgileBundle\Utils\Dbg;

class Bundle {

    /**
     * Current bundle instance
     *
     * @var Bundle|null
     */
    private static ?Bundle $instance = null;

    /**
     * Project root directory
     *
     * @var ?string
     */
    public ?string $projectRoot;

    /**
     * Domain used to access the public directory
     *
     * @var ?string
     */
    public ?string $publicDomain;

    /**
     * Public directory path relatively to the configured domain
     *
     * @var ?string
     */
    public ?string $publicRelativeDirectory;

    /**
     * Defines either if the project is in dev mode or not
     *
     * @var bool
     */
    public bool $isDev;

    /**
     * Dbg prefix when logging
     *
     * @var string
     */
    public string $dbgPrefix;

    /**
     * Bundle constructor.
     * Must be called before all getInstance methods
     *
     * @param ?string $projectRoot Main project root directory
     * @param bool $isDev Defines either if the project is in dev mode or not
     * @param string $dbgPrefix
     */
    public function __construct(
        string $projectRoot = null,
        bool $isDev = true,
        string $dbgPrefix = "",
    ) {
        static::$instance = $this;
        define("BUNDLE_ROOT", dirname(__DIR__));
        $this->projectRoot = $projectRoot;
        $this->isDev = $isDev;
        $this->dbgPrefix = $dbgPrefix;
        if (!is_writable($this->projectRoot . '/data')) die('Error Data folder is not writable.');
        if (!file_exists($this->projectRoot . '/data/cache/')) mkdir($this->projectRoot . '/data/cache/');
        $this->loadFunctions();
        Dbg::init();
    }

    /**
     * Require every functions files in the Function directory
     */
    private function loadFunctions() {
        foreach(glob(BUNDLE_ROOT . "/src/Functions/*.php") as $file){
            if (is_file($file)) {
                require $file;
            }
        }
    }

    /**
     * Return the current instance (if it exists) of the bundle or null
     *
     * @return ?Bundle
     */
    public static function getInstance(): ?Bundle {
        return static::$instance;
    }

}
