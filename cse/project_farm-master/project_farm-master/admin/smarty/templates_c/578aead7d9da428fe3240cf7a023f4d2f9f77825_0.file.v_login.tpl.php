<?php
/* Smarty version 3.1.30, created on 2026-05-01 16:08:50
  from "C:\xampp\htdocs\cse\project_farm-master\project_farm-master\admin\views\v_login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_69f4b3f2c83327_25586223',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '578aead7d9da428fe3240cf7a023f4d2f9f77825' => 
    array (
      0 => 'C:\\xampp\\htdocs\\cse\\project_farm-master\\project_farm-master\\admin\\views\\v_login.tpl',
      1 => 1777643810,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69f4b3f2c83327_25586223 (Smarty_Internal_Template $_smarty_tpl) {
?>
<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login Administrator Chu's Farm</div>
      <div class="card-body">
        <form method="POST" autocomplete="off">
          <div class="form-group">
            <input class="form-control" name="username" type="text" 
            min="6" max="50"
            placeholder="Username" value="<?php if (isset($_POST['btn_login'])) {
echo $_POST['username'];
}?>" autocomplete="off" required>
          </div>
          <div class="form-group">
            <input class="form-control" name="password" type="password" 
            min="6" max="50"
            placeholder="Password" autocomplete="off" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="btn_login">Login</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="../index.php">Return Index</a>
        </div>
      </div>
    </div>
  </div>
  <?php if (isset($_SESSION['alert'])) {?>
    <?php echo '<script'; ?>
>swal("<?php echo $_SESSION['alert'];?>
");<?php echo '</script'; ?>
>
  <?php }
}
}
