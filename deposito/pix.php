<?php
// Iniciar ou resumir a sessão


// Obtém o valor após o '=' na URL
$externalReference = isset($_GET['externalReference']) ? $_GET['externalReference'] : '';
$valor = isset($_GET['value']) ? $_GET['value'] : ''; // Adiciona esta linha para obter o valor da URL

// Armazena o externalReference e valor na sessão
$_SESSION['externalReference'] = $externalReference;
$_SESSION['valor'] = $valor; // Adiciona esta linha para armazenar o valor na sessão

// Obtém o email da sessão
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Define o status como pendente
$status = 'pendente';

// Se o externalReference, email e valor estiverem presentes, realiza a verificação e inserção no banco de dados
if (!empty($externalReference) && !empty($email) && !empty($valor)) {
    try {
        
        
           include './../conectarbanco.php';

        $conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);
        $dbuser = $config['db_user'];
        $conn = new PDO("mysql:host=localhost;dbname={$config['db_name']}", $config['db_user'], $config['db_pass']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verifica se já existe um registro com o mesmo email e externalReference
        $stmt_check = $conn->prepare("SELECT COUNT(*) FROM confirmar_deposito WHERE email = :email AND externalreference = :externalReference");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->bindParam(':externalReference', $externalReference);
        $stmt_check->execute();

        $count = $stmt_check->fetchColumn();

        if ($count == 0) {
            // Não há registro existente, pode realizar a inserção
            $stmt_insert = $conn->prepare("INSERT INTO confirmar_deposito (email, externalreference, status, valor) VALUES (:email, :externalReference, :status, :valor)");
            $stmt_insert->bindParam(':email', $email);
            $stmt_insert->bindParam(':externalReference', $externalReference);
            $stmt_insert->bindParam(':status', $status);
            $stmt_insert->bindParam(':valor', $valor); // Adiciona esta linha para inserir o valor no banco de dados
            $stmt_insert->execute();

        } else {
            // Se houver um registro existente, você pode decidir o que fazer aqui
            // Por exemplo, atualizar o valor no registro existente se necessário
        }
    } catch (PDOException $e) {
        // Trate a exceção, se necessário
        echo "Erro: " . $e->getMessage();
    }
} else {
    // Se algum dos parâmetros estiver faltando, você pode decidir o que fazer aqui
}

// Redireciona para outra página
// header('Location: ../deposito/consultarpagamento.php');
// exit();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rox Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.png"/>
    <meta name="theme-color" content="#483D8B"/>
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Space Mono:regular,700"]
            }
        });
    </script>
    <script type="text/javascript">
        !function (o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
                .className += t + "touch")
        }(window, document);
    </script>
</head>
<body class="flex flex-col items-center justify-center h-screen max-h-screen p-4 overflow-x-hidden bg-cover" style="background-image: url('/assets/rox_bg2.png'); background-position: right;">
     <img src="../assets/favicon.png" alt="Rox Payments" class="w-full max-w-[110px] relative top-[-35px]">
    <section class="bg-[#483d8b] text-white w-full  mx-4 p-4 rounded-lg flex flex-col items-center sm:mx-2 sm:max-w-none md:max-w-[550px]">
        <h2 class="text-center mb-4 text-2xl">PAGAMENTO</h2>
        <p class="text-center mb-6">Escaneie ou copie o código para pagamento!</p>

        <div id="qrcode" class="mb-4"></div>
        <div id="qr-code-text" class="mb-4 text-center break-words max-w-full overflow-hidden rounded-lg border border-[#836fff]" style="max-height: 50px;"></div>
        <button id="copy-button" class="bg-blue-600 p-2 rounded text-white hover:bg-blue-700">Copiar Código Pix</button>
    </section>

    <p class="text-[#ADD8E6] text-sm fixed bottom-8">Desenvolvido por <a href="https://daanrox.com" target="_blank">DAANROX</a></p>

    <script>
        // Obtenha os parâmetros da URL
        const urlParams = new URLSearchParams(window.location.search);
        const pixKey = urlParams.get('pix_key');

        // Verifique se a chave PIX está presente
        if (pixKey) {
            // Crie uma instância do QRCode
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: pixKey,
                width: 256,
                height: 256
            });

            // Exiba a chave PIX abaixo do QR code
            document.getElementById('qr-code-text').innerText = "PIX Key: " + pixKey;

            // Adicione a funcionalidade de cópia do PIX Key
            document.getElementById("copy-button").addEventListener("click", function () {
                var textArea = document.createElement("textarea");
                textArea.value = pixKey; // Adicione a chave PIX como valor
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand("copy");
                document.body.removeChild(textArea);
                alert("PIX Key copiada para a área de transferência.");
            });
        } else {
            // Caso a chave PIX não esteja presente, exiba uma mensagem de erro
            document.getElementById('qr-code-text').innerText = 'Chave PIX não encontrada.';
        }

        async function c() {
            const now = new Date().getTime();
            const interval = 5 * 60 * 1000;

            while (new Date().getTime() < now + interval) {
                const params = new URLSearchParams(window.location.search);
                const token = params.get('token');
                const url = '../deposito/consultarpagamento.php?token=' + token;
                await fetch(url)
                    .then((resp) => resp.json())
                    .then(function ({ status }) {
                        console.log(status)
                        if (status === 'PAID_OUT') {
                            window.location.href = '../obrigado/';
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                await new Promise(resolve => setTimeout(resolve, 2000));
            }
        }

        setTimeout(c, 1000);
    </script>
</body>
</html>
