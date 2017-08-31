<?php

$configFile = 'config.xml';
$dataFiles = 'data.csv';

// Uncomment for example
// $configFile = 'config_example.xml';
// $dataFiles = 'data_example.csv';

$configPath = 'config';
$dataPath = 'data';
$formattersPath = 'formatters';
$jsPath = 'js';

$jsClass = 'jquery';

$lineDelimeter = "\n";
$break = "**********************************************************************\n";

if (!file_exists($configPath . '/' . $configFile)) {
    throw new Exception("No config file available. Please check $configPath/$configFile is available.");
}

if (!file_exists($dataPath . '/' . $dataFiles)) {
    throw new Exception("No data file available. Please check $dataPath/$dataFiles is available.");
}

// Load config
$xml = simplexml_load_file($configPath . '/' . $configFile);

// Read data file
$origfile = fopen($dataPath . '/' . $dataFiles, "r") or die("Unable to open file!");
$rawOutput = fread($origfile, filesize($dataPath . '/' . $dataFiles));
fclose($origfile);

$dataLines = explode($lineDelimeter, $rawOutput);
$dataConfig = explode(',', $dataLines[0]);
unset($dataLines[0]);

$configLookup = [];

foreach ($xml->fieldMappings->field as $field) {
    $field = (array)$field;
    $configLookup[$field['column']] = $field;
}

include_once $jsPath . '/' . $jsClass . '.php';
$jsFormatter = new $jsClass;

$count = 1;

foreach ($dataLines as $value) {
    $data = explode(',', $value);
    $formData = [];

    print $break;
    print "JS for record - $count\n";
    print $break;

    foreach ($dataConfig as $dataKey => $configKey) {
        if (!array_key_exists($configLookup[$configKey]['type'], $formData)) {
            $formData[$configLookup[$configKey]['type']] = [];
        }

        if (is_string($configLookup[$configKey]['formatter'])) {
            $formatterFile = $formattersPath . '/' . $configLookup[$configKey]['formatter'] . '.php';

            if (!file_exists($formatterFile)) {
                throw new Exception('Cannot locate formatter:' . $formatterFile);
            }

            include_once $formatterFile;
            $value = (new $configLookup[$configKey]['formatter'])->format($data[$dataKey]);
        } else {
            $value = $data[$dataKey];
        }

        $formData[$configLookup[$configKey]['type']][$configLookup[$configKey]['id']] = $value;
    }

    foreach ($formData as $fieldType => $fields) {
        $method = 'getOutputFor' . ucfirst($fieldType);

        if (!method_exists($jsFormatter, $method)) {
            throw new Exception("Class $jsClass is missing method $method");
        }

        print $jsFormatter->$method($fields);
    }

    $count++;
}
