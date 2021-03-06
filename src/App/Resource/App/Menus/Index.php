<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\App\Resource\App\Menus;

use Mackstar\Spout\Provide\Resource\ResourceObject;
use BEAR\Package\Module\Database\Dbal\Setter\DbSetterTrait;
use BEAR\Sunday\Annotation\Db;

/**
 * Index
 *
 * @Db
 */
class Index extends ResourceObject
{

    use DbSetterTrait;

    protected $table = 'menus';


    public function onPost(
        $name,
        $slug
    ) {

        $properties = [
            'name' => $name,
            'slug' => $slug
        ];
        $this->db->insert('menus', $properties);
        $this['menu'] = $properties;
        $this['_model'] = 'menu';
        return $this;
    }

    public function onGet()
    {
        $sql = "SELECT * FROM {$this->table}";
        $this['menus'] = $this->db->fetchAll($sql);
        return $this;
    }

    public function onDelete($slug)
    {
        $this->db->delete($this->table, ['slug' => $slug]);
        $this->code = 204;
        return $this;
    }
}
