<div class="container d-flex flex-row flex-wrap justify-content-center">
    <?php
        use app\controller\pedidosController;
        $pedido = new pedidosController();
        $pedido->seleccionarTodosPedidos();
    ?>
</div>
<script src="<?php echo APP_URL?>app/view/js/Pedido.js"></script>