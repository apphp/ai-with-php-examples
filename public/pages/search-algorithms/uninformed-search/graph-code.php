<?php

declare(strict_types=1);

class Graph {
    private array $adjacencyList;
    private array $levels;

    public function __construct() {
        $this->adjacencyList = [];
        $this->levels = [];
    }

    public function addVertex(string $vertex, int $level = -1): void {
        if (!isset($this->adjacencyList[$vertex])) {
            $this->adjacencyList[$vertex] = [];
            $this->levels[$vertex] = $level;
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
        $path = [];

        // Mark the starting vertex as visited and enqueue it
        $visited[$startVertex] = true;
        $queue->enqueue($startVertex);

        while (!$queue->isEmpty()) {
            $currentVertex = $queue->dequeue();

            // Add vertex to path
            $path[] = [
                'vertex' => $currentVertex,
                'level' => $this->levels[$currentVertex]
            ];

            // Get all adjacent vertices of the dequeued vertex
            foreach ($this->adjacencyList[$currentVertex] as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = true;
                    $queue->enqueue($neighbor);
                }
            }
        }

        return $path;
    }

    public function dfs(string $startVertex, string $target = null): array {
        if (!isset($this->adjacencyList[$startVertex])) {
            throw new InvalidArgumentException("Start vertex does not exist in the graph");
        }

        $visited = [];
        $path = [];

        // Helper function for recursive DFS
        $dfsRecursive = function(string $vertex) use (&$dfsRecursive, &$visited, &$path, $target): bool {
            // Mark current vertex as visited
            $visited[$vertex] = true;

            // Add vertex to path
            $path[] = [
                'vertex' => $vertex,
                'level' => $this->levels[$vertex]
            ];

            // If we found the target, stop the search
            if ($vertex === $target) {
                return true; // Target found
            }

            // Visit all adjacent vertices
            foreach ($this->adjacencyList[$vertex] as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    if ($dfsRecursive($neighbor)) {
                        return true; // Target found in this path
                    }
                }
            }

            return false; // Target not found in this path
        };

        // Start DFS from the given vertex
        $dfsRecursive($startVertex);
        return $path;
    }

    public function dls(string $startVertex, int $maxDepth, string $target = null): array {
        if (!isset($this->adjacencyList[$startVertex])) {
            throw new InvalidArgumentException("Start vertex does not exist in the graph");
        }

        $visited = [];
        $path = [];
        $found = false;

        // Helper function for recursive DLS
        $dlsRecursive = function(string $vertex, int $depth) use (&$dlsRecursive, &$visited, &$path, &$found, $maxDepth, $target): void {
            // Mark current vertex as visited
            $visited[$vertex] = true;

            // Add vertex to path
            $path[] = [
                'vertex' => $vertex,
                'level' => $this->levels[$vertex],
                'depth' => $depth
            ];

            // If we found the target, mark as found
            if ($vertex === $target) {
                $found = true;
                return;
            }

            // If we've reached max depth, stop exploring this path
            if ($depth >= $maxDepth) {
                return;
            }

            // Visit all adjacent vertices
            foreach ($this->adjacencyList[$vertex] as $neighbor) {
                if (!isset($visited[$neighbor]) && !$found) {
                    $dlsRecursive($neighbor, $depth + 1);
                }
            }

            // If this path didn't lead to the target and we're backtracking,
            // we can optionally remove this vertex from visited to allow it
            // to be visited again through a different path
            if (!$found) {
                unset($visited[$vertex]);
            }
        };

        // Start DLS from the given vertex at depth 0
        $dlsRecursive($startVertex, 0);

        return [
            'path' => $path,
            'found' => $found,
            'maxDepth' => $maxDepth
        ];
    }

    public function getAdjacencyList(): array {
        return $this->adjacencyList;
    }

    public function printPath(array $path): void {
        foreach ($path as $node) {
            echo sprintf("Node: %s (Level %d)\n", $node['vertex'], $node['level']);
        }
    }

    // Helper method to print the adjacency list (for debugging)
    public function printGraph(): void {
        foreach ($this->adjacencyList as $vertex => $neighbors) {
            echo sprintf("%s (Level %d) -> %s\n",
                $vertex,
                $this->levels[$vertex],
                implode(', ', $neighbors)
            );
        }
    }
}
