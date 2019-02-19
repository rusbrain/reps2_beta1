<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 12:17
 */

namespace App\Traits\ViewHelper;

use App\{ForumSection, ForumTopic, SectionIcon};
use Carbon\Carbon;

trait ForumData
{
    /**
     * @return mixed
     */
    public function getLastForum()
    {
        if (!self::$instance->last_forum) {
            if (!self::$instance->all_sections) {
                self::$instance->getAllForumSections();
            }
            self::$instance->last_forum = self::$instance->all_sections->where('is_general', 1);
        }
        return self::$instance->last_forum;
    }

    /**
     * @return ForumSection[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllForumSections()
    {
        if (!$this->all_sections) {
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
                $all_sections[$key]->topics = $topics[$section->id];
            }
            $this->all_sections = $all_sections;
        }
        return self::$instance->all_sections;
    }

    /**
     * @return mixed
     */
    public function getGeneralSectionsForum()
    {
        if (!self::$instance->general_sections) {
            if (!self::$instance->all_sections) {
                self::$instance->getAllForumSections();
            }
            self::$instance->general_sections = self::$instance->all_sections->where('is_general', 1);
        }
        return self::$instance->general_sections;
    }

    /**
     * @return mixed
     */
    public function getLastForumHome()
    {
        self::$instance->last_forum_home = self::$instance->last_forum_home ?? ForumTopic::whereHas('section',
                function ($query) {
                    $query->where('is_active', 1)->where('is_general', 1);
                })
                ->where('approved', 1)
                ->with('preview_image')
                ->withCount('positive', 'negative', 'comments')
                ->limit(5)->get();

        return self::$instance->last_forum_home;
    }

    /**
     * Get icon url from Id
     *
     * @return mixed
     */
    public function getSectionIcons()
    {
        if (!self::$instance->section_icons){
            $icons = SectionIcon::all();
            foreach ($icons as $icon) {
                self::$instance->section_icons[$icon->id] = $icon->icon;
            }
            return self::$instance->section_icons;
        }
    }

}