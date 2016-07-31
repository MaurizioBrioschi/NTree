<?php

/**
 * Class NodeTest
 */
class NodeTest extends PHPUnit_Framework_TestCase
{
    protected $node;

    public function setUp()
    {
        $this->node = new \ridesoft\Graph\NTree\Node(
            [
                'name' => 'child',
                'music' => 'rock'
            ], new \ridesoft\Graph\NTree\Node(
                [
                    'name' => 'parent',
                    'music' => 'hard rock'
                ]
            )
        );
    }

    /**
     * @test
     * @group Ridesoft
     * @group Ridesoft_Graph
     * @group Ridesoft_Graph_NTree
     * @group Ridesoft_Graph_NTree_Node
     * @group Ridesoft_Graph_NTree_Node_GetParent
     */
    public function getParent()
    {
        $parent = $this->node->getParent();
        $this->assertInstanceOf('\ridesoft\Graph\NTree\Node', $parent);
    }

    /**
     * @test
     * @group Ridesoft
     * @group Ridesoft_Graph
     * @group Ridesoft_Graph_NTree
     * @group Ridesoft_Graph_NTree_Node
     * @group Ridesoft_Graph_NTree_Node_SetGetLeftChild
     */
    public function setLeftChild(Node $child): Node
    {


    }

    /**
     * @test
     * @group Ridesoft
     * @group Ridesoft_Graph
     * @group Ridesoft_Graph_NTree
     * @group Ridesoft_Graph_NTree_Node
     * @group Ridesoft_Graph_NTree_Node_SetRightSibling
     */
    public function setRightSibling(Node $sibling): Node
    {

    }

    /**
     * @test
     * @group Ridesoft
     * @group Ridesoft_Graph
     * @group Ridesoft_Graph_NTree
     * @group Ridesoft_Graph_NTree_Node
     * @group Ridesoft_Graph_NTree_Node_GetLeftChild
     */
    public function getLeftChild(): Node
    {

    }

    /**
     * @test
     * @group Ridesoft
     * @group Ridesoft_Graph
     * @group Ridesoft_Graph_NTree
     * @group Ridesoft_Graph_NTree_Node
     * @group Ridesoft_Graph_NTree_Node_GetRightSibling
     */
    public function getRightSibling(): Node
    {

    }

    /**
     * @test
     * @group Ridesoft
     * @group Ridesoft_Graph
     * @group Ridesoft_Graph_NTree
     * @group Ridesoft_Graph_NTree_Node
     * @group Ridesoft_Graph_NTree_Node_GetId
     */
    public function getId(): int
    {

    }

    /**
     * @test
     * @group Ridesoft
     * @group Ridesoft_Graph
     * @group Ridesoft_Graph_NTree
     * @group Ridesoft_Graph_NTree_Node
     * @group Ridesoft_Graph_NTree_Node_GetValues
     */
    public function getValues(): array
    {

    }
}
