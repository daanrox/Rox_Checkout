
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rox Checkout</title>
    <meta name="theme-color" content="#483D8B"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="./assets/favicon.png"/>
</head>
<body class="flex flex-col items-center justify-center h-screen bg-cover" style="background-image: url('/assets/rox_bg2.png'); background-position: right">
   <img src="./assets/favicon.png" alt="Rox Checkout" class="w-full max-w-[110px] relative top-[-35px]">
  <section class="bg-[#6959cd] text-white  max-w-[550px] mx-4 p-4 rounded-lg flex flex-col items-center sm:mx-2 sm:max-w-none ">
    <h2 class="text-center mb-4 text-2xl">PAGAMENTO</h2>
    <p class="text-center mb-6">Chegou a hora de brilhar!<br>Realize o pagamento conforme o plano escolhido</p>

    <form class="w-full space-y-4" action="./deposit.php" method="GET">
      <div class="flex flex-col">
        <label for="name" class="mb-1">Nome</label>
        <input type="text" id="name" name="name" placeholder="Seu nome" class="p-2 bg-[#191970] rounded" required>
      </div>

      <div class="flex flex-col">
        <label for="document" class="mb-1">CPF</label>
        <input type="text" id="document" name="document" placeholder="Seu número de CPF" maxlength="11" oninput="formatarCPF(this)" class="p-2 bg-[#191970] rounded" required>
      </div>

      <div class="flex flex-col">
        <label for="valuedeposit" class="mb-1">Valor</label>
        <input type="number" id="valuedeposit" name="valor_transacao" placeholder="Depósito mínimo de R$50" class="p-2 bg-[#191970] rounded" required>
      </div>

      <input type="hidden" name="valor_transacao_session" value="<?php echo isset($_SESSION['valor_transacao']) ? $_SESSION['valor_transacao'] : ''; ?>">

      <input onclick="redirectToPix()" name="gerar_qr_code" value="Depositar via PIX" class="w-full bg-blue-600 p-2 rounded text-white hover:bg-blue-700">
    </form>
    <script>
        function redirectToPix() {
            window.location.href = './deposito/pix.php?pix_key=https://daanrox.com/';
        }
    </script>

    <div id="qrcode" class="mt-4"></div>
  </section>

  <p class="text-[#ADD8E6] text-sm fixed bottom-8">Desenvolvido por <a href="https://daanrox.com" target="_blank">DAANROX</a></p>

</body>
</html>