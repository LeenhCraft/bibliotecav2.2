<?php

namespace App\Models;

class MenuModel extends Model
{
    protected $table = 'menus';

    protected $sql;

    public function menus()
    {
        $menu = $this->where('me_publico', 1)->where("me_status",1)->get();
        foreach ($menu as $key => $value) {
            $menu[$key]['submenus'] = $this->query("SELECT * FROM submenus WHERE idmenu = {$value['idmenu']} AND me_publico = 1 AND me_status = 1")->get();
        }
        return $menu;
    }
}
