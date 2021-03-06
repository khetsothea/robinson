<?php
namespace Phalcon\Test\Fixtures;
class CategoryImages
{
    /**
     * Creates CategoryImages fixtures.
     * 
     * @param array $records records
     * 
     * @return string
     */
    public static function get($records = null)
    {
        $template = "(%d, '%s', '%s', %d, %d, '%s', %d, %d)";
        for ($i = 1; $i <= 5; $i++)
        {
            $data[] = "($i, 'testfile$i', '2014-01-01 0$i:00:00', 1, $i, 'jpg', 250, 100)";
        }
        return $data;
    }
}