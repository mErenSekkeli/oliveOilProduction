<?php
ob_start();
require_once 'header.php';
if($user['is_admin'] == 0){
    header('Location: 404.php');
    exit;
}
require_once 'controller/products_controller.php';
$con = new products_controller();
$product = $con->getProduct($_GET['id']);
$product = $product->fetch(PDO::FETCH_ASSOC);
?>
                <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <h1 class="h3 mb-4 text-gray-800">Ürün Düzenle</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="olive_type">Ürün İsmi</label>
                        <input type="text" class="form-control form-control-user" value="<?= $product['product_name']; ?>"  name="product_name" placeholder="İsim">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="olive_type">Ürün Stoğu (Litre)</label>
                        <input type="number" class="form-control form-control-user" value="<?= $product['product_stock']; ?>" name="product_stock" placeholder="Litre">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="olive_type">1 Litre Ücreti</label>
                        <input type="number" class="form-control form-control-user" value="<?= $product['product_price_per_kilo']; ?>" name="product_price" placeholder="Ücret">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="selectdiv" style="margin-top: 23px;">
                            <select class="form-select" name="product_status">
                                <option <?php if($product['product_status'] == 1) echo "selected"; ?> value="1">Aktif</option>
                                <option <?php if($product['product_status'] == 2) echo "selected"; ?> value="2">Stok Bitti</option>
                                <option <?php if($product['product_status'] == 3) echo "selected"; ?> value="3">Pasif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="button" onclick="editProduct('<?= $_GET['id']; ?>')" class="btn btn-success"><i class="fas fa-plus"></i> Düzenle</button>
                        <button type="button" onclick="deleteProduct('<?= $_GET['id']; ?>')" class="btn btn-danger">Sil</button>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </div>
    </div>

    <script>
        function editProduct(id){
            var product_name = $("input[name='product_name']").val();
            var product_stock = $("input[name='product_stock']").val();
            var product_price = $("input[name='product_price']").val();
            var product_status = $("select[name='product_status']").val();
            $.ajax({
                url: 'controller/products_controller.php',
                type: 'POST',
                data: {
                    'editProduct': true,
                    'product_id': id,
                    'product_name': product_name,
                    'product_stock': product_stock,
                    'product_price': product_price,
                    'product_status': product_status
                },
                success: function(data){
                   var returned = JSON.parse(data);
                    if(returned.status == "success"){
                        swal('Başarılı', 'Ürün Başarıyla Düzenlendi! Yönlendiriliyor...', 'success');
                        setTimeout(function(){
                            window.location.href = "products";
                        }, 2000);
                    }else if(returned.status == "error"){
                        swal('Hata', 'Bir Hata Oluştu!', 'error');
                    }
                }
            });
        }

        function deleteProduct(id){
            swal({
                title: "Uyarı!",
                text: "Bu ürünü silmek istediğinize emin misiniz?",
                icon: "warning",
                buttons: true,
                buttons: ["Hayır", "Evet"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: 'controller/products_controller.php',
                        type: 'POST',
                        data: {
                            'deleteProduct': true,
                            'product_id': id
                        },
                        success: function(data){
                            var returned = JSON.parse(data);
                            if(returned.status == "success"){
                                swal('Başarılı', 'Ürün Başarıyla Silindi! Yönlendiriliyor...', 'success');
                                setTimeout(function(){
                                    window.location.href = "products";
                                }, 2000);
                            }else if(returned.status == "error"){
                                swal('Hata', 'Bir Hata Oluştu!', 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>
<?php require_once 'footer.php';
ob_flush();
?>