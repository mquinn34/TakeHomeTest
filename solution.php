<?php

// load JSON files into arrays

$eventsJson = file_get_contents('event_details.json');
$events = json_decode($eventsJson, true);

$referencesJson = file_get_contents('references.json');
$references = json_decode($referencesJson, true);

// task 1

$colorCountsJune = [];
$colorCountsMarch = [];

// Loop through each event and extract year-month (YYYY-MM) and color

foreach ($events as $event) {
    $date = $event['date'];
    $month = substr($date, 0, 7);
    $color = $event['color'];

    // check for june 2024 colors
    if ($month === "2024-06") {
        if (!isset($colorCountsJune[$color])) {
            $colorCountsJune[$color] = 0;
        }
        $colorCountsJune[$color]++;
    }
    // check for march 2025 colors
    if ($month === "2025-03") {
        if (!isset($colorCountsMarch[$color])) {
            $colorCountsMarch[$color] = 0;
        }
        $colorCountsMarch[$color]++;
    }
}

// task 2

// Build arrays 
$byIdA = [];
$byIdB = [];


foreach ($events as $event) {
    if (isset($event['id_a'])) {
        $byIdA[$event['id_a']] = $event;
    }
    if (isset($event['id_b'])) {
        $byIdB[$event['id_b']] = $event;
    }
}

$sumValue = 0;
$earliestDate = null;
$earliestName = "";

$minValue = null;
$minValueName = "";

$highValueNames = [];

foreach ($references as $ref) {
    $event = null;

    // match by id_a
    if (isset($ref['id_a']) && isset($byIdA[$ref['id_a']])) { 
        $event = $byIdA[$ref['id_a']];
    }
    // match by id_b
    elseif (isset($ref['id_b']) && isset($byIdB[$ref['id_b']])) {
        $event = $byIdB[$ref['id_b']];
    }

    if ($event) {
        // sum values
        $sumValue += $event['value'];

        // check earliest date with tie-breaker
        if (
            $earliestDate === null ||
            $event['date'] < $earliestDate ||
            ($event['date'] === $earliestDate && $ref['name'] < $earliestName)
        ) {
            $earliestDate = $event['date'];
            $earliestName = $ref['name'];
           }
        // check for min value 
        if (
            $minValue === null ||
            $event['value'] < $minValue ||
            ($event['value'] === $minValue && $ref['name'] <$minValueName)

        )  {
            $minValue = $event['value'];
            $minValueName = $ref ['name'];
            }
        
        // check for values > 25
        if ($event['value'] > 25) {
            $highValueNames[] = $ref['name'];
        }
    }
}

// final results in Json

// Force order: RED, BLUE, GREEN 

$ordered = ["RED","BLUE","GREEN"];
$colorCountsJune  = array_replace(array_fill_keys($ordered, 0), $colorCountsJune);
$colorCountsMarch = array_replace(array_fill_keys($ordered, 0), $colorCountsMarch);


$result = [
    "task1" =>[
        "color_freq_2024_06" => $colorCountsJune,
        "color_freq_2025_03" => $colorCountsMarch,
    ],
    
    "task2" => [
        "sum_value" => $sumValue,
        "earliest_date_name" => $earliestName,
        "min_value_name" => $minValueName,
        "high_value_names" => array_values($highValueNames),
    ],
];


echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
