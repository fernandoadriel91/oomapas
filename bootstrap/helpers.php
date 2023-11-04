<?php
    function menu_builder_iconFn($menu){
        $result = explode(' ', $menu);
        return sizeof($result) > 1 ? $result[sizeof($result) - 1] : $menu;
    }

    function menu_urlFunction($menu){
        $result = Normalizer::normalize($menu['title'], Normalizer::FORM_D);
        $result = preg_replace("/\\\\u([0-9a-fA-F]{4})/", "&#x\\1;", $result);
        $result = html_entity_decode($result, ENT_QUOTES, 'UTF-8');
        $result = iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$result);
        $result = preg_replace('/\s/', '', $result);
        return '#/' . $result;
    }

    function menu_sectionAllowed($parent, $index, $last)
    {
        $allow = true;
        if($last || $parent[$index + 1]->menu == 0)
            $allow = false;
        return $allow;
    }

    function role_permission_value($menu, $permissions)
    {
        foreach ($permissions as $key => $value) {
            if($menu->id == $value->id)
                return $value;
        }
    }