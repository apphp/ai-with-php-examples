<?php

//////////////////////
$menu = [
    'Introduction' => [
        ['section' => '', 'subSection' => '', 'page' => 'home', 'title' => 'Getting Started', 'permissions' => ['home']],
    ],
    'Machine Learning' => [
        [
            'title' => 'Mathematics for ML',
            'subMenu' => [
                ['section' => 'mathematics', 'subSection' => '', 'page' => 'index', 'title' => 'Index', 'permissions' => ['index']],
                ['section' => 'mathematics', 'subSection' => 'scalars', 'page' => 'index', 'title' => 'Scalars', 'permissions' => ['index', 'scalars-code-run']],
                ['section' => 'mathematics', 'subSection' => 'vectors', 'page' => 'index', 'title' => 'Vectors', 'permissions' => ['index', 'vectors-code-run']],
                ['section' => 'mathematics', 'subSection' => 'matrices', 'page' => 'index', 'title' => 'Matrices', 'permissions' => ['index', 'matrices-code-run']],
                ['section' => 'mathematics', 'subSection' => 'tensors', 'page' => 'index', 'title' => 'Tensors', 'permissions' => ['index', 'creating-tensors', 'creating-tensors-code-run']],
            ],
        ],
        [
            'title' => 'Data Fundamentals',
            'subMenu' => [
                ['section' => 'data-fundamentals', 'subSection' => '', 'page' => 'index', 'title' => 'Index', 'permissions' => ['index']],
                ['section' => 'data-fundamentals', 'subSection' => 'big-data-considerations', 'page' => 'index', 'title' => 'Big Data Considerations', 'permissions' => ['index', 'chunked-processing', 'chunked-processing-code-run', 'dataset-generator', 'dataset-generator-code-run']],
                ['section' => 'data-fundamentals', 'subSection' => 'data-processing', 'page' => 'index', 'title' => 'Data Processing', 'permissions' => ['index', 'rubix-data-cleaning', 'rubix-data-cleaning-handling-missing-code-run']],
            ],
        ],
    ],
];

return $menu;
