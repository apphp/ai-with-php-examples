<?php

namespace app\classes\search;

class SimulatedAnnealing {
    private $temperature;
    private $coolingRate;
    private $stopTemperature;
    private $iterationLog = [];

    public function __construct($initialTemperature, $coolingRate, $stopTemperature) {
        $this->temperature = $initialTemperature;
        $this->coolingRate = $coolingRate;
        $this->stopTemperature = $stopTemperature;
    }

    private function objectiveFunction($x) {
        // Example: Finding the minimum of x^2
        return pow($x, 2);
    }

    private function getRandomNeighbor($x) {
        // Generate a small random step
        return $x + ((rand(0, 1000) / 1000) - 0.5) * 2;
    }

    private function acceptanceProbability($currentEnergy, $newEnergy) {
        if ($newEnergy < $currentEnergy) {
            return 1.0;
        }
        return exp(($currentEnergy - $newEnergy) / $this->temperature);
    }

    public function optimize($initialSolution, int $precision) {
        $currentSolution = $initialSolution;
        $currentEnergy = $this->objectiveFunction($currentSolution);
        $iteration = 0;

        // Log initial state
        $this->logIteration($iteration, $currentSolution, $currentEnergy, $this->temperature, null, null, false);

        while ($this->temperature > $this->stopTemperature) {
            $iteration++;
            $newSolution = $this->getRandomNeighbor($currentSolution);
            $newEnergy = $this->objectiveFunction($newSolution);

            $acceptanceProbability = $this->acceptanceProbability($currentEnergy, $newEnergy);
            $accepted = false;

            if ($acceptanceProbability > mt_rand() / mt_getrandmax()) {
                $accepted = true;
                $currentSolution = $newSolution;
                $currentEnergy = $newEnergy;
            }

            // Log this iteration
            $this->logIteration($iteration, $currentSolution, $currentEnergy,
                $this->temperature, $newSolution, $newEnergy, $accepted);

            $this->temperature *= $this->coolingRate;
        }

        return round($currentSolution, $precision);
    }

    /**
     * Logs information about each iteration
     *
     * @param int $iteration Iteration number
     * @param float $currentSolution Current solution
     * @param float $currentEnergy Energy of current solution
     * @param float $temperature Current temperature
     * @param float|null $triedSolution Solution that was tried
     * @param float|null $triedEnergy Energy of tried solution
     * @param bool $accepted Whether the tried solution was accepted
     */
    private function logIteration($iteration, $currentSolution, $currentEnergy,
                                  $temperature, $triedSolution, $triedEnergy, $accepted) {
        $this->iterationLog[] = [
            'iteration' => $iteration,
            'solution' => $currentSolution,
            'energy' => $currentEnergy,
            'temperature' => $temperature,
            'tried_solution' => $triedSolution,
            'tried_energy' => $triedEnergy,
            'accepted' => $accepted
        ];
    }

    /**
     * Returns the log of iterations
     *
     * @return array Array of iteration data
     */
    public function getIterationLog() {
        return $this->iterationLog;
    }

    /**
     * Format the iteration log as a string
     *
     * @param bool $detailed Whether to include detailed information about tried solutions
     * @return string Formatted log as a string
     */
    public function printIterationLog($detailed = false) {
        $output = "Simulated Annealing Iterations Log:\n\n";
        $output .= str_pad("#", 3) . str_pad("Solution", 12) . str_pad("Energy", 12) .
            str_pad("Temp", 12);

        if ($detailed) {
            $output .= str_pad("Tried", 11) . str_pad("Tried Energy", 15) . "Accepted";
        }

        $output .= "\n" . str_repeat("-", $detailed ? 75 : 50) . "\n";

        foreach ($this->iterationLog as $log) {
            $output .= str_pad($log['iteration']. '. ', 3) .
                str_pad(number_format($log['solution'], 3), 12) .
                str_pad(number_format($log['energy'], 3), 12) .
                str_pad(number_format($log['temperature'], 3), 12);

            if ($detailed && $log['iteration'] > 0) {
                $output .= str_pad(number_format($log['tried_solution'], 3), 11) .
                    str_pad(number_format($log['tried_energy'], 3), 15) .
                    ($log['accepted'] ? "Yes" : "No");
            }

            $output .= "\n";
        }

        return $output;
    }
}
