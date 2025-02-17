<?php
$search = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<title>Search Results</title>";
echo "</head>";
echo "<body>";

if ($search) {
    $pages = [
        "index.php" => "Home Page",
        "about.html" => "About Us",
        "contact.html" => "Contact",
        "faq.html" => "FAQ",
    ];

    $found = false;
    echo "<h2>Search Results for '$search'</h2>";

    foreach ($pages as $file => $title) {
        if (strpos(strtolower($title), $search) !== false) {
            echo "<p><a href='$file'>$title</a></p>";
            $found = true;
        }
    }

    if (!$found) {
        echo "<p>No results found.</p>";
    }
} else {
    echo "<p>Please enter a search term.</p>";
}
echo "</body>";
echo "</html>";
?>
