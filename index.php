
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rox Checkout</title>
    <meta name="theme-color" content="#483D8B"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="./assets/favicon.png"/>
    <style>
        @keyframes pulse-grow {
            0%, 100% {
                transform: scale(1.2);
            }
            50% {
                transform: scale(1.4);
            }
        }

        .animate-pulse-grow {
            animation: pulse-grow 2s infinite;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center h-screen bg-cover" style="background-image: url('/assets/rox_bg2.png'); background-position: right">
   <img src="./assets/favicon.png" alt="Rox Checkout" class="w-full max-w-[110px] relative top-[-35px]">
  <section class="text-white  max-w-[800px] mx-4 p-4 rounded-lg flex flex-col items-center gap-2 sm:mx-2 sm:max-w-none ">
   <h1 class="text-[#6959CD] text-xl md:text-2xl font-bold">CHEGOU SUA HORA DE BRILHAR!</h1>
   <p class="text-center">Um sistema simples com a melhor segurança para receber seus pagamentos online</p>
   
   <div class="bg-[#483d8b] text-white p-6 rounded-lg flex flex-col gap-4 items-center mt-4">
      <h1 class="text-[#6959CD] text-xl md:text-2xl font-bold">QUANTO VALE?</h1>
      <p>Escolha o valor que deseja depositar</p>
   </div>

   <button onclick="redirectToDeposit()"  class="mt-4 bg-red-500 text-white font-bold py-2 px-4 rounded animate-pulse-grow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75">
        CLIQUE AQUI
    </button>
    <script>
        function redirectToDeposit() {
            window.location.href = './deposit.php';
        }
    </script>
  
  </section>

  <p class="text-[#ADD8E6] text-sm fixed bottom-8">Desenvolvido por <a href="https://daanrox.com" target="_blank">DAANROX</a></p>
</body>
</html>