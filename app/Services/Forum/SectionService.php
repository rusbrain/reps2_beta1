<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.19
 * Time: 14:26
 */

namespace App\Services\Forum;

use App\{Comment, ForumSection};
use App\Http\Requests\ForumSectionUpdateAdminRequest;
use Carbon\Carbon;

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
    public static function getSectionViewData($topics, $title)//TODO remove
    {
        return [
            'title' => $title,
            'total_comment_count' => $topics->sum('comments_count')
        ];
    }

    /**
     * @param $section_id
     */
    public static function removeSection($section_id)
    {
        $section = ForumSection::find($section_id);

        foreach ($section->topics()->get() as $topic){
            $topic->comments()->delete();
            $topic->positive()->delete();
            $topic->negative()->delete();
        }

        $section->topics()->delete();

        ForumSection::where('id', $section_id)->delete();
    }

    /**
     * @param ForumSectionUpdateAdminRequest $request
     * @param $section_id
     */
    public static function updateSection(ForumSectionUpdateAdminRequest $request, $section_id)
    {
        $data = $request->validated();

        $data['is_active']              = $data['is_active']??0;
        $data['is_general']             = $data['is_general']??0;
        $data['user_can_add_topics']    = $data['user_can_add_topics']??0;

        ForumSection::where('id',$section_id)->update($data);
    }

    /**
     * @return ForumSection[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllForumSections()
    {
            $all_sections = ForumSection::active()->get();
            $time = Carbon::now()->format('Y-M-d');
            $sql = [];
            foreach ($all_sections as $section) {
                $sql[] = "(
        select * from `forum_topics` where `approved` = 1 and (`start_on` is null or `start_on` <= '$time') and `section_id` = $section->id ORDER BY `commented_at` DESC limit 5
        )";
            }

            $sql = implode(" UNION ALL ", $sql);
            $topics = collect(\DB::select($sql))->groupBy('section_id');

            foreach ($all_sections as $key => $section) {
                if(isset($topics[$section->id])){
                    $all_sections[$key]->topics = $topics[$section->id];
                }
            }

        return $all_sections;
    }

    /**
     * @return mixed
     */
    public static function getGeneralSectionsForum()
    {
        $all_sections = self::getAllForumSections();
        return $all_sections->where('is_general', 1);
    }

    /**
     *
     * @return static
     */
    public static function getAllSections()
    {
        $all_sections = self::getAllForumSections();
        return $all_sections->whereIn('is_general', [1,0]);
    }
}