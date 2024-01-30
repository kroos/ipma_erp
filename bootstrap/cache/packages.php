<?php return array (
  'barryvdh/laravel-dompdf' =>
  array (
    'providers' =>
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
    'aliases' =>
    array (
      'Pdf' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
      'PDF' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
    ),
  ),
  'crabbly/fpdf-laravel' =>
  array (
    'providers' =>
    array (
      0 => 'Crabbly\\Fpdf\\FpdfServiceProvider',
    ),
  ),
  'laravel/sanctum' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    ),
  ),
  'laravel/tinker' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'laravel/ui' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Ui\\UiServiceProvider',
    ),
  ),
  'laravelcollective/html' =>
  array (
    'providers' =>
    array (
      0 => 'Collective\\Html\\HtmlServiceProvider',
    ),
    'aliases' =>
    array (
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
    ),
  ),
  'maatwebsite/excel' =>
  array (
    'providers' =>
    array (
      0 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
    ),
    'aliases' =>
    array (
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'nesbot/carbon' =>
  array (
    'providers' =>
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' =>
  array (
    'providers' =>
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'nunomaduro/termwind' =>
  array (
    'providers' =>
    array (
      0 => 'Termwind\\Laravel\\TermwindServiceProvider',
    ),
  ),
  'spatie/laravel-ignition' =>
  array (
    'providers' =>
    array (
      0 => 'Spatie\\LaravelIgnition\\IgnitionServiceProvider',
    ),
    'aliases' =>
    array (
      'Flare' => 'Spatie\\LaravelIgnition\\Facades\\Flare',
    ),
  ),
);
