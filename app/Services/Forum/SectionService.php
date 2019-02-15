<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:26
 */

namespace App\Services\Forum;


use App\Comment;
use App\ForumSection;

class SectionService
{
    /**
     * @return mixed
     */
    public static function getSections()
    {
        $sections = ForumSection::active()->withCount('topics')->get();
        $section_comments = \DB::select('select ft.section_id, count(*) as comment_count from comments as c left join forum_topics as ft On ft.id = c.object_id where c.relation = ? and ft.section_id > 0 group by ft.section_id', [Comment::RELATION_FORUM_TOPIC]);

        $section_comments_count = [];
        foreach ($section_comments as $comment){
            $section_comments_count[$comment->section_id] = $comment->comment_count;
        }
        foreach ($sections as $key=>$section) {
            $sections[$key]['comment_count'] = $section_comments_count[$section->id];
        }

        return $sections;
    }

    /**
     * @param $topics
     * @param $title
     * @return array
     */
    public static function getSectionViewData($topics, $title)
    {
        return ['topics'=> $topics, 'title' => $title, 'total_comment_count' => $topics->sum('comments_count')];
    }
}