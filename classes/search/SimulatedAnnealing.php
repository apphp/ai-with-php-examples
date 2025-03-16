<?php

namespace app\classes\search;

class SimulatedAnnealing {
    private $temperature;
    private $coolingRate;
    private $stopTemperature;

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

    public function optimize($initialSolution) {
        $currentSolution = $initialSolution;
        $currentEnergy = $this->objectiveFunction($currentSolution);

        while ($this->temperature > $this->stopTemperature) {
            $newSolution = $this->getRandomNeighbor($currentSolution);
            $newEnergy = $this->objectiveFunction($newSolution);

            if ($this->acceptanceProbability($currentEnergy, $newEnergy) > mt_rand() / mt_getrandmax()) {
                $currentSolution = $newSolution;
                $currentEnergy = $newEnergy;
            }

            $this->temperature *= $this->coolingRate;
        }

        return $currentSolution;
    }
}

