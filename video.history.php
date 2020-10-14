<?php
$this->view->options->disableView = true;
echo "idget:" . $_GET['videoId'];

// Verify user is logged in, otherwise set the id for anonymous hits to -1
$authService = new AuthService();
$user = $authService->getAuthUser();
if ($user) {
  $userId = $user->userId;
}
else{
  $userId = -1;
}

// Verify a video was selected
if (empty($_GET['videoId']) || !is_numeric($_GET['videoId']) || $_GET['videoId'] < 1) App::Throw404();

// Check if video is valid
$video = $videoMapper->getVideoByCustom(array('video_id' => $_GET['videoId'], 'status' => 'approved'));
if (!$video) App::Throw404();

if (is_numeric($video->videoId) && is_numeric($userId)) 
{
  $videoMapper = new VideoMapper();
  $video->views++;
  $videoMapper->save($video);

  include_once "HistoryMeta.php";
  
}
?>