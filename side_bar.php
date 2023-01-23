<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/oliveOil">
    <div class="sidebar-brand-icon rotate-n-15">
    <img src="img/brandIcon.png" width="50">
    </div>
    <div class="sidebar-brand-text mx-3">Zeytinden Yağ'a</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="/oliveOil">
        <i class="fas fa-home"></i>
        <span>Ana Sayfa</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Sayfalar
</div>

<li class="nav-item">
    <a class="nav-link" href="oil_transform">
        <i class="fas fa-sync"></i>
        <span>Zeytinimi Dönüştür</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="order_oil">
        <i class="fas fa-cart-plus"></i>
        <span>Zeytin Yağı Satın Al</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="my_orders">
        <i class="fas fa-fw fa-table"></i>
        <span>Yağ Siparişlerim</span>
    </a>
</li>

<?php
if($user['is_admin'] == 1){ ?>
<li class="nav-item">
    <a class="nav-link" href="products">
        <i class="fas fa-fw fa-table"></i>
        <span>Şirket Ürünleri</span>
    </a>
</li>
<?php } ?>

<li class="nav-item">
    <a class="nav-link" href="my_appointments">
        <i class="fas fa-fw fa-table"></i>
        <span>Tüm Randevularım</span>
    </a>
</li>

<?php if($user['is_admin'] == 1){ ?>
<li class="nav-item">
    <a class="nav-link" href="users">
        <i class="fas fa-fw fa-table"></i>
        <span>Kullanıcılar</span>
    </a>
</li>
<?php } ?>

<?php
if($user['is_admin'] == 1){ ?>
<li class="nav-item">
    <a class="nav-link" href="all_appointments">
        <i class="fas fa-fw fa-table"></i>
        <span>Müşteri Randevuları</span>
    </a>
</li>
<?php } ?>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
