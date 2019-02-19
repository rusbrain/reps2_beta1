<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.19
 * Time: 11:40
 */

namespace App\Services\Base;


use Illuminate\Pagination\LengthAwarePaginator;

class ViewService
{
    /**
     * @param $comments
     * @return string
     */
    public static function getComments(LengthAwarePaginator $comments)
    {
        return (string) view('admin.comment')->with(['data' => $comments]);
    }

    /**
     * @param $data
     * @return string
     */
    public static function getPagination($data)
    {
        return (string) view('admin.pagination')->with(['data' => $data]);
    }

    /**
     * @param LengthAwarePaginator $countries
     * @return string
     */
    public static function getCountries(LengthAwarePaginator $countries)
    {
        return (string) view('admin.country.list_table')->with(['data' => $countries]);
    }

    /**
     * @param LengthAwarePaginator $countries
     * @return string
     */
    public static function getCountriesPopUp(LengthAwarePaginator $countries)
    {
        return (string) view('admin.country.list_pop_up')->with(['data' => $countries]);
    }

    /**
     * @param LengthAwarePaginator $files
     * @return string
     */
    public static function getFiles(LengthAwarePaginator $files)
    {
        return (string) view('admin.file.list_table')->with(['data' => $files]);
    }

    /**
     * @param LengthAwarePaginator $files
     * @return string
     */
    public static function getFilesPopUp(LengthAwarePaginator $files)
    {
        return (string) view('admin.file.list_pop_up')->with(['data' => $files]);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getSections(LengthAwarePaginator $data)
    {
        return (string) view('admin.forum.section.list_table')->with(['data' => $data]);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getTopics(LengthAwarePaginator $data)
    {
        return (string) view('admin.forum.topic.list_table')->with(['data' => $data]);
    }

    /**
     * @param LengthAwarePaginator $questions
     * @return string
     */
    public static function getInterview(LengthAwarePaginator $questions)
    {
        return (string) view('admin.question.list_table')->with(['data' => $questions]);
    }

    /**
     * @param LengthAwarePaginator $questions
     * @return string
     */
    public static function getInterviewPopUp(LengthAwarePaginator $questions)
    {
        return (string) view('admin.question.list_pop_up')->with(['data' => $questions]);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getReplay(LengthAwarePaginator $data)
    {
        return (string) view('admin.replay.list_table')->with(['data' => $data]);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function  getReplayPopUp(LengthAwarePaginator $data)
    {
        return (string) view('admin.replay.list_pop_up')->with(['data' => $data]);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getMap(LengthAwarePaginator $data)
    {
        return (string) view('admin.replay.map.list_table')->with(['data' => $data]);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getMapPopUp(LengthAwarePaginator $data)
    {
        return (string) view('admin.replay.map.list_pop_up')->with(['data' => $data]);
    }

    /**
     * @param LengthAwarePaginator $repuntation
     * @return string
     */
    public static function getReputation(LengthAwarePaginator $repuntation)
    {
        return (string) view('admin.user.reputation.list_table')->with(['data' => $repuntation]);
    }

    /**
     * @param LengthAwarePaginator $comments
     * @return string
     */
    public static function getUserComment(LengthAwarePaginator $comments)
    {
        return (string) view('admin.user.comments.list_table')->with(['data' => $comments]);
    }

    /**
     * @param $users
     * @return string
     */
    public static function getUsers($users)
    {
        return (string) view('admin.user.user_list_table')->with(['data' => $users]);
    }

    /**
     * @param LengthAwarePaginator $galleries
     * @return string
     */
    public static function getGallery(LengthAwarePaginator $galleries)
    {
        return (string) view('admin.user.gallery.list_table')->with(['data' => $galleries]);
    }

    /**
     * @param LengthAwarePaginator $galleries
     * @return string
     */
    public static function getGalleryPopUp(LengthAwarePaginator $galleries)
    {
        return (string) view('admin.user.gallery.list_pop_up')->with(['data' => $galleries]);
    }

    /**
     * @param LengthAwarePaginator $questions
     * @return string
     */
    public static function getQuestions(LengthAwarePaginator $questions)
    {
        return (string) view('admin.user.questions.list_table')->with(['data' => $questions]);
    }
}