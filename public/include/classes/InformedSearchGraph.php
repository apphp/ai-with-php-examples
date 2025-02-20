<?php

namespace app\public\include\classes;

use InvalidArgumentException;

class InformedSearchGraph {
    private array $adjacencyList;
    private array $vertexLabels;
    private array $levels;
    private array $heuristics;
    private array $edgeCosts;

    public function __construct() {
        $this->adjacencyList = [];
        $this->vertexLabels = [];
        $this->levels = [];
        $this->heuristics = [];
        $this->edgeCosts = [];
    }

    public function addVertex(string $vertex, int $level = -1, float $heuristic = 0.0, string $label = ''): void {
        if (!isset($this->adjacencyList[$vertex])) {
            $this->adjacencyList[$vertex] = [];
            $this->vertexLabels[$vertex] = $label;
            $this->levels[$vertex] = $level;
            $this->heuristics[$vertex] = $heuristic;
            $this->edgeCosts[$vertex] = [];
        }
    }

    public function getVertexLabel(string $vertex = ''): string {
        return $this->vertexLabels[$vertex] ?? $vertex;
    }

    public function addEdge(string $from, string $to, float $cost = 1.0): void {
        if (!isset($this->adjacencyList[$from]) || !isset($this->adjacencyList[$to])) {
            throw new InvalidArgumentException('Both vertices must exist in the graph.');
        }

        if (!isset($this->edgeCosts[$from])) {
            $this->edgeCosts[$from] = [];
        }

        if (!in_array($to, $this->adjacencyList[$from])) {
            $this->adjacencyList[$from][] = $to;
            $this->edgeCosts[$from][$to] = $cost;
        }
    }

    public function getEdgeCost(string $from, string $to): float {
        if (!isset($this->edgeCosts[$from][$to])) {
            throw new InvalidArgumentException("No edge exists between $from and $to");
        }
        return $this->edgeCosts[$from][$to];
    }

