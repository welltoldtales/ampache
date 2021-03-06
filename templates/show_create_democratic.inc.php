<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2013 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

UI::show_box_top(T_('Configure Democratic Playlist')); ?>
<form method="post" action="<?php echo Config::get('web_path'); ?>/democratic.php?action=create" enctype="multipart/form-data">
<table class="tabledata" cellspacing="0" cellpadding="0">
<tr>
    <td><?php echo T_('Name'); ?></td>
    <td><input type="text" name="name" value="<?php echo scrub_out($democratic->name); ?>" /></td>
</tr>
<tr>
    <td><?php echo T_('Base Playlist'); ?></td>
    <td><?php show_playlist_select('democratic',$democratic->base_playlist); ?></td>
</tr>
<tr>
    <td><?php echo T_('Cooldown Time'); ?></td>
    <td><input type="text" size="4" maxlength="6" name="cooldown" value="<?php echo $democratic->cooldown; ?>" />&nbsp;(<?php echo T_('minutes'); ?>)</td>
</tr>
<!--
<tr>
    <td><?php echo T_('Level'); ?></td>
    <td>
        <select name="level">
                <option value="25"><?php echo T_('User'); ?></option>
                <option value="50"><?php echo T_('Content Manager'); ?></option>
                <option value="75"><?php echo T_('Catalog Manager'); ?></option>
                <option value="100"><?php echo T_('Admin'); ?></option>
                </select>

<tr>
    <td><?php echo T_('Make Default'); ?></td>
    <td><input type="checkbox" name="make_default" value="1" /></td>
</tr>
-->
<tr>
    <td><?php echo T_('Force Democratic Play'); ?></td>
    <td><input type="checkbox" value="1" name="force_democratic" /></td>
</tr>
</table>
<div class="formValidation">
        <?php echo Core::form_register('create_democratic'); ?>
        <input type="submit" value="<?php echo T_('Update'); ?>" />
</div>
</form>
<?php UI::show_box_bottom(); ?>
