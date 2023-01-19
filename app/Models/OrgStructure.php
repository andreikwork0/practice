<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgStructure extends Model
{
    use HasFactory;

    protected $guarded = [];


    public  function getTree($company_id)
    {
            $elements = $this->query()->get();//->where('company_id', '=', $company_id)->get();

//            $ar = array();
//            foreach ($elements as $el) {
//                //$ar[$el->id] = $el;
//                if (!is_null($el->org_structure_id)) {
//                    $ar[$el->org_structure_id]['childs'] =
//                }
//            }

        $tree = $this->buildTree($elements);
        $arr = array();
        $this->draw($tree, $arr);



        return $arr;
    }

    public  function buildTree($data, $parent_id = 0, $level = 0)
    {
        $tree = [];
        $level++;
        foreach ($data as $id => $node) {
            if ($node->org_structure_id == $parent_id ) {
                unset($data[$id]);
                $node->level= $level;
                $node->childs = $this->buildTree($data, $node->id, $level);
                $tree[] = $node;
            }
        }
        $level--;
        return $tree;
    }

    public function draw($els, &$arr){
        foreach ($els as $el){
            $item = new \stdClass();
            $item->id = $el->id;
            $item->name =  str_repeat('—', 1 * ($el->level - 1) ). $el->name;
            $arr[] = $item;
            if($el->childs) {
                $this->draw($el->childs, $arr);
            }
        }
    }
}
