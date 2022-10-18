<?php

namespace Tools;

class Node{
    public $val;
    public $left = null;
    public $right = null;
    public function __construct($val){
        $this->val = $val;
    }
}

class BTree{
    private $_head = null;
    private $_level = 0;
    private $_tree_traverse_values = [];
    const PRE_ORDER_TRAVERSE = 1;//前序
    const IN_ORDER_TRAVERSE = 2;//中序
    const POST_ORDER_TRAVERSE = 3;//后序
    const LEVEL_ORDER_TRAVERSE = 4;//层序

    public function __construct($data=[]){
        $this->_level = intval(log(count($data)+1, 2));
        $this->_head = $this->_init_tree($data);
    }

    private function _init_tree($data, $level=1, $index=1){
        $node = null;
        $n = pow(2, $level-1)-1+$index;
        if(isset($data[$n-1]) && $data[$n-1] != null){
            $node = new Node($data[$n-1]);
            $node->left = $this->_init_tree($data, $level+1, $index*2-1);
            $node->right = $this->_init_tree($data, $level+1, $index*2);
        }
        return $node;
    }

    public function traverse($traverse_order=self::PRE_ORDER_TRAVERSE){
        $this->_tree_traverse_values = [];
        if($traverse_order == self::PRE_ORDER_TRAVERSE){
            $this->_pre_order_traverse($this->_head);
        }
        if($traverse_order == self::IN_ORDER_TRAVERSE){
            $this->_in_order_traverse($this->_head);
        }
        if($traverse_order == self::POST_ORDER_TRAVERSE){
            $this->_post_order_traverse($this->_head);
        }
        if($traverse_order == self::LEVEL_ORDER_TRAVERSE){
            $this->_level_order_traverse($this->_head);
        }
        return $this->_tree_traverse_values;
    }

    /**
     * root -> left -> right
     */
    private function _pre_order_traverse($node){
        array_push($this->_tree_traverse_values, $node->val);
        if($node->left != null){
            $this->_pre_order_traverse($node->left);
        }
        if($node->right != null){
            $this->_pre_order_traverse($node->right);
        }
    }

    /**
     * left -> root -> right
     */
    private function _in_order_traverse($node){
        if($node->left != null){
            $this->_in_order_traverse($node->left);
        }
        array_push($this->_tree_traverse_values, $node->val);
        if($node->right != null){
            $this->_in_order_traverse($node->right);
        }
    }

    /**
     * left -> right -> root
     */
    private function _post_order_traverse($node){
        if($node->left != null){
            $this->_post_order_traverse($node->left);
        }
        if($node->right != null){
            $this->_post_order_traverse($node->right);
        }
        array_push($this->_tree_traverse_values, $node->val);
    }

    /*
     * breadth first traverse
     */
    private function _level_order_traverse($node, $level=0){
        if($node){
            if(!isset($this->_tree_traverse_values[$level])){
                $this->_tree_traverse_values[$level] = [];
            }
            array_push($this->_tree_traverse_values[$level], $node->val);
            if($node->left != null){
                $this->_level_order_traverse($node->left, $level+1);
            }
            if($node->right != null){
                $this->_level_order_traverse($node->right, $level+1);
            }
        }
    }
}

$bt = new BTree([
                    'F',
           'B',                'G',
      'A',      'D',      null,    'I',
    null,null,'C','E', null,null,'H',null
]);

// var_dump($bt);
// $bt = new BTree('F', 'B', 'G', 'A','D',null,'I', null, null,'C', 'E',null,null,'H',null);
echo 'pre-order traverse result:   '.json_encode($bt->traverse(BTree::PRE_ORDER_TRAVERSE)).PHP_EOL;
echo 'in-order traverse result:    '.json_encode($bt->traverse(BTree::IN_ORDER_TRAVERSE)).PHP_EOL;
// echo 'post-order traverse result:  '.json_encode($bt->traverse(BTree::POST_ORDER_TRAVERSE)).PHP_EOL;
// echo 'level-order traverse result: '.json_encode($bt->traverse(BTree::LEVEL_ORDER_TRAVERSE)).PHP_EOL;