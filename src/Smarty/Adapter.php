<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/26
 * Time: 下午2:48
 */
namespace TheFairLib\Smarty;

use \Yaf\View_Interface;
use \Yaf\Loader;

define('SMARTY_PATH', dirname(__FILE__));
Loader::import(SMARTY_PATH . DIRECTORY_SEPARATOR . "libs/Smarty.class.php");
Loader::import(SMARTY_PATH . DIRECTORY_SEPARATOR . "libs/sysplugins/smarty_internal_templatecompilerbase.php");
Loader::import(SMARTY_PATH . DIRECTORY_SEPARATOR . "libs/sysplugins/smarty_internal_templatelexer.php");
Loader::import(SMARTY_PATH . DIRECTORY_SEPARATOR . "libs/sysplugins/smarty_internal_templateparser.php");
Loader::import(SMARTY_PATH . DIRECTORY_SEPARATOR . "libs/sysplugins/smarty_internal_compilebase.php");
Loader::import(SMARTY_PATH . DIRECTORY_SEPARATOR . "libs/sysplugins/smarty_internal_write_file.php");

/**
 *  DEMO
    $config = Registry::get("config")->smarty->toArray();
    $config['template_dir'] = $config['template_dir'] . $request->module . '/';
    $smarty = new TheFairLib\Smarty\Adapter(null, $config);
    Dispatcher::getInstance()->setView($smarty);
 *
 * Class Adapter
 * @package TheFairLib\Smarty
 */
class Adapter implements View_Interface
{
    /**
     * Smarty object
     * @var Smarty
     */
    public $_smarty;

    /**
     * 实现yaf_view模板
     *
     * @param null $tplPath
     * @param array $extraParams
     * @throws \Yaf\Exception
     */
    public function __construct($tplPath = null, $extraParams = array())
    {
        $this->_smarty = new \Smarty();
        if (null !== $tplPath) {
            $this->setScriptPath($tplPath);
        }
        foreach ($extraParams as $key => $value) {
            $this->_smarty->$key = $value;
        }
    }

    /**
     * Return the template engine object
     *
     * @return Smarty
     */
    public function getEngine()
    {
        return $this->_smarty;
    }

    /**
     * Set the path to the templates
     *
     * @param string $path The directory to set as the path.
     * @return void
     */
    public function setScriptPath($path)
    {
        if (is_readable($path)) {
            $this->_smarty->template_dir = $path;
            return;
        }

        throw new \Yaf\Exception('Invalid path provided');
    }

    /**
     * Retrieve the current template directory
     *
     * @return string
     */
    public function getScriptPath()
    {
        return $this->_smarty->template_dir;
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function setBasePath($path, $prefix = '')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function addBasePath($path, $prefix = '')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Assign a variable to the template
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     */
    public function __set($key, $val)
    {
        $this->_smarty->assign($key, $val);
    }

    /**
     * Allows testing with empty() and isset() to work
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        return (null !== $this->_smarty->get_template_vars($key));
    }

    /**
     * Allows unset() on object properties to work
     *
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->_smarty->clear_assign($key);
    }

    /**
     * Assign variables to the template
     *
     * Allows setting a specific key to the specified value, OR passing
     * an array of key => value pairs to set en masse.
     *
     * @see __set()
     * @param string|array $spec The assignment strategy to use (key or
     * array of key => value pairs)
     * @param mixed $value (Optional) If assigning a named variable,
     * use this as the value.
     * @return void
     */
    public function assign($spec, $value = null)
    {
        if (is_array($spec)) {
            $this->_smarty->assign($spec);
            return;
        }
        $this->_smarty->assign($spec, $value);
    }

    /**
     * Clear all assigned variables
     *
     * Clears all variables assigned to Zend_View either via
     * {@link assign()} or property overloading
     * ({@link __get()}/{@link __set()}).
     *
     * @return void
     */
    public function clearVars()
    {
        $this->_smarty->clear_all_assign();
    }

    /**
     * Processes a template and returns the output.
     *
     * @param string $name The template to process.
     * @return string The output.
     */
    public function render($name, $value = null)
    {
        return $this->_smarty->fetch($name);
    }

    public function display($name, $value = null)
    {
        echo $this->_smarty->fetch($name);
    }
}
