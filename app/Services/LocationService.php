<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class  LocationService extends Service
{
    public function __construct(){
        $this->model = new Location();
    }

    public function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s, 'UTF-8') : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','ї'=>'i','є'=>'e','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','і'=>'i','Ї'=>'i','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'kh','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));

        $s = preg_replace("/(\s|[^0-9a-z-])+/", "-", $s); // очищаем строку от недопустимых символов
        $s = trim($s, '-'); // убираем пробелы в начале и конце строки
        // $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    public function locationsTree ($locations){
        $data = [];
        // трансформируем массив в плоский с ключами id-file  [$file['id'] = $file]
        foreach ($locations as $id => $location) {
            $data[$location['id']] = $location;
        }
        $tree = [];
        // трансформируем массив в древовидный с ключами id-parent-file->id-children-file [$file['children'] = $file]

        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] =& $node;
            } else {
                $data[$node['parent_id']]['children'][$id] =& $node;
            }
        }
         return $tree;
    }

    public function getParentPath ($parent_id, $reg_path) {
        $location[] = Location1::find($parent_id);

        $arr = [];

        if(count($location) > 0 && isset($location)){

            foreach($location as $id => $parent){
                if($parent){
                    $reg_path = 'new_reg('.$parent->parent_id.','.$parent->id.');'.$reg_path;
                    if($parent->parent_id != 0){
                        // $arr[$parent->id]['parent'] = $this->getParentPath ($parent->parent_id, $reg_path);
                        $reg_path = $this->getParentPath ($parent->parent_id, $reg_path);
                        //  $this->getParentPath ($parent_id);
                    }
                }

            }
        }

        return $reg_path;
    }

    public function getParentPathOnlyId ($parent_id, $reg_path) {
        //$location[] = Location::find($parent_id)->only('id', 'parent_id');
        $location[] = Location1::find($parent_id)->toArray();
        $arr = [];
        if($location){
            foreach($location as $id => $parent){
                $reg_path = 'new_reg('.$parent['parent_id'].','.$parent['id'].');'.$reg_path;
                if($parent['parent_id'] != 0){
                    $reg_path = $this->getParentPathOnlyId ($parent['parent_id'], $parent['id']);
                }
            }
        }

        return $reg_path;
    }


}
