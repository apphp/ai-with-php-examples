<?php

declare(strict_types=1);

class InformedSearchGraph {
    private array $adjacencyList;
    private array $levels;
    private array $heuristics;

    public function __construct() {
        $this->adjacencyList = [];
        $this->levels = [];
        $this->heuristics = [];
    }

    public function addVertex(string $vertex, int $level = -1, float $heuristic = 0.0): void {
        if (!isset($this->adjacencyList[$vertex])) {
            $this->adjacencyList[$vertex] = [];
            $this->levels[$vertex] = $level;
            $this->heuristics[$vertex] = $heuristic;
        }
    }

    public function addEdge(string $from, string $to): void {
        if (!isset($this->adjacencyList[$from]) || !isset($this->adjacencyList[$to])) {
            throw new InvalidArgumentException("Both vertices must exist in the graph.");
        }

        if (!in_array($to, $this->adjacencyList[$from])) {
            $this->adjacencyList[$from][] = $to;
        }
    }

    public function printPath(array $path): void {
        foreach ($path as $node) {
            echo sprintf("Node: %s (Level %d, h=%d)\n",
                $node['vertex'],
                $node['level'],
                $node['heuristic']
            );
        }
    }

    public function printGraph(): void {
        foreach ($this->adjacencyList as $vertex => $neighbors) {
            echo sprintf("%s (Level %d, h=%d) -> %s\n",
                $vertex,
                $this->levels[$vertex],
                $this->heuristics[$vertex],
                implode(', ', $neighbors)
            );
        }
    }

    public function greedySearch(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        $path = [];
        $currentVertex = $start;

        // Keep going until we reach the goal
        while ($currentVertex !== $goal) {
            // Add current vertex to path
            $path[] = [
                'vertex' => $currentVertex,
                'level' => $this->levels[$currentVertex],
                'heuristic' => $this->heuristics[$currentVertex]
            ];

            // Get all neighbors of current vertex
            $neighbors = $this->adjacencyList[$currentVertex];

            if (empty($neighbors)) {
                return null; // Dead end
            }

            // Find neighbor with lowest heuristic value
            $bestNeighbor = null;
            $bestHeuristic = PHP_FLOAT_MAX;

            foreach ($neighbors as $neighbor) {
                $h = $this->heuristics[$neighbor];
                if ($h < $bestHeuristic) {
                    $bestHeuristic = $h;
                    $bestNeighbor = $neighbor;
                }
            }

            // If we can't find a better neighbor, we're stuck
            if ($bestNeighbor === null) {
                return null;
            }

            // Move to the best neighbor
            $currentVertex = $bestNeighbor;
        }

        // Add the goal vertex to complete the path
        $path[] = [
            'vertex' => $goal,
            'level' => $this->levels[$goal],
            'heuristic' => $this->heuristics[$goal]
        ];

        return $path;
    }
}
