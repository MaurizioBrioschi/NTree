<?php

namespace ridesoft\Graph\NTree;

/**
 * Class Node
 */
class Node
{

    protected $values;
    /**
     * @var Node
     */
    protected $parent;

    /**
     * @var Node
     */
    protected $leftChild;

    /**
     * @var Node
     */
    protected $rightSibling;

    public function __construct(array $values = [], Node $parent = null)
    {
        $this->values = $values;
        $this->parent = $parent;
    }

    /**
     * Get the parent
     *
     * @return Node
     */
    public function getParent(): Node
    {
        return $this->parent;
    }

    /**
     * Get the Left child of its parent
     *
     * @return Node|null
     */
    public function getLeftChild(): Node
    {
        return $this->leftChild;
    }

    /**
     * Get the right Sibling
     *
     * @return Node|null
     */
    public function getRightSibling(): Node
    {
        return $this->rightSibling;
    }

    /**
     * Set the left child
     *
     * @param Node $child
     *
     * @return $this
     */
    public function setLeftChild(Node $child): Node
    {
        $this->leftChild = $child;

        return $this;
    }

    /**
     * Set the right Sibling od the node
     *
     * @param Node $sibling
     *
     * @return $this
     */
    public function setRightSibling(Node $sibling): Node
    {
        $this->rightSibling = $sibling;

        return $this;
    }

    /**
     * Get the id of the node
     *
     * @return int
     */
    public function getId(): int
    {
        if(array_key_exists('category_id', $this->values)){
            return $this->values['category_id'];
        }
        return 0;
    }

    /**
     * Get all the values of the node
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
