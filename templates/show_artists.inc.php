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

session_start();

$web_path = Config::get('web_path');

?>
<?php require Config::get('prefix') . '/templates/list_header.inc.php'; ?>
<table class="tabledata" cellpadding="0" cellspacing="0">
<colgroup>
    <col id="col_directplay">
    <col id="col_add" />
    <col id="col_artist" />
    <col id="col_songs" />
    <col id="col_albums" />
    <col id="col_tags" />
    <col id="col_rating" />
    <col id="col_userflag" />
    <col id="col_action" />
</colgroup>
<tr class="th-top">
<?php if (Config::get('directplay')) { ?>
    <th class="cel_directplay"><?php echo T_('Play'); ?></th>
<?php } ?>
    <th class="cel_add"><?php echo T_('Add'); ?></th>
    <th class="cel_artist"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=artist&sort=name', T_('Artist'),'artist_sort_name'); ?></th>
    <th class="cel_songs"><?php echo T_('Songs');  ?></th>
    <th class="cel_albums"><?php echo T_('Albums'); ?></th>
    <th class="cel_time"><?php echo T_('Time'); ?></th>
    <th class="cel_tags"><?php echo T_('Tags'); ?></th>
<?php if (Config::get('ratings')) { ?>
    <th class="cel_rating"><?php echo T_('Rating'); ?></th>
<?php } ?>
<?php if (Config::get('userflags')) { ?>
    <th class="cel_userflag"><?php echo T_('Flag'); ?></th>
<?php } ?>
    <th class="cel_action"> <?php echo T_('Action'); ?> </th>
</tr>
<?php
// Cache the ratings we are going to use
if (Config::get('ratings')) { Rating::build_cache('artist',$object_ids); }
if (Config::get('userflags')) { Userflag::build_cache('artist',$object_ids); }

/* Foreach through every artist that has been passed to us */
foreach ($object_ids as $artist_id) {
        $artist = new Artist($artist_id, $_SESSION['catalog']);
        $artist->format();
?>
<tr id="artist_<?php echo $artist->id; ?>" class="<?php echo UI::flip_class(); ?>">
    <?php require Config::get('prefix') . '/templates/show_artist_row.inc.php'; ?>
</tr>
<?php } //end foreach ($artists as $artist) ?>
<?php if (!count($object_ids)) { ?>
<tr class="<?php echo UI::flip_class(); ?>">
    <td colspan="5"><span class="nodata"><?php echo T_('No artist found'); ?></span></td>
</tr>
<?php } ?>
<tr class="th-bottom">
<?php if (Config::get('directplay')) { ?>
    <th class="cel_directplay"><?php echo T_('Play'); ?></th>
<?php } ?>
    <th class="cel_add"><?php echo T_('Add'); ?></th>
    <th class="cel_artist"><?php echo Ajax::text('?page=browse&action=set_sort&type=artist&browse_id=' . $browse->id . '&sort=name', T_('Artist'),'artist_sort_name_bottom'); ?></th>
    <th class="cel_songs"> <?php echo T_('Songs');  ?> </th>
    <th class="cel_albums"> <?php echo T_('Albums'); ?> </th>
    <th class="cel_time"> <?php echo T_('Time'); ?> </th>
    <th class="cel_tags"><?php echo T_('Tags'); ?></th>
<?php if (Config::get('ratings')) { ?>
    <th class="cel_rating"><?php echo T_('Rating'); ?></th>
<?php } ?>
<?php if (Config::get('userflags')) { ?>
    <th class="cel_userflag"><?php echo T_('Flag'); ?></th>
<?php } ?>
    <th class="cel_action"> <?php echo T_('Action'); ?> </th>
</tr>
</table>
<?php require Config::get('prefix') . '/templates/list_header.inc.php'; ?>
