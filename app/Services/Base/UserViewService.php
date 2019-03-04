<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 11:40
 */

namespace App\Services\Base;

use Illuminate\Pagination\LengthAwarePaginator;

class UserViewService extends ViewService
{
    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
   public static function getSection(LengthAwarePaginator $data)
   {
       return (string) view('forum.section_list')->with(['topics' => $data]);
   }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
   public static function getPagination(LengthAwarePaginator $data)
   {
       return (string) view('pagination')->with(['data' => $data]);
   }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
   public static function getComments(LengthAwarePaginator $data)
   {
       return (string) view('comments.comments-content')->with(['comments' => $data]);
   }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
   public static function getNews(LengthAwarePaginator $data)
   {
       return (string) view('news.news_list')->with(['data' => $data]);
   }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
   public static function getUserComments(LengthAwarePaginator $data)
   {
       return (string) view('user.comments.my_comments_list')->with(['comments' => $data]);
   }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
   public static function getTopics(LengthAwarePaginator $data)
   {
       return (string) view('forum.my_topics_list')->with(['data' => $data]);
   }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
   public static function getReplay(LengthAwarePaginator $data)
   {
       return (string) view('replay.replays_list')->with(['replays' => $data]);
   }
}