<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carrinho de Compras com PHP</title>
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>
    <body>

        <!--Container de produtos-->
        <h2>Vitrine</h2>
        <div class="carrinho-container">
        <?php 
            //echo "<pre>";
            $itens = array(
                ['nome' => "Camiseta", "preco" => 53.50,  'imagem' => 'assets/img/imagem.jpg'],
                ['nome' => "Shorts", "preco" => 35.00,  'imagem' => 'assets/img/imagem2.jpg'],
                ['nome' => "Boné", "preco" => 20.99,  'imagem' => 'assets/img/imagem3.jpg']
            );

            //print_r($itens);   
            //echo "</pre>";

            //Div dos produtos
            foreach($itens as $key => $value){
            ?>
                <div class="produto">
                    <img src="<?php echo $value['imagem']; ?>" alt="<?php echo $value['nome']; ?>" title="<?php echo $value['nome']; ?>"/>
                    <a href="?adicionar=<?php echo $key ?>" onclick='confirmar()'>Adicionar ao carrinho</a>
                </div><!--produto-->
            <?php 
            }
            ?>
            </div><!--carrinho container-->

        <?php 
            if(isset($_GET['adicionar'])){
                //adicionar
                $id_produto = filter_input(INPUT_GET, 'adicionar', FILTER_SANITIZE_NUMBER_INT);
                //verificar se o número que tá no url é um índice do array
                if(isset($itens[$id_produto])){
                    //echo "O produto existe";
                    if(isset($_SESSION['carrinho'][$id_produto])){
                        $_SESSION['carrinho'][$id_produto]['quantidade']++;
                    }else{
                        $_SESSION['carrinho'][$id_produto] = array('quantidade'=> 1, 'nome' => $itens[$id_produto]['nome'], 'preco' => $itens[$id_produto]['preco']);
                    }
                    echo "<script>alert('O item ".$_SESSION['carrinho'][$id_produto]['nome']." foi adicionado ao carrinho');</script>";
                }else{
                    die("Você não pode adicionar um item que não existe.");
                }
            }
        ?>

        <!--Carrinho-->
        <h2>Carrinho</h2>
        <table id="tabela-carrinho">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Preço R$</th>
                    <th>Total R$</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $tudo = 0.00;
            foreach ($_SESSION['carrinho'] as $key => $value) {
                $total = $value['preco'] * $value['quantidade'];
                $tudo += $total;
                echo "
                <tr>
                    <td>".$value['nome']."</td>
                    <td>".$value['quantidade']."</td>
                    <td>".number_format($value['preco'], 2, ",", ".")."</td>
                    <td>".number_format($total, 2, ",", ".")."</td>
                </tr>
                ";
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total: </th>
                    <td colspan="3"><?php echo "R$ ".number_format($tudo, 2, ",", "."); ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>