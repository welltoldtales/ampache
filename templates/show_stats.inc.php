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

$stats = Catalog::get_stats();
$catalogs = Catalog::get_catalogs();
?>
<?php UI::show_box_top(T_('Statistics'), 'box box_stats'); ?>
<em><?php echo T_('Catalogs'); ?></em>
<table class="tabledata" cellpadding="3" cellspacing="1">
<tr class="th-top">
        <th><?php echo T_('Connected Users'); ?></th>
        <th><?php echo T_('Total Users'); ?></th>
        <th><?php echo T_('Albums'); ?></th>
        <th><?php echo T_('Artists'); ?></th>
        <th><?php echo T_('Songs'); ?></th>
    <th><?php echo T_('Videos'); ?></th>
        <th><?php echo T_('Tags'); ?></th>
        <th><?php echo T_('Catalog Size'); ?></th>
        <th><?php echo T_('Catalog Time'); ?></th>
</tr>
<tr>
        <td><?php echo $stats['connected']; ?></td>
        <td><?php echo $stats['users'] ?></td>
        <td><?php echo $stats['albums']; ?></td>
        <td><?php echo $stats['artists']; ?></td>
        <td><?php echo $stats['songs']; ?></td>
    <td><?php echo $stats['videos']; ?></td>
        <td><?php echo $stats['tags']; ?></td>
        <td><?php echo $stats['formatted_size']; ?></td>
        <td><?php echo $stats['time_text']; ?></td>
</tr>
</table>
<hr />
<table class="tabledata" cellpadding="0" cellspacing="0">
<colgroup>
  <col id="col_catalog" />
  <col id="col_path" />
  <col id="col_lastverify" />
  <col id="col_lastadd" />
  <col id="col_lastclean" />
  <col id="col_songs" />
  <col id="col_video" />
  <col id="col_total" />
</colgroup>
<tr class="th-top">
        <th class="cel_catalog"><?php echo T_('Name'); ?></th>
        <th class="cel_path"><?php echo T_('Path'); ?></th>
        <th class="cel_lastverify"><?php echo T_('Last Verify'); ?></th>
        <th class="cel_lastadd"><?php echo T_('Last Add'); ?></th>
        <th class="cel_lastclean"><?php echo T_('Last Clean'); ?></th>
    <th class="cel_songs"><?php echo T_('Songs'); ?></th>
    <th class="cel_video"><?php echo T_('Videos'); ?></th>
    <th class="cel_total"><?php echo T_('Catalog Size'); ?></th>
</tr>
<?php foreach ($catalogs as $catalog_id) {
        $catalog = Catalog::create_from_id($catalog_id);
        $catalog->format();
        $stats = Catalog::get_stats($catalog_id);
?>
<tr>
    <td class="cel_catalog"><?php echo $catalog->name; ?></td>
    <td class="cel_path"><?php echo scrub_out($catalog->f_path); ?></td>
    <td class="cel_lastverify"><?php echo scrub_out($catalog->f_update); ?></td>
    <td class="cel_lastadd"><?php echo scrub_out($catalog->f_add); ?></td>
    <td class="cel_lastclean"><?php echo scrub_out($catalog->f_clean); ?></td>
    <td class="cel_songs"><?php echo scrub_out($stats['songs']); ?></td>
    <td class="cel_video"><?php echo scrub_out($stats['videos']); ?></td>
    <td class="cel_total"><?php echo scrub_out($stats['formatted_size']); ?></td>
</tr>
<?php } ?>

</table>
<?php UI::show_box_bottom(); ?>
