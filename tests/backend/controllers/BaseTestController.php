<?php
namespace Robinson\Backend\Controllers;
class BaseTestController extends \Phalcon\Test\FunctionalTestCase
{
    public function setUp(\Phalcon\DiInterface $di = null, \Phalcon\Config $config = null)
    {
        /**
        * Include services
        */
        require APPLICATION_PATH . '/../config/services.php';

        $config = include APPLICATION_PATH . '/backend/config/config.php';
        $config['database']['dbname'] = 'robinson_testing';
        $di = include APPLICATION_PATH . '/backend/config/services.php';
        
        parent::setUp($di, $config);
        
        $this->application->registerModules(array
        (
            'backend' => array
            (
                'className' => 'Robinson\Backend\Module',
                'path' => APPLICATION_PATH . '/backend/Module.php',
            ),
        ));
    }
    
    protected function registerMockSession()
    {
        $sessionMock = $this->getMock('Phalcon\Session\Adapter\Files', array('get'));
        $sessionMock->expects($this->any())
            ->method('get')
            ->with($this->equalTo('auth'))
            ->will($this->returnValue(array('username' => 'nemanja')));
        $this->getDI()->set('session', $sessionMock);
    }
    
    /**
     * 
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function makeRequestMock($methods = array())
    {
        $requestMock = $this->getMock('Phalcon\Http\Request', $methods);
        return $requestMock;
    }
    
    /**
        * Populates a table with default data
        *
        * @param      $table
        * @param null $records
        * @author Nikos Dimopoulos <nikos@phalconphp.com>
        * @since  2012-11-08
        */
       public function populateTable($table, $records = null)
       {
            // Empty the table first
            $this->emptyTable($table);

            $connection = $this->di->get('db');
            $parts = explode('_', $table);
            $suffix = '';

            foreach ($parts as $part) {
                    $suffix .= ucfirst($part);
            }
            include_once APPLICATION_PATH . '/../tests/fixtures/' . $suffix . '.php';
            $class = 'Phalcon\Test\Fixtures\\' . $suffix;

            $data = $class::get($records);

            foreach ($data as $record) {
                    $sql = "INSERT INTO {$table} VALUES " . $record;
                    $connection->execute($sql);
            }
       }
}