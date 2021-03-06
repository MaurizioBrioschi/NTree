<?php
namespace ridesoft\Graph\NTree;

/**
 * Class Multi Children Tree
 * This class is a representation of a tree where every node can have multiple children
 * This is a non oriented graph, connected and acyclic with a root node (like a tree)
 * The representation of the tree is by a linked list
 * Every Node of the list have three methods: one to get the parent, one to get the left child of the parent, one to get its right sibling
 */
class NTree
{
    /**
     * Name of the tree
     *
     * @var string
     */
    protected $name;
    /**
     * Represents the list nodes
     *
     * @var  Node
     */
    protected $root;

    /**
     * Size of the list reprensenting the tree
     *
     * @var int
     */
    protected $size;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->root = null;
        $this->size = 0;
    }

    /**
     * Insert a node in the tree
     *
     * @param array $node
     * @param array $parent
     *
     * @return NTree|null the NTree object or null if the insert fails
     *
     * @throws Exception
     */
    public function insert(array $node, array $parent): NTree
    {
        if (is_null($parent)) {
            //insert the root element and its son
            if (is_null($this->root)) {
                $this->root = new Node(['name' => $this->name]);
                $child = new Node($node, $this->root);
                $this->root->setLeftChild($child);
                return $this;
            } else {
                $child = new Node($node, $this->root);
                $leftChild = $this->root->getLeftChild();
                if (is_null($leftChild)) {
                    $this->root->setLeftChild(new Node($child, $this->root));
                    return $this;
                } else if ($leftChild->getId() != $child->getId()) {
                    $leftSibling = $this->getRightSibling($leftChild);
                    //if the leftSibling exist, add the right sibling
                    if ($this->search($this->root, $leftSibling->getId()) && !$this->search($this->root, $child->getId())) {
                        $leftSibling->setRightSibling($child);
                    }

                }
                return $this;
            }

        }

        if ($this->search($this->root, $parent['category_id'])) {
            $parentNode = $this->searchNode($this->root, $parent['category_id']);
            $leftChild = $parentNode->getLeftChild();
            $child = new Node($node, $parentNode);
            if (is_null($leftChild)) {
                $parentNode->setLeftChild($child);
            } else if ($leftChild->getId() != $child->getId()) {
                $leftSibling = $this->getRightSibling($leftChild);
                //if the leftSibling exist, add the right sibling
                if ($this->search($parentNode, $leftSibling->getId()) && !$this->search($parentNode, $child->getId())) {
                    $leftSibling->setRightSibling($child);
                }
            }

            return $this;
        } else {
            return null;
        }
    }

    /**
     * Get the right sibling of a node recursively
     *
     * @param Node $node
     *
     * @return Node the right siblig or the node if the right sibling is null
     */
    public function getRightSibling(Node $node): Node
    {
        $rightSibling = $node->getRightSibling();
        if (is_null($rightSibling)) {
            return $node;
        } else {
            return $this->getRightSibling($rightSibling);
        }

    }

    /**
     * Get the right sibling of a node, recursively to its parent
     *
     * @param Node $node
     *
     * @return Node
     */
    public function getRightSiblingParentRecursively(Node $node): Node
    {
        $rightSibling = $node->getRightSibling();
        if (is_null($rightSibling)) {
            if (is_null($node->getParent())) {
                return null;
            }
            return $this->getRightSiblingParentRecursively($node->getParent());
        } else {
            return $rightSibling;
        }

    }

    /**
     * Search recursively for a node with $id
     *
     * @param Node $rootNode starting node
     * @param int $id
     *
     * @return bool
     */
    protected function search(Node $rootNode, int $id): bool
    {
        //if the rootNode node is not present -> exist fail point
        if (is_null($rootNode)) {
            return false;
        }
        //if node id is equal to the id i'm searching -> exist positive point
        if ($rootNode->getId() == $id) {
            return true;
        } else {
            //try to see if the left child is good -> i'm exploring in deep
            $node = $rootNode->getLeftChild();
            while (!is_null($node)) {
                return $this->search($node, $id);
            }
            //no sub node found in deep, so i try in widht
            $node = $this->getRightSiblingParentRecursively($rootNode);
            return $this->search($node, $id);
        }
    }

    /**
     * Search recursively for a node with $id
     *
     * @param Node $rootNode starting node
     * @param int $id
     *
     * @return Node|null
     */
    protected function searchNode(Node $rootNode, int $id): Node
    {
        //if the rootNode node is not present -> exist fail point
        if (is_null($rootNode)) {
            return null;
        }
        //if node id is equal to the id i'm searching -> exist positive point
        if ($rootNode->getId() == $id) {
            return $rootNode;
        } else {
            //try to see if the left child is good -> i'm exploring in deep
            $node = $rootNode->getLeftChild();
            while (!is_null($node)) {
                return $this->searchNode($node, $id);
            }
            //no sub node found in deep, so i try in widht
            $node = $this->getRightSiblingParentRecursively($rootNode);
            return $this->searchNode($node, $id);
        }
    }

    /**
     * Get the root node
     *
     * @return Node|null
     */
    public function getRootNode(): Node
    {
        return $this->root;
    }

    /**
     * Visit a node with $id in deep
     *
     * @param null $id
     *
     * @return Node|null
     */
    public function deepVisitByNodeId(int $id = null): Node
    {
        if (is_null($id)) {
            return $this->root;
        }
        $node = $this->searchNode($this->root, $id);

        return $node;
    }

    /**
     * Visit a node with $id in width
     * Get all its siblings
     *
     * @param null $id
     *
     * @return array|null
     */
    public function widthVisitByNodeId(int $id = null): Node
    {

        if (is_null($id)) {
            return null;
        }
        $node = $this->searchNode($this->root, $id);
        $siblings = [];
        while (!is_null($node)) {
            $siblings[] = $node->getValues();
            $node = $node->getRightSibling();
        }

        return $siblings;
    }

    /**
     * Get all the children values of a node
     *
     * @param int $id
     * @param bool $sorted if i want to sort children
     * @param string $sortedKey key value for sorting
     *
     * @return array|null children values or null if there are not children
     */
    public function getAllChildren(int $id, bool $sorted = true, string $sortedKey = 'position'): array
    {

        if (is_null($id)) {
            $node = $this->root;
        } else {
            $node = $this->searchNode($this->root, $id);;
        }
        $node = $node->getLeftChild();
        if (!is_null($node)) {
            $children = $this->widthVisitByNodeId($node->getId());
            if ($sorted) {
                $children = $this->quicksortSibling($children, $sortedKey);
            }
            return $children;
        }

        return null;
    }

    /**
     * Sort Sibling recursively using a quicksort algorithm
     *
     * @param array $children
     * @param $key
     *
     * @return array Siblings values
     */
    protected function quicksortSibling(array $children, string $key): array
    {

        if (count($children) < 2) {
            return $children;
        }
        $left = $right = array();
        reset($array);
        $pivot_key = key($children);
        $pivot = array_shift($children);
        foreach ($children as $k => $v) {
            if ((int)$v[$key] < (int)$pivot[$key])
                $left[$k] = $v;
            else
                $right[$k] = $v;
        }
        return array_merge($this->quicksortSibling($left, $key), array($pivot_key => $pivot), $this->quicksortSibling($right, $key));
    }
}

