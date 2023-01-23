<?php require_once 'header.php';
require_once 'controller\oil_transform_controller.php';
    $date = new DateTime();
    if($date->format('D'))
    $date->modify('next monday');
    $date->modify('+6 hours');
?>
<script>
   
</script>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Randevu Al</h1>
                    <div id="allSlots">
                    <form action="controller/oil_transform_controller.php" method="POST">
                    <div class="row">
                            <div class="col-md-12">
                                <span class="">
                                    *Siyah Zeytin -> Ton Başına ₺100 <br>
                                    *Siyah Zeytin -> Ton Başına ₺200 <br>
                                    *Karışık Zeytin -> Ton Başına ₺150 <br>
                                </span>
                            </div>
                    </div><br>
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                                Kaç Ton Zeytin Getireceksin?
                                <input type="number" class="form-control form-control-user" min="0" name="olive_weight" placeholder="Ton">
                        </div>
                        <div class="col-md-8">
                                Zeytin Türünü Seç
                                <div class="selectdiv">
                                <select class="form-select" name="olive_type">
                                    <option selected value="1">Siyah Zeytin</option>
                                    <option value="2">Yeşil Zeytin</option>
                                    <option value="3">Karışık Zeytin</option>
                                </select>
                                </div>
                        </div>
                    </div>
                    </div><br>
                    <span>*Zeytini İşletmemize Getirmeden Önce Randevu Almalısın.</span>
                    <?php $index = 0; for($i = 0; $i < 5; $i++){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h4><span class="badge badge-pill badge-primary">
                                <?php switch($date->format('d-m-Y D')){
                                    case str_contains($date->format('d-m-Y D'), 'Mon'): echo $date->format('d-m-Y').' Pazartesi'; break;
                                    case str_contains($date->format('d-m-Y D'), 'Tue'): echo $date->format('d-m-Y').' Salı'; break;
                                    case str_contains($date->format('d-m-Y D'), 'Wed'): echo $date->format('d-m-Y').' Çarşamba'; break;
                                    case str_contains($date->format('d-m-Y D'), 'Thu'): echo $date->format('d-m-Y').' Perşembe'; break;
                                    case str_contains($date->format('d-m-Y D'), 'Fri'): echo $date->format('d-m-Y').' Cuma'; break;
                                } ?></span></h4>
                        </div>
                        <?php for($j = 0; $j < 9; $j++){ ?>
                        <div class="col-md-1">
                        <input type="hidden" value="<?= $date->format('Y-m-d H:i:s') ?>" id="slot_<?=$i.$j ?>"> 
                        <button type="button" disabled id="btn_<?= $i.$j ?>" onclick="sendDate('<?= $date->format('d/m/Y H:i:s') ?>')" class="btn btn-light" style="border-color: #858796;"><span id="text_<?= $i.$j?>" class="text-primary"><?=substr($date->format('H:i:s'), 0, 5); ?></span></button>                           
                        </div><hr>
                        <?php $date->modify('+2 hours'); $index++; } ?>
                    </div><br>
                    <?php $date->modify('+1 day'); $date->modify('-18 hours'); } ?>
                    <hr>
                    </form>
                    <script src="js/oil_transform.js"></script>
                    </div> 
                </div>
                
            <!-- End of Main Content -->
<?php require_once 'footer.php'; ?>