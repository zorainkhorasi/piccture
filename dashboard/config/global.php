<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}
$link .= "://" . $_SERVER['HTTP_HOST'];
return [
    'project_name' => 'CLIMATE RISK AND RESILIENCE ASSESSMENT',
    'project_shortname' => 'PICCTURE',
    'asset_path' => $link . '/dashboards_public_asset/laravel',
    'asset_path_bnp'=>$link . '/dashboards_public_asset/bnp_cohort',
    'asset_path_prepare'=>$link . '/dashboards_public_asset/prepare',
]

?>
