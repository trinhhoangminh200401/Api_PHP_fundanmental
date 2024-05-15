<!-- <?php
function routes($requesturl, $callback)
{
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($requesturl === $url) {
        $callback();
        exit();
    }
}
routes('/index.php', function () {
    return ;
})
?> -->