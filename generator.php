<?php
//Why would we ever need to use an image generation library? All done in less than 40 lines of code...
mb_internal_encoding("UTF-8");
header('Content-type: image/svg+xml');
// Input validation
$background = (isset($_GET["background"]) && ctype_xdigit($_GET["background"]) && strlen($_GET["background"]) == 6) ? "#" . $_GET["background"] : null;
$color = (isset($_GET["color"]) && ctype_xdigit($_GET["color"]) && strlen($_GET["color"]) == 6) ? "#" . $_GET["color"] : "#fff";
$name = isset($_GET["name"]) ? filter_var($_GET["name"], FILTER_SANITIZE_STRING) : "O";
$length = isset($_GET["length"]) ? intval($_GET["length"]) : 2;
$width = isset($_GET["width"]) ? intval($_GET["width"]) : "500";
$height = isset($_GET["height"]) ? intval($_GET["height"]) : "500";
$font_size = isset($_GET["fontSize"]) ? intval($_GET["fontSize"]) : "250";
$rounded = isset($_GET["rounded"]) ? intval($_GET["rounded"]) : null;
$isRounded = (isset($_GET["isRounded"]) && $_GET["isRounded"] == "1") ? true : null;
$capitalize = (isset($_GET["caps"]) && $_GET["caps"] == "1") ? true : false;
$lowercase = (isset($_GET["caps"]) && $_GET["caps"] == "2") ? true : false;
$bold = (isset($_GET["bold"]) && $_GET["bold"] == "true") ? true : false;

$letters = grapheme_substr($name, 0, $length);
if ($length > 1 && grapheme_strlen($name) > 2 && grapheme_strpos($name, " ") < grapheme_strlen($name)) {
    $letters = grapheme_substr($name, 0, 1) . grapheme_substr($name, grapheme_strpos($name, " ") + 1, 1);
} else {
    $letters = grapheme_substr($name, 0, $length);
}
if (!$background) {
    //If not set or defined, pick a random sexy color.
    $colors = ["#E284B3", "#FFED8B",  "#681313", "#F3C1C6",  "#735372",  "#009975", "#FFBD39", "#B1E8ED", "#52437B", "#F76262", "#216583", "#293462", "#DD9D52", "#936B93", "#6DD38D", "#888888", "#6F8190", "#BCA0F0", "#AAF4DD", "#96C2ED", "#3593CE", "#5EE2CD", "#96366E", "#E38080"];
    $random_color_key = array_rand($colors, 1);
    $background = $colors[$random_color_key];
}
if ($capitalize) {
    $letters = mb_strtoupper($letters);
} else if ($lowercase) {
    $letters = mb_strtolower($letters);
}
$style = "";
if ($bold) {
    $style = "font-weight:700;";
}
echo '<svg style="' . $style . '" width="' . (string) $width . 'px" height="' . (string) $height . 'px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><style type="text/css">@font-face {font-family: "montserratbold";src: url("https://cdn.oxro.io/fonts/montserrat-bold-webfont.woff2") format("woff2"),url("https://cdn.oxro.io/fonts/montserrat-bold-webfont.woff") format("woff");font-weight: normal;font-style: normal;}</style></defs><rect x="0" y="0" width="500" height="500" rx="' . isset($rounded) ? (string) $rounded : isset($isRounded) ? '50px' : '0' .'" style="fill:' . $background . '"/><text x="50%" y="50%" dy=".1em" fill="' . $color . '" text-anchor="middle" dominant-baseline="middle" style="font-family: &quot;Montserrat&quot;, sans-serif; font-size: ' . (string) $font_size . 'px; line-height: 1">' . $letters . '</text></svg>';
