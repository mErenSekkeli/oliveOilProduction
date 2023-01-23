<?php
require_once 'header.php';
require_once 'controller/my_orders_controller.php';
$con = new my_orders_controller();
$orders = $con->getOrders();
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tüm Siparişlerim</h1>
                    <?php if(isset($_GET['situation']) && $_GET['situation'] == "success") { ?>
                        <div class="alert alert-success" role="alert">
                            Sipariş Alındı. updateStock Trigger'ı Tetiklendi.
                        </div>
                    <?php } ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Siparişlerim</h6>
                        </div>
                        <form action="controller/my_appointment_controller.php" method="POST">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Ürün Adı</th>
                                            <th>Toplam Litre</th>
                                            <th>Tutar</th>
                                            <th>Teslim Tarihi</th>
                                            <th>Durum</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $orders->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td><?=$row['product_name']; ?></td>
                                            <td><?= $row['product_liter']; ?> Litre</td>
                                            <td>₺<?= $row['order_price']; ?></td>
                                            <td><?php $date = date_create($row['order_date']);
                                            echo date_format($date, "Y/m/d H:i:s"); ?></td>
                                            <td><?php
                                                switch($row['is_refund']){
                                                    case 0:
                                                        echo "Teslim Edildi";
                                                        break;
                                                    case 1:
                                                        echo "İade Edildi";
                                                        break;      
                                                }
                                            ?></td>
                                            <?php if($row['is_refund'] == 0){ ?>
                                            <td><button onclick="refundOrders('<?= $row['order_id']; ?>')" type="button" class="btn btn-danger">İade Et</button></td>
                                            <?php }else if($row['is_refund'] == 1){ ?>
                                            <td><button onclick="deleteOrders('<?= $row['order_id']; ?>')" type="button" class="btn btn-danger">Sil</button></td>
                                            <?php } ?>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
        
<script>
function refundOrders(id){
    var str = "order_id=" + id + "&refundOrder=" + true;
    $.ajax({
        url: "controller/my_orders_controller.php",
        type: "POST",
        data: str,
        success: function(data){
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal('Başarılı', 'Siparişiniz İade Edildi!', 'success');
                setTimeout(function(){
                    $("#ordersTable").load("my_orders.php #ordersTable");
                }, 1000);
            }else if(returned.status == "error"){
                swal('Hata', 'Sipariş İade Edilemedi!', 'error');
            }
        }
    });
}

function deleteOrders(id){
    var str = "order_id=" + id + "&deleteOrder=" + true;
    $.ajax({
        url: "controller/my_orders_controller.php",
        type: "POST",
        data: str,
        success: function(data){
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal('Başarılı', 'Siparişiniz Silindi!', 'success');
                setTimeout(function(){
                    $("#ordersTable").load("my_orders.php #ordersTable");
                }, 1000);
            }else if(returned.status == "error"){
                swal('Hata', 'Sipariş Silinemedi', 'error');
            }
        }
    });
}

</script>
<?php require_once 'footer.php'; ?>