<?php

class HistoryMapper extends MapperAbstract
{
  /**
   * Main source table
   */
  const TABLE = 'history';

  /**
   * Maps the values from a history record to the properties in a history data model
   * @param array $record The record from the history table
   * @return History Returns an instance of a History data model populated with the record's data
   */
  protected function _map($record)
  {
    include_once "History.php";
    $history = new History();
    $history->historyId = (int) $record['id'];
    $history->videoId = (int) $record['video_id'];
    $history->userId = (int) $record['user_id'];
    $history->timeStamp = new \DateTime($record['timestamp'], new \DateTimeZone('UTC'));
    return $history;
  }

  /**
   * Creates or updates a history record in the database. New record is created if no id is provided.
   * @param History $history The history event being saved
   * @return int Returns the id of the saved history record
   */
  public function save(History $history)
  {
    $db = Registry::get('db');
    if (!empty($history->historyId)) {
      // Update
      $query = 'UPDATE ' . DB_PREFIX . static::TABLE . ' SET';
      $query .= ' id = :historyId, video_id = :videoId, user_id = :userId, timestamp = :timeStamp';
      $query .= ' WHERE file_id = :fileId';
      $bindParams = array(
        ':historyId' => $history->historyId,
        ':videoId' => $history->videoId,
        ':userId' => $history->userId,
        ':timeStamp' => $history->timeStamp->format(DATE_FORMAT)
      );
    } else {
      // Create
      $query = 'INSERT INTO ' . DB_PREFIX . static::TABLE;
      $query .= ' (video_id, user_id, timestamp)';
      $query .= ' VALUES (:videoId, :userId, :timeStamp)';
      $bindParams = array(
        ':videoId' => $history->videoId,
        ':userId' => $history->userId,
        ':timeStamp' => gmdate(DATE_FORMAT)
      );
    }

    $db->query($query, $bindParams);
    $historyId = (!empty($history->historyId)) ? $history->historyId : $db->lastInsertId();
    return $historyId;
  }
}