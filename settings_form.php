<h1>Stats Settings</h1>

<?php if ($message): ?>
<div class="alert <?=$message_type?>"><?=$message?></div>
<?php endif; ?>

<form method="post">

    <div class="form-group <?=(isset ($errors['stats_page'])) ? 'has-error' : ''?>">
	    <label class="control-label">Page to display stats on:</label>
	    <select name="stats_page" class="form-control">
	    <?php foreach ((array) $pages as $key => $value): ?>
		    <option value="<?=$value->pageId?>" <?=(isset ($data['stats_page']) && $data['stats_page'] == $value->pageId)?'selected="selected"':''?>><?=$value->title?></option>
	    <?php endforeach; ?>
	    </select>
    </div>
    <div class="form-group">
      <label for="stats_analytics">Analytics Code: </label>
<p>Place your Google Analytics, Matomo/Piwik or similar code here to be inserted at the bottom of the head tag.</p>
      <textarea class="form-control" id="stats_analytics" name="stats_analytics_code" style="width: 90%;" rows="10"><?= $data['stats_analytics_code']; ?></textarea>
    </div>

    <input type="hidden" value="yes" name="submitted" />
    <input type="hidden" name="nonce" value="<?=$formNonce?>" />
    <input type="submit" class="button" value="Update Settings" />

</form>
