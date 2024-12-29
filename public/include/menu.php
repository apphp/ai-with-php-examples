<?php

//////////////////////
$menu = [
    '<i class="fas fa-home me-1"></i> Introduction' => [
        ['section' => '', 'subSection' => '', 'page' => 'home', 'title' => 'Getting Started', 'permissions' => ['home']],
    ],
    '<i class="fas fa-brain me-1"></i> Artificial Intelligence' => [
        [
            'title' => 'Search Algoritms',
            'subMenu' => [
                ['section' => 'search-algorithms', 'subSection' => '', 'page' => 'index', 'title' => 'Index', 'permissions' => ['index']],
                ['section' => 'search-algorithms', 'subSection' => 'uninformed-search', 'page' => 'index', 'title' => 'Uninformed Search', 'permissions' => [
                    'index',
                    'breadth-first-search', 'breadth-first-search-code-run',
                    'depth-first-search', 'depth-first-search-code-run',
                    'depth-limited-search', 'depth-limited-search-code-run',
                    'iterative-deepening-depth-first-search', 'iterative-deepening-depth-first-search-code-run',
                    'uniform-cost-search', 'uniform-cost-search-code-run',
                    'bidirectional-search', 'bidirectional-search-code-run',
                ]],
                ['section' => 'search-algorithms', 'subSection' => 'informed-search', 'page' => 'index', 'title' => 'Informed Search', 'permissions' => [
                    'index',
                    'greedy-search', 'greedy-search-code-run',
                    'a-tree-search', 'a-tree-search-code-run',
                    'a-graph-search', 'a-graph-search-code-run',
                    'iterative-deepening-a-search', 'iterative-deepening-a-search-code-run',
                    'beam-search', 'beam-search-code-run',
                ]],
            ],
        ],
    ],
    '<i class="fas fa-robot me-1"></i> Machine Learning' => [
        [
            'title' => 'Mathematics for ML',
            'subMenu' => [
                ['section' => 'mathematics', 'subSection' => '', 'page' => 'index', 'title' => 'Index', 'permissions' => ['index']],
                ['section' => 'mathematics', 'subSection' => 'scalars', 'page' => 'index', 'title' => 'Scalars', 'permissions' => ['index', 'scalars-code-run']],
                ['section' => 'mathematics', 'subSection' => 'vectors', 'page' => 'index', 'title' => 'Vectors', 'permissions' => ['index', 'vectors-code-run']],
                ['section' => 'mathematics', 'subSection' => 'matrices', 'page' => 'index', 'title' => 'Matrices', 'permissions' => ['index', 'matrices-code-run']],
                ['section' => 'mathematics', 'subSection' => 'tensors', 'page' => 'index', 'title' => 'Tensors', 'permissions' => ['index', 'creating-tensors', 'creating-tensors-code-run']],
                ['section' => 'mathematics', 'subSection' => 'linear-transformations', 'page' => 'index', 'title' => 'Linear Transformations', 'permissions' => [
                    'index',
                    'scale-transformation', 'scale-transformation-code-run',
                    'simple-linear-layer', 'simple-linear-layer-code-run',
                    'fully-connected-layer', 'fully-connected-layer-code-run',
                    'relu-activation', 'relu-activation-code-run',
                ]],
            ],
        ],
        [
            'title' => 'Data Fundamentals',
            'subMenu' => [
                ['section' => 'data-fundamentals', 'subSection' => '', 'page' => 'index', 'title' => 'Index', 'permissions' => ['index']],
                ['section' => 'data-fundamentals', 'subSection' => 'big-data-considerations', 'page' => 'index', 'title' => 'Big Data Considerations', 'permissions' => ['index', 'chunked-processing', 'chunked-processing-code-run', 'dataset-generator', 'dataset-generator-code-run']],
                ['section' => 'data-fundamentals', 'subSection' => 'data-processing', 'page' => 'index', 'title' => 'Data Processing', 'permissions' => [
                    'index',
                    'rubix-data-cleaning', 'rubix-data-cleaning-handling-missing-code-run',
                    'rubix-data-normalization', 'rubix-data-normalization-code-run',
                    'rubix-data-standardization', 'rubix-data-standardization-code-run',
                    'rubix-data-encoding-categorical-variables', 'rubix-data-encoding-categorical-variables-code-run',
                    'phpml-data-cleaning', 'phpml-data-cleaning-handling-missing-code-run',
                    'phpml-data-normalization', 'phpml-data-normalization-code-run',
                ]],
            ],
        ],
        [
            'title' => 'ML Algorithms',
            'subMenu' => [
                ['section' => 'ml-algorithms', 'subSection' => '', 'page' => 'index', 'title' => 'Index', 'permissions' => ['index']],
                ['section' => 'ml-algorithms', 'subSection' => 'linear-regression', 'page' => 'index', 'title' => 'Linear Regression', 'permissions' => [
                    'index',
                    'rubix-simple-linear-regression', 'rubix-simple-linear-regression-code-run',
                    'rubix-multiple-linear-regression', 'rubix-multiple-linear-regression-code-run',
                    'phpml-simple-linear-regression', 'phpml-simple-linear-regression-code-run',
                    'phpml-multiple-linear-regression', 'phpml-multiple-linear-regression-code-run'
                ]],
            ],
        ],
    ],
    '<i class="fas fa-network-wired me-1"></i> Neural Networks' => [
        [
            'title' => 'Types of NN',
            'subMenu' => [
                ['section' => 'neural-networks', 'subSection' => '', 'page' => 'index', 'title' => 'Index', 'permissions' => ['index']],
                ['section' => 'neural-networks', 'subSection' => 'simple-perceptron', 'page' => 'index', 'title' => 'Basic Neural Network', 'permissions' => ['index', 'rubix-simple-perceptron', 'rubix-simple-perceptron-code-run', 'phpml-simple-perceptron', 'phpml-simple-perceptron-code-run']],
            ],
        ],
    ],
];

return $menu;
