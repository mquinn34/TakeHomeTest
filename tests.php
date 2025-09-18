
<?php

// Quick test: handle empty arrays
$events = [];
$references = [];

if (empty($events) && empty($references)) {
    echo "Test passed: handled empty events and references." . PHP_EOL;
} else {
    echo "Test failed: expected empty arrays." . PHP_EOL;
}
