<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 11:40
 */

namespace App\Services\Base;

use Illuminate\Pagination\LengthAwarePaginator;

class AdminViewService extends ViewService
{
    /**
     * @param $comments
     * @return string
     */
    public static function getComments(LengthAwarePaginator $comments)
    {
        return self::getView('admin.comment',$comments);
    }

    /**
     * @param $data
     * @return string
     */
    public static function getPagination($data)
    {
        return self::getView('admin.pagination',$data);
    }

    /**
     * @param LengthAwarePaginator $countries
     * @return string
     */
    public static function getCountries(LengthAwarePaginator $countries)
    {
        return self::getView('admin.country.list_table',$countries);
    }

    /**
     * @param LengthAwarePaginator $countries
     * @return string
     */
    public static function getCountriesPopUp(LengthAwarePaginator $countries)
    {
        return self::getView('admin.country.list_pop_up',$countries);
    }

    /**
     * @param LengthAwarePaginator $files
     * @return string
     */
    public static function getFiles(LengthAwarePaginator $files)
    {
        return self::getView('admin.file.list_table',$files);
    }

    /**
     * @param LengthAwarePaginator $files
     * @return string
     */
    public static function getFilesPopUp(LengthAwarePaginator $files)
    {
        return self::getView('admin.file.list_pop_up',$files);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getSections(LengthAwarePaginator $data)
    {
        return self::getView('admin.forum.section.list_table',$data);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getTopics(LengthAwarePaginator $data)
    {
        return self::getView('admin.forum.topic.list_table',$data);
    }

    /**
     * @param LengthAwarePaginator $questions
     * @return string
     */
    public static function getInterview(LengthAwarePaginator $questions)
    {
        return self::getView('admin.question.list_table',$questions);
    }

    /**
     * @param LengthAwarePaginator $questions
     * @return string
     */
    public static function getInterviewPopUp(LengthAwarePaginator $questions)
    {
        return self::getView('admin.question.list_pop_up',$questions);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getReplay(LengthAwarePaginator $data)
    {
        return self::getView('admin.replay.list_table',$data);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function  getReplayPopUp(LengthAwarePaginator $data)
    {
        return self::getView('admin.replay.list_pop_up',$data);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getMap(LengthAwarePaginator $data)
    {
        return self::getView('admin.replay.map.list_table',$data);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getMapPopUp(LengthAwarePaginator $data)
    {
        return self::getView('admin.replay.map.list_pop_up',$data);
    }

    /**
     * @param LengthAwarePaginator $repuntation
     * @return string
     */
    public static function getReputation(LengthAwarePaginator $repuntation)
    {
        return self::getView('admin.user.reputation.list_table',$repuntation);
    }

    /**
     * @param LengthAwarePaginator $comments
     * @return string
     */
    public static function getUserComment(LengthAwarePaginator $comments)
    {
        return self::getView('admin.user.comments.list_table',$comments);
    }

    /**
     * @param $users
     * @return string
     */
    public static function getUsers($users)
    {
        return self::getView('admin.user.user_list_table',$users);
    }

    /**
     * @param LengthAwarePaginator $galleries
     * @return string
     */
    public static function getGallery(LengthAwarePaginator $galleries)
    {
        return self::getView('admin.user.gallery.list_table',$galleries);
    }

    /**
     * @param LengthAwarePaginator $galleries
     * @return string
     */
    public static function getGalleryPopUp(LengthAwarePaginator $galleries)
    {
        return self::getView('admin.user.gallery.list_pop_up',$galleries);
    }

    /**
     * @param LengthAwarePaginator $questions
     * @return string
     */
    public static function getQuestions(LengthAwarePaginator $questions)
    {
        return self::getView('admin.user.questions.list_table',$questions);
    }
}