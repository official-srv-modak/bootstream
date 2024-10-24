<?php
    if (PHP_OS_FAMILY === 'Windows') {
        // Windows-specific command to get all the output of ipconfig
        $server_ip_output = shell_exec('ipconfig');

        // Extract the relevant section under "Wireless LAN adapter Wi-Fi"
        $pattern = '/Wireless LAN adapter Wi-Fi:.*?IPv4 Address.*?: ([\d\.]+)/s';
        if (preg_match($pattern, $server_ip_output, $matches)) {
            $server_ip = $matches[1]; // Capture the first match (IPv4 Address)
        } else {
            // Fallback to first non-loopback IP if no specific Wi-Fi adapter found
            if (preg_match('/\b((?!127\.|169\.254\.).*\d+\.\d+\.\d+\.\d+)\b/', $server_ip_output, $fallback)) {
                $server_ip = $fallback[0]; // First valid IP
            } else {
                $server_ip = 'IP not found';
            }
        }
    } else {
        // macOS/Linux-specific command to get the first non-loopback IPv4 address
        $server_ip = trim(shell_exec("ifconfig | grep 'inet ' | grep -v 127.0.0.1 | awk '{print $2}'"));
    }

    $path_movies = "path_movies.txt";
    $path_tv = "path_tv.txt";
    $path_cached_images = "path_cached_images.txt";
    $path_cached_images_ip = "http://$server_ip/cached_images/";
    $path_server = "http://$server_ip/";
    $path_server_root = PHP_OS_FAMILY === 'Windows' ? "C:\\xampp\\htdocs\\" : "/Applications/XAMPP/htdocs/";

    // echo "Server IP: " . $server_ip;
?>
