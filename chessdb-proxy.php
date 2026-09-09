<?php
/**
 * Minimal same-origin proxy for ChessDB.
 * Serve this package with PHP (e.g. php -S 127.0.0.1:8000) so browser code can
 * query chessdb.cn without CORS problems.
 */
header('Cache-Control: no-store');
header('Content-Type: application/json; charset=utf-8');

$allowed = ['queryall', 'querybest', 'queryscore', 'querypv', 'querysearch', 'queue'];
$action = isset($_GET['action']) ? $_GET['action'] : '';
$board = isset($_GET['board']) ? $_GET['board'] : '';

if (!in_array($action, $allowed, true) || $board === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid action or missing board/FEN.']);
    exit;
}

$params = [
    'action' => $action,
    'board'  => $board,
    // Safe default for a viewer/client: do not automatically add work to CDB.
    'learn'  => (isset($_GET['learn']) && $_GET['learn'] === '1') ? '1' : '0',
];
if ($action !== 'queue') {
    $params['json'] = '1';
}
foreach (['showall', 'endgame', 'egtbmetric'] as $key) {
    if (isset($_GET[$key])) $params[$key] = $_GET[$key];
}

$url = 'https://www.chessdb.cn/cdb.php?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);

$body = false;
$status = 502;
$contentType = 'application/json; charset=utf-8';

if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 6,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_USERAGENT => 'chessboard3js-chessdb/0.1',
    ]);
    $body = curl_exec($ch);
    if ($body !== false) {
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $upstreamType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if ($upstreamType) $contentType = $upstreamType;
    }
    $err = curl_error($ch);
    curl_close($ch);
} else {
    $ctx = stream_context_create(['http' => [
        'timeout' => 15,
        'header' => "User-Agent: chessboard3js-chessdb/0.1\r\n",
    ]]);
    $body = @file_get_contents($url, false, $ctx);
    $err = $body === false ? 'Unable to reach chessdb.cn' : '';
    $status = $body === false ? 502 : 200;
}

if ($body === false) {
    http_response_code(502);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'error', 'message' => $err ?: 'ChessDB upstream request failed.']);
    exit;
}

http_response_code($status >= 200 && $status < 600 ? $status : 502);
if ($action === 'queue') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => trim($body) === 'ok' ? 'ok' : 'upstream', 'raw' => trim($body)]);
} else {
    header('Content-Type: ' . $contentType);
    echo $body;
}
