<?php
/* Smarty version 3.1.30, created on 2026-05-01 16:29:54
  from "C:\xampp\htdocs\cse\project_farm-master\project_farm-master\admin\smarty\templates\layout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_69f4b8e2e08ec6_82140751',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8e475f0d49bb55f3607da774b5c9ab8f78051190' => 
    array (
      0 => 'C:\\xampp\\htdocs\\cse\\project_farm-master\\project_farm-master\\admin\\smarty\\templates\\layout.tpl',
      1 => 1777643809,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/head.tpl' => 1,
    'file:layouts/body.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_69f4b8e2e08ec6_82140751 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:layouts/head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:layouts/body.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:layouts/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
