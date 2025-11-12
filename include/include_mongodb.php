<?php
/**
 * MongoDB Connection Helpers (read-only) replicated from html-solution.
 */

if (!class_exists('MongoDB\Driver\Manager')) {
    throw new RuntimeException('MongoDB PHP extension is required for meeting dashboard.');
}

$mongodb_config = require_once(__DIR__ . '/mongodb_config.php');

function getMongoDBConnection() {
    global $mongodb_config;

    try {
        if (!empty($mongodb_config['connection_string'])) {
            $connection_string = $mongodb_config['connection_string'];
        } elseif (!empty($mongodb_config['username']) && !empty($mongodb_config['password'])) {
            $connection_string = sprintf(
                "mongodb://%s:%s@%s:%s/%s",
                $mongodb_config['username'],
                $mongodb_config['password'],
                $mongodb_config['host'],
                $mongodb_config['port'],
                $mongodb_config['database']
            );
        } else {
            $connection_string = sprintf(
                "mongodb://%s:%s/%s",
                $mongodb_config['host'],
                $mongodb_config['port'],
                $mongodb_config['database']
            );
        }

        return new MongoDB\Driver\Manager($connection_string, $mongodb_config['options']);
    } catch (Exception $e) {
        error_log("MongoDB Connection Error: " . $e->getMessage());
        return null;
    }
}

function mongoFind($collection, $filter = [], $options = []) {
    global $mongodb_config;

    try {
        $manager = getMongoDBConnection();
        if (!$manager) {
            return ['success' => false, 'error' => 'Connection failed', 'data' => []];
        }

        $query = new MongoDB\Driver\Query($filter, $options);
        $namespace = $mongodb_config['database'] . '.' . $collection;

        $cursor = $manager->executeQuery($namespace, $query);
        return ['success' => true, 'data' => $cursor->toArray()];
    } catch (Exception $e) {
        error_log("MongoDB Query Error: " . $e->getMessage());
        return ['success' => false, 'error' => $e->getMessage(), 'data' => []];
    }
}

function mongoAggregate($collection, $pipeline = []) {
    global $mongodb_config;

    try {
        $manager = getMongoDBConnection();
        if (!$manager) {
            return ['success' => false, 'error' => 'Connection failed', 'data' => []];
        }

        $command = new MongoDB\Driver\Command([
            'aggregate' => $collection,
            'pipeline' => $pipeline,
            'cursor' => new stdClass,
        ]);

        $cursor = $manager->executeCommand($mongodb_config['database'], $command);
        return ['success' => true, 'data' => $cursor->toArray()];
    } catch (Exception $e) {
        error_log("MongoDB Aggregation Error: " . $e->getMessage());
        return ['success' => false, 'error' => $e->getMessage(), 'data' => []];
    }
}

function mongoCount($collection, $filter = []) {
    global $mongodb_config;

    try {
        $manager = getMongoDBConnection();
        if (!$manager) {
            return 0;
        }

        $pipeline = [];
        if (!empty($filter)) {
            $pipeline[] = ['$match' => $filter];
        }
        $pipeline[] = ['$count' => 'total'];

        $command = new MongoDB\Driver\Command([
            'aggregate' => $collection,
            'pipeline' => $pipeline,
            'cursor' => new stdClass,
        ]);

        $cursor = $manager->executeCommand($mongodb_config['database'], $command);
        $result = $cursor->toArray();

        return isset($result[0]->total) ? (int)$result[0]->total : 0;
    } catch (Exception $e) {
        error_log("MongoDB Count Error: " . $e->getMessage());
        return 0;
    }
}

function mongoIdToString($id) {
    if (is_object($id) && get_class($id) === 'MongoDB\BSON\ObjectId') {
        return (string)$id;
    }
    return (string)$id;
}

function mongoDateToString($date, $format = 'Y-m-d H:i:s') {
    if (is_object($date) && get_class($date) === 'MongoDB\BSON\UTCDateTime') {
        return $date->toDateTime()->format($format);
    }
    return '';
}

function getMeetingStats() {
    try {
        return [
            'total' => mongoCount('meetings', []),
            'live' => mongoCount('meetings', ['status' => 'LIVE']),
            'scheduled' => mongoCount('meetings', ['status' => 'SCHEDULED']),
            'ended' => mongoCount('meetings', ['status' => 'ENDED']),
        ];
    } catch (Exception $e) {
        return ['total' => 0, 'live' => 0, 'scheduled' => 0, 'ended' => 0];
    }
}

function formatDuration($minutes) {
    if (empty($minutes) || $minutes == 0) {
        return '-';
    }
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    if ($hours > 0) {
        return $hours . '시간 ' . $mins . '분';
    }
    return $mins . '분';
}

