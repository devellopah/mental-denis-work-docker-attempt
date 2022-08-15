<script src="{{ asset('js/libs/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'baseUrl' => url('/'),
        'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; }) 
    ]); ?>
</script>