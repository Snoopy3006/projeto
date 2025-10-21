<?php
// 1. Lê os inscritos do arquivo CSV
$inscritos = file("inscritos.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// 2. Faz scraping de notícias do IGN Brasil
$html = file_get_contents("https://br.ign.com/");
$noticias = [];

if ($html && preg_match_all('/<a href="(https:\/\/br\.ign\.com\/[^"]+)"[^>]*>(.*?)<\/a>/', $html, $matches)) {
    for ($i = 0; $i < min(5, count($matches[0])); $i++) {
        $noticias[] = "- " . strip_tags($matches[2][$i]) . " (" . $matches[1][$i] . ")";
    }
}

//  Monta o conteúdo do e-mail
$conteudo = "Olá, aqui estão as principais notícias de jogos:\n\n" . implode("\n", $noticias) . "\n\nAté a próxima!";

//  Envia para cada inscrito do site
foreach ($inscritos as $linha) {
    list($nome, $email) = explode(",", $linha);

    $subject = "🕹️ Sua Newsletter de Jogos - ".date('d/m/Y');
    $message = "Olá $nome,\n\n$conteudo";
    $headers = "From: newsletter@seudominio.com\r\n";

    
    mail($email, $subject, $message, $headers);
}

echo "Newsletter enviada com sucesso!";
?>
