<?php

namespace App\Http\Controllers;

use App\Models\OrgStructure;
use Illuminate\Http\Request;

class OrgStructureController extends Controller
{




    public  function getTreeForSelect(Request  $request)
    {
        $elements = OrgStructure::filter(request(['company']))->get();
        $arr = array();

        if ($elements->count() > 0) {
            $tree = $this->buildTree($elements);
            $this->draw($tree, $arr);
        }


        $col = \Illuminate\Support\Collection::make($arr);
        return response()->json(
            [
                'results' =>    $col ?? '',
                // "pagination" => ["more" =>  $col->count() ? true : false ]
            ]
        );
        //return $arr;
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
            $item->name =   str_repeat('—', 1 * ($el->level - 1) ). $el->name;
            $arr[] = $item;
            if($el->childs) {
                $this->draw($el->childs, $arr);
            }
        }
    }
}
