<?php
// display results
if (count($results[$p]) > 0) {
	//print_r($_SERVER);
?>
<div class="container-fluid searchresults">
  <div class="row">
		<div class="col-xs-6">
			<div class="row">
				<div class="alert alert-dismissible alert-success col-xs-8">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<span class="glyphicon glyphicon-search"></span> <strong><?php echo $total; ?> files found</strong>.
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="alert alert-dismissible alert-warning col-xs-8 pull-right unsavedChangesAlert" style="display:none;">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<span class="glyphicon glyphicon-save"></span> <strong> <span class="changetagcounter"></span>. Press Tag files to save changes.</strong>
				</div>
			</div>
		</div>
  </div>
  <div class="row">
    <form method="post" action="/tagfiles.php" class="form-inline">
			<div class="col-xs-12 text-right">
				<div class="row">
				<div class="btn-group">
					<button class="btn btn-default tagAllDelete" type="button" name="tagAll"> Select All Delete</button>
					<button class="btn btn-default tagAllArchive" type="button" name="tagAll"> All Archive</button>
					<button class="btn btn-default tagAllKeep" type="button" name="tagAll"> All Keep</button>
					<button class="btn btn-default tagAllUntagged" type="button" name="tagAll"> All Untagged</button>
				</div>
				<button type="button" class="btn btn-default reload-results"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
				<button type="submit" class="btn btn-default button-tagfiles"><i class="glyphicon glyphicon-tag"></i> Tag files</button>
				<div class="form-group">
					<input type="text" class="search form-control" placeholder="Search within results">
				</div>
				</div>
		</div>
    <div class="counter pull-right"></div>
    <table class="table table-striped table-hover results">
      <thead>
        <tr>
          <th class="text-nowrap">#</th>
          <th class="text-nowrap">Filename <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=filename&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=filename&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
          <th class="text-nowrap">Parent Path <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=path_parent&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=path_parent&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
					<th class="text-nowrap">Size <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=filesize&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=filesize&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
          <th class="text-nowrap">Owner <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=owner&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=owner&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
          <th class="text-nowrap">Group <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=group&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=group&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
          <th class="text-nowrap">Last Modified (utc) <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=last_modified&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=last_modified&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
          <th class="text-nowrap">Last Access (utc) <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=last_access&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=last_access&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
          <th class="text-nowrap">Tag (del/arch/keep) <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=tag&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=tag&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
          <th class="text-nowrap">Custom Tag <a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=tag_custom&sortorder=asc' ?>"><i class="glyphicon glyphicon-chevron-up sortarrows"></i></a><a href="<?php echo $_SERVER["REQUEST_URI"] . '&sort=tag_custom&sortorder=desc' ?>"><i class="glyphicon glyphicon-chevron-down sortarrows"></i></a></th>
        </tr>
        <tr class="warning no-result">
          <td colspan="10"><i class="fa fa-warning"></i> No result</td>
        </tr>
      </thead>
      <tfoot>
				<tr>
					<th class="text-nowrap">#</th>
					<th class="text-nowrap">Filename</th>
					<th class="text-nowrap">Parent Path</th>
					<th class="text-nowrap">Size</th>
					<th class="text-nowrap">Owner</th>
					<th class="text-nowrap">Group</th>
					<th class="text-nowrap">Last Modified (utc)</th>
					<th class="text-nowrap">Last Access (utc)</th>
					<th class="text-nowrap">Tag (del/arch/keep)</th>
					<th class="text-nowrap">Custom Tag</th>
				</tr>
      </tfoot>
      <tbody id="results-tbody">
      <?php
        error_reporting(E_ALL ^ E_NOTICE);
        $limit = $searchParams['size'];
        $i = $p * $limit - $limit;
        foreach ($results[$p] as $result) {
          $file = $result['_source'];
          $i += 1;
      ?>
      <input type="hidden" name="<?php echo $result['_id']; ?>" value="<?php echo $result['_index']; ?>" />
      <tr class="<?php if ($file['tag'] == 'delete') { echo 'warning'; } elseif ($file['tag'] == 'archive') { echo 'success'; } elseif ($file['tag'] == 'keep') { echo 'info'; }?>">
        <th scope="row" class="text-nowrap"><?php echo $i; ?></th>
        <td><a href="/view.php?id=<?php echo $result['_id'] . '&amp;index=' . $result['_index']; ?>"><?php echo $file['filename']; ?></a></td>
		  <td><a href="/filetree.php?path=<?php echo rawurlencode($file['path_parent']); ?>&amp;filter=<?php echo $_COOKIE['filter']; ?>&amp;mtime=<?php echo $_COOKIE['mtime']; ?>"><label class="btn btn-default btn-xs"><span class="glyphicon glyphicon-folder-open"></span></label></a>&nbsp;<a href="/treemap.php?path=<?php echo rawurlencode($file['path_parent']); ?>"><label class="btn btn-default btn-xs"><span class="glyphicon glyphicon-th-large"></span></label></a>&nbsp;<a href="/advanced.php?submitted=true&amp;p=1&amp;path_parent=<?php echo rawurlencode($file['path_parent']); ?>"><label class="btn btn-default btn-xs"><span class="glyphicon glyphicon-filter"></span></label></a>&nbsp;<?php echo $file['path_parent']; ?></td>
        <td class="text-nowrap"><?php echo formatBytes($file['filesize']); ?></td>
        <td class="text-nowrap"><?php echo $file['owner']; ?></td>
        <td class="text-nowrap"><?php echo $file['group']; ?></td>
        <td class="text-nowrap"><?php echo $file['last_modified']; ?></td>
        <td class="text-nowrap"><?php echo $file['last_access']; ?></td>
        <td class="text-nowrap"><div class="btn-group tagButtons" style="white-space:nowrap;" data-toggle="buttons">
            <label class="tagDeleteLabel btn btn-warning btn-sm <?php if ($file['tag'] == 'delete') { echo 'active'; }?>" style="display:inline-block;float:none;" id="highlightRowDelete">
              <input class="tagDeleteInput" type="radio" name="ids_tag[<?php echo $result['_id']; ?>]" value="delete" <?php if ($file['tag'] == 'delete') { echo 'checked'; }; ?> /><span class="glyphicon glyphicon-trash"></span>
            </label>
            <label class="tagArchiveLabel btn btn-success btn-sm <?php if ($file['tag'] == 'archive') { echo 'active'; }?>" style="display:inline-block;float:none;" id="highlightRowArchive">
              <input class="tagArchiveInput" type="radio" name="ids_tag[<?php echo $result['_id']; ?>]" value="archive" <?php if ($file['tag'] == 'archive') { echo 'checked'; }; ?> /><span class="glyphicon glyphicon-cloud-upload"></span>
            </label>
            <label class="tagKeepLabel btn btn-info btn-sm <?php if ($file['tag'] == 'keep') { echo 'active'; }?>" style="display:inline-block;float:none;" id="highlightRowKeep">
              <input class="tagKeepInput" type="radio" name="ids_tag[<?php echo $result['_id']; ?>]" value="keep" <?php if ($file['tag'] == 'keep') { echo 'checked'; }; ?> /><span class="glyphicon glyphicon-floppy-saved"></span>
            </label>
						<label class="tagUntaggedLabel btn btn-default btn-sm" style="display:inline-block;float:none;" id="highlightRowUntagged">
              <input class="tagUntaggedInput" type="radio" name="ids_tag[<?php echo $result['_id']; ?>]" value="untagged" <?php if ($file['tag'] == 'untagged') { echo 'checked'; }; ?> /><span class="glyphicon glyphicon-remove-sign"></span>
            </label>
          </div></td>
        <td class="text-nowrap"><input type="text" name="ids_tag_custom[<?php echo $result['_id']; ?>]" class="custom-tag-input" value="<?php echo $file['tag_custom']; ?>"></td>
      </tr>
      <?php
        } // END foreach loop over results
      ?>
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-xs-12 text-right">
			<div class="row">
      <div class="btn-group">
        <button class="btn btn-default tagAllDelete" type="button" name="tagAll"> Select All Delete</button>
        <button class="btn btn-default tagAllArchive" type="button" name="tagAll"> All Archive</button>
        <button class="btn btn-default tagAllKeep" type="button" name="tagAll"> All Keep</button>
				<button class="btn btn-default" type="button" name="tagAll"> All Untagged</button>
      </div>
      <button type="button" class="btn btn-default reload-results"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
      <button type="submit" class="btn btn-default button-tagfiles"><i class="glyphicon glyphicon-tag"></i> Tag files</button>
      </form>
			</div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 text-right">
			<div class="row">
      <?php
      // pagination
      if ($total > $limit) {
      ?>
      <ul class="pagination">
        <?php
        parse_str($_SERVER["QUERY_STRING"], $querystring);
        $links = 7;
        $page = $querystring['p'];
        $last = ceil($total / $limit);
        $start = (($page - $links) > 0) ? $page - $links : 1;
        $end = (($page + $links) < $last) ? $page + $links : $last;
        $qsfp = $qslp = $qsp = $qsn = $querystring;
        $qsfp['p'] = 1;
        $qslp['p'] = $last;
        if ($qsp['p'] > 1) {
          $qsp['p'] -= 1;
        }
        if ($qsn['p'] < $last) {
          $qsn['p'] += 1;
        }
        $qsfp = http_build_query($qsfp);
        $qslp = http_build_query($qslp);
        $qsn = http_build_query($qsn);
        $qsp = http_build_query($qsp);
        $firstpageurl = $_SERVER['PHP_SELF'] . "?" . $qsfp;
        $lastpageurl = $_SERVER['PHP_SELF'] . "?" . $qslp;
        $prevpageurl = $_SERVER['PHP_SELF'] . "?" . $qsp;
        $nextpageurl = $_SERVER['PHP_SELF'] . "?" . $qsn;
        ?>
        <?php if ($start > 1) { echo '<li><a href="' . $firstpageurl . '">1</a></li>'; } ?>
        <?php if ($page == 1) { echo '<li class="disabled"><a href="#">'; } else { echo '<li><a href="' . $prevpageurl . '">'; } ?>&laquo;</a></li>
        <?php
        for ($i=$start; $i<=$end; $i++) {
          $qs = $querystring;
          $qs['p'] = $i;
          $qs1 = http_build_query($qs);
          $url = $_SERVER['PHP_SELF'] . "?" . $qs1;
        ?>
        <li<?php if ($page == $i) { echo ' class="active"'; } ?>><a href="<?php echo $url; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
        <?php if ($page >= $last) { echo '<li class="disabled"><a href="#">'; } else { echo '<li><a href="' . $nextpageurl . '">'; } ?>&raquo;</a></li>
        <?php if ($end < $last) { echo '<li><a href="' . $lastpageurl . '">' . $last . '</a></li>'; } ?>
      </ul>
      <?php } ?>
    </div>
	</div>
  </div>
</div>
<?php
} // END if there are search results

else {
?>
<div class="container">
  <div class="row">
    <div class="alert alert-dismissible alert-warning col-xs-8">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <span class="glyphicon glyphicon-exclamation-sign"></span> <strong>Sorry, no files found :(</strong> Change a few things up and try searching again.
    </div>
  </div>
</div>
<?php

} // END elsif there are no search results

?>