    public function greedySearch(string $start, string $goal, $maxSteps = 100): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException('Both start and goal vertices must exist in the graph.');
        }

        $path = [];
        $currentVertex = $start;

        // Keep going until we reach the goal
        $count = 0;
        while ($currentVertex !== $goal && $count < $maxSteps) {
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
            $count++;
        }

        // No path found within reasonable time
        if ($count >= $maxSteps) {
            return null;
        }

        // Add the goal vertex to complete the path
        $path[] = [
            'vertex' => $goal,
            'level' => $this->levels[$goal],
            'heuristic' => $this->heuristics[$goal]
        ];

        return $path;
    }

    public function aStarTreeSearch(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        // Priority queue implemented as array with state information
        $openSet = [[
            'vertex' => $start,
            'gScore' => 0.0,
            'fScore' => $this->heuristics[$start],
            'path' => [
                [
                    'vertex' => $start,
                    'level' => $this->levels[$start],
                    'heuristic' => $this->heuristics[$start]
                ]
            ]
        ]];

        while (!empty($openSet)) {
            // Find node in openSet with lowest fScore
            $currentIndex = 0;
            $currentFScore = $openSet[0]['fScore'];

            for ($i = 1; $i < count($openSet); $i++) {
                if ($openSet[$i]['fScore'] < $currentFScore) {
                    $currentIndex = $i;
                    $currentFScore = $openSet[$i]['fScore'];
                }
            }

            $current = $openSet[$currentIndex];
            $currentVertex = $current['vertex'];

            // Check if we've reached the goal
            if ($currentVertex === $goal) {
                return $current['path'];
            }

            // Remove current from openSet
            array_splice($openSet, $currentIndex, 1);

            // Explore all neighbors
            foreach ($this->adjacencyList[$currentVertex] as $neighbor) {
                // Calculate g score for this path
                $tentativeGScore = $current['gScore'] + $this->getEdgeCost($currentVertex, $neighbor);

                // Calculate f score (g score + heuristic)
                $fScore = $tentativeGScore + $this->heuristics[$neighbor];

                // Create new path
                $newPath = $current['path'];
                $newPath[] = [
                    'vertex' => $neighbor,
                    'level' => $this->levels[$neighbor],
                    'heuristic' => $this->heuristics[$neighbor]
                ];

                // Add new state to openSet
                $openSet[] = [
                    'vertex' => $neighbor,
                    'gScore' => $tentativeGScore,
                    'fScore' => $fScore,
                    'path' => $newPath
                ];
            }
        }

        return null; // No path found
    }

    public function aStarGroupSearch(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        $openSet = [$start];
        $cameFrom = [];
        $gScore = [$start => 0.0];
        $fScore = [$start => $this->heuristics[$start]];

        while (!empty($openSet)) {
            // Find node in openSet with lowest fScore
            $current = $openSet[0];
            $currentFScore = $fScore[$current];
            foreach ($openSet as $node) {
                if ($fScore[$node] < $currentFScore) {
                    $current = $node;
                    $currentFScore = $fScore[$node];
                }
            }

            if ($current === $goal) {
                // Reconstruct path
                $path = [$current];
                while (isset($cameFrom[$current])) {
                    $current = $cameFrom[$current];
                    array_unshift($path, $current);
                }
                return $path;
            }

            // Remove current from openSet
            $openSet = array_values(array_diff($openSet, [$current]));

            // Explore neighbors
            foreach ($this->adjacencyList[$current] as $neighbor) {
                $tentativeGScore = $gScore[$current] + $this->getEdgeCost($current, $neighbor);

                if (!isset($gScore[$neighbor]) || $tentativeGScore < $gScore[$neighbor]) {
                    $cameFrom[$neighbor] = $current;
                    $gScore[$neighbor] = $tentativeGScore;
                    $fScore[$neighbor] = $tentativeGScore + $this->heuristics[$neighbor];

                    if (!in_array($neighbor, $openSet)) {
                        $openSet[] = $neighbor;
                    }
                }
            }
        }

        return null; // No path found
    }

    public function beamSearch(string $start, string $goal, int $beamWidth = 2): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        // Initialize beam with start vertex
        $beam = [[
            'vertex' => $start,
            'path' => [
                [
                    'vertex' => $start,
                    'level' => $this->levels[$start],
                    'heuristic' => $this->heuristics[$start]
                ]
            ]
        ]];

        $visited = [$start => true];

        while (!empty($beam)) {
            $candidates = [];

            // Generate all possible next states from current beam
            foreach ($beam as $state) {
                $currentVertex = $state['vertex'];

                // Check if we've reached the goal
                if ($currentVertex === $goal) {
                    return $state['path'];
                }

                // Get all neighbors of current vertex
                foreach ($this->adjacencyList[$currentVertex] as $neighbor) {
                    // Skip if we've already visited this vertex
                    if (isset($visited[$neighbor])) {
                        continue;
                    }

                    $newPath = $state['path'];
                    $newPath[] = [
                        'vertex' => $neighbor,
                        'level' => $this->levels[$neighbor],
                        'heuristic' => $this->heuristics[$neighbor]
                    ];

                    $candidates[] = [
                        'vertex' => $neighbor,
                        'path' => $newPath,
                        'heuristic' => $this->heuristics[$neighbor]
                    ];

                    $visited[$neighbor] = true;
                }
            }

            if (empty($candidates)) {
                return null; // No path found
            }

            // Sort candidates by heuristic value (ascending)
            usort($candidates, function($a, $b) {
                return $a['heuristic'] <=> $b['heuristic'];
            });

            // Keep only the k best candidates (beam width)
            $beam = array_slice($candidates, 0, $beamWidth);
        }

        return null; // No path found
    }

    public function idaStarSearch(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        // Initialize the bound as the heuristic value of the start node
        $bound = $this->heuristics[$start];

        // Initial path contains only the start node
        $path = [
            [
                'vertex' => $start,
                'level' => $this->levels[$start],
                'heuristic' => $this->heuristics[$start]
            ]
        ];

        while (true) {
            // Search with current bound
            $result = $this->idaStarRecursive($path, 0, $bound, $goal);

            if (is_array($result)) {
                // Path found
                return $result;
            }

            if ($result === PHP_FLOAT_MAX) {
                // No path exists
                return null;
            }

            // Update bound to the minimum f-value that exceeded current bound
            $bound = $result;
        }
    }

    private function idaStarRecursive(array $path, float $g, float $bound, string $goal): array|float {
        $current = $path[count($path) - 1]['vertex'];
        $f = $g + $this->heuristics[$current];

        // If f exceeds bound, return f as the new minimum bound
        if ($f > $bound) {
            return $f;
        }

        // If goal is reached, return the path
        if ($current === $goal) {
            return $path;
        }

        $min = PHP_FLOAT_MAX;

        // Explore all neighbors
        foreach ($this->adjacencyList[$current] as $neighbor) {
            // Check if neighbor is already in path (avoid cycles)
            $inPath = false;
            foreach ($path as $node) {
                if ($node['vertex'] === $neighbor) {
                    $inPath = true;
                    break;
                }
            }
            if ($inPath) {
                continue;
            }

            // Add neighbor to path
            $path[] = [
                'vertex' => $neighbor,
                'level' => $this->levels[$neighbor],
                'heuristic' => $this->heuristics[$neighbor]
            ];

            // Recursively search from neighbor
            $result = $this->idaStarRecursive(
                $path,
                $g + $this->getEdgeCost($current, $neighbor),
                $bound,
                $goal
            );

            // Remove neighbor from path (backtrack)
            array_pop($path);

            // Process result
            if (is_array($result)) {
                // Path to goal found
                return $result;
            }

            // Update minimum bound if needed
            if ($result < $min) {
                $min = $result;
            }
        }

        return $min;
    }

    /**
     * Simple Hill Climbing: Takes the first neighbor that improves the current state.
     * Faster but may miss better solutions.
     */
    public function simpleHillClimbing(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        $currentVertex = $start;
        $path = [[
            'vertex' => $start,
            'level' => $this->levels[$start],
            'heuristic' => $this->heuristics[$start]
        ]];

        $visited = [$start => true];

        while ($currentVertex !== $goal) {
            $neighbors = $this->adjacencyList[$currentVertex];
            if (empty($neighbors)) {
                return null; // Dead end
            }

            // Find first better neighbor
            $betterFound = false;
            $currentHeuristic = $this->heuristics[$currentVertex];

            foreach ($neighbors as $neighbor) {
                if (isset($visited[$neighbor])) {
                    continue;
                }

                if ($this->heuristics[$neighbor] < $currentHeuristic) {
                    $currentVertex = $neighbor;
                    $visited[$neighbor] = true;
                    $path[] = [
                        'vertex' => $neighbor,
                        'level' => $this->levels[$neighbor],
                        'heuristic' => $this->heuristics[$neighbor]
                    ];
                    $betterFound = true;
                    break;
                }
            }

            if (!$betterFound) {
                return null; // Local maximum reached
            }
        }

        return $path;
    }

    /**
     * Steepest Ascent Hill Climbing: Evaluates all neighbors and selects the one
     * that provides the maximum improvement. More thorough but slower.
     */
    public function steepestAscentHillClimbing(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        $currentVertex = $start;
        $path = [[
            'vertex' => $start,
            'level' => $this->levels[$start],
            'heuristic' => $this->heuristics[$start]
        ]];

        $visited = [$start => true];

        while ($currentVertex !== $goal) {
            $neighbors = $this->adjacencyList[$currentVertex];
            if (empty($neighbors)) {
                return null; // Dead end
            }

            // Find the neighbor with maximum improvement
            $bestNeighbor = null;
            $bestImprovement = 0;
            $currentHeuristic = $this->heuristics[$currentVertex];

            foreach ($neighbors as $neighbor) {
                if (isset($visited[$neighbor])) {
                    continue;
                }

                $improvement = $currentHeuristic - $this->heuristics[$neighbor];
                if ($improvement > $bestImprovement) {
                    $bestImprovement = $improvement;
                    $bestNeighbor = $neighbor;
                }
            }

            if ($bestNeighbor === null) {
                return null; // Local maximum reached
            }

            $currentVertex = $bestNeighbor;
            $visited[$currentVertex] = true;
            $path[] = [
                'vertex' => $currentVertex,
                'level' => $this->levels[$currentVertex],
                'heuristic' => $this->heuristics[$currentVertex]
            ];
        }

        return $path;
    }

    /**
     * Stochastic Hill Climbing: Randomly selects among the better neighbors,
     * with probability proportional to the amount of improvement.
     * Can escape some local maxima but may take longer to converge.
     */
    public function stochasticHillClimbing(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        $currentVertex = $start;
        $path = [[
            'vertex' => $start,
            'level' => $this->levels[$start],
            'heuristic' => $this->heuristics[$start]
        ]];

        $visited = [$start => true];
        $maxAttempts = 100; // Prevent infinite loops
        $attempts = 0;

        while ($currentVertex !== $goal && $attempts < $maxAttempts) {
            $neighbors = $this->adjacencyList[$currentVertex];
            if (empty($neighbors)) {
                return null; // Dead end
            }

            // Collect better neighbors and their improvements
            $candidates = [];
            $totalImprovement = 0;
            $currentHeuristic = $this->heuristics[$currentVertex];

            foreach ($neighbors as $neighbor) {
                if (isset($visited[$neighbor])) {
                    continue;
                }

                $improvement = $currentHeuristic - $this->heuristics[$neighbor];
                if ($improvement > 0) {
                    $candidates[] = [
                        'vertex' => $neighbor,
                        'improvement' => $improvement
                    ];
                    $totalImprovement += $improvement;
                }
            }

            if (empty($candidates)) {
                return null; // Local maximum reached
            }

            // Randomly select a neighbor, weighted by improvement
            $random = mt_rand() / mt_getrandmax() * $totalImprovement;
            $sum = 0;
            $selectedNeighbor = null;

            foreach ($candidates as $candidate) {
                $sum += $candidate['improvement'];
                if ($sum >= $random) {
                    $selectedNeighbor = $candidate['vertex'];
                    break;
                }
            }

            if ($selectedNeighbor === null) {
                $selectedNeighbor = $candidates[array_key_last($candidates)]['vertex'];
            }

            $currentVertex = $selectedNeighbor;
            $visited[$currentVertex] = true;
            $path[] = [
                'vertex' => $currentVertex,
                'level' => $this->levels[$currentVertex],
                'heuristic' => $this->heuristics[$currentVertex]
            ];

            $attempts++;
        }

        return $attempts < $maxAttempts ? $path : null;
    }

    /*
     | ----------------------------------------------------------------------
     | DEBUG methods
     | ----------------------------------------------------------------------
     */

    /**
     * Debug output for Beam Search showing the beam selection process
     * and path finding decisions
     */
    public function debugBeamSearch(string $start, string $goal, int $beamWidth = 2): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        echo "\n=== Beam Search Debug (Beam Width: {$beamWidth}) ===\n";
        echo "Starting from {$start} to reach {$goal}\n";

        // Initialize beam with start vertex
        $beam = [[
            'vertex' => $start,
            'path' => [
                [
                    'vertex' => $start,
                    'level' => $this->levels[$start],
                    'heuristic' => $this->heuristics[$start]
                ]
            ]
        ]];

        $visited = [$start => true];
        $iteration = 0;

        while (!empty($beam)) {
            $iteration++;
            echo "\n=== Iteration {$iteration} ===\n";
            echo "Current beam states:\n";
            foreach ($beam as $index => $state) {
                echo sprintf("  %d. %s (h=%.2f)\n",
                    $index + 1,
                    $state['vertex'],
                    $this->heuristics[$state['vertex']]
                );
            }

            $candidates = [];

            // Generate all possible next states from current beam
            foreach ($beam as $state) {
                $currentVertex = $state['vertex'];
                echo "\nExpanding vertex: {$currentVertex}\n";

                // Check if we've reached the goal
                if ($currentVertex === $goal) {
                    echo "\nGoal state reached!\n";
                    echo "Final path: \n" . implode(" -> ", $this->getSequenceNames(array_column($state['path'], 'vertex'))) . "\n\n";
                    return $state['path'];
                }

                // Get all neighbors of current vertex
                echo "Evaluating neighbors:\n";
                foreach ($this->adjacencyList[$currentVertex] as $neighbor) {
                    if (isset($visited[$neighbor])) {
                        echo "  {$neighbor}: Skipped (already visited)\n";
                        continue;
                    }

                    $newPath = $state['path'];
                    $newPath[] = [
                        'vertex' => $neighbor,
                        'level' => $this->levels[$neighbor],
                        'heuristic' => $this->heuristics[$neighbor]
                    ];

                    $candidates[] = [
                        'vertex' => $neighbor,
                        'path' => $newPath,
                        'heuristic' => $this->heuristics[$neighbor]
                    ];

                    echo sprintf("  %s: Added as candidate (h=%.2f)\n",
                        $neighbor,
                        $this->heuristics[$neighbor]
                    );

                    $visited[$neighbor] = true;
                }
            }

            if (empty($candidates)) {
                echo "\nNo candidates available - search failed\n";
                return null;
            }

            // Sort candidates by heuristic value (ascending)
            usort($candidates, function($a, $b) {
                return $a['heuristic'] <=> $b['heuristic'];
            });

            echo "\nCandidate ranking:\n";
            foreach ($candidates as $index => $candidate) {
                echo sprintf("  %d. %s (h=%.2f)%s\n",
                    $index + 1,
                    $candidate['vertex'],
                    $candidate['heuristic'],
                    $index < $beamWidth ? " ← Selected for beam" : ""
                );
            }

            // Keep only the k best candidates (beam width)
            $beam = array_slice($candidates, 0, $beamWidth);
            echo "\nNew beam width: " . count($beam) . " states\n";
        }

        echo "\nSearch completed without finding goal\n";
        return null;
    }

    /**
     * Debug output for A* Tree Search showing the search process
     * and decision making at each step
     */
    public function debugAStarTreeSearch(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        echo "\n=== A* Tree Search Debug ===\n";
        echo "Starting from {$start} to reach {$goal}\n";

        // Priority queue implemented as array with state information
        $openSet = [[
            'vertex' => $start,
            'gScore' => 0.0,
            'fScore' => $this->heuristics[$start],
            'path' => [
                [
                    'vertex' => $start,
                    'level' => $this->levels[$start],
                    'heuristic' => $this->heuristics[$start]
                ]
            ]
        ]];

        $iteration = 0;
        $totalCost = 0;

        while (!empty($openSet)) {
            $iteration++;
            echo "\n=== Iteration {$iteration} ===\n";

            // Find node in openSet with lowest fScore
            $currentIndex = 0;
            $currentFScore = $openSet[0]['fScore'];

            echo "Current open set states:\n";
            foreach ($openSet as $index => $state) {
                echo sprintf("  %d. %s (g=%.2f, f=%.2f)\n",
                    $index + 1,
                    $state['vertex'],
                    $state['gScore'],
                    $state['fScore']
                );
                if ($state['fScore'] < $currentFScore) {
                    $currentIndex = $index;
                    $currentFScore = $state['fScore'];
                }
            }

            $current = $openSet[$currentIndex];
            $currentVertex = $current['vertex'];

            echo "\nSelected node {$currentVertex} with lowest f-score: {$currentFScore}\n";
            echo "Current path: " . implode(" -> ", array_column($current['path'], 'vertex')) . "\n";

            // Check if we've reached the goal
            if ($currentVertex === $goal) {
                echo "\nGoal reached!\n";
                echo "Final path: \n" . implode(" -> ", $this->getSequenceNames(array_column($current['path'], 'vertex'))) . "\n";
                echo "Total cost: {$current['gScore']}\n\n";
                return $current['path'];
            }

            // Remove current from openSet
            array_splice($openSet, $currentIndex, 1);
            echo "\nExploring neighbors of {$currentVertex}:\n";

            // Explore all neighbors
            foreach ($this->adjacencyList[$currentVertex] as $neighbor) {
                // Calculate g score for this path
                $tentativeGScore = $current['gScore'] + $this->getEdgeCost($currentVertex, $neighbor);

                // Calculate f score (g score + heuristic)
                $fScore = $tentativeGScore + $this->heuristics[$neighbor];

                echo sprintf("  %s: g=%.2f, h=%.2f, f=%.2f\n",
                    $neighbor,
                    $tentativeGScore,
                    $this->heuristics[$neighbor],
                    $fScore
                );

                // Create new path
                $newPath = $current['path'];
                $newPath[] = [
                    'vertex' => $neighbor,
                    'level' => $this->levels[$neighbor],
                    'heuristic' => $this->heuristics[$neighbor]
                ];

                // Add new state to openSet
                $openSet[] = [
                    'vertex' => $neighbor,
                    'gScore' => $tentativeGScore,
                    'fScore' => $fScore,
                    'path' => $newPath
                ];

                echo "  → Added to open set\n";
            }
        }

        echo "\nNo path found to goal\n";
        return null;
    }

    /**
     * Debug output for A* Group Search showing the search process
     * and decision making at each step
     */
    public function debugAStarGroupSearch(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        echo "\n=== A* Group Search Debug ===\n";
        echo "Starting from {$start} to reach {$goal}\n";

        $openSet = [$start];
        $cameFrom = [];
        $gScore = [$start => 0.0];
        $fScore = [$start => $this->heuristics[$start]];
        $iteration = 0;

        echo "\nInitial state:";
        echo "\nVertex: {$start}";
        echo "\nLevel: {$this->levels[$start]}";
        echo "\nHeuristic: {$this->heuristics[$start]}\n";

        while (!empty($openSet)) {
            $iteration++;
            echo "\n=== Iteration {$iteration} ===\n";

            // Find node in openSet with lowest fScore
            $current = $openSet[0];
            $currentFScore = $fScore[$current];

            echo "Current open set:\n";
            foreach ($openSet as $vertex) {
                echo sprintf("  %s (g=%.2f, f=%.2f)\n",
                    $vertex,
                    $gScore[$vertex],
                    $fScore[$vertex]
                );
                if ($fScore[$vertex] < $currentFScore) {
                    $current = $vertex;
                    $currentFScore = $fScore[$vertex];
                }
            }

            echo "\nSelected vertex {$current} with lowest f-score: {$currentFScore}\n";

            if ($current === $goal) {
                // Reconstruct path
                $path = [$current];
                $totalCost = $gScore[$current];

                while (isset($cameFrom[$current])) {
                    $current = $cameFrom[$current];
                    array_unshift($path, $current);
                }

                echo "\nGoal reached!\n";
                echo "Final path: \n" . implode(" -> ", $this->getSequenceNames($path)) . "\n";
                echo "Total cost: {$totalCost}\n\n";
                return $path;
            }

            // Remove current from openSet
            $openSet = array_values(array_diff($openSet, [$current]));
            echo "\nExploring neighbors of {$current}:\n";

            // Explore neighbors
            foreach ($this->adjacencyList[$current] as $neighbor) {
                $tentativeGScore = $gScore[$current] + $this->getEdgeCost($current, $neighbor);
                $neighborFScore = $tentativeGScore + $this->heuristics[$neighbor];

                echo sprintf("  %s: g=%.2f, h=%.2f, f=%.2f",
                    $neighbor,
                    $tentativeGScore,
                    $this->heuristics[$neighbor],
                    $neighborFScore
                );

                if (!isset($gScore[$neighbor]) || $tentativeGScore < $gScore[$neighbor]) {
                    echo " → Better path found!\n";
                    $cameFrom[$neighbor] = $current;
                    $gScore[$neighbor] = $tentativeGScore;
                    $fScore[$neighbor] = $neighborFScore;

                    if (!in_array($neighbor, $openSet)) {
                        $openSet[] = $neighbor;
                        echo "    Added to open set\n";
                    }
                } else {
                    echo " → Not better than existing path\n";
                }
            }
        }

        echo "\nNo path found to goal\n";
        return null;
    }

    /**
     * Debug output for IDA* Search showing iterative deepening process
     * and the search decisions at each step
     */
    public function debugIdaStarSearch(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        echo "\n=== IDA* Search Debug ===\n";
        echo "Starting from {$start} to reach {$goal}\n";

        // Initialize the bound as the heuristic value of the start node
        $bound = $this->heuristics[$start];
        $iteration = 0;

        echo "\nInitial state:";
        echo "\nVertex: {$start}";
        echo "\nLevel: {$this->levels[$start]}";
        echo "\nHeuristic: {$this->heuristics[$start]}";
        echo "\nInitial bound: {$bound}\n";

        // Initial path contains only the start node
        $path = [
            [
                'vertex' => $start,
                'level' => $this->levels[$start],
                'heuristic' => $this->heuristics[$start]
            ]
        ];

        while (true) {
            $iteration++;
            echo "\n=== Iteration {$iteration} ===\n";
            echo "Current bound: {$bound}\n";

            // Search with current bound
            $result = $this->debugIdaStarRecursive($path, 0, $bound, $goal, 1);

            if (is_array($result)) {
                echo "\nGoal reached!\n";
                echo "Final path: \n" . implode(" -> ", $this->getSequenceNames(array_column($result, 'vertex'))) . "\n\n";
                return $result;
            }

            if ($result === PHP_FLOAT_MAX) {
                echo "\nNo path exists to goal\n";
                return null;
            }

            echo "\nMinimum f-value exceeding current bound: {$result}\n";
            echo "Increasing bound for next iteration\n";

            // Update bound to the minimum f-value that exceeded current bound
            $bound = $result;
        }
    }

    /**
     * Debug recursive helper function for IDA* search
     */
    private function debugIdaStarRecursive(array $path, float $g, float $bound, string $goal, int $depth): array|float {
        $current = $path[count($path) - 1]['vertex'];
        $f = $g + $this->heuristics[$current];

        $indent = str_repeat("  ", $depth);
        echo "{$indent}Examining vertex: {$current}\n";
        echo "{$indent}g-value: {$g}, h-value: {$this->heuristics[$current]}, f-value: {$f}\n";
        echo "{$indent}Current path: " . implode(" -> ", array_column($path, 'vertex')) . "\n";

        // If f exceeds bound, return f as the new minimum bound
        if ($f > $bound) {
            echo "{$indent}f-value {$f} exceeds bound {$bound}, backtracking\n";
            return $f;
        }

        // If goal is reached, return the path
        if ($current === $goal) {
            echo "{$indent}Goal reached!\n";
            return $path;
        }

        $min = PHP_FLOAT_MAX;
        echo "{$indent}Exploring neighbors:\n";

        // Explore all neighbors
        foreach ($this->adjacencyList[$current] as $neighbor) {
            // Check if neighbor is already in path (avoid cycles)
            $inPath = false;
            foreach ($path as $node) {
                if ($node['vertex'] === $neighbor) {
                    $inPath = true;
                    break;
                }
            }

            if ($inPath) {
                echo "{$indent}  {$neighbor}: Skipped (already in path)\n";
                continue;
            }

            echo "{$indent}  {$neighbor}:\n";
            echo "{$indent}    Edge cost: {$this->getEdgeCost($current, $neighbor)}\n";
            echo "{$indent}    Heuristic: {$this->heuristics[$neighbor]}\n";

            // Add neighbor to path
            $path[] = [
                'vertex' => $neighbor,
                'level' => $this->levels[$neighbor],
                'heuristic' => $this->heuristics[$neighbor]
            ];

            // Recursively search from neighbor
            $result = $this->debugIdaStarRecursive(
                $path,
                $g + $this->getEdgeCost($current, $neighbor),
                $bound,
                $goal,
                $depth + 1
            );

            // Remove neighbor from path (backtrack)
            array_pop($path);

            // Process result
            if (is_array($result)) {
                // Path to goal found
                return $result;
            }

            // Update minimum bound if needed
            if ($result < $min) {
                $min = $result;
                echo "{$indent}  New minimum f-value found: {$min}\n";
            }
        }

        if ($min === PHP_FLOAT_MAX) {
            echo "{$indent}No valid neighbors found, backtracking\n";
        } else {
            echo "{$indent}All neighbors explored, minimum f-value: {$min}\n";
        }

        return $min;
    }

    /**
     * Debug the Simple Hill Climbing algorithm showing decision process
     */
    public function debugSimpleHillClimbing(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        echo "\n=== Simple Hill Climbing Debug ===\n";
        echo "Starting from {$start} to reach {$goal}\n";

        $currentVertex = $start;
        $path = [[
            'vertex' => $start,
            'level' => $this->levels[$start],
            'heuristic' => $this->heuristics[$start]
        ]];
        $visited = [$start => true];
        $totalCost = 0;

        echo "\nInitial state:";
        echo "\nVertex: {$start}";
        echo "\nLevel: {$this->levels[$start]}";
        echo "\nHeuristic: {$this->heuristics[$start]}\n";

        while ($currentVertex !== $goal) {
            echo "\n----------------------------\n";
            echo "Current path: " . implode(" -> ", array_column($path, 'vertex'));
            echo "\nAt vertex: {$currentVertex} (h={$this->heuristics[$currentVertex]})\n";

            $neighbors = $this->adjacencyList[$currentVertex];
            if (empty($neighbors)) {
                echo "Dead end reached - no neighbors available\n";
                return null;
            }

            $betterFound = false;
            $currentHeuristic = $this->heuristics[$currentVertex];

            foreach ($neighbors as $neighbor) {
                if (isset($visited[$neighbor])) {
                    echo "  Skipping {$neighbor}: already visited\n";
                    continue;
                }

                $neighborHeuristic = $this->heuristics[$neighbor];
                $edgeCost = $this->getEdgeCost($currentVertex, $neighbor);
                echo "  Evaluating {$neighbor}:";
                echo "\n    Heuristic: {$neighborHeuristic}";
                echo "\n    Edge cost: {$edgeCost}";
                echo "\n    Current best: {$currentHeuristic}\n";

                if ($neighborHeuristic < $currentHeuristic) {
                    echo "  → Better neighbor found: {$neighbor}\n";
                    $totalCost += $edgeCost;
                    $currentVertex = $neighbor;
                    $visited[$neighbor] = true;
                    $path[] = [
                        'vertex' => $neighbor,
                        'level' => $this->levels[$neighbor],
                        'heuristic' => $neighborHeuristic
                    ];
                    $betterFound = true;
                    break;
                } else {
                    echo "  → Not better than current state\n";
                }
            }

            if (!$betterFound) {
                echo "\nLocal maximum reached - no improving neighbors found\n";
                echo "Final path: \n" . implode(" -> ", $this->getSequenceNames(array_column($path, 'vertex'))) . "\n";
                echo "Total cost: {$totalCost}\n\n";
                return null;
            }
        }

        echo "\nGoal reached!\n";
        echo "Final path: \n" . implode(" -> ", $this->getSequenceNames(array_column($path, 'vertex'))) . "\n";
        echo "Total cost: {$totalCost}\n\n";
        return $path;
    }

    /**
     * Debug the Steepest Ascent Hill Climbing algorithm showing evaluation process
     */
    public function debugSteepestAscentHillClimbing(string $start, string $goal): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException("Both start and goal vertices must exist in the graph.");
        }

        echo "\n=== Steepest Ascent Hill Climbing Debug ===\n";
        echo "Starting from {$start} to reach {$goal}\n";

        $currentVertex = $start;
        $path = [[
            'vertex' => $start,
            'level' => $this->levels[$start],
            'heuristic' => $this->heuristics[$start]
        ]];
        $visited = [$start => true];
        $totalCost = 0;

        echo "\nInitial state:";
        echo "\nVertex: {$start}";
        echo "\nLevel: {$this->levels[$start]}";
        echo "\nHeuristic: {$this->heuristics[$start]}\n";

        while ($currentVertex !== $goal) {
            echo "\n----------------------------\n";
            echo "Current path: " . implode(" -> ", array_column($path, 'vertex'));
            echo "\nAt vertex: {$currentVertex} (h={$this->heuristics[$currentVertex]})\n";

            $neighbors = $this->adjacencyList[$currentVertex];
            if (empty($neighbors)) {
                echo "Dead end reached - no neighbors available\n";
                return null;
            }

            $bestNeighbor = null;
            $bestImprovement = 0;
            $bestCost = 0;
            $currentHeuristic = $this->heuristics[$currentVertex];

            echo "\nEvaluating all neighbors:\n";
            foreach ($neighbors as $neighbor) {
                if (isset($visited[$neighbor])) {
                    echo "  Skipping {$neighbor}: already visited\n";
                    continue;
                }

                $neighborHeuristic = $this->heuristics[$neighbor];
                $edgeCost = $this->getEdgeCost($currentVertex, $neighbor);
                $improvement = $currentHeuristic - $neighborHeuristic;

                echo "  {$neighbor}:";
                echo "\n    Heuristic: {$neighborHeuristic}";
                echo "\n    Edge cost: {$edgeCost}";
                echo "\n    Improvement: {$improvement}\n";

                if ($improvement > $bestImprovement) {
                    $bestImprovement = $improvement;
                    $bestNeighbor = $neighbor;
                    $bestCost = $edgeCost;
                    echo "  → New best neighbor!\n";
                }
            }

            if ($bestNeighbor === null) {
                echo "\nLocal maximum reached - no improving neighbors found\n";
                echo "Final path: \n" . implode(" -> ", $this->getSequenceNames(array_column($path, 'vertex'))) . "\n";
                echo "Total cost: {$totalCost}\n\n";
                return null;
            }

            echo "\nSelected best neighbor: {$bestNeighbor}";
            echo "\nImprovement: {$bestImprovement}";
            echo "\nEdge cost: {$bestCost}\n";

            $totalCost += $bestCost;
            $currentVertex = $bestNeighbor;
            $visited[$currentVertex] = true;
            $path[] = [
                'vertex' => $currentVertex,
                'level' => $this->levels[$currentVertex],
                'heuristic' => $this->heuristics[$currentVertex]
            ];
        }

        echo "\nGoal reached!\n";
        echo "Final path: \n" . implode(" -> ", $this->getSequenceNames(array_column($path, 'vertex'))) . "\n";
        echo "Total cost: {$totalCost}\n\n";
        return $path;
    }

    /**
     * Debug output for Stochastic Hill Climbing showing the probabilistic decisions
     * made during the search process
     */
    public function debugStochasticHillClimbing(?array $searchResult, string $start, string $goal): ?array {
        $start = $this->vertexLabels[$start] ?? $start;
        $goal = $this->vertexLabels[$goal] ?? $goal;

        if ($searchResult === null) {
            echo "\n=== Stochastic Hill Climbing Debug ===\n";
            echo "No path found from {$start} to {$goal}!\n";
            return null;
        }

        echo "\n=== Stochastic Hill Climbing Debug ===\n";
        echo "Path found from {$start} to {$goal}\n";

        $totalCost = 0;
        $pathLength = count($searchResult);

        echo "\nPath sequence analysis:\n";
        for ($i = 0; $i < $pathLength; $i++) {
            $currentNode = $searchResult[$i];
            $currentVertex = $currentNode['vertex'];

            echo "\nStep {$i}:";
            echo "\nCurrent vertex: {$currentVertex}";
            echo "\nLevel: {$currentNode['level']}";
            echo "\nHeuristic: {$currentNode['heuristic']}\n";

            // If not the last node, analyze the transition to the next node
            if ($i < $pathLength - 1) {
                $nextNode = $searchResult[$i + 1];
                $nextVertex = $nextNode['vertex'];

                // Get all neighbors of current vertex
                $neighbors = $this->adjacencyList[$currentVertex];

                // Calculate improvements and probabilities for all valid neighbors
                $candidates = [];
                $totalImprovement = 0;

                echo "\nNeighbor analysis:";
                foreach ($neighbors as $neighbor) {
                    $neighborHeuristic = $this->heuristics[$neighbor];
                    $improvement = $this->heuristics[$currentVertex] - $neighborHeuristic;

                    if ($improvement > 0) {
                        $candidates[$neighbor] = $improvement;
                        $totalImprovement += $improvement;
                    }

                    echo sprintf("\n  %s:", $neighbor);
                    echo sprintf("\n    Heuristic: %.2f", $neighborHeuristic);
                    echo sprintf("\n    Improvement: %.2f", $improvement);
                    if ($improvement > 0) {
                        echo "\n    → Eligible for selection";
                    } else {
                        echo "\n    → Not eligible (no improvement)";
                    }
                }

                // Show selection probabilities
                if (!empty($candidates)) {
                    echo "\n\nSelection probabilities:";
                    foreach ($candidates as $neighbor => $improvement) {
                        $probability = ($improvement / $totalImprovement) * 100;
                        echo sprintf("\n  %s: %.2f%%", $neighbor, $probability);
                        if ($neighbor === $nextVertex) {
                            echo " ← Selected";
                        }
                    }
                }

                // Show transition details
                $edgeCost = $this->getEdgeCost($currentVertex, $nextVertex);
                $totalCost += $edgeCost;

                echo sprintf("\n\nTransition: %s -> %s", $currentVertex, $nextVertex);
                echo sprintf("\nEdge cost: %.2f", $edgeCost);
                echo sprintf("\nRunning total cost: %.2f", $totalCost);
            }

            echo "\n----------------------------";
        }

        echo sprintf("\n\nFinal path: \n%s", implode(" -> ", $this->getSequenceNames(array_column($searchResult, 'vertex'))));
        echo sprintf("\nTotal path cost: %.2f\n\n", $totalCost);

        return $searchResult;
    }

    /**
     * Debug output for Greedy Search showing decision process
     * and neighbor evaluations at each step
     */
    public function debugGreedySearch(string $start, string $goal, $maxSteps = 100): ?array {
        if (!isset($this->adjacencyList[$start]) || !isset($this->adjacencyList[$goal])) {
            throw new InvalidArgumentException('Both start and goal vertices must exist in the graph.');
        }

        echo "\n=== Greedy Search Debug ===\n";
        echo "Starting from {$start} to reach {$goal}\n";

        $path = [];
        $currentVertex = $start;
        $totalCost = 0;
        $iteration = 0;

        echo "\nInitial state:";
        echo "\nVertex: {$start}";
        echo "\nLevel: {$this->levels[$start]}";
        echo "\nHeuristic: {$this->heuristics[$start]}\n";

        // Keep going until we reach the goal
        $count = 0;
        while ($currentVertex !== $goal && $count < $maxSteps) {
            $iteration++;
            echo "\n=== Iteration {$iteration} ===\n";

            // Add current vertex to path
            $path[] = [
                'vertex' => $currentVertex,
                'level' => $this->levels[$currentVertex],
                'heuristic' => $this->heuristics[$currentVertex]
            ];

            echo "Current path: " . implode(" -> ", array_column($path, 'vertex')) . "\n";
            echo "At vertex: {$currentVertex} (h={$this->heuristics[$currentVertex]})\n";

            // Get all neighbors of current vertex
            $neighbors = $this->adjacencyList[$currentVertex];

            if (empty($neighbors)) {
                echo "Dead end reached - no neighbors available\n";
                return null;
            }

            echo "\nEvaluating neighbors:\n";

            // Find neighbor with lowest heuristic value
            $bestNeighbor = null;
            $bestHeuristic = PHP_FLOAT_MAX;
            $bestEdgeCost = 0;

            foreach ($neighbors as $neighbor) {
                $h = $this->heuristics[$neighbor];
                $edgeCost = $this->getEdgeCost($currentVertex, $neighbor);

                echo sprintf("  %s:\n", $neighbor);
                echo sprintf("    Heuristic: %.2f\n", $h);
                echo sprintf("    Edge cost: %.2f\n", $edgeCost);

                if ($h < $bestHeuristic) {
                    $bestHeuristic = $h;
                    $bestNeighbor = $neighbor;
                    $bestEdgeCost = $edgeCost;
                    echo "    → New best neighbor!\n";
                } else {
                    echo "    → Not better than current best\n";
                }
            }

            // If we can't find a better neighbor, we're stuck
            if ($bestNeighbor === null) {
                echo "\nNo improving neighbor found - search failed\n";
                return null;
            }

            echo "\nSelected best neighbor: {$bestNeighbor}";
            echo "\nHeuristic value: {$bestHeuristic}";
            echo "\nEdge cost: {$bestEdgeCost}\n";

            // Move to the best neighbor
            $totalCost += $bestEdgeCost;
            $currentVertex = $bestNeighbor;
            $count++;
        }

        // No path found within reasonable time
        if ($count >= $maxSteps) {
            return null;
        }

        // Add the goal vertex to complete the path
        $path[] = [
            'vertex' => $goal,
            'level' => $this->levels[$goal],
            'heuristic' => $this->heuristics[$goal]
        ];

        echo "\nGoal reached!\n";
        echo "Final path: " . implode(" -> ", array_column($path, 'vertex')) . "\n";
        echo "Total cost: {$totalCost}\n";

        return $path;
    }

    public function searchAnalysis($searchResult, bool $showCost = true): void {
        if ($searchResult === null) {
            echo "No path found!\n";
            return;
        }

        $totalCost = 0;

        echo "Path sequence:\n";
        $pathSequenceNames = array_map(function ($node) {
            $vertex = $node['vertex'] ?? $node;
            return $this->vertexLabels[$vertex] ?? $vertex;
        }, $searchResult);
        echo " -> " . implode("\n -> ", $pathSequenceNames) . "\n";

        echo "\nPath analysis:\n";
        $lastIndex = 0;
        $lastVertex = null;
        $pathSequence = array_map(function ($node) {
            $vertex = $node['vertex'] ?? $node;
            return $node['vertex'] ?? $node;
        }, $searchResult);

        foreach ($pathSequence as $index => $vertex) {
            if ($index > 0) {
                $prevVertex = $pathSequence[$index - 1];
                $cost = $this->getEdgeCost($prevVertex, $vertex);
                $totalCost += $cost;
                echo sprintf("Step %d: %s (level %d, h=%.1f) -> %s (level %d, h=%.1f): cost: %.1f\n",
                    $index,
                    $prevVertex,
                    $this->levels[$prevVertex],
                    $this->heuristics[$prevVertex],
                    $vertex,
                    $this->levels[$vertex],
                    $this->heuristics[$vertex],
                    $cost,
                //$searchResult[$index]['heuristic']
                );
            }
            $lastIndex++;
            $lastVertex = $vertex;
        }

        echo sprintf("Step %d: %s (level %d, h=%.1f)\n",
            $lastIndex,
            $lastVertex,
            $this->levels[$vertex],
            $this->heuristics[$vertex]
        );

        if ($showCost) {
            echo sprintf("\nTotal path cost: %.1f\n", $totalCost);
        }
    }

    public function getAdjacencyList(): array {
        return $this->adjacencyList;
    }

    public function printPath(array $path, bool $showCost = true): void {
        $totalCost = 0;
        $previousVertex = null;

        foreach ($path as $step) {
            // Get current vertex name depending on path format
            $currentVertex = is_array($step) ? $step['vertex'] : $step;

            if ($showCost) {
                if ($previousVertex !== null) {
                    $edgeCost = $this->getEdgeCost($previousVertex, $currentVertex);
                    $totalCost += $edgeCost;
                    echo sprintf("Edge cost from %s to %s: %.1f\n",
                        $previousVertex,
                        $currentVertex,
                        $edgeCost
                    );
                }
            }

            echo sprintf("Node: %s (Level %d, h=%.1f)\n",
                $currentVertex,
                $this->levels[$currentVertex],
                $this->heuristics[$currentVertex]
            );

            $previousVertex = $currentVertex;
        }

        if ($showCost) {
            echo sprintf("\nTotal path cost: %.1f\n", $totalCost);
        }
    }

    public function printGraph(): void {
        foreach ($this->adjacencyList as $vertex => $neighbors) {
            $costs = array_map(function($neighbor) use ($vertex) {
                return sprintf("%s(%.1f)", $neighbor, $this->edgeCosts[$vertex][$neighbor]);
            }, $neighbors);

            echo sprintf("%s (Level %d, h=%.1f) -> %s\n",
                $this->vertexLabels[$vertex] ?? $vertex,
                $this->levels[$vertex],
                $this->heuristics[$vertex],
                implode(', ', $costs)
            );
        }
    }

    /**
     * @param array $path
     * @return array
     */
    protected function getSequenceNames(array $path): array {
        $pathSequenceNames = array_map(function ($node) {
            $vertex = $node['vertex'] ?? $node;
            return $this->vertexLabels[$vertex] ?? $vertex;
        }, $path);

        return $pathSequenceNames;
    }
}
