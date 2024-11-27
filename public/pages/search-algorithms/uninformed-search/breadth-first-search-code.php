<?php

declare(strict_types=1);

class Graph {
    private array $adjacencyList;

    public function __construct() {
        $this->adjacencyList = [];
    }

    public function addVertex(string $vertex): void {
        if (!isset($this->adjacencyList[$vertex])) {
            $this->adjacencyList[$vertex] = [];
        }
    }

    public function addEdge(string $vertex1, string $vertex2): void {
        if (!isset($this->adjacencyList[$vertex1]) || !isset($this->adjacencyList[$vertex2])) {
            throw new InvalidArgumentException("Both vertices must exist in the graph");
        }

        $this->adjacencyList[$vertex1][] = $vertex2;
        $this->adjacencyList[$vertex2][] = $vertex1; // For undirected graph
    }

    public function bfs(string $startVertex): array {
        if (!isset($this->adjacencyList[$startVertex])) {
            throw new InvalidArgumentException("Start vertex does not exist in the graph");
        }

        $visited = [];
        $queue = new SplQueue();
        $result = [];

        // Mark the starting vertex as visited and enqueue it
        $visited[$startVertex] = true;
        $queue->enqueue($startVertex);

        while (!$queue->isEmpty()) {
            $currentVertex = $queue->dequeue();
            $result[] = $currentVertex;

            // Get all adjacent vertices of the dequeued vertex
            foreach ($this->adjacencyList[$currentVertex] as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = true;
                    $queue->enqueue($neighbor);
                }
            }
        }

        return $result;
    }

    public function getAdjacencyList(): array {
        return $this->adjacencyList;
    }
}
