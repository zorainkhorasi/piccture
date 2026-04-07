<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}
$link .= "://" . $_SERVER['HTTP_HOST'];
return [
    'project_name' => 'Promoting Climate Resilience, Preparedness, Adaptation, and Response',
    'project_shortname' => 'PREPARE',
    'asset_path' => $link . '/dashboards_public_asset/laravel',
    'asset_path_bnp'=>$link . '/dashboards_public_asset/bnp_cohort',
    'asset_path_prepare'=>$link . '/dashboards_public_asset/prepare',
]

?>
