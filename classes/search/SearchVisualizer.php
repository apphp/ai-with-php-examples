<?php

namespace app\classes\search;

class SearchVisualizer {
    private array $allNodes;
    private array $allEdges;
    private array $visitedEdges;
    private array $nodeLevels;
    private UninformedSearchGraph|InformedSearchGraph $graph;

    public function __construct(UninformedSearchGraph|InformedSearchGraph $graph) {
        $this->graph = $graph;
        $this->allNodes = [];
        $this->allEdges = [];
        $this->visitedEdges = [];
        $this->nodeLevels = [];

        // Get graph structure from UninformedSearchGraph
        $this->initializeGraphStructure();
    }

    private function initializeGraphStructure(): void {
        // Get adjacency list from the graph
        $adjacencyList = $this->graph->getAdjacencyList();

        // Build nodes and edges from adjacency list
        foreach ($adjacencyList as $vertex => $neighbors) {
            if (!in_array($vertex, $this->allNodes)) {
                $this->allNodes[] = $vertex;
            }

            foreach ($neighbors as $neighbor) {
                if (!in_array($neighbor, $this->allNodes)) {
                    $this->allNodes[] = $neighbor;
                }

                // Add edge in both directions since it's undirected
                $edge = "$vertex-$neighbor";
                $reverseEdge = "$neighbor-$vertex";

                if (!in_array($edge, $this->allEdges) && !in_array($reverseEdge, $this->allEdges)) {
                    $this->allEdges[] = $edge;
                }
            }
        }
    }

    public function generateVisualization(array $searchResult, bool $showOriginalGraph = false): array {
        // First, generate the original graph visualization if requested
        $originalGraph = $showOriginalGraph ? $this->generateMermaidGraph() : null;

        // Reset state
        $this->visitedEdges = [];

        // Extract path information
        $path = $searchResult['path'] ?? $searchResult;

        // Generate steps array
        $steps = [];
        $prevNode = null;

        foreach ($path as $node) {
            $currentNode = $node['vertex'] ?? $node;
            $level = $node['level'] ?? $node;

            // Store node level
            if(!empty($this->nodeLevels)){
                $this->nodeLevels[$currentNode] = $level;
            }

            // Add to all nodes if not exists
            if (!in_array($currentNode, $this->allNodes)) {
                $this->allNodes[] = $currentNode;
            }

            // Create edge if we have a previous node
            if ($prevNode !== null) {
                $edge = "$prevNode-$currentNode";
                if (!in_array($edge, $this->allEdges)) {
                    $this->allEdges[] = $edge;
                }
                $this->visitedEdges[] = $edge;
            }

            // Create step info
            $levelNames = ['root', 'first level', 'second level', 'third level', 'fourth level', 'fifth level', 'sixth level', 'seventh level'];

            $last = end($path)['vertex'] ?? end($path);
            $currentNodeName = $this->graph->getVertexLabel($currentNode);
            $info = $currentNode === $last
                ? (isset($levelNames[$level]) ? "Visiting {$levelNames[$level]} node $currentNodeName - Search complete!" : "Visiting node $currentNodeName - Search complete!")
                : (isset($levelNames[$level]) ? "Visiting {$levelNames[$level]} node $currentNodeName" : "Visiting node $currentNodeName");

            $steps[] = [
                'visit' => $currentNode,
                'info' => $info,
                'edge' => $prevNode !== null ? "$prevNode-$currentNode" : null
            ];

            $prevNode = $currentNode;
        }

        // Generate Mermaid graph
        $graph = $this->generateMermaidGraph();

        return [
            'graph' => $graph,
            'originalGraph' => $originalGraph,
            'steps' => json_encode($steps),
            'startNode' => $path[0]['vertex'] ?? $path[0],
            'endNode' => end($path)['vertex'] ?? end($path)
        ];
    }

    private function generateMermaidGraph(): string {
        $graphLines = ['graph TB'];

        // Track visited nodes and their sequence
        $visitedNodesSequence = [];
        foreach ($this->visitedEdges as $edge) {
            [$from, $to] = explode('-', $edge);
            $visitedNodesSequence[] = $from;
            $visitedNodesSequence[] = $to;
        }

        // Function to check if an edge represents backward traversal
        $isBackwardEdge = function($from, $to) use ($visitedNodesSequence) {
            // Get the first occurrence of both nodes
            $fromIndex = array_search($from, $visitedNodesSequence);
            $toIndex = array_search($to, $visitedNodesSequence);

            // If we're going to a node we've seen before and it's earlier in the sequence,
            // it's a backward edge
            return $toIndex !== false && $fromIndex !== false && $toIndex < $fromIndex;
        };

        // Keep track of edge index for styling
        $edgeIndex = 0;
        $backwardEdgeIndices = [];

        // Add edges with appropriate styling
        foreach ($this->allEdges as $edge) {
            [$from, $to] = explode('-', $edge);

            if (in_array($edge, $this->visitedEdges)) {
                // Check if this is a backward edge
                if ($isBackwardEdge($from, $to)) {
                    $backwardEdgeIndices[] = $edgeIndex;
                }
            }

            // Add edge without special styling - we'll style it later
            $graphLines[] = "    $from(($from)) --> $to(($to))";
            $edgeIndex++;
        }

        // Add style definitions
        $graphLines[] = "    classDef default fill:#fff,stroke:#333,stroke-width:2px";
        $graphLines[] = "    linkStyle default stroke:#333,stroke-width:2px";

        // Style backward edges with dotted lines
        if (!empty($backwardEdgeIndices)) {
            $graphLines[] = "    linkStyle " . implode(',', $backwardEdgeIndices) . " stroke:#666,stroke-width:1px,stroke-dasharray: 5";
        }

        return implode("\n", $graphLines);
    }
}
